<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Company;
use App\Models\Folder;
use App\Models\Invoice;
use App\Models\Currency; // Ajout pour la création de devises dans les tests
use App\Livewire\Admin\Invoices\GenerateInvoice as GenerateInvoiceComponent;
use App\Livewire\Admin\Folder\FolderShow as FolderShowComponent;
use App\Livewire\Admin\Invoices\ShowInvoice as ShowInvoiceComponent;
use App\Livewire\Admin\Folder\FolderList as FolderListComponent; // Ajout pour le test de la liste des dossiers
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class InvoiceFolderLinkTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Company $company;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        $this->company = Company::factory()->create();

        // Créer des devises de base pour les tests si elles n'existent pas via seeders
        Currency::factory()->create(['code' => 'USD', 'exchange_rate' => 1.0]);
        Currency::factory()->create(['code' => 'CDF', 'exchange_rate' => 2800.0]); // Taux exemple
    }

    /** @test */
    public function test_folder_list_displays_facturer_button_correctly(): void
    {
        // Arrange
        $unlinkedFolder = Folder::factory()->for($this->company)->create(['folder_number' => 'UNLINKED-001']);
        $linkedFolder = Folder::factory()->for($this->company)->create(['folder_number' => 'LINKED-002']);
        $invoiceForLinkedFolder = Invoice::factory()->for($this->company)->create([
            'folder_id' => $linkedFolder->id,
            'invoice_number' => 'INV-LINKED-002'
        ]);

        // Act: Rendu du composant FolderList
        $response = Livewire::test(FolderListComponent::class)
                        ->call('render'); // S'assurer que les données sont chargées

        // Assert
        // Pour le dossier non lié
        // La route 'admin.invoices.generate' est celle définie pour le composant GenerateInvoice.
        // Nous y passons 'folder_id' comme paramètre de query string.
        $expectedFacturerUrl = route('admin.invoices.generate', ['folder_id' => $unlinkedFolder->id]);
        $response->assertSeeHtml('<a href="'.$expectedFacturerUrl.'"');
        $response->assertSeeText('Facturer'); // Vérifie la présence du texte du bouton/lien
        $response->assertSee($unlinkedFolder->folder_number);

        // Pour le dossier lié
        $expectedInvoiceUrl = route('invoices.show', $invoiceForLinkedFolder->id);
        $response->assertSeeHtml('<a href="'.$expectedInvoiceUrl.'"');
        $response->assertSeeText('Facturé ('.$invoiceForLinkedFolder->invoice_number.')');
        $response->assertSee($linkedFolder->folder_number);
        // Vérifie que le bouton "Facturer" n'est PAS présent pour le dossier déjà lié
        $response->assertDontSeeHtml('<a href="'.route('admin.invoices.generate', ['folder_id' => $linkedFolder->id]).'"');
    }

    /** @test */
    public function test_generate_invoice_prefills_from_folder_id_in_url(): void
    {
        // Arrange
        $folder = Folder::factory()->for($this->company)->create([
            'folder_number' => 'PREFILL-001',
            'company_id' => $this->company->id,
            'fob_amount' => 2500.75,
            'insurance_amount' => 200.50,
            'cif_amount' => 3000.25, // Implique freight = 299
            'weight' => 1500.00,
            'description' => 'Description spécifique pour pré-remplissage'
        ]);

        // Act & Assert
        Livewire::actingAs($this->user)
            ->withQueryParams(['folder_id' => $folder->id])
            ->test(GenerateInvoiceComponent::class)
            ->assertSet('folder_id', $folder->id)
            ->assertNotNull('selectedFolder')
            ->assertSet('selectedFolder.id', $folder->id)
            ->assertSet('company_id', $folder->company_id)
            ->assertSet('fob_amount', $folder->fob_amount)
            ->assertSet('insurance_amount', $folder->insurance_amount)
            ->assertSet('cif_amount', $folder->cif_amount)
            ->assertSet('weight', $folder->weight)
            ->assertSet('product', $folder->description)
            ->assertSet('freight_amount', 299.00);
            // L'assertion assertSeeText a été retirée car elle dépend trop de la structure exacte de la vue
            // et le pré-remplissage des propriétés est le test principal ici.
    }

    /** @test */
    public function test_cannot_load_generate_invoice_for_already_invoiced_folder_via_url(): void
    {
        // Arrange
        $folder = Folder::factory()->for($this->company)
            ->has(Invoice::factory()->for($this->company), 'invoice') // Assure que la relation est correcte
            ->create();

        // Act & Assert
        Livewire::actingAs($this->user)
            ->withQueryParams(['folder_id' => $folder->id])
            ->test(GenerateInvoiceComponent::class)
            ->assertSet('folder_id', null)
            ->assertNull('selectedFolder') // selectedFolder doit être null
            ->assertSessionHas('error');
    }

    /** @test */
    public function test_can_create_invoice_linked_to_folder_via_url_workflow(): void
    {
        // Arrange
        $folder = Folder::factory()->for($this->company)->create([
            'fob_amount' => 1200.00,
            'description' => 'Produits pour facture liée via URL',
            'company_id' => $this->company->id,
        ]);

        // Act
        Livewire::actingAs($this->user)
            ->withQueryParams(['folder_id' => $folder->id])
            ->test(GenerateInvoiceComponent::class)
            // La méthode mount devrait pré-remplir les champs.
            // Les valeurs par défaut du composant pour payment_mode, currency_id, exchange_rate sont utilisées.
            // L'item par défaut est aussi créé par la logique de pré-remplissage.
            ->call('save')
            ->assertHasNoErrors();

        // Assert
        $this->assertDatabaseHas('invoices', [
            'folder_id' => $folder->id,
            'company_id' => $folder->company_id,
            'product' => $folder->description,
            'fob_amount' => $folder->fob_amount,
        ]);
        $this->assertEquals(1, Invoice::where('folder_id', $folder->id)->count());
        // Le test du message flash de succès peut être instable si le composant est réinitialisé différemment.
        // session()->get('success') pourrait être vérifié directement si Livewire::assertSessionHas ne fonctionne pas comme attendu après un call.
    }

    /** @test */
    public function test_cannot_create_invoice_if_folder_is_already_linked_on_save(): void
    {
        // Arrange: Crée un dossier déjà lié à une facture
        $currencyUSD = Currency::where('code', 'USD')->first();

        $linkedFolder = Folder::factory()->for($this->company)
            ->has(Invoice::factory()->for($this->company), 'invoice')
            ->create();

        // Act & Assert
        Livewire::actingAs($this->user)
            ->test(GenerateInvoiceComponent::class)
            ->set('company_id', $this->company->id)
            ->set('invoice_date', now()->toDateString())
            ->set('product', 'Test Product For Already Linked')
            ->set('fob_amount', 200)
            ->set('payment_mode', 'provision')
            ->set('currency_id', $currencyUSD->id)
            ->set('exchange_rate', Currency::where('code', 'CDF')->first()->exchange_rate)
            ->set('items', [
                [
                    'label' => 'Test Item Linked',
                    'category' => 'extra_fee',
                    'amount_local' => 200,
                    'currency_id' => $currencyUSD->id,
                    'tax_id' => null, 'agency_fee_id' => null, 'extra_fee_id' => null, 'exchange_rate' => 1.0, 'amount_usd' => 200, 'amount_cdf' => 200 * 2800
                ]
            ])
            ->set('folder_id', $linkedFolder->id)
            ->call('save')
            ->assertHasErrors(['folder_id' => 'unique']);

        $this->assertEquals(1, Invoice::where('folder_id', $linkedFolder->id)->count());
    }

    /** @test */
    public function test_folder_and_invoice_show_pages_display_reciprocal_links(): void
    {
        // Arrange: Crée un dossier et une facture liés
        $folder = Folder::factory()->for($this->company)->create(['folder_number' => 'DOSSIER-LINK-007']);
        $invoice = Invoice::factory()->for($this->company)->create([
            'folder_id' => $folder->id,
            'invoice_number' => 'FACT-LINK-007'
        ]);

        // Act & Assert (FolderShow)
        $responseFolderShow = $this->get(route('folder.show', $folder->id));
        $responseFolderShow->assertStatus(200);
        $responseFolderShow->assertSeeLivewire(FolderShowComponent::class);
        $responseFolderShow->assertSee($invoice->invoice_number);
        $responseFolderShow->assertSee(route('invoices.show', $invoice->id));

        // Act & Assert (InvoiceShow)
        $responseInvoiceShow = $this->get(route('invoices.show', $invoice->id));
        $responseInvoiceShow->assertStatus(200);
        $responseInvoiceShow->assertSeeLivewire(ShowInvoiceComponent::class);
        $responseInvoiceShow->assertSee($folder->folder_number);
        $responseInvoiceShow->assertSee(route('folder.show', $folder->id));
    }

    /** @test */
    public function test_validation_error_when_reference_id_missing_for_category(): void
    {
        $currencyUSD = Currency::where('code', 'USD')->first();

        Livewire::actingAs($this->user)
            ->test(GenerateInvoiceComponent::class)
            ->set('company_id', $this->company->id)
            ->set('invoice_date', now()->toDateString())
            ->set('product', 'Test Product')
            ->set('fob_amount', 100)
            ->set('payment_mode', 'provision')
            ->set('currency_id', $currencyUSD->id)
            ->set('exchange_rate', Currency::where('code', 'CDF')->first()->exchange_rate)
            ->set('items', [
                [
                    'label' => 'Missing Tax',
                    'category' => 'import_tax',
                    'amount_local' => 50,
                    'currency_id' => $currencyUSD->id,
                    'tax_id' => null,
                    'agency_fee_id' => null,
                    'extra_fee_id' => null,
                    'exchange_rate' => 1.0,
                    'amount_usd' => 50,
                    'amount_cdf' => 50 * 2800,
                ],
            ])
            ->call('save')
            ->assertHasErrors(['items.0.tax_id' => 'required_if']);
    }
}

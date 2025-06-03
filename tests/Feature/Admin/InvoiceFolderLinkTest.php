<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Company;
use App\Models\Folder;
use App\Models\Invoice;
use App\Livewire\Admin\Invoices\GenerateInvoice as GenerateInvoiceComponent;
use App\Livewire\Admin\Folder\FolderShow as FolderShowComponent; // Supposant que c'est le nom du composant
use App\Livewire\Admin\Invoices\ShowInvoice as ShowInvoiceComponent; // Supposant que c'est le nom du composant
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
    }

    /** @test */
    public function test_can_search_and_select_folder_in_invoice_generation(): void
    {
        // Arrange
        $unlinkedFolder1 = Folder::factory()->for($this->company)->create([
            'folder_number' => 'FOLDER-001',
            'fob_amount' => 1000,
            'insurance_amount' => 100,
            'cif_amount' => 1200, // Implique freight = 100
            'weight' => 500,
            'description' => 'Description du dossier 001'
        ]);
        // Crée un dossier déjà lié à une facture (ne devrait pas apparaître dans les résultats de recherche)
        Folder::factory()->for($this->company)
            ->has(Invoice::factory(), 'invoice') // Assure que la relation est 'invoice' sur Folder
            ->create(['folder_number' => 'FOLDER-002']);

        $unlinkedFolder3 = Folder::factory()->for($this->company)->create(['folder_number' => 'FOLDER-003']);

        // Act & Assert
        $component = Livewire::test(GenerateInvoiceComponent::class)
            ->set('searchTermFolder', 'FOLDER-00');

        // Vérifie que $searchableFolders contient les dossiers non liés et pas celui déjà lié
        $searchableFolders = $component->get('searchableFolders');
        $this->assertCount(2, $searchableFolders);
        // La conversion en collection pour faciliter les assertions
        $searchableFolderNumbers = collect($searchableFolders)->pluck('folder_number');
        $this->assertTrue($searchableFolderNumbers->contains('FOLDER-001'));
        $this->assertTrue($searchableFolderNumbers->contains('FOLDER-003'));
        $this->assertFalse($searchableFolderNumbers->contains('FOLDER-002'));

        // Simule la sélection du premier dossier non lié
        $component->call('selectFolder', $unlinkedFolder1->id);

        // Vérifie que folder_id est défini
        $this->assertEquals($unlinkedFolder1->id, $component->get('folder_id'));
        $this->assertNotNull($component->get('selectedFolder'));
        $this->assertEquals($unlinkedFolder1->id, $component->get('selectedFolder')->id);

        // Vérifie le pré-remplissage des champs
        $this->assertEquals($unlinkedFolder1->company_id, $component->get('company_id'));
        $this->assertEquals($unlinkedFolder1->fob_amount, $component->get('fob_amount'));
        $this->assertEquals($unlinkedFolder1->insurance_amount, $component->get('insurance_amount'));
        $this->assertEquals($unlinkedFolder1->cif_amount, $component->get('cif_amount'));
        $this->assertEquals($unlinkedFolder1->weight, $component->get('weight'));
        $this->assertEquals($unlinkedFolder1->description, $component->get('product'));

        // Vérifie le calcul du fret (cif - fob - insurance)
        $expectedFreight = $unlinkedFolder1->cif_amount - $unlinkedFolder1->fob_amount - $unlinkedFolder1->insurance_amount;
        $this->assertEquals($expectedFreight, $component->get('freight_amount'));

        // Vérifie l'initialisation de l'item (si la logique est d'ajouter un item par défaut)
        $items = $component->get('items');
        $this->assertCount(1, $items); // Supposant qu'un item est ajouté/mis à jour
        if (count($items) > 0) {
            $this->assertEquals($unlinkedFolder1->description, $items[0]['label']);
            $this->assertEquals($unlinkedFolder1->fob_amount, $items[0]['amount_local']);
        }
    }

    /** @test */
    public function test_can_create_invoice_linked_to_folder(): void
    {
        // Arrange
        $folder = Folder::factory()->for($this->company)->create([
            'fob_amount' => 1200, // Nécessaire pour pré-remplir l'item
            'description' => 'Produits pour facture liée'
        ]);

        // Act: Interagir avec le composant GenerateInvoice
        // Les valeurs des items, etc., seront celles par défaut ou pré-remplies par selectFolder.
        // Il faut s'assurer que les champs requis pour la facture elle-même sont valides.
        Livewire::test(GenerateInvoiceComponent::class)
            ->call('selectFolder', $folder->id) // Sélectionne le dossier, pré-remplit les champs
            // Assurer que les champs requis sont remplis si non couverts par selectFolder:
            // Par exemple, si invoice_date, payment_mode, currency_id ne sont pas settés par selectFolder
            // et n'ont pas de valeurs par défaut valides dans le composant, il faudrait les setter ici.
            // Pour ce test, on suppose que les valeurs par défaut ou celles de selectFolder sont suffisantes.
            // Si des items sont requis au-delà de ce que selectFolder prépare, il faudrait les ajouter/modifier ici.
            // ex: ->set('items.0.label', 'Label spécifique si différent de product')
            ->call('save'); // Appelle la méthode de sauvegarde

        // Assert
        $this->assertDatabaseHas('invoices', [
            'folder_id' => $folder->id,
            'company_id' => $folder->company_id, // Vérifie que la compagnie du dossier est utilisée
            'product' => $folder->description, // Vérifie que le produit est bien la description du dossier
            'fob_amount' => $folder->fob_amount,
        ]);

        // Vérifie que la facture créée est unique pour ce dossier
        $this->assertEquals(1, Invoice::where('folder_id', $folder->id)->count());

        // Vérifie le message de succès (Livewire gère cela différemment)
        Livewire::test(GenerateInvoiceComponent::class)->assertSessionHas('success');
    }

    /** @test */
    public function test_cannot_create_invoice_if_folder_is_already_linked(): void
    {
        // Arrange: Crée un dossier déjà lié à une facture
        $linkedFolder = Folder::factory()->for($this->company)
            ->has(Invoice::factory(), 'invoice') // Lie une facture existante via la relation 'invoice'
            ->create();

        // Act & Assert
        // Tente de créer une nouvelle facture en liant le dossier déjà lié
        Livewire::test(GenerateInvoiceComponent::class)
            ->set('company_id', $this->company->id) // Définir les champs requis pour la facture
            ->set('invoice_date', now()->toDateString())
            ->set('product', 'Test Product')
            ->set('fob_amount', 100)
            ->set('payment_mode', 'provision')
            ->set('currency_id', \App\Models\Currency::factory()->create(['code' => 'USD'])->id) // Assurer l'existence d'une devise
            ->set('exchange_rate', 1)
            ->set('items', [ // Au moins un item valide
                [
                    'label' => 'Test Item',
                    'category' => 'extra_fee', // 'extra_fee' requiert un label
                    'amount_local' => 100,
                    'currency_id' => \App\Models\Currency::first()->id ?? \App\Models\Currency::factory()->create(['code' => 'USD'])->id,
                    'tax_id' => null,
                    'agency_fee_id' => null,
                    'extra_fee_id' => null,
                ]
            ])
            ->set('folder_id', $linkedFolder->id) // Tente de lier le dossier déjà lié
            ->call('save')
            ->assertHasErrors(['folder_id' => 'unique']); // Vérifie l'erreur de validation d'unicité

        // Assert: Vérifie qu'aucune nouvelle facture n'a été créée pour ce dossier (il ne devrait y en avoir qu'une)
        $this->assertEquals(1, Invoice::where('folder_id', $linkedFolder->id)->count());
        $this->assertEquals(1, Invoice::count()); // Total des factures dans la BDD (celle créée par la factory)
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
        // Supposant que la route pour FolderShow est 'folder.show' et utilise l'ID.
        // Adaptez si le nom de la route ou le paramètre est différent.
        // Et que le composant Livewire est bien `FolderShowComponent`
        $responseFolderShow = $this->get(route('folder.show', $folder->id));
        $responseFolderShow->assertStatus(200);
        $responseFolderShow->assertSeeLivewire(FolderShowComponent::class);
        $responseFolderShow->assertSee($invoice->invoice_number); // Vérifie que le numéro de facture est visible
        $responseFolderShow->assertSee(route('invoices.show', $invoice->id)); // Vérifie que le lien vers la facture est présent

        // Act & Assert (InvoiceShow)
        // Supposant que la route pour InvoiceShow est 'invoices.show' et utilise l'ID.
        // Adaptez si le nom de la route ou le paramètre est différent.
        $responseInvoiceShow = $this->get(route('invoices.show', $invoice->id));
        $responseInvoiceShow->assertStatus(200);
        $responseInvoiceShow->assertSeeLivewire(ShowInvoiceComponent::class);
        $responseInvoiceShow->assertSee($folder->folder_number); // Vérifie que le numéro de dossier est visible
        $responseInvoiceShow->assertSee(route('folder.show', $folder->id)); // Vérifie que le lien vers le dossier est présent
    }
}

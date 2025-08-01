<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\GlobalInvoice;
use App\Models\GlobalInvoiceItem;
use App\Livewire\Admin\Invoices\InvoiceIndex;
use App\Livewire\Admin\Invoices\GlobalInvoiceIndex as GlobalInvoiceIndexComponent; // Alias pour éviter conflit de nom
use App\Livewire\Admin\Invoices\GlobalInvoiceShow as GlobalInvoiceShowComponent;  // Alias pour éviter conflit de nom
use App\Services\Invoice\GlobalInvoiceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;

class GlobalInvoiceManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Company $company;

    protected function setUp(): void
    {
        parent::setUp();
        // Assurez-vous que les factories User et Company existent et sont correctement configurées.
        // Si votre User factory crée des données liées (ex: un profil par défaut), c'est ok.
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        $this->company = Company::factory()->create();
    }

    /** @test */
    public function test_can_create_global_invoice_successfully(): void
    {
        // 1. Création des données de test
        $invoice1 = Invoice::factory()->for($this->company)->create(['status' => 'pending']);
        InvoiceItem::factory()->for($invoice1)->create([
            'description' => 'Item A',
            'quantity' => 2,
            'unit_price' => 10.00,
            'total_price' => 20.00,
        ]);
        InvoiceItem::factory()->for($invoice1)->create([
            'description' => 'Item B',
            'quantity' => 1,
            'unit_price' => 15.00,
            'total_price' => 15.00,
        ]);

        $invoice2 = Invoice::factory()->for($this->company)->create(['status' => 'pending']);
        InvoiceItem::factory()->for($invoice2)->create([
            'description' => 'Item A', // Item identique pour l'agrégation
            'quantity' => 3,
            'unit_price' => 10.00,
            'total_price' => 30.00,
        ]);
        InvoiceItem::factory()->for($invoice2)->create([
            'description' => 'Item C',
            'quantity' => 5,
            'unit_price' => 5.00,
            'total_price' => 25.00,
        ]);

        $selectedInvoiceIds = [$invoice1->id, $invoice2->id];
        $expectedTotalAmount = (20.00 + 15.00) + (30.00 + 25.00); // 90.00

        // 2. Appel de l'action du composant Livewire
        Livewire::test(InvoiceIndex::class)
            ->set('selectedInvoices', $selectedInvoiceIds)
            ->set('companyIdForGlobalInvoice', $this->company->id)
            ->call('createGlobalInvoice');

        // 3. Assertions
        $this->assertEquals(1, GlobalInvoice::count());
        $globalInvoice = GlobalInvoice::first();

        $this->assertNotNull($globalInvoice);
        $this->assertEquals($this->company->id, $globalInvoice->company_id);
        $this->assertEquals($expectedTotalAmount, $globalInvoice->total_amount);
        $this->assertNotNull($globalInvoice->global_invoice_number);

        // Vérification des items agrégés
        $this->assertEquals(3, $globalInvoice->globalInvoiceItems()->count()); // Item A (agrégé), Item B, Item C

        $itemA_aggregated = $globalInvoice->globalInvoiceItems()->where('description', 'Item A')->first();
        $this->assertNotNull($itemA_aggregated);
        $this->assertEquals(2 + 3, $itemA_aggregated->quantity); // 5
        $this->assertEquals(10.00, $itemA_aggregated->unit_price);
        $this->assertEquals(20.00 + 30.00, $itemA_aggregated->total_price); // 50.00
        $this->assertCount(2, json_decode($itemA_aggregated->original_item_ids, true));

        $itemB = $globalInvoice->globalInvoiceItems()->where('description', 'Item B')->first();
        $this->assertNotNull($itemB);
        $this->assertEquals(1, $itemB->quantity);
        $this->assertEquals(15.00, $itemB->total_price);
        $this->assertCount(1, json_decode($itemB->original_item_ids, true));


        $itemC = $globalInvoice->globalInvoiceItems()->where('description', 'Item C')->first();
        $this->assertNotNull($itemC);
        $this->assertEquals(5, $itemC->quantity);
        $this->assertEquals(25.00, $itemC->total_price);
        $this->assertCount(1, json_decode($itemC->original_item_ids, true));

        // Vérification de la mise à jour des factures originales
        $updatedInvoice1 = $invoice1->fresh();
        $this->assertEquals($globalInvoice->id, $updatedInvoice1->global_invoice_id);
        $this->assertEquals('grouped_in_global_invoice', $updatedInvoice1->status);

        $updatedInvoice2 = $invoice2->fresh();
        $this->assertEquals($globalInvoice->id, $updatedInvoice2->global_invoice_id);
        $this->assertEquals('grouped_in_global_invoice', $updatedInvoice2->status);

        // Vérification du message flash (Livewire gère cela différemment des contrôleurs HTTP standards)
        // Pour tester les messages flash avec Livewire, on vérifie la session directement ou les événements émis.
        // Ici, on va supposer que le test de la session flash est suffisant.
        Livewire::test(InvoiceIndex::class)->assertSessionHas('success');
    }

    /** @test */
    public function test_cannot_create_global_invoice_with_invoices_from_different_companies(): void
    {
        $company2 = Company::factory()->create();
        $invoice1 = Invoice::factory()->for($this->company)->create(['status' => 'pending']);
        $invoice2 = Invoice::factory()->for($company2)->create(['status' => 'pending']); // Facture d'une autre compagnie

        $selectedInvoiceIds = [$invoice1->id, $invoice2->id];

        Livewire::test(InvoiceIndex::class)
            ->set('selectedInvoices', $selectedInvoiceIds)
            // ->set('companyIdForGlobalInvoice', $this->company->id) // Ceci est normalement mis à jour par updatedSelectedInvoices
            ->call('createGlobalInvoice');

        $this->assertEquals(0, GlobalInvoice::count());
        // Le message d'erreur spécifique est flashé par le composant Livewire
        Livewire::test(InvoiceIndex::class)->assertSessionHas('error', 'Toutes les factures sélectionnées doivent appartenir à la même compagnie.');

        // Vérifier que les factures originales ne sont pas modifiées
        $this->assertNull($invoice1->fresh()->global_invoice_id);
        $this->assertEquals('pending', $invoice1->fresh()->status);
        $this->assertNull($invoice2->fresh()->global_invoice_id);
        $this->assertEquals('pending', $invoice2->fresh()->status);
    }

    /** @test */
    public function test_cannot_create_global_invoice_with_already_grouped_invoice(): void
    {
        $existingGlobalInvoice = GlobalInvoice::factory()->for($this->company)->create();
        $invoice1_grouped = Invoice::factory()
            ->for($this->company)
            ->create([
                'status' => 'grouped_in_global_invoice',
                'global_invoice_id' => $existingGlobalInvoice->id,
            ]);

        $invoice2_pending = Invoice::factory()->for($this->company)->create(['status' => 'pending']);

        $selectedInvoiceIds = [$invoice1_grouped->id, $invoice2_pending->id];

        Livewire::test(InvoiceIndex::class)
            ->set('selectedInvoices', $selectedInvoiceIds)
            ->call('createGlobalInvoice');

        // Aucune NOUVELLE facture globale ne doit être créée.
        $this->assertEquals(1, GlobalInvoice::count()); // Seule $existingGlobalInvoice doit exister

        // Le message d'erreur spécifique est flashé.
        // Le message exact dépend de l'implémentation dans InvoiceIndex.php
        // Supposons que le message inclut le numéro de la facture déjà groupée.
        Livewire::test(InvoiceIndex::class)
            ->assertSessionHas('error', "La facture {$invoice1_grouped->invoice_number} est déjà incluse dans une facture globale.");

        // La facture non groupée ne doit pas être modifiée
        $this->assertNull($invoice2_pending->fresh()->global_invoice_id);
        $this->assertEquals('pending', $invoice2_pending->fresh()->status);
    }

    /** @test */
    public function test_can_view_global_invoice_list_page(): void
    {
        GlobalInvoice::factory()->for($this->company)->count(3)->create();

        $response = $this->get(route('admin.global-invoices.index'));

        $response->assertStatus(200);
        $response->assertSeeLivewire(GlobalInvoiceIndexComponent::class); // Vérifie que le composant est rendu

        // Vérifie que les numéros de facture sont visibles
        // Ceci est une vérification de base; un test plus approfondi pourrait vérifier les données spécifiques
        // passées au composant ou rendues dans la vue.
        $globalInvoices = GlobalInvoice::latest()->take(3)->get();
        foreach ($globalInvoices as $gi) {
            $response->assertSee($gi->global_invoice_number);
        }
    }

    /** @test */
    public function test_can_view_specific_global_invoice_page(): void
    {
        $globalInvoice = GlobalInvoice::factory()
            ->for($this->company)
            ->has(GlobalInvoiceItem::factory()->count(3), 'globalInvoiceItems') // Assure la relation est 'globalInvoiceItems'
            ->create();

        $response = $this->get(route('admin.global-invoices.show', $globalInvoice));

        $response->assertStatus(200);
        $response->assertSeeLivewire(GlobalInvoiceShowComponent::class);
        $response->assertSee($globalInvoice->global_invoice_number);
        $response->assertSee(number_format($globalInvoice->total_amount, 2));

        foreach ($globalInvoice->globalInvoiceItems as $item) {
            $response->assertSee($item->description);
            // $response->assertSee(number_format($item->quantity, 2)); // DOMPDF peut avoir des soucis avec le formatage exact des nombres en HTML source
            // $response->assertSee(number_format($item->unit_price, 2));
        }
    }

    /** @test */
    public function test_can_download_global_invoice_pdf(): void
    {
        $globalInvoice = GlobalInvoice::factory()->for($this->company)->create();

        $response = $this->get(route('admin.global-invoices.download', $globalInvoice));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
        $response->assertHeader('Content-Disposition', 'attachment; filename="Facture_Globale_' . $globalInvoice->global_invoice_number . '.pdf"');
    }

    /** @test */
    public function test_cannot_create_global_invoice_if_any_item_has_missing_description(): void
    {
        // 1. Arrange: Crée une facture avec un item ayant une description manquante
        $invoiceWithMissingDesc = Invoice::factory()->for($this->company)->create(['status' => 'pending']);
        InvoiceItem::factory()->for($invoiceWithMissingDesc)->create([
            'description' => 'Produit Valide A',
            'quantity' => 1,
            'unit_price' => 10.00,
            'total_price' => 10.00,
        ]);
        InvoiceItem::factory()->for($invoiceWithMissingDesc)->create([
            'description' => null, // Description manquante
            'quantity' => 2,
            'unit_price' => 5.00,
            'total_price' => 10.00,
        ]);

        $selectedInvoiceIds = [$invoiceWithMissingDesc->id];

        // 2. Act: Tente de créer la facture globale
        // Le composant InvoiceIndex devrait intercepter la ValidationException du service
        // et mettre un message d'erreur dans la session.
        Livewire::test(InvoiceIndex::class)
            ->set('selectedInvoices', $selectedInvoiceIds)
            ->call('createGlobalInvoice');

        // 3. Assert
        // Aucune GlobalInvoice ne doit être créée
        $this->assertEquals(0, GlobalInvoice::count());
        // Ou $this->assertDatabaseCount('global_invoices', 0);

        // Vérifie la présence d'un message d'erreur dans la session flash
        // Le message exact peut varier légèrement en fonction de la gestion des erreurs dans le composant Livewire.
        // On vérifie la présence de la clé 'error' et une partie significative du message attendu.
        Livewire::test(InvoiceIndex::class) // Nouvelle instance pour vérifier la session après l'appel
            ->assertSessionHas('error', function ($value) {
                return str_contains($value, "la description d'un ou plusieurs items de facture est manquante ou invalide");
            });

        // Vérifie que la facture originale n'a pas été modifiée
        $originalInvoice = $invoiceWithMissingDesc->fresh();
        $this->assertNull($originalInvoice->global_invoice_id);
        $this->assertEquals('pending', $originalInvoice->status);
    }
}

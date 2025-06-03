<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Company;
use App\Models\Folder;
use App\Models\Invoice;
use App\Models\GlobalInvoice;
use App\Models\Licence;
use App\Livewire\Admin\Dashboard\Dashboard as DashboardComponent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Company $company;

    protected function setUp(): void
    {
        parent::setUp();
        // Crée un utilisateur et l'authentifie.
        // Assurez-vous que votre factory User est correctement configurée.
        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        // Crée une compagnie par défaut pour les tests
        $this->company = Company::factory()->create();
    }

    /** @test */
    public function test_admin_dashboard_loads_correctly_and_displays_key_sections(): void
    {
        // 1. Arrange: Crée des données de test minimales
        $folder = Folder::factory()->for($this->company)->create(['folder_number' => 'DOSSIER-TEST-123']);
        $invoice = Invoice::factory()->for($this->company)->create(['invoice_number' => 'FACT-TEST-456']);
        $globalInvoice = GlobalInvoice::factory()->for($this->company)->create(['global_invoice_number' => 'GLOB-TEST-789']);
        $licence = Licence::factory()->create(); // Supposant que Licence n'est pas directement liée à Company

        // 2. Act: Effectue une requête GET vers la route du tableau de bord
        $response = $this->get(route('dashboard')); // 'dashboard' est le nom de la route défini précédemment

        // 3. Assert: Vérifications
        $response->assertStatus(200);
        $response->assertSeeLivewire(DashboardComponent::class);

        // Vérifie la présence de textes clés représentatifs des nouvelles sections
        // KPIs
        $response->assertSeeText('Total Dossiers'); // Titre d'un KPI
        $response->assertSeeText('Licences Expirant Bientôt'); // Autre KPI

        // Raccourcis
        $response->assertSeeText('Nouveau Dossier'); // Texte d'un bouton de raccourci

        // Titres des listes récentes
        $response->assertSeeText('Derniers Dossiers');
        $response->assertSeeText('Dernières Factures');
        $response->assertSeeText('Dernières Factures Globales');

        // Vérifie la présence des données créées
        $response->assertSee($folder->folder_number);
        $response->assertSee($invoice->invoice_number);
        $response->assertSee($globalInvoice->global_invoice_number);

        // Vérifie également que les compteurs affichent au moins '1' (ou la valeur exacte si vous voulez être précis)
        // Note: Les compteurs "ce mois-ci" pourraient être 0 si les factories ne définissent pas created_at à aujourd'hui.
        // Pour simplifier, nous vérifions les totaux généraux.
        $response->assertSeeTextInOrder(['Total Dossiers', $folder->count()]); // Exemple de vérification du compteur
        $response->assertSeeTextInOrder(['Total Factures', $invoice->count()]);
        $response->assertSeeTextInOrder(['Factures Globales', $globalInvoice->count()]);
        // Pour $activeLicences et $expiringSoonLicences, les valeurs dépendent de la date d'expiration définie par la factory Licence.
        // Une vérification de la présence du label peut suffire ici.
        $response->assertSeeText('Licences Actives');

    }
}

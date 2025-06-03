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
        // Ces assertions peuvent être fragiles si le formatage exact du nombre change (ex: espaces pour milliers)
        // Il est souvent préférable de vérifier la présence du label et de la donnée séparément si le formatage est complexe.
        $response->assertSeeText('Total Clients');
        $response->assertSeeTextInOrder(['Total Clients', (string)Company::count()]);

        $response->assertSeeText('Total Dossiers');
        $response->assertSeeTextInOrder(['Total Dossiers', (string)Folder::count()]);

        $response->assertSeeText('Total Factures');
        $response->assertSeeTextInOrder(['Total Factures', (string)Invoice::count()]);

        $response->assertSeeText('Factures Globales');
        $response->assertSeeTextInOrder(['Factures Globales', (string)GlobalInvoice::count()]);

        $response->assertSeeText('Licences Actives');
        // La valeur de $activeLicences et $expiringSoonLicences dépend de la date, donc on vérifie juste le label.
        $response->assertSeeText('Licences Expirant Bientôt');


        // Vérification des titres des nouvelles sections de listes récentes
        $response->assertSeeText('Derniers Clients Ajoutés');
        // $response->assertSeeText('Derniers Dossiers Créés'); // Le titre est "Derniers Dossiers" dans la nouvelle vue
        // $response->assertSeeText('Dernières Factures Créées'); // Le titre est "Dernières Factures"
        // $response->assertSeeText('Dernières Factures Globales Créées'); // Le titre est "Dernières Factures Globales"


        // Assurer que les données spécifiques sont visibles dans leurs sections respectives
        // Cela implique que les factories créent des données qui seront parmi les 5 plus récentes.
        // Si ce n'est pas garanti, ces tests pourraient être instables.
        // Pour plus de robustesse, on pourrait cibler plus spécifiquement le HTML des listes.
        // Pour l'instant, une simple vérification de présence est maintenue.
    }
}

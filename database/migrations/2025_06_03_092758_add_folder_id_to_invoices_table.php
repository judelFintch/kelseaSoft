<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Folder; // Importation du modèle Folder

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Ajoute la colonne folder_id et ses contraintes
            // Assure qu'un dossier ne peut être lié qu'à une seule facture (unique)
            // Si un dossier est supprimé, folder_id dans la facture devient NULL (onDelete('SET NULL'))
            $table->foreignIdFor(Folder::class)
                  ->nullable()
                  ->unique() // Un dossier ne peut être lié qu'à une seule facture
                  ->constrained()
                  ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Supprime la clé étrangère et la colonne folder_id
            // Le nom de la contrainte est généré par Laravel, ex: invoices_folder_id_foreign
            // Il est plus sûr de spécifier explicitement les colonnes pour dropForeign
            $table->dropForeign(['folder_id']);
            $table->dropColumn('folder_id');
        });
    }
};

<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
        UserSeeder::class,
        DocumentTypeSeeder::class,
        SupplierSeeder::class,
        DeclarationTypeSeeder::class,
        CustomsOfficeSeeder::class,
        LocationSeeder::class,
        TransporterSeeder::class,
        
        // Devise d'abord pour pouvoir référencer les autres montants
        CurrencySeeder::class,

        // Références monétaires
        TaxSeeder::class,
        AgencyFeeSeeder::class,
        ExtraFeeSeeder::class,

        // Entreprises et licences liées aux dossiers
        CompanySeeder::class,
       // LicenceSeeder::class,

        // Dossiers créés après les entités de référence
        //FolderSeeder::class,

        // Facturation (actuellement en commentaire)
       // InvoiceItemSeeder::class,
            
        ]);
    }
}
 
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // Blog seeders
        $this->call([
            BlogCategoriesSeeder::class,
            CreateBlogMirrorSeeder::class,
        ]);

        // Product seeders
        $this->call([
            CreateProductColorsSeeder::class,
            CreateProductMaterialsSeeder::class,
            CreateProductCategoriesSeeder::class,
            CreateProductSizesSeeder::class,
            CreateProductTypesSeeder::class,
            CreateProductsMirrorTriggerSeeder::class,
        ]);

        // Users and admins seeders
        $this->call([
            CreateAdminsSeeder::class,
            CreateUsersMirrorTriggerSeeder::class,
        ]);

        // Checkout seeders
        $this->call([
            CreateOrdersMirrorTriggerSeeder::class,
            CreateWishlistMirrorTriggerSeeder::class,
        ]);

        // Prices seeders
        $this->call([
            PriceTypeSeeder::class,
            CreatePriceTriggerSeeder::class,
            CreatePriceUpdateTriggerSeeder::class,
        ]);

        // Permissions seeders
        $this->call([
            RolesandPermissionsSeeder::class,
        ]);

        // Systems seeders
        $this->call([
            CreateFailedJobsMirrorSeeder::class,
            CreatePasswordResetTokensMirrorTriggerSeeder::class,
        ]);
    }
}

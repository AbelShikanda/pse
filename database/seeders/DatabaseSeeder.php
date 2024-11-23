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
        BlogCategoriesSeeder::class;
        CreateBlogMirrorSeeder::class;
        // Product seeders
        CreateProductColorsSeeder::class;
        CreateProductMaterialsSeeder::class;
        CreateProductCategoriesSeeder::class;
        CreateProductSizesSeeder::class;
        CreateProductTypesSeeder::class;
        CreateProductsMirrorTriggerSeeder::class;
        // Users and admins seeders
        CreateAdminsSeeder::class;
        CreateUsersMirrorTriggerSeeder::class;
        // Checkout seeders
        CreateOrdersMirrorTriggerSeeder::class;
        CreateWishlistMirrorTriggerSeeder::class;
        // Prices seeders
        PriceTypeSeeder::class;
        CreatePriceTriggerSeeder::class;
        CreatePriceUpdateTriggerSeeder::class;
        // Permissions seeders
        RolesandPermissionsSeeder::class;
        // Systems seeders
        CreateFailedJobsMirrorSeeder::class;
        CreatePasswordResetTokensMirrorTriggerSeeder::class;
    }
}

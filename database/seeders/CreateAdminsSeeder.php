<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateAdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Run a raw SQL insert
        DB::statement("
        INSERT INTO `admins` (`id`, `uuid`, `username`, `name`, `avatar`, `email`, `password`, `is_admin`, `created_at`, `updated_at`)
        VALUES 
            (5, 'e7ed7f10-7e8e-43f5-af31-ee6dfa65eb49', 'abel', 'abel', NULL, 'abelshikanda3@gmail.com', '$2y$10$3LYZlEfKFA4xzo84LPmtHuqDHxWIEcEeMqFNho/FXlLFFOs14aE1a', '1', NULL, NULL),
            (6, 'e7ed7f10-7e8e-48f5-af31-ee6dfa65fb49', 'fiona', 'fiona', NULL, 'liszt.luca2@gmail.com', '$2y$10$3LYZlEfKFA4xzo84LPmtHuqDHxWIEcEeMqFNho/FXlLFFOs14aE1a', '1', NULL, NULL);
        ");
    }
}

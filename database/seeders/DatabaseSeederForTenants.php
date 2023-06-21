<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeederForTenants extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /**
         * To run for all tenants without 'tenants:seed', just run --class=TenancySeeder
         */

        $this->call(
            static::seedersForTenants()
        );
    }

    /**
     * seedersForTenants function
     *
     * @return array
     */
    public static function seedersForTenants(): array
    {
        return [
            CategoriesAndPostsSeeder::class,
            DynamicContentSeeder::class,
            OrcamentoSeeder::class,
        ];
    }
}

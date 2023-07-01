<?php

namespace Database\Seeders\TenantSeeders;

use App\Models\DynamicContent;
use Illuminate\Database\Seeder;

class DynamicContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DynamicContent::factory(25)->create();
    }
}

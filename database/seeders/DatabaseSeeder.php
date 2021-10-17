<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\{
    Campaign,
    CampaignCreative
};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Campaign::factory(5)
        ->has(CampaignCreative::factory()->count(2), 'creatives')
        ->create();
    }
}

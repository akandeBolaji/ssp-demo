<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\Campaign;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CampaignTest extends TestCase
{
    public function campaign_listing()
    {
        $response= $this->get('api/campaign/index');

        $response->assertStatus(200);
    }

    public function create_campaign()
    {
        $data = [
            'name'          => $this->faker->name,
            'from'          => $this->faker->date(),
            'to'            => $this->faker->date(),
            'total_budget'  => $this->faker->randomDigit,
            'daily_budget'  => $this->faker->randomDigit,
            'creatives'     => [
                UploadedFile::fake()->image(
                    public_path('faker/images/img1.jpg')
                ),
                UploadedFile::fake()->image(
                    public_path('faker/images/img2.jpg')
                )
            ]
        ];
        $this->json('post','api/campaign/store', $data)
            ->assertStatus(201);
    }

    public function update_campaign()
    {
        $data = [
            'name'          => $this->faker->name,
            'from'          => $this->faker->date(),
            'to'            => $this->faker->date(),
            'total_budget'  => $this->faker->randomDigit,
            'daily_budget'  => $this->faker->randomDigit,
        ];
        $campaign = Campaign::first();
        $this->json('put','api/campaign/'.$campaign->id, $data)
            ->assertStatus(204);
    }
}

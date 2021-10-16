<?php

namespace Tests\Feature;

use App\Models\Campaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CampaignTest extends TestCase
{
    /** @test */
    public function campaign_listing()
    {
        $response= $this->get('api/campaign/index');

        $response->assertStatus(200);
    }

    /** @test */
    public function create_campaign()
    {
        $data['name']           = $this->faker->name;
        $data['from']           = $this->faker->date();
        $data['to']             = $this->faker->date();
        $data['total_budget']   = $this->faker->randomDigit;
        $data['daily_budget']   = $this->faker->randomDigit;
        $data['creatives'][]    = UploadedFile::fake()->image(
            public_path('faker/images/img1.jpg')
        );
        $data['creatives'][]    = UploadedFile::fake()->image(
            public_path('faker/images/img2.jpg')
        );
        $this->json('post','api/campaign/store',$data)
            ->assertStatus(201);
    }

    /** @test */
    public function update_campaign()
    {
        $data['name']           = $this->faker->name;
        $data['from']           = $this->faker->date();
        $data['to']             = $this->faker->date();
        $data['total_budget']   = $this->faker->randomDigit;
        $data['daily_budget']   = $this->faker->randomDigit;

        $campaign = Campaign::first();
        $this->json('put','api/campaign/'.$campaign->id,$data)
            ->assertStatus(204);
    }
}

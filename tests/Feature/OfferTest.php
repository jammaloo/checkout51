<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class OfferTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test that an empty list is returned.
     *
     * @return void
     */
    public function testOffersListEmpty()
    {
        $empty_response = $this->get('/api/offers');

        $empty_response
            ->assertStatus(200)
            ->assertJsonCount(0, 'offers');
    }

    /**
     * Test that a list of offers is returned.
     *
     * @return void
     */
    public function testOffersListPopulated()
    {
        // Create three Offers instances...
        \App\Models\Offer::factory()->count(5)->create();

        $populated_response = $this->get('/api/offers');
        $populated_response
            ->assertStatus(200)
            ->assertJsonCount(5, 'offers');
    }
}

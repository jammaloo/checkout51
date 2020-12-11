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
            ->assertJsonCount(0, 'offers.data')
            ->assertJsonPath('offers.total', 0);
    }

    /**
     * Test that a list of offers is returned.
     *
     * @return void
     */
    public function testOffersListPopulated()
    {
        $offer_count = 5;
        // Create some Offer instances...
        \App\Models\Offer::factory()->count($offer_count)->create();

        $populated_response = $this->get('/api/offers');
        $populated_response
            ->assertStatus(200)
            ->assertJsonCount($offer_count, 'offers.data')
            ->assertJsonPath('offers.total', $offer_count);
    }
}

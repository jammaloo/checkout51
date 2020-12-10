<?php

namespace Database\Seeders;

use App\Models\Offer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class OfferSeeder extends Seeder
{
    /**
     * Seed Offers from JSON file.
     *
     * @return void
     */
    public function run()
    {
        $offers_file = $this->loadOffersFile();

        // Wrap the offer creation in a transaction
        // If there is an issue with the loading of offers, we don't want a partially loaded file
        DB::transaction(function () use ($offers_file) {
            //Validate the provided batch ID
            $batch_id = $offers_file['batch_id'] ?? null;

            if (is_null($batch_id) || !is_int($batch_id) || $batch_id < 0) {
                throw new \InvalidArgumentException("Batch ID must be a positive integer");
            }

            if (!is_array($offers_file['offers'] ?? null)) {
                throw new \InvalidArgumentException("No offers found in batch");
            }

            foreach ($offers_file['offers'] as $offer_entry) {
                $offer = new Offer();
                $offer->id = $offer_entry['offer_id'] ?? null;
                $offer->batch_id = $batch_id;
                $offer->name = $offer_entry['name'] ?? null;
                $offer->image_url = $offer_entry['image_url'] ?? null;
                $offer->cash_back = $offer_entry['cash_back'] ?? 0;

                // Simple validation
                // In  a real application, this would be offloaded to a separate class
                // As the data source may come from many different locations, not just a single JSON file
                if (is_null($offer->id) || !is_int($offer->id)) {
                    throw new \InvalidArgumentException("Offer ID is missing or invalid");
                }
                if (empty($offer->name)) {
                    throw new \InvalidArgumentException("Offer Name is missing");
                }
                if (empty($offer->image_url)) {
                    throw new \InvalidArgumentException("Offer Image URL is missing");
                }
                if (is_null($offer->cash_back) || !is_numeric($offer->cash_back) || $offer->cash_back <= 0) {
                    throw new \InvalidArgumentException("Offer Cash Back is missing or is less than 0");
                } else {
                    // If cash back is a valid dollar amount, convert it into cents
                    $offer->cash_back *= floor(100);
                }
                $offer->saveOrFail();
            }
        });
    }

    /**
     * Load and parse the offers seed file.
     *
     * Returns the seed file contents as an associative array
     *
     * @return array
     */
    private function loadOffersFile() {
        // Load in offers seed file
        $offers_file_path = __DIR__ . '/../../resources/seed_files/offers.json';
        $offers_raw = file_get_contents($offers_file_path);

        // Check we could read the file
        if ($offers_raw === false) {
            throw new FileException("Offer file could not be read ($offers_file_path)");
        }

        // Parse the JSON
        $offers = json_decode($offers_raw, true);
        if (is_null($offers)) {
            throw new FileException("Offer file does not contain valid JSON ($offers_file_path)");
        }
        return $offers;
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            // Batch ID is undocumented, but likely could be used to differentiate data sets
            // Potentially it could be extracted and moved into a separate table
            $table->integer('batch_id');
            // Varchar 255 for the offer name and image URL
            $table->string('name');
            $table->string('image_url');
            // Integer, as working with prices is always easier in whole cents
            // as it removes concerns over rounding and floating point representation
            $table->integer('cash_back');

            // Some nice-to-haves, updated at, created at, and soft delete columns
            $table->timestamps();
            $table->softDeletes();

            // Indexes

            // Index on name and cash back, so we can filter/sort by those
            $table->index('name');
            $table->index('cash_back');

            // Index on cash_back->name and name->cash_back, so we can do a multiple column sort/filter
            // Overkill for a dataset this small, but realistically, users would want to be able to sort cash back and name
            $table->index(['cash_back', 'name']);
            $table->index(['name', 'cash_back']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function list(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'offers' => \App\Models\Offer::paginate(20),
        ]);
    }
}

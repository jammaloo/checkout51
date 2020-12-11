<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Traits\Listable;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    use Listable;
    public function list(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'offers' => $this->listModels(Offer::class, $request),
        ]);
    }
}

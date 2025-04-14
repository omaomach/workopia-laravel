<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class GeocodeController extends Controller
{
    // @desc    Make request to mapbox
    // @route   GET /geocode
    public function geocode(Request $request): JsonResponse
    {
        $address = $request->input('address');

        // Use the correct environment variable name
        $accessToken = env('MAP_API_KEY');

        if (!$address || !$accessToken) {
            return response()->json(['error' => 'Address or API key missing'], 400);
        }

        try {
            $response = Http::get("https://api.mapbox.com/geocoding/v5/mapbox.places/{$address}.json", [
                'access_token' => $accessToken,
            ]);

            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

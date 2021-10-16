<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReverseGeocodeController extends Controller
{
    public function __invoke(Request $request)
    {
        $latitude = $request->latitude ?? null;
        $longitude = $request->longitude ?? null;

        $googleApiKey = env('GOOGLE_API_KEY', null);

        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$latitude},{$longitude}&key={$googleApiKey}";
        $response = json_decode(file_get_contents($url), true);
        $address = $response['results'][0]['formatted_address'];
        return $address ?? null;
    }
}

<?php

namespace App\Http\Controllers\Rajaongkir;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Subdistrict;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getCities($provinceId)
    {
        $cities = City::where('province_id', $provinceId)->get();
        return response()->json(['cities' => $cities]);
    }

    public function getSubdistricts($cityId)
    {
        $subdistricts = Subdistrict::where('city_id', $cityId)->get();
        return response()->json(['subdistricts' => $subdistricts]);
    }
}

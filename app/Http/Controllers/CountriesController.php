<?php

namespace App\Http\Controllers;

use App\Http\Resources\CountryResource;
use App\Models\Country;
use Illuminate\Http\Request;

class CountriesController extends Controller
{
    public function index(Request $request)
    {
        $countries = Country::query()
            ->where('name', 'like', $request->q.'%')
            ->get();

        return $this->ok(
            CountryResource::collection($countries)
        );
    }
}

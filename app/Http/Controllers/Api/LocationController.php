<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function countries()
    {
        $countries = Country::all();

        if ($countries->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Record Not Found.'
                ], Response::HTTP_OK);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Record Found.',
                'data' => $countries
                ], Response::HTTP_OK);
        }
    }

    public function states(Request $request)
    {
        $states = State::where('country_id', $request->country_id)->get();
        if ($states->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Record Not Found.'
                ], Response::HTTP_OK);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Record Found.',
                'data' => $states
                ], Response::HTTP_OK);
        }
    }
}

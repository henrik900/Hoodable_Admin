<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Controller;
use App\Models\BusinessType;
use App\Models\Category;
use App\Models\Spot;
use App\Models\SpotCreator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SpotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      //  DB::connection()->enableQueryLog();
        $user_id = $request->user()->id;
        $spots = Spot::with(['spot_creator' => function($query) use($user_id) {
            $query->with('user');
            $query->where('user_id', $user_id);
        }, 'event' => function($query) {
            $query->where('event_type', 'event');
        }, 'promotion' => function($query) {
            $query->where('event_type', 'promotion');
        }, 'competition' => function($query) {
            $query->where('event_type', 'competition');
        }])->whereHas('spot_creator', function($query) use($user_id) {
            $query->where('user_id', $user_id);
        })->get();
    //    dd($spots);
  //  dd(DB::getQueryLog());
        if ($spots->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Record Not Found.'
                ], Response::HTTP_OK);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Record Found.',
                'data' => $spots
                ], Response::HTTP_OK);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_type_id' => 'required|integer',
            'category_id' => 'required|integer',
            'spot_name' => 'required|string',
            'spot_description' => 'required|string',
            'spot_phone' => 'required|string',
            'spot_website' => 'required|string',
        //    'spot_opening_time' => 'required|string',
            'location' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'The given data was invalid.', 'errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        //Create Spot
        $spot = new Spot([
            'business_type_id' => $request->business_type_id,
            'category_id' => $request->category_id,
            'spot_name' => $request->spot_name,
            'spot_description' => $request->spot_description,
            'spot_phone' => $request->spot_phone,
            'spot_website' => $request->spot_website,
            'spot_opening_time' => $request->spot_opening_time,
            'spot_ending_time' => $request->spot_ending_time,
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'image_url' => $request->image_url
        ]);
        $spot->save();
        $spot_id = $spot->id;

        //create spot user
        $spot_creator = new SpotCreator([
            'spot_id' => $spot_id,
            'user_id' => $request->user()->id
        ]);
        $spot_creator->save();

        return response()->json([
            'success' => true,
            'message' => 'Spot created successfully.'
            ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function businessTypes()
    {
        $business_types = BusinessType::all();

        if ($business_types->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Record Not Found.'
                ], Response::HTTP_OK);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Record Found.',
                'data' => $business_types
                ], Response::HTTP_OK);
        }
    }

    public function categories()
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Record Not Found.'
                ], Response::HTTP_OK);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Record Found.',
                'data' => $categories
                ], Response::HTTP_OK);
        }
    }

    public function spotList()
    {
    //    DB::connection()->enableQueryLog();
        $spots = Spot::with(['spot_creator' => function($query) {
            $query->with('user');
        }, 'event' => function($query) {
            $query->where('event_type', 'event');
            $query->where('end_date', '>', Carbon::now());
        }, 'promotion' => function($query) {
            $query->where('event_type', 'promotion');
        }, 'competition' => function($query) {
            $query->where('event_type', 'competition');
        }])->get();

        //dd(DB::getQueryLog());

        if ($spots->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Record Not Found.'
                ], Response::HTTP_OK);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Record Found.',
                'data' => $spots
                ], Response::HTTP_OK);
        }
    }

    public function search(Request $request)
    {
        $q = $request->get('query');
     //   dd($q);
        $spots = Spot::with(['spot_creator', 'event' => function($query) {
            $query->where('event_type', 'event');
        }, 'promotion' => function($query) {
            $query->where('event_type', 'promotion');
        }, 'competition' => function($query) {
            $query->where('event_type', 'competition');
        }])->where('spot_name', 'LIKE', '%'. $q . '%')->get();

        if ($spots->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Record Not Found.'
                ], Response::HTTP_OK);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Record Found.',
                'data' => $spots
                ], Response::HTTP_OK);
        }
    }

    public function spotUserAccess(Request $request)
    {
        $user_id = $request->user()->id;
        $validator = Validator::make($request->all(), [
            'spot_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'The given data was invalid.', 'errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $spot = Spot::where('id', $request->spot_id)->get();
        if ($spot->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Record Not Found.'
                ], Response::HTTP_NOT_FOUND);
        } else {
            $spot_access = new SpotCreator([
                'spot_id' => $request->spot_id,
                'user_id' => $request->user_id,
                'access_type' => 'editor'
            ]);

            $spot_access->save();

            return response()->json([
                'success' => true,
                'message' => 'User assigned successfully.'
                ], Response::HTTP_OK);
        }

    }
}

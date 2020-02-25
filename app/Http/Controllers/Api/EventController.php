<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventImage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_type' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Parameter missing.', 'errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user_id = $request->user()->id;
        $events = Event::where(['event_type' => $request->event_type])->get();
        if ($events->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Record Not Found.'
                ], Response::HTTP_OK);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Record Found.',
                'data' => $events
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
            'event_type' => 'required|string',
            'spot_id' => 'required|integer',
            'user_id' => 'required|integer',
            'name' => 'required|string',
            'description' => 'required|string',
            'start_date' => 'required|string',
            'end_date' => 'required|string',
            'location' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'The given data was invalid.', 'errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        //Create Event
        
        $event = new Event([
            'event_type' => $request->event_type,
            'spot_id' => $request->spot_id,
            'user_id' => $request->user_id,
            'name' => $request->name,
            'description' => addslashes($request->description),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => addslashes($request->location),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'image_url' => $request->image_url,
            'prizes' => $request->prizes,
            'crystal' => $request->crystal
        ]);
        $event->save();
        $event_id = $event->id;

        //Store images
    /*     $event_image = new EventImage([
            'event_id' => $event_id,
            'image_url' => $request->image_url
        ]);

        $event_image->save(); */
        $message = '';
        if ($request->event_type == 'event') 
        {
            $message = 'Event';
        } elseif ($request->event_type == 'promotion') {
            $message = 'Promotion';
        } else {
            $message = 'Competition';
        }

        return response()->json([
            'success' => true,
            'message' => $message.' created successfully.'
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
}

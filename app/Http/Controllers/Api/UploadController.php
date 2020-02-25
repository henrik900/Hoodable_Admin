<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        $imageData = new \stdClass;
        if ($request->hasFile('event_image') && $request->file('event_image')->isValid()) {
            $image = $request->file('event_image');
            $extension = $image->getClientOriginalExtension();
            $file_name = time() . rand(10, 100) . '.' . $extension;
            Storage::disk('public')->put('events/'.$file_name, File::get($image));
            $imageData->event_image = $file_name;
        }

        if ($request->hasFile('identity_image') && $request->file('identity_image')->isValid()) {
            $image = $request->file('identity_image');
            $extension = $image->getClientOriginalExtension();
            $file_name = time() . rand(10, 100) . '.' . $extension;
            Storage::disk('public')->put('user/identity/'.$file_name, File::get($image));
            $imageData->identity_image = $file_name;
        }

        if ($request->hasFile('video_clip') && $request->file('video_clip')->isValid()) {
            $image = $request->file('video_clip');
            $extension = $image->getClientOriginalExtension();
            $file_name = time() . rand(10, 100) . '.' . $extension;
            Storage::disk('public')->put('user/video/'.$file_name, File::get($image));
            $imageData->video_clip = $file_name;
        }

        if ($request->hasFile('spot_image') && $request->file('spot_image')->isValid()) {
            $image = $request->file('spot_image');
            $extension = $image->getClientOriginalExtension();
            $file_name = time() . rand(10, 100) . '.' . $extension;
            Storage::disk('public')->put('spots/'.$file_name, File::get($image));
            $imageData->spot_image = $file_name;
        }

        return response()->json([
            'success' => true,
            'message' => 'Image uploaded successfully.',
            'path' => $imageData
            ], Response::HTTP_CREATED);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UpgradeRequests;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user_id = $request->user()->id;
        $user = User::find((int) $user_id);

        return response()->json([
            'success' => true,
            'message' => 'Profile detail',
            'user' => $user
        ], Response::HTTP_OK);
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

    //Upgrade request user
    public function upgradeRequest(Request $request)
    {
        $user_id = $request->user()->id;
        $check_record = UpgradeRequests::where('user_id', $user_id)->first();
        $rand = rand(100000, 999999);
        if (is_null($check_record)) {
            $upgrade_request = new UpgradeRequests([
                'user_id' => $user_id,
                'request_status' => 'pending',
                'upgrade_code' => $rand
            ]);

            $upgrade_request->save();

            return response()->json([
                'success' => true,
                'message' => 'Request submitted successfully.'
            ], Response::HTTP_CREATED);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Your request has already been taken! Please contact to Administrator.'
            ], Response::HTTP_CREATED);
        }
    }

    //upgrade user
    public function upgrade(Request $request)
    {
        $user_id = $request->user()->id;
        $otp = $request->otp;
        $check_data = UpgradeRequests::where(['user_id' => $user_id, 'upgrade_code' => $otp])->get();
        //    dd($check_data->isEmpty());
        if ($check_data->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Otp does not matched.'
            ], Response::HTTP_OK);
        } else {
            $upgrade_user = User::find((int) $user_id);
            $upgrade_user->upgrade = 1;
            $upgrade_user->save();

            return response()->json([
                'success' => true,
                'message' => 'Your are upgraded to PRO User.'
            ], Response::HTTP_OK);
        }
    }

    public function updateProfileImage(Request $request)
    {
        $user_id = $request->user()->id;

        $validator = Validator::make($request->all(), [
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'The given data was invalid.', 'errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $image = $request->file('profile_image');
        $extension = $image->getClientOriginalExtension();
        $file_name = time() . rand(10, 100) . '.' . $extension;
        Storage::disk('public')->put('user/profile/' . $file_name, File::get($image));

        $user = User::find((int) $user_id);
        Storage::disk('public')->delete('user/profile/' . basename($user->profile_image));
        $user->profile_image = $file_name;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile image updated successfully',
            'user' => $user
        ], Response::HTTP_OK);
    }
}

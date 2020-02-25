<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @param [string] name
     * @param [string] email
     * @param [string] password
     * @param [string] phone
     */
    public function signup(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'family_name' => 'required|string',
        //    'date_of_birth' => 'required|string',
            'password' => 'required|string',
        //    'phone' => 'required|string',
        //    'postal_code' => 'required|string',
            'user_type' => 'required|string'
        ]);

        $validator->sometimes('paypal_id', 'required|string', function($input) {
            return $input->user_type == '1';
        });
        $validator->sometimes('country_id', 'required|integer', function($input) {
            return $input->user_type == '1';
        });
        $validator->sometimes('state_id', 'required|integer', function($input) {
            return $input->user_type == '1';
        });
        $validator->sometimes('address', 'required|string', function($input) {
            return $input->user_type == '1';
        });

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'The given data was invalid.', 'errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = new User([
            'user_type' => $request->user_type,
            'name' => $request->name,
            'email' => $request->email,
            'family_name' => $request->family_name,
            'date_of_birth' => $request->date_of_birth,
            'postal_code' => $request->postal_code,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'paypal_id' => $request->paypal_id,
            'active' => 1,
            'verified' => 1,
            'identity_image' => $request->identity_image,
            'video_clip' => $request->video_clip,
        ]);

        $user->save();

        Auth::login($user);

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();

        return response()->json([
            'success' => true, 
            'message' => 'Successfully created user!',
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'user' => $user
        ], Response::HTTP_CREATED);
    }

    /**
     * @param [string] email
     * @param [string] phone
     * @param [string] password
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     * @return [object] user
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $credentials = ['email' => $request->email, 'password' => $request->password];

        if (!Auth::attempt($credentials)) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();

        return response()->json([
            'success' => true,
            'message' => 'Logged in successfully',
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'user' => $user
            ], Response::HTTP_OK);
    }

    /**
     * Logout user (Revoke the token)
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $user = $request->user();
    //    $user->login_status = 'inactive';
    //    $user->save();
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Successfully logged out'], Response::HTTP_OK);
    }

}

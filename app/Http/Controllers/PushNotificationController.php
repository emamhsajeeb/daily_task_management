<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class PushNotificationController extends Controller
{
    public function updateDeviceToken(Request $request): \Illuminate\Http\JsonResponse
    {
        var_dump($request->token);
        Auth::user()->device_token =  $request->token;

        Auth::user()->save();

        return response()->json(['message' => 'Token successfully stored.']);

    }
}

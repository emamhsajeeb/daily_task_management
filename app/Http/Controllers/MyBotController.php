<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;

class MyBotController extends Controller
{
    public function handle(Request $request)
    {
        $botman = app('botman');

        // Retrieve user message from request payload
        $userInput = $request->input('message');

        // Process user message using BotMan
        $botman->hears($userInput, function (BotMan $bot) {
            // Your bot logic here
            $bot->reply('Hello! I am a BotMan chatbot.');
        });

        // Return response
        return response()->json(['message' => 'Bot response']);
    }

}

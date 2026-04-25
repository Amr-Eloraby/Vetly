<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Message;

class ChatController extends Controller
{
    // predict ai 
    public function predict(Request $request)
    {
        $request->validate([
            'animal' => 'required|string',
            'description' => 'required|string'
        ]);

        $user = auth()->user();
        $animal = $request->animal;

        $chat = Chat::firstOrCreate([
            'user_id' => $user->id,
            'animal_type' => $animal
        ]);

        $userMessage = Message::create([
            'chat_id' => $chat->id,
            'role' => 'user',
            'message' => $request->description
        ]);

        $history = Message::where('chat_id', $chat->id)
            ->latest()
            ->take(5)
            ->get()
            ->reverse()
            ->map(fn($msg) => [
                'role' => $msg->role,
                'content' => $msg->message
            ])
            ->toArray();
        $messages = array_merge([
            [
                'role' => 'system',
                'content' => "You are a professional veterinarian. Animal: {$animal}"
            ]
        ], $history);

        $messages[] = [
            'role' => 'user',
            'content' => $request->description
        ];

        $response = Http::timeout(30)
            ->withHeaders([
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ])
            ->post('https://vetly-ai-production.up.railway.app/predict', [
                'animal'=>$request->animal,
                'description' => $request->description
            ]);
            $aiText = "Prediction: " . $response['prediction'] . " " . 
                    "Attention: " . $response['attention'] . " " . 
                    "Treatment: " . $response['treatment'];
        if (!$response->successful()) {
            return response()->json([
                'error' => $response->body()
            ], 500);
        }

        $aiMessage = Message::create([
            'chat_id' => $chat->id,
            'role' => 'assistant',
            'message' => $aiText
        ]);

        return response()->json([
            'user_message' => [
                'id' => $userMessage->id,
                'message' => $userMessage->message,
                'role' => $userMessage->role,
                'created_at' => $userMessage->created_at->format('h:i A'),
            ],
            'ai_reply' => [
                'id' => $aiMessage->id,
                'message' => $aiMessage->message,
                'role' => $aiMessage->role,
                'created_at' => $aiMessage->created_at->format('h:i A'),
            ]
        ]);
    }

}

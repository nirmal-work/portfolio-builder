<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenAI;

class ChatbotController extends Controller
{
    public function chat(Request $request): JsonResponse
    {
        $request->validate([
            'message' => ['required', 'string', 'max:500'],
            'profile_slug' => ['required', 'string'],
        ]);

        try {
            $apiKey = config('services.openai.api_key');
            if (!$apiKey) {
                return response()->json(['error' => 'AI feature is not configured'], 503);
            }

            $client = OpenAI::client($apiKey);

            // Build context from portfolio data
            $user = User::where('slug', $request->profile_slug)->first();
            if (!$user) {
                return response()->json(['error' => 'Profile not found'], 404);
            }

            $profile = $user->profile;
            $context = $this->buildPortfolioContext($user, $profile);

            $response = $client->chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "You are a helpful assistant for {$user->name}'s portfolio. Answer questions about their profile, skills, projects, and experience based on this information:\n\n{$context}\n\nAlways be professional and helpful. Keep responses concise.",
                    ],
                    [
                        'role' => 'user',
                        'content' => $request->message,
                    ],
                ],
                'max_tokens' => 300,
                'temperature' => 0.7,
            ]);

            return response()->json([
                'reply' => $response->choices[0]->message->content,
            ]);
        } catch (\Exception $e) {
            \Log::error('Chatbot error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to get response from AI',
            ], 500);
        }
    }

    private function buildPortfolioContext($user, $profile): string
    {
        $context = "Name: {$user->name}\n";
        if (!empty(config('services.openai.api_key'))) {
            $context .= "Email: {$user->email}\n\n";
        }

        if ($profile) {
            if ($profile->title) {
                $context .= "Professional Title: {$profile->title}\n";
            }
            if ($profile->bio) {
                $context .= "Bio: {$profile->bio}\n\n";
            }
        }

        $skills = $user->skills()->get();
        if ($skills->count()) {
            $context .= "Skills:\n";
            foreach ($skills as $skill) {
                $context .= "- {$skill->name}" . ($skill->level ? " ({$skill->level})" : "") . "\n";
            }
            $context .= "\n";
        }

        $experiences = $user->experiences()->get();
        if ($experiences->count()) {
            $context .= "Work Experience:\n";
            foreach ($experiences as $exp) {
                $context .= "- {$exp->role} at {$exp->company}" . ($exp->duration ? " ({$exp->duration})" : "") . "\n";
            }
            $context .= "\n";
        }

        $projects = $user->projects()->get();
        if ($projects->count()) {
            $context .= "Projects:\n";
            foreach ($projects as $project) {
                $context .= "- {$project->title}: " . ($project->description ? substr($project->description, 0, 50) : "No description") . "\n";
            }
        }

        return $context;
    }
}

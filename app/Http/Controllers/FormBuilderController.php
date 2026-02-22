<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Services\GeminiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FormBuilderController extends Controller
{
    /**
     * Display the form builder interface.
     */
    public function index(): View
    {
        return view('builder.index');
    }

    /**
     * Generate a form using AI based on user prompt.
     */
    public function generate(Request $request): JsonResponse
    {
        // Validate the incoming request
        $validated = $request->validate([
            'prompt' => 'required|string|min:10|max:500',
        ]);

        try {
            // Get conversation history from session (default to empty array)
            $history = session('chat_history', []);

            // Call GeminiService to generate the form
            $geminiService = new GeminiService();
            $formData = $geminiService->generateForm($validated['prompt'], $history);

            // Append user message and AI response to chat history
            $history[] = [
                'role' => 'user',
                'content' => $validated['prompt'],
            ];
            $history[] = [
                'role' => 'assistant',
                'content' => json_encode($formData),
            ];

            // Save updated history back to session
            session(['chat_history' => $history]);

            return response()->json([
                'success' => true,
                'form' => $formData,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a new form in the database.
     */
    public function store(Request $request): JsonResponse
    {
        // Validate the incoming request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'schema' => 'required|array',
        ]);

        try {
            // Create a new form for the authenticated user
            $form = new Form();
            $form->user_id = auth()->id();
            $form->title = $validated['title'];
            $form->description = $validated['schema']['description'] ?? null;
            $form->slug = Form::generateSlug();
            $form->schema = $validated['schema'];
            $form->is_active = true;
            $form->save();

            return response()->json([
                'success' => true,
                'redirect' => '/dashboard',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Clear the chat history from session.
     */
    public function clearChat(): JsonResponse
    {
        session()->forget('chat_history');

        return response()->json([
            'success' => true,
        ]);
    }
}

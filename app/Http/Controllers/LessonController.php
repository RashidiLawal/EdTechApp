<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lessons = Lesson::all();
        return Inertia::render('Lessons/Index', [
            'lessons' => $lessons,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Lessons/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Lesson::create($request->all());

        return redirect()->route('lessons.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson)
    {
        return Inertia::render('Lessons/Show', [
            'lesson' => $lesson,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson)
    {
        return Inertia::render('Lessons/Edit', [
            'lesson' => $lesson,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lesson $lesson)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $lesson->update($request->only(['title', 'content']));

        return redirect()->route('lessons.show', $lesson);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->route('lessons.index');
    }

    public function ask(Request $request, Lesson $lesson)
{
    $request->validate([
        'question' => 'required|string',
    ]);

    $question = $request->input('question');
    $lessonText = $lesson->content;

    try {
        $apiKey = env('COHERE_API_KEY');
        if (!$apiKey) {
            throw new \Exception('Cohere API key is not set.');
        }
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'https://api.cohere.ai/',
            'headers' => [
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ],
        ]);

        $prompt = "Lesson: $lessonText\n\nStudent question: $question\n\nAnswer as a helpful tutor:";
        $response = $client->post('v1/generate', [
            'json' => [
                'model' => 'command', // or 'command-light' for faster/cheaper
                'prompt' => $prompt,
                'max_tokens' => 200,
                'temperature' => 0.7,
            ],
        ]);
        $data = json_decode($response->getBody(), true);
        $answer = $data['generations'][0]['text'] ?? 'Sorry, I could not answer that.';
    } catch (\Throwable $e) {
        return response()->json([
            'answer' => null,
            'recommendations' => [],
            'error' => $e->getMessage(),
        ], 500);
    }

    $recommendations = Lesson::where('id', '!=', $lesson->id)->limit(3)->get(['id', 'title']);

    return response()->json([
        'answer' => $answer,
        'recommendations' => $recommendations,
    ]);
}
}

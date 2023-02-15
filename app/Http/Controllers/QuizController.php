<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class QuizController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        Quiz::create([
            'user_id' => currentUser()->id,
            'name' => $request->name,
            'structure' => $request->structure
        ]);

        return response()->services(true, 'La encuesta fue registrada correctamente');
    }

    public function edit(int $id)
    {
        $quiz = Quiz::find($id);
        return view('quiz.edit', ['quiz' => $quiz]);
    }

    public function search(Request $request): JsonResponse
    {
        $quizzes = Quiz::selectRaw('id, name')
            ->whereRaw('name like "%'.$request->name.'%"')
            ->orderByDesc('id')
            ->paginate(15);

        return response()->services(true, 'Lista de encuestas', $quizzes);
    }
    public function list(Request $request): JsonResponse
    {
        $quizzes = Quiz::selectRaw('id, name,structure')
            ->get();
        return response()->services(true, 'Lista de encuestas', $quizzes);
    }

    public function delete(int $id): JsonResponse
    {
        Quiz::find($id)->delete();
        return response()->services(true, 'La encuesta fue eliminada');
    }

    public function getQuiz(int $id)
    {
       $quiz = Quiz::find($id);
       return response()->services(true, '', $quiz);
    }
    
    public function update(Request $request){
        Quiz::find($request->id)->update([
            'name' => $request->name,
            'structure' => $request->structure,
        ]);
        return response()->services(true, 'La encuesta fue actualizada correctamente');
    }
}

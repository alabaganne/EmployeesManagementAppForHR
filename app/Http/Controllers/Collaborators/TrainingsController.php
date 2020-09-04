<?php

namespace App\Http\Controllers\Collaborators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TrainingsController extends Controller
{
    private function validateTraining($request) {
        $request->validate([
            'name' => 'required',
            'duration' => 'required|integer' // ! hours: integer
        ]);
    }

    public function index($user_id) {
        return response()
            ->json(Training::where('user_id', $user_id)->get(), 200);
    }

    public function store(Request $request, $user_id) {
        $validatedData = $this->validateTraining($request);
        
        $training = new Training();

        $training->name = $validatedData['name'];
        $training->duration = $validatedData['duration'];
        $training->user_id = $user_id;

        $training->save();

        return response()->json([
            'message' => 'A training has been created.'
        ], 201);
    }

    public function update(Request $request, $training_id) {
        Training::findOrFail($training_id)
            ->update(
                $this->validateTraining($request)
            );
        
        return response()->json([
            'message' => 'Training updated.'
        ], 200);
    }

    public function destroy($training_id) {
        Training::findOrFail($training_id)
            ->update(
                $this->validateTraining($request)
            );
    }
}

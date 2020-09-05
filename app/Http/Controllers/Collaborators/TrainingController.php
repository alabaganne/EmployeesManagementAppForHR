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

    public function index(User $user) {
        return response()
            ->json(Training::where('user_id', $user->id)->get(), 200);
    }

    public function store(Request $request, User $user) {
        $validatedData = $this->validateTraining($request);
        
        $training = new Training();

        $training->name = $validatedData['name'];
        $training->duration = $validatedData['duration'];
        $training->user_id = $user->id;

        $training->save();

        return response()->json([
            'message' => 'Training created.'
        ], 201);
    }

    public function update(Request $request, Training $training) {
        $training->update(
            $this->validateTraining($request)
        );
        
        return response()->json([
            'message' => 'Training updated.'
        ], 200);
    }

    public function destroy(Training $training) {
        $training->update(
            $this->validateTraining($request)
        );

        return response()->json([ 'message' => 'User training deleted.' ], 200);
    }
}

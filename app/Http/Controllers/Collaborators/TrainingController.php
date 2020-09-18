<?php

namespace App\Http\Controllers\Collaborators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    private function validateTraining($request) {
        $request->validate([
            'entitled' => 'required|regex:' . $this->custom_regex,
            'start_date' => 'required|date',
            'duration' => 'required|integer',
            'note' => 'required|numeric'
        ]);
    }

    public function index(User $user) {
        return response()
            ->json(Training::where('user_id', $user->id)->get(), 200);
    }

    public function store(Request $request, User $user) {
        $validatedData = $this->validateTraining($request);
        
        $training = new Training();

        $training->entitled = $validatedData['entitled'];
        $training->start_date = $validatedData['start_date'];
        $training->duration = $validatedData['duration'];
        $training->note = $validatedData['note'];
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
        
        return response()->json([], 200);
    }

    public function destroy(Training $training) {
        $training->update(
            $this->validateTraining($request)
        );

        return response()->json([], 200);
    }

    public function isValid(Request $request) {
        $this->validateTraining($request);

        return response()->json([], 200);
    }
}

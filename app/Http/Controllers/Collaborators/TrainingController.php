<?php

namespace App\Http\Controllers\Collaborators;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Training;

use App\Http\Requests\Training as TrainingRequest;
use App\Http\Resources\TrainingResource;

class TrainingController extends Controller
{
    public function __construct() {
        $this->middleware('can:edit-collaborator')
            ->only('store, update');
    }

    public function index(User $user) {
        return response()->json(
            TrainingResource::collection(
                Training::where('user_id', $user->id)->get()
            ), 200
        );
    }

    public function store(TrainingRequest $request, User $user) {
        $validated = $request->validated();
        
        $training = new Training();

        $training->entitled = $validated['entitled'];
        $training->start_date = $validated['start_date'];
        $training->duration = $validated['duration'];
        $training->note = $validated['note'];
        $training->user_id = $user->id;

        $training->save();

        return response()->json([], 201);
    }

    public function update(TrainingRequest $request, User $user, Training $training) {
        $training->update(
            $request->validated()
        );
        
        return response()->json([], 200);
    }

    public function destroy(Training $training) {
        $training->delete();

        return response()->json([], 200);
    }

    
}

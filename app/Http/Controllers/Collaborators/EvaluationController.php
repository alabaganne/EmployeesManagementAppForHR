<?php

namespace App\Http\Controllers\Collaborators;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Evaluation;
use App\Http\Requests\Evaluation as EvaluationRequest;
use App\Http\Resources\EvaluationResource;

class EvaluationController extends Controller
{
    public function __construct() {
        $this->middleware('can:edit-collaborator')
            ->only('store, update');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        return response()->json(
            EvaluationResource::collection(
                Evaluation::where('user_id', $user->id)->get()
            ),
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EvaluationRequest $request, User $user)
    {
        $validated = $request->validated();

        $evaluation = new Evaluation();

        $evaluation->type = $validated['type'];
        $evaluation->manager = $validated['manager'];
        $evaluation->date = $validated['date'];
        $evaluation->status = $validated['status'];
        $evaluation->user_id = $user->id;

        $evaluation->save();

        return response()->json([], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EvaluationRequest $request, User $user, Evaluation $evaluation)
    {
        $evaluation->update($request->validated());
        
        return response()->json([], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Evaluation $evaluation)
    {
        $evaluation->delete();
        
        return response()->json([], 200);
    }
}

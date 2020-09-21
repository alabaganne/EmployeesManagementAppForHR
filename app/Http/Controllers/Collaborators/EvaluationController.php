<?php

namespace App\Http\Controllers\Collaborators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Evaluation;

class EvaluationController extends Controller
{
    // validate Evaluation
    private function validateEvaluation($request) {
        return $request->validate([
            'type' => 'required',
            'manager' => 'required|regex:' . $this->custom_regex,
            'date' => 'required|date',
            'status' => 'required',
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        return response()->json(
            Evaluation::where('user_id', $user->id)->get(),
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $validatedData = $this->validateEvaluation($request);

        $evaluation = new Evaluation();

        $evaluation->type = $validatedData['type'];
        $evaluation->manager = $validatedData['manager'];
        $evaluation->date = $validatedData['date'];
        $evaluation->status = $validatedData['status'];
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
    public function update(Request $request, Evaluation $evaluation)
    {
        $evaluation->update(
            $this->validateEvaluation($request)
        );
        
        return response()->json([], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evaluation $evaluation)
    {
        $evaluation->delete();
        
        return response()->json([], 200);
    }

    public function isValid(Request $request) {
        $this->validateEvaluation($request);

        return response()->json([], 200);
    }
}

<?php

namespace App\Http\Controllers\Collaborators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EvaluationsController extends Controller
{
    // ! Validate Evaluation
    private function validateEvaluation($request) {
        return $request->validate([
            'type' => 'required',
            'manager' => 'required',
            'date' => 'required|date',
            'status' => 'required',
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        return response()->json([
            'Evaluations' => Evaluation::where('user_id', $user_id)->get()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $user_id)
    {
        $validatedData = $this->validateEvaluation($request);

        $evaluation = new Evaluation();

        $evaluation->type = $validatedData['type'];
        $evaluation->manager = $validatedData['manager'];
        $evaluation->date = $validatedData['date'];
        $evaluation->status = $validatedData['status'];
        $evaluation->user_id = $user_id;

        $evaluation->save();

        return response()->json([
            'message' => 'Evaluation created.'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $evaluation_id)
    {
        Evaluation::findOrFail($evaluation_id)
            ->update(
                $this->validateEvaluation($request)
            );
        
        return response()->json([
            'message' => 'Evaluation updated.'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($evaluation_id)
    {
        Evaluation::findOrFail($evaluation_id)
            ->delete();
        
        return response()->json([
            'message' => 'Evaluation deleted.'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Collaborators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LeavesController extends Controller
{
    // ! Validate Leave
    private function validateLeave($request) {
        return $request->validate([
            'days' => 'required|integer'
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
            'leaves' => Leave::where('user_id', $user_id)->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $user_id)
    {
        $validatedData = $this->validateLeave($request);

        $leave = new Leave();

        $leave->days = $validatedData['days'];
        $leave->user_id = $user_id;

        $leave->save();

        return response()->json([
            'message' => 'Leave created.'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $leave_id)
    {
        Leave::findOrFail($leave_id)
            ->update(
                $this->validateLeave($request)
            );
        
        return response()->json([
            'message' => 'Leave updated.'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($leave_id)
    {
        Leave::findOrFail($leave_id)
            ->delete();
        
        return response()->json([
            'message' => 'Leave deleted.'
        ]);
    }
}

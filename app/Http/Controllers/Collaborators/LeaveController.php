<?php

namespace App\Http\Controllers\Collaborators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Leave;

class LeaveController extends Controller
{
    // validate Leave
    private function validateLeave($request) {
        return $request->validate([
            'type' => 'required|regex:' . $this->custom_regex,
            'days' => 'required|integer'
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        return response()->json(Leave::where('user_id', $user->id)->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $validatedData = $this->validateLeave($request);

        $leave = new Leave();

        $leave->type = $validatedData['type'];
        $leave->days = $validatedData['days'];
        $leave->user_id = $user->id;

        $leave->save();

        return response()->json([], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Leave $leave)
    {
        $leave->update(
            $this->validateLeave($request)
        );
        
        return response()->json([], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leave $leave)
    {
        $leave->delete();
        
        return response()->json([], 200);
    }

    public function isValid(Request $request) {
        $this->validateLeave($request);

        return response()->json([], 200);
    }
}

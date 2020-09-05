<?php

namespace App\Http\Controllers\Collaborators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Skill;

class SkillsController extends Controller
{
    // ! Validate skill
    private function validateSkill($request) {
        return $request->validate([
            'name' => 'required',
            'note' => 'required|integer'
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
            Skill::where('user_id', $user->id)->get(), 200
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
        $validatedData = $this->validateSkill($request);

        $skill = new Skill();
        $skill->name = $validatedData['name'];
        $skill->note = $validatedData['note'];
        $skill->user_id = $user->id;

        $skill->save();

        return response()->json([
            'message' => 'A new skill has been added to ' . $user->name
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, Skill $skill)
    {
        $skill->update(
            $this->validateSkill($request)
        );

        return response()->json([
            'message' => 'Skill for ' . $user->name . ' has been updated.'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Skill $skill)
    {
        $skill->delete();

        return response()->json([
            'message' => "A skill has been deleted successfully."
        ], 200);
    }
}

<?php

namespace App\Http\Controllers\Collaborators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Skill;

class SkillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $user_id)
    {
        $validatedData = $this->validateSkill($request);

        $skill = new Skill();
        $skill->name = $validatedData['name'];
        $skill->note = $validatedData['note'];

        $skill->user_id = auth()->user()->id;

        $skill->save();

        return response()->json([
            'message' => 'Skill added successfully.'
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $skill_id)
    {
        Skill::findOrFail($skill_id)->update(
            $this->validateSkill($request)
        );

        return response()->json([
            'message' => 'Skill updated successfully.'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($skill_id)
    {
        Skill:findOrFail($skill_id)->delete();

        return response()->json([
            'message' => 'Skill deleted successfully.'
        ]);
    }

    private function validateSkill($request) {
        $request->validate([
            'name' => 'required',
            'note' => 'required|integer'
        ]);
    }
}

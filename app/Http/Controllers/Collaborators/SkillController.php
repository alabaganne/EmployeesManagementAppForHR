<?php

namespace App\Http\Controllers\Collaborators;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Skill;

use App\Http\Resources\UserSkillResource;
use App\Http\Requests\Skill as SkillRequest;

/**
 * @OA\requestBody(
 *      request="skillRequestBody",
 *      required=true,
 *      description="Skill request",
 *      @OA\JsonContent(ref="#/components/schemas/skill")
 * ),
 * 
 * @OA\Parameter(
 *      parameter="skill_id",
 *      name="skill_id",
 *      description="Skill ID",
 *      in="path",
 *      required=true,
 *      @OA\Schema(
 *          type="integer",
 *          format="int64"
 *      )
 * ),
 * 
 * @OA\PathItem(
 *      path="/api/collaborators/{user_id}/skills",
 *      @OA\parameter(ref="#/components/parameters/user_id"),
 * ),
 * 
 * @OA\PathItem(
 *      path="/api/collaborators/{user_id}/skills/{skill_id}",
 *      @OA\parameter(ref="#/components/parameters/user_id"),
 *      @OA\parameter(ref="#/components/parameters/skill_id"),
 * ),
*/

class SkillController extends Controller
{
    public function __construct() {
        $this->middleware('can:edit-collaborator')
            ->only('store, update');
    }
    /**
     * @OA\Get(
     *      path="/api/collaborators/{user_id}/skills",
     *      tags={"Skills"},
     *      summary="User skills",
     *      description="Get user skills",
     *      @OA\RequestBody(ref="#/components/requestBodies/skillRequestBody"),
     *      @OA\Response(
     *          response=200,
     *          description="User skills list",
     *          @OA\JsonContent(ref="#/components/schemas/skill")
     *      ),
     *      @OA\Response(response=401, ref="#/components/responses/unauthenticated"),
     *      @OA\Response(response=403, ref="#/components/responses/unauthorized"),
     *      @OA\Response(response=422, ref="#/components/responses/invalid-data")
     * )
    */
    public function index(User $user)
    {
        $userSkills = $user->skills()->get();

        return response()->json(
            UserSkillResource::collection($userSkills), 200
        );
    }

    /**
     * @OA\Post(
     *      path="/api/collaborators/{user_id}/skills",
     *      tags={"Skills"},
     *      summary="Assign a skill to a user",
     *      description="Assign a skill to a user",
     *      @OA\requestBody(ref="#/components/requestBodies/skillRequestBody"),
     *      @OA\Response(response=200, ref="#/components/responses/success"),
     *      @OA\Response(response=401, ref="#/components/responses/unauthenticated"),
     *      @OA\Response(response=403, ref="#/components/responses/unauthorized"),
     *      @OA\Response(response=422, ref="#/components/responses/invalid-data")
     * )
    */
    public function store(SkillRequest $request, User $user)
    {
        $validated = $request->validated();

        $skill = Skill::where('name', $validated['name'])->first();
        if(! $skill) {
            $skill = Skill::create(['name' => $validated['name']]);
        }

        $user->skills()->attach($skill, ['note' => $validated['note']]);

        // $skill = new Skill();
        // $skill->name = $validated['name'];
        // $skill->note = $validated['note'];
        // $skill->user_id = $user->id;
        // $skill->save();

        return response()->json([], 201);
    }

    /**
     * @OA\Put(
     *      path="/api/collaborators/{user_id}/skills/{skill_id}",
     *      tags={"Skills"},
     *      summary="Edit user skill",
     *      description="Update a skill for a user",
     *      @OA\requestBody(ref="#/components/requestBodies/skillRequestBody"),
     *      @OA\Response(response=200, ref="#/components/responses/success"),
     *      @OA\Response(response=401, ref="#/components/responses/unauthenticated"),
     *      @OA\Response(response=403, ref="#/components/responses/unauthorized"),
     *      @OA\Response(response=422, ref="#/components/responses/invalid-data")
     * )
    */
    public function update(SkillRequest $request, User $user, $skill_id) // "name" and "note" are present on the request object
    {
        $validated = $request->validated();
        $skill = Skill::find($skill_id);
        
        if($skill->name !== $validated['name']) {
            $user->skills()->detach($skill);
            
            if(count($skill->users) === 0) // delete skill if no user has it 
                $skill->delete();

            $newSkill = Skill::create(['name' => $validated['name']]);
            $user->skills()->attach($newSkill, ['note' => $validated['note']]);
        } else {
            $user_skill_pivot = $user->skills()->wherePivot('skill_id', $skill_id)->first()->pivot;
            $user_skill_pivot->update(['note' => $validated['note']]);
        }

        return response()->json([], 200);
    }

    /**
     * @OA\Delete(
     *      path="/api/collaborators/{user_id}/skills/{skill_id}",
     *      tags={"Skills"},
     *      summary="Revoke a skill from a user",
     *      description="Revoke a skill to a user and delete it if no user still have it",
     *      @OA\Response(response=200, ref="#/components/responses/success"),
     *      @OA\Response(response=401, ref="#/components/responses/unauthenticated"),
     *      @OA\Response(response=403, ref="#/components/responses/unauthorized")
     * )
    */
    public function destroy(User $user, Skill $skill)
    {
        $user->skills()->detach($skill);

        if(count($skill->users) === 0)
            $skill->delete();

        return response()->json([], 200);
    }
}

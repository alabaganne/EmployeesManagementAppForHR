<?php

namespace App\Http\Controllers\Collaborators;

use App\Http\Controllers\Controller;
use App\Http\Requests\Leave as LeaveRequest;
use App\Http\Resources\LeaveResource;
use App\Models\User;
use App\Models\Leave;

/**
 * @OA\Parameter(
 *      parameter="leave_id",
 *      name="leave_id",
 *      description="Leave ID",
 *      in="path",
 *      required=true,
 *      @OA\Schema(
 *          type="integer",
 *          format="int64"
 *      )
 * ),
 * 
 * @OA\PathItem(
 *      path="/api/collaborators/{user_id}/leaves",
 *      @OA\Parameter(ref="#/components/parameters/user_id"),
 * ),
 * 
 * @OA\PathItem(
 *      path="/api/collaborators/{user_id}/leaves/{leave_id}",
 *      @OA\Parameter(ref="#/components/parameters/user_id"),
 *      @OA\Parameter(ref="#/components/parameters/leave_id")
 * ),
 * 
 * @OA\RequestBody(
 *      request="leaveRequestBody",
 *      required=true,
 *      @OA\JsonContent(ref="#/components/schemas/leave")
 * )
*/

class LeaveController extends Controller
{
    public function __construct() {
        $this->middleware('can:edit-collaborator')
            ->only('store, update');
    }
    /**
     * @OA\Get(
     *      path="/api/collaborators/{user_id}/leaves",
     *      tags={"Leaves"},
     *      summary="Get user leaves",
     *      description="Get all user leaves",
     *      @OA\Response(
     *          response=200,
     *          description="User leaves",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/leave")
     *          )
     *      ),
     *      @OA\Response(response=401, ref="#/components/responses/unauthenticated"),
     *      @OA\Response(response=403, ref="#/components/responses/unauthorized")
     * )
    */
    public function index(User $user)
    {
        return response()->json(LeaveResource::collection(
            Leave::where('user_id', $user->id)->get()
        ), 200);
    }

    /**
     * @OA\Post(
     *      path="/api/collaborators/{user_id}/leaves",
     *      tags={"Leaves"},
     *      summary="Add a new leave to a user",
     *      description="Add a new leave to a user",
     *      @OA\requestBody(ref="#/components/requestBodies/leaveRequestBody"),
     *      @OA\Response(response=200, ref="#/components/responses/success"),
     *      @OA\Response(response=401, ref="#/components/responses/unauthenticated"),
     *      @OA\Response(response=403, ref="#/components/responses/unauthorized")
     * )
    */
    public function store(LeaveRequest $request, User $user)
    {
        $validated = $request->validated();

        $leave = new Leave();

        $leave->type = $validated['type'];
        $leave->days = $validated['days'];
        $leave->user_id = $user->id;

        $leave->save();

        return response()->json([], 201);
    }

    /**
     * @OA\Put(
     *      path="/api/collaborators/{user_id}/leaves/{leave_id}",
     *      tags={"Leaves"},
     *      summary="Update user leave",
     *      description="Update specified user leave",
     *      @OA\RequestBody(ref="#/components/requestBodies/leaveRequestBody"),
     *      @OA\Response(response=200, ref="#/components/responses/success"),
     *      @OA\Response(response=401, ref="#/components/responses/unauthenticated"),
     *      @OA\Response(response=403, ref="#/components/responses/unauthorized"),
     * )
    */
    public function update(LeaveRequest $request, User $user, Leave $leave)
    {
        $leave->update($request->validated());

        return response()->json([], 200);
    }

    /**
     * @OA\Delete(
     *      path="/api/collaborators/{user_id}/leaves/{leave_id}",
     *      tags={"Leaves"},
     *      summary="Delete a specified leave from storage",
     *      description="Delete a specified leave from storage",
     *      @OA\RequestBody(ref="#/components/requestBodies/leaveRequestBody"),
     *      @OA\Response(response=200, ref="#/components/responses/success"),
     *      @OA\Response(response=401, ref="#/components/responses/unauthenticated"),
     *      @OA\Response(response=403, ref="#/components/responses/unauthorized"),
     * )
    */
    public function destroy(User $user, Leave $leave) // /api/collaborators/1/leaves/5
    {
        $leave->delete();
        
        return response()->json([], 200);
    }
}

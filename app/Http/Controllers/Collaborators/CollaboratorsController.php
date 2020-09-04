<?php

namespace App\Http\Controllers\Collaborators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User; // collaborator
use Spatie\Permission\Models\Role;
use App\UserHasRole;

$alpha_space_regex = 'regex:/^[a-z A-Z]+$/i';

class CollaboratorsController extends Controller
{
    public function index() {
        $collaborators = User::doesntHave('roles')->get();

        return response()->json([
            'users_without_roles' => $users
        ]);
    }
    
    public function show($user_id) {
        return response()->json([
            'collaborator' => User::findOrFail($user_id)
        ]);
    }

    public function store(Request $request) {
        $user = User::create(
            $this->validateCollaborator($request)
        );

        return response()->json(['message' => 'User successfully created.'], 201);
    }

    public function update($user_id, Request $request) {
        User::findOrFail($user_id)->update(
            $this->validateCollaborator($request)
        );

        return response()->json([
            'message' => 'Collaborator updated successfully.'
        ], 200);
    }

    public function destroy($user_id) {
        User::findOrFail($user_id)->delete();

        return response()->json([
            'message' => 'Collaborator deleted successfully'
        ], 200);
    }

    private function validateCollaborator($request) {
        return $request->validate([
            'name' => 'required|' . $alpha_space_regex,
            'email' => 'required|email|unique:users',
            'birth_date' => 'date',
            'phone_number' => 'numeric|size:8',
            'school' => $alpha_space_regex,
            'position' => $alpha_space_regex,
            'department_id' => 'integer',
            'contract_start_date' => 'date',
            'contract_end_date' => 'date',
            'gender' => Rule::in(['male', 'female']),
            'allowed_leaves' => 'integer',
            'ncin' => 'numeric|size:8'
        ]);
    }
}

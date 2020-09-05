<?php

namespace App\Http\Controllers\Collaborators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User; // collaborator
use Spatie\Permission\Models\Role;
use App\UserHasRole;

class CollaboratorsController extends Controller
{
    private $alpha_space_regex = 'regex:/^[a-z A-Z]+$/i';

    private function validateCollaborator($request) {
        return $request->validate([
            'name' => 'required|' . $this->alpha_space_regex,
            'email' => 'required|email|unique:users',
            'birth_date' => 'date',
            'phone_number' => 'numeric|size:8',
            'school' => $this->alpha_space_regex,
            'position' => $this->alpha_space_regex,
            'department_id' => 'integer',
            'contract_start_date' => 'date',
            'contract_end_date' => 'date',
            'gender' => Rule::in(['male', 'female']),
            'allowed_leaves' => 'integer',
            'ncin' => 'numeric|size:8'
        ]);
    }

    public function index() {
        $collaborators = User::doesntHave('roles')->get();

        return response()->json($collaborators, 200);
    }
    
    public function show(User $user) {
        return response()->json([
            'collaborator' => $user
        ], 200);
    }

    public function store(Request $request) {
        User::create(
            $this->validateCollaborator($request)
        );

        return response()->json(['message' => 'User successfully created.'], 201);
    }

    public function update(Request $request, User $user) {
        $user->update(
            $this->validateCollaborator($request)
        );

        return response()->json([ 'message' => 'Collaborator updated successfully.' ], 200);
    }

    public function destroy(User $user) {
        $user->delete();

        return response()->json([ 'message' => 'Collaborator deleted successfully' ], 200);
    }
}

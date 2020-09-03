<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; // collaborator
use Spatie\Permission\Models\Role;
use App\UserHasRole;

$alpha_space_regex = 'regex:/^[a-z A-Z]+$/i';

class CollaboratorsController extends Controller
{
    public function index() {
        $usersWithRoles = UserHasRole::all()->pluck('model_id'); // ? gets all the id of the users with roles

        $collaborators = User::whereNotIn('id', $usersWithRoles)->get();

        return response()->json(compact('collaborators'));
    }

    public function store(Request $request) {
        User::create(
            $this->validateCollaborator($request)
        );

        return response()->json(['message' => 'User successfully created.'], 201);
    }

    public function update($id, Request $request) {
        User::findOrFail($id)->update(
            $this->validateCollaborator($request)
        );

        return response()->json([
            'message' => 'Collaborator updated successfully.'
        ], 200);
    }

    public function destroy($id) {
        User::findOrFail($id)->delete();

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
            'contract_start_date' => 'date',
            'contract_end_date' => 'date',
            'gender' => Rule::in(['male', 'female']),
            'allowed_leaves' => 'integer',
            'ncin' => 'numeric|size:8'
        ]);
    }
}

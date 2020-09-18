<?php

namespace App\Http\Controllers\Collaborators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\User; // ?collaborator
use Spatie\Permission\Models\Role;
use Illuminate\Support\Collection;

class CollaboratorController extends Controller
{
    // validation
    private function validateCollaborator($request) {
        return $request->validate([
            'name' => 'required|regex:' . $this->custom_regex,
            'username' => 'required|alpha|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'phone_number' => 'required|numeric',
            'date_of_birth' => 'nullable|date',
            'address' => '',
            'civil_status' => 'in:single,married',
            'gender' => Rule::in(['male', 'female']),
            'id_card_number' => 'nullable|numeric|unique:users,id_card_number',
            'nationality' => 'nullable|alpha',
            'university' => 'nullable|regex:' . $this->custom_regex,
            'history' => '',
            'experience_level' => 'nullable|integer',
            'source' => '',
            'position' => 'regex:' . $this->custom_regex,
            'grade' => '',
            'hiring_date' => 'nullable|date', // contract_start_date
            'contract_end_date' => 'nullable|date',
            'type_of_contract' => 'nullable',
            'allowed_leave_days' => 'integer',
            'department_id' => 'required|integer',
        ]);
    }
    
    // actions
    public function index(Request $request) {
        $validatedData = $request->validate([
            'items_per_page' => 'required|integer',
            'search_text' => 'nullable|regex:' . $this->custom_regex
        ]);
        $collaborators = User::doesntHave('roles')
            ->where('name', 'LIKE', '%' . $validatedData['search_text'] . '%')
            ->paginate($validatedData['items_per_page']);
        
        foreach($collaborators as $collaborator) {
            $collaborator->department;
        }

        return response()->json($collaborators);
    }
    
    public function show(User $user) {
        return response()->json([
            'collaborator' => $user
        ], 200);
    }

    public function store(Request $request) {
        $collaborator = User::create(
            $this->validateCollaborator($request)
        );

        return response()->json(['collaborator_id' => $collaborator->id], 201);
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

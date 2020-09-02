<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; // collaborator
use Spatie\Permission\Models\Role;

class CollaboratorsController extends Controller
{
    public function index() {
        $collaborators = User::role('rh')->get();
        return response()->json(compact('collaborators'));
    }
}

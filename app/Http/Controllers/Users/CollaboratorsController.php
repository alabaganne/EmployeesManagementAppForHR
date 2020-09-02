<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CollaboratorsController extends Controller
{
    public function index() {
        $collaborators = User::role('rh')->get();
        return response()->json(compact('collaborators'));
    }
}

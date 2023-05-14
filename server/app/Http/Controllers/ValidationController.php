<?php

namespace App\Http\Controllers;

class ValidationController extends Controller
{
    // validate leave
    public function leave(\App\Http\Requests\Leave $request) {
        return response()->json([], 200);
    }

    // validate skill
    public function skill(\App\Http\Requests\Skill $request) {
        return response()->json([], 200);
    }

    // validate training
    public function training(\App\Http\Requests\Training $request) {
        return response()->json([], 200);
    }

    // validate evaluation
    public function evaluation(\App\Http\Requests\Evaluation $request) {
        return response()->json([], 200);
    }
}

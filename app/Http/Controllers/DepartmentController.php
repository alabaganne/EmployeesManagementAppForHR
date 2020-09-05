<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Department;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Department::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Department::create(
            $request->validate([
                'name' => 'required'
            ])
        );
        
        return response()->json([
            'message' => 'Department created.'
        ], 201);
    }

    // * Get the collaborators that belongs to a specific department
    public function getUsers(Department $department) {
        return response()->json(
            User::where('department_id', $department->id)->get(), 200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return response()->json([
            'message' => 'Department deleted.'
        ], 200);
    }
}

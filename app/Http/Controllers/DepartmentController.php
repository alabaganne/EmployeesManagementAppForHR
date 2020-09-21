<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Department;
use App\User;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments_names = [];
        foreach(Department::all() as $department) {
            array_push($departments_names, $department);
        }
        
        return response()->json($departments_names, 200);
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
        
        return response()->json([], 201);
    }

    // * Get the collaborators that belongs to a specific department
    public function getUsers(Department $department) {
        return response()->json(User::where('department_id', $department->id)->get(), 200);
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

        return response()->json([], 200);
    }
}

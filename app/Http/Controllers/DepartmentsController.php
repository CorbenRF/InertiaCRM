<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id = Department::create(
            Request::validate([
                'name' => ['required', 'max:50', 'unique:departments'],
            ])
        )->id;
        return response()->json(array('success' => true, 'inserted_id' => $id), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(departments $departments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(departments $departments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Department $department)
    {
        $department->update(

            Request::validate([
                'name' => ['required', 'max:50'], // todo: unique entry_num as well as department_name
                'id' => ['required'],
            ])
        );

        return Redirect::back()->with('success', 'department entry updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return Redirect::back()->with('success', 'department deleted.');
    }
}

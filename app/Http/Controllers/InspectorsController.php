<?php

namespace App\Http\Controllers;

use App\Models\Inspector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class InspectorsController extends Controller
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
        $id = Inspector::create(
            Request::validate([
                'name' => ['required', 'max:50', 'unique:inspectors'],
            ])
        )->id;
        return response()->json(array('success' => true, 'inserted_id' => $id), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(inspectors $inspectors)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(inspectors $inspectors)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Inspector $inspector)
    {
        $inspector->update(

            Request::validate([
                'name' => ['required', 'max:50'], // todo: unique entry_num as well as inspector_name
                'id' => ['required'],
            ])
        );

        return Redirect::back()->with('success', 'inspector entry updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(inspectors $inspectors)
    {
        //
    }
}

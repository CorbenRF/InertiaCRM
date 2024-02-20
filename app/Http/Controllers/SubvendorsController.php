<?php

namespace App\Http\Controllers;

use App\Models\Subvendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class SubvendorsController extends Controller
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
        $id = Subvendor::create(
            Request::validate([
                'name' => ['required', 'max:50', 'unique:subvendors'],
            ])
        )->id;
        return response()->json(array('success' => true, 'inserted_id' => $id), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(subvendors $subvendors)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(subvendors $subvendors)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Subvendor $subvendor)
    {
        $subvendor->update(

            Request::validate([
                'name' => ['required', 'max:50'], // todo: unique entry_num as well as subvendor_name
                'id' => ['required'],
            ])
        );

        return Redirect::back()->with('success', 'subvendor entry updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(subvendors $subvendors)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Curator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class CuratorsController extends Controller
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
        $id = Curator::create(
            Request::validate([
                'name' => ['required', 'max:50', 'unique:curators'],
            ])
        )->id;
        return response()->json(array('success' => true, 'inserted_id' => $id), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(curators $curators)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(curators $curators)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Curator $curator)
    {
        $curator->update(

            Request::validate([
                'name' => ['required', 'max:50'], // todo: unique entry_num as well as curator_name
                'id' => ['required'],
            ])
        );

        return Redirect::back()->with('success', 'curator entry updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(curators $curators)
    {
        //
    }
}

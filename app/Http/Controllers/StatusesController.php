<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class StatusesController extends Controller
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
        $id = Status::create(
            Request::validate([
                'name' => ['required', 'max:50', 'unique:statuses'],
            ])
        )->id;
        return response()->json(array('success' => true, 'inserted_id' => $id), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(statuses $statuses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(statuses $statuses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Status $status)
    {
        $status->update(

            Request::validate([
                'name' => ['required', 'max:50'], // todo: unique entry_num as well as status_name
                'id' => ['required'],
            ])
        );

        return Redirect::back()->with('success', 'status entry updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $status)
    {
        $status->delete();

        return Redirect::back()->with('success', 'status deleted.');
    }
}

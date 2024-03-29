<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ClientsController extends Controller
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
        $id = Client::create(
            Request::validate([
                'name' => ['required', 'max:50', 'unique:clients'],
            ])
        )->id;
        return response()->json(array('success' => true, 'inserted_id' => $id), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(clients $clients)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(clients $clients)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Client $client)
    {
        $client->update(

            Request::validate([
                'name' => ['required', 'max:50'], // todo: unique entry_num as well as client_name
                'id' => ['required'],
            ])
        );

        return Redirect::back()->with('success', 'client entry updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return Redirect::back()->with('success', 'client deleted.');
    }
}

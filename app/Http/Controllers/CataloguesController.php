<?php

namespace App\Http\Controllers;

use App\Models\catalogues;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class CataloguesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Catalogues/Index', [

        ]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(catalogues $catalogues)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(catalogues $catalogues)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, catalogues $catalogues)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(catalogues $catalogues)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Entry;
use App\Models\User;
use App\Models\Catalogue;
use App\Models\Department;
use App\Models\Client;
use App\Models\Curator;
use App\Models\Inspector;
use App\Models\Status;
use App\Models\Subvendor;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use OwenIt\Auditing\Models\Audit;
use OwenIt\Auditing\Contracts\Auditable;

class HistoryController extends Controller implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entry = Entry::first();
        $audits = Audit::paginate(4);

        // this sorts by id = 10
        // $audits = Audit::where('auditable_id', '=', 10)->paginate(4);

        $query = $audits
        ->withQueryString()
        ->through(function ($item) {
            return [
                'user_id' => $item->user_id,
                'event' => $item->event,
                'auditable_item_id' => $item->auditable_id,
                'old_values' => $item->old_values,
                'new_values' => $item->new_values,
                'url' => $item->url,
                'timestamp' => $item->created_at,
            ];});

        return Inertia::render('History/Index', [
            'history' => $query,
            'users' => User::get(),
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
    public function show(history $history)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(history $history)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, history $history)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(history $history)
    {
        //
    }
}

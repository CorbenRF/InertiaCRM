<?php

namespace App\Http\Controllers;

use App\Models\Entry;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class EntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entries = Entry::paginate(2)
        ->through(function ($entry) {
            return [
                'id' => $entry->id,
                    'client_entry_num' => $entry->client_entry_num,
                    'date_received' => $entry->date_received,
                    'date_startby' => $entry->date_startby,
                    'date_actual_start' => $entry->date_actual_start,
                    'date_end' => $entry->date_end,
                    'department' => [
                        'id' => $entry->department_id,
                        'name' => Department::find($entry->department_id)->name,
                    ],
                    'client' => [
                        'id' => $entry->client_name_id,
                        'name' => Client::find($entry->client_name_id)->name,
                    ],
                    'vendor' => [
                        'id' => $entry->vendor_name_id,
                        'name' => Vendor::find($entry->vendor_name_id)->name,
                    ],
                    'subvendor' => [
                        'id' => $entry->subvendor_name_id,
                        'name' => Subvendor::find($entry->subvendor_name_id)->name,
                    ],
                    'status' => [
                        'id' => $entry->status_id,
                        'name' => Status::find($entry->status_id)->name,
                    ],
                    'curator' => [
                        'id' => $entry->curator_id,
                        'name' => Curator::find($entry->curator_id)->name,
                    ],
                    'inspector' => [
                        'id' => $entry->inspector_id,
                        'name' => Inspector::find($entry->inspector_id)->name,
                    ],
                    'expired' => $entry->expired,
                    'busy_edit' => $entry->busy_edit,
                    'created_at' => $entry->created_at,
                    'updated_at' => $entry->updated_at,
                    'inspection_lvl' => $entry->inspection_lvl,
            ];
        });
        return Inertia::render('Entries/Index', [
            'entries' => $entries, // entries from here pass as props down to Index.vue
            'catalogues' => [
                'departments' => Department::all(),
                'clients' => Client::all(),
                'curators' => Curator::all(),
                'inspectors' => Inspector::all(),
                'statuses' => Status::all(),
                'vendors' => Vendor::all(),
                'subvendors' => Subvendor::all(),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */

    //  public function catalogues(): Response
    //  {
    //     return Inertia::render('Entries/catalogues', [
    //         'catalogues' => [
    //             'departments' => Department::all(),
    //             'clients' => Client::all(),
    //             'curators' => Curator::all(),
    //             'inspectors' => Inspector::all(),
    //             'statuses' => Status::all(),
    //             'vendors' => Vendor::all(),
    //             'subvendors' => Subvendor::all(),
    //         ]
    //     ]);
    //  }

    public function create()
    {
        return Inertia::render('Entries/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Auth::user()->account->entries()->create(
            Request::validate([
                'client_entry_num' => ['required', 'max:50'], // todo: unique entry_num as well as client_name
                'date_received' => ['required', 'date', 'date_format:d.m.Y'],
                'date_startby' => ['date', 'date_format:d.m.Y'],
                'date_actual_start' => ['date', 'date_format:d.m.Y'],
                'date_end' => ['date', 'date_format:d.m.Y'],
                'inspection_lvl' => ['nullable', 'max:3'],
            ])
        );

        return Redirect::route('entries')->with('success', 'Entry created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Entry $entry)
    {
        return Inertia::render('Entries/Show', [
            'entry' => $entry->only(
                'id',
                'client_entry_num',
              ),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entry $entry)
    {
        return Inertia::render('Entries/Edit', [
            'entry' => [
                'id' => $entry->id,
                'client_entry_num' => $entry->client_entry_num,
                'date_received' => $entry->date_received,
                'date_startby' => $entry->date_startby,
                'date_actual_start' => $entry->date_actual_start,
                'date_end' => $entry->date_end,
                'expired' => $entry->expired,
                'busy_edit' => $entry->busy_edit,
                'created_at' => $entry->created_at,
                'updated_at' => $entry->updated_at,
                'inspection_lvl' => $entry->inspection_lvl,
                'department' => $entry->department_id,
                'client' => $entry->client_name_id,
                'vendor' => $entry->vendor_name_id,
                'subvendor' => $entry->subvendor_name_id,
                'status' => $entry->status_id,
                'curator' => $entry->curator_id,
                'inspector' => $entry->inspector_id,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Entry $entry)
    {
        $entry->update(

            Request::validate([
                'client_entry_num' => ['required', 'max:50'], // todo: unique entry_num as well as client_name
                'client_name_id' => ['required'],
                'department_id' => ['required'],
                'vendor_name_id' => ['required'],
                'subvendor_name_id' => ['required'],
                'status_id' => ['required'],
                'curator_id' => ['required'],
                'inspector_id' => ['required'],
                'date_received' => ['required', 'date'],
                'date_startby' => ['nullable', 'date'],
                'date_actual_start' => ['nullable', 'date'],
                'date_end' => ['nullable', 'date'],
                'inspection_lvl' => ['required'],
            ])
        );

        return Redirect::back()->with('success', 'entry updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entry $entry)
    {
        $entry->delete();

        return Redirect::back()->with('success', 'Entry deleted.');
    }
}

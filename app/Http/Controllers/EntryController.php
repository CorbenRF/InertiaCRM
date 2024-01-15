<?php

namespace App\Http\Controllers;

use App\Models\Account;
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
        // ORDER AND SEARCH QUERY BUILDER

        $sortDateReceived = request()->query('date_received') ?: 'asc';
        $sortDateStartby = request()->query('date_startby') ?: 'asc';
        $searchArr = (object) [
            'searchClientEntryNum'  => request()->query('searchClientEntryNum') ?: null,
            'searchClientName' => request()->query('searchClientName') ?: null,
            'searchVendorName' => request()->query('searchVendorName') ?: null,
            'searchSubvendorName' => request()->query('searchSubvendorName') ?: null,
            'searchDepartmentName' => request()->query('searchDepartmentName') ?: null,
            'searchDRFrom' => request()->query('searchDRFrom') ?: null,
            'searchDRTo' => request()->query('searchDRTo') ?: null,
            'searchDSFrom' => request()->query('searchDSFrom') ?: null,
            'searchDSTo' => request()->query('searchDSTo') ?: null,
    ];

        $query = Entry::query();

        if (isset($searchArr->searchClientEntryNum))
            $query->where('client_entry_num', 'like', '%' . $searchArr->searchClientEntryNum . '%');

        if (isset($searchArr->searchClientName))
            $query->whereHas('clients', function($qty) use ($searchArr){
                $qty->where('name', 'like', '%' . $searchArr->searchClientName . '%');
           });

        if (isset($searchArr->searchVendorName))
            $query->whereHas('vendors', function($qty) use ($searchArr){
                $qty->where('name', 'like', '%' . $searchArr->searchVendorName . '%');
        });

        if (isset($searchArr->searchSubvendorName))
            $query->whereHas('subvendors', function($qty) use ($searchArr){
                $qty->where('name', 'like', '%' . $searchArr->searchSubvendorName . '%');
           });

        if (isset($searchArr->searchDepartmentName))
        $query->whereHas('departments', function($qty) use ($searchArr){
            $qty->where('name', 'like', '%' . $searchArr->searchDepartmentName . '%');
        });

        if (isset($searchArr->searchDRFrom) && isset($searchArr->searchDRTo))
        $query->whereBetween('date_received', [$searchArr->searchDRFrom, $searchArr->searchDRTo]);

        if (isset($searchArr->searchDSFrom) && isset($searchArr->searchDSTo))
        $query->whereBetween('date_startby', [$searchArr->searchDSFrom, $searchArr->searchDSTo]);

        // END - ORDER AND SEARCH QUERY BUILDER

        $entries = $query->
        orderByRaw("date_received {$sortDateReceived}, date_startby {$sortDateStartby}")
        ->paginate(2)->withQueryString()
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
            'filters' => Request::all('search'),
            'entries' => $entries,  // entries from here pass as props down to Index.vue
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
        Entry::create(
            // Auth::user()->account->entries()->create(
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
                'comments' => ['nullable'],
            ])
        );

        return Redirect::route('entries')->with('success', 'Entry created.');
    }

    /**
     * Display the specified resource.
     */


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

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
use Illuminate\Support\Facades\Schedule;

class EntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // ORDER AND SEARCH QUERY BUILDER
        $searchArr = (object) [
            'searchDRFrom' => request()->query('searchDRFrom') ?: null,
            'searchDRTo' => request()->query('searchDRTo') ?: null,
            'searchDSFrom' => request()->query('searchDSFrom') ?: null,
            'searchDSTo' => request()->query('searchDSTo') ?: null,
    ];

    $query = Entry::query();

        foreach (request()->except('_token') as $key => $value) {
            $queryValue = isset($value) ? $value : null;
        if ($key == 'searchClientEntryNum')
            {$query->where('client_entry_num', 'like', '%' . $queryValue . '%');}

        elseif ($key == 'searchClientName')
            {$query->whereHas('clients', function($qty) use ($queryValue){
                $qty->where('name', 'like', '%' . $queryValue . '%');
           });}

        elseif ($key == 'searchVendorName')
            {$query->whereHas('vendors', function($qty) use ($queryValue){
                $qty->where('name', 'like', '%' . $queryValue . '%');
        });}

        elseif ($key == 'searchSubvendorName')
            {$query->whereHas('subvendors', function($qty) use ($queryValue){
                $qty->where('name', 'like', '%' . $queryValue . '%');
           });}

        elseif ($key == 'searchDepartmentName')
            {$query->whereHas('departments', function($qty) use ($queryValue){
                $qty->where('name', 'like', '%' . $queryValue . '%');
            });}

        elseif ($key == 'searchDRFrom' && isset($searchArr->searchDRFrom) && isset($searchArr->searchDRTo))
            {$query->whereBetween('date_received', [$searchArr->searchDRFrom, $searchArr->searchDRTo]);}

        elseif ($key == 'searchDSFrom' && isset($searchArr->searchDSFrom) && isset($searchArr->searchDSTo))
            {$query->whereBetween('date_startby', [$searchArr->searchDSFrom, $searchArr->searchDSTo]);}

        elseif ($key == 'date_received')
            {$query->orderBy('date_received', $queryValue);}

        elseif ($key == 'date_startby')
            {$query->orderBy('date_startby', $queryValue);}

          }

        // END - ORDER AND SEARCH QUERY BUILDER

        $entries = $query
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
                'busy_edit' => ['bool'],
            ])
        );

        return Redirect::back()->with('success', 'entry updated.');
    }

    public function isbusy(Entry $entry)
    {
        $check = [
            'isbusy' => $entry->busy_edit,
        ];
        return response()->json($check);

    }

    public function makebusy(Request $request)
    {
        $entry = Entry::find(request()->id);
        $entry->busy_edit = request()->busy;
        $entry->save();

        // Schedule::call(function () use ($entry) {
        //     $entry->busy_edit = 0;
        //     $entry->save();
        // })->everyMinute();


        return Redirect::back()->with('success', 'entry updated.');

    }

    /**
     *

     * Remove the specified resource from storage.
     */
    public function destroy(Entry $entry)
    {
        $entry->delete();

        return Redirect::back()->with('success', 'Entry deleted.');
    }
}

<?php

namespace App\Http\Controllers;

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

class CataloguesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentCatalogue = request()->query('catalogue');
        $output_string = 'App\Models\$value';
        $values = array( '$value' => request()->query('catalogue'));

        $catalogue = $currentCatalogue ?
        strtr($output_string, $values)::query()
        ->paginate(4)->withQueryString()
        ->through(function ($entry) {
            return [
                'id' => $entry->id,
                'name' => $entry->name,
            ];})
        : null;
        // $catalogue = $currentCatalogue::all();

        return Inertia::render('Catalogues/Index', [
            'catalogue' => $catalogue,
            'cataloguesList' => [
                ['id' => 'Department', 'name' => 'УИК'],
                ['id' => 'Client', 'name' => 'Заказчики'],
                ['id' => 'Vendor', 'name' => 'Поставщики'],
                ['id' => 'Subvendor', 'name' => 'Изготовители/Субпоставщики'],
                ['id' => 'Inspector', 'name' => 'Инспекторы'],
                ['id' => 'Curator', 'name' => 'Кураторы'],
                ['id' => 'Status', 'name' => 'Статусы'],

            ],
        ]);
    }

    public function get(Request $request)
    {
        $catalogues = [
            'catalogues' => [
                'departments' => Department::all(),
                'clients' => Client::all(),
                'curators' => Curator::all(),
                'inspectors' => Inspector::all(),
                'statuses' => Status::all(),
                'vendors' => Vendor::all(),
                'subvendors' => Subvendor::all(),
            ]
            ];
        return response()->json($catalogues);
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
    public function show(Catalogue $catalogue)
    {

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

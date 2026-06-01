<?php

namespace App\Http\Controllers;

use App\Models\Storage;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $storages = Storage::withCount([
            'products',

            'products as products_status_instock_count' => function ($query) {
                $query->where('status', 1);
            },

            'products as products_status_sold_count' => function ($query) {
                $query->where('status', 2);
            },

            'products as products_status_loan_count' => function ($query) {
                $query->where('status', 3);
            },

        ])->get();

        return view('storages.index', [
            'storages' => $storages
        ]);
    }

    /**
     * Store new storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:25|unique:storages,name',
        ]);

        $storage = new Storage();

        $storage->name = $request->name;

        $storage->save();

        return redirect()->route('storage.index', withLang());
    }

    /**
     * Update storage
     */
public function update(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:25|unique:storages,name,' . $request->id . ',id',
    ]);

    $storage = Storage::findOrFail($request->id);

    $storage->name = $request->name;

    $storage->save();

    return redirect()->route('storage.index', withLang());
}
    /**
     * Delete storage
     */
    public function destroy(Storage $storage)
    {
        $storage->delete();

        return redirect()->route('storage.index', withLang());
    }
}
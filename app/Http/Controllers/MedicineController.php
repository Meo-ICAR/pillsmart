<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Imports\MedicinesImport;
use Maatwebsite\Excel\Facades\Excel;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Medicine::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('codice_aic', 'like', "%$search%")
                  ->orWhere('denominazione', 'like', "%$search%")
                  ->orWhere('descrizione', 'like', "%$search%")
                  ->orWhere('ragione_sociale', 'like', "%$search%");
            });
        }

        $medicines = $query->orderBy('id', 'desc')->paginate(20)->withQueryString();

        return view('medicines', compact('medicines'));
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
        $validated = $request->validate([
            'codice_aic' => 'required|string|unique:medicines',
            'cod_farmaco' => 'nullable|string',
            'cod_confezione' => 'nullable|string',
            'denominazione' => 'nullable|string',
            'descrizione' => 'nullable|string',
            'codice_ditta' => 'nullable|string',
            'ragione_sociale' => 'nullable|string',
            'stato_amministrativo' => 'nullable|string',
            'tipo_procedura' => 'nullable|string',
            'forma' => 'nullable|string',
            'codice_atc' => 'nullable|string',
            'pa_associati' => 'nullable|string',
            'link' => 'nullable|string',
        ]);
        $medicine = Medicine::create($validated);
        return response()->json($medicine, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Medicine $medicine)
    {
        return $medicine;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medicine $medicine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'codice_aic' => 'sometimes|required|string|unique:medicines,codice_aic,' . $medicine->id,
            'cod_farmaco' => 'nullable|string',
            'cod_confezione' => 'nullable|string',
            'denominazione' => 'nullable|string',
            'descrizione' => 'nullable|string',
            'codice_ditta' => 'nullable|string',
            'ragione_sociale' => 'nullable|string',
            'stato_amministrativo' => 'nullable|string',
            'tipo_procedura' => 'nullable|string',
            'forma' => 'nullable|string',
            'codice_atc' => 'nullable|string',
            'pa_associati' => 'nullable|string',
            'link' => 'nullable|string',
        ]);
        $medicine->update($validated);
        return response()->json($medicine);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medicine $medicine)
    {
        $medicine->delete();
        return response()->json(null, 204);
    }

    /**
     * Import medicines from a CSV file.
     */
    public function importCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);
        Excel::import(new MedicinesImport, $request->file('file'));
        return redirect()->back()->with('success', 'Medicines imported successfully!');
    }
}

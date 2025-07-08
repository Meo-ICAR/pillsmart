<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Patient::query();
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%");
        }
        $patients = $query->orderBy('id', 'desc')->paginate(20)->withQueryString();
        return view('patients', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not used, handled by modal
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'breakfast_hour' => 'nullable|date_format:H:i:s',
            'lunch_hour' => 'nullable|date_format:H:i:s',
            'dinner_hour' => 'nullable|date_format:H:i:s',
            'wakeup_hour' => 'nullable|date_format:H:i:s',
            'sleep_hour' => 'nullable|date_format:H:i:s',
            'address' => 'nullable|string|max:255',
            'user_id' => 'nullable|integer|exists:users,id',
        ]);
        Patient::create($validated);
        return redirect()->route('patients.index')->with('success', 'Patient created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return $patient;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        // Not used, handled by modal
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'breakfast_hour' => 'nullable|date_format:H:i:s',
            'lunch_hour' => 'nullable|date_format:H:i:s',
            'dinner_hour' => 'nullable|date_format:H:i:s',
            'wakeup_hour' => 'nullable|date_format:H:i:s',
            'sleep_hour' => 'nullable|date_format:H:i:s',
            'address' => 'nullable|string|max:255',
            'user_id' => 'nullable|integer|exists:users,id',
        ]);
        $patient->update($validated);
        return redirect()->route('patients.index')->with('success', 'Patient updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the doctors.
     */
    public function index()
    {
        $doctors = \App\Models\Doctor::all();
        return response()->json($doctors);
    }

    public function create() { /* Not used, handled by modal */ }

    /**
     * Store a newly created doctor in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'kind' => 'nullable|string|max:255',
            'user_id' => 'nullable|integer|exists:users,id',
        ]);
        $doctor = \App\Models\Doctor::create($validated);
        return response()->json($doctor, 201);
    }

    /**
     * Display the specified doctor.
     */
    public function show($id)
    {
        $doctor = \App\Models\Doctor::findOrFail($id);
        return response()->json($doctor);
    }

    public function edit(Doctor $doctor) { /* Not used, handled by modal */ }

    /**
     * Update the specified doctor in storage.
     */
    public function update(Request $request, $id)
    {
        $doctor = \App\Models\Doctor::findOrFail($id);
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'kind' => 'nullable|string|max:255',
            'user_id' => 'nullable|integer|exists:users,id',
        ]);
        $doctor->update($validated);
        return response()->json($doctor);
    }

    /**
     * Remove the specified doctor from storage.
     */
    public function destroy($id)
    {
        $doctor = \App\Models\Doctor::findOrFail($id);
        $doctor->delete();
        return response()->json(['message' => 'Doctor deleted successfully']);
    }
}

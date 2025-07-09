<?php

namespace App\Http\Controllers;

use App\Models\Caregiver;
use Illuminate\Http\Request;

class CaregiverController extends Controller
{
    /**
     * Display a listing of the caregivers.
     */
    public function index()
    {
        $caregivers = \App\Models\Caregiver::all();
        return response()->json($caregivers);
    }

    public function create() { /* Not used, handled by modal */ }

    /**
     * Store a newly created caregiver in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'kind' => 'nullable|string|max:255',
            'user_id' => 'nullable|integer|exists:users,id',
        ]);
        $caregiver = \App\Models\Caregiver::create($validated);
        return response()->json($caregiver, 201);
    }

    /**
     * Display the specified caregiver.
     */
    public function show($id)
    {
        $caregiver = \App\Models\Caregiver::findOrFail($id);
        return response()->json($caregiver);
    }

    public function edit(Caregiver $caregiver) { /* Not used, handled by modal */ }

    /**
     * Update the specified caregiver in storage.
     */
    public function update(Request $request, $id)
    {
        $caregiver = \App\Models\Caregiver::findOrFail($id);
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'kind' => 'nullable|string|max:255',
            'user_id' => 'nullable|integer|exists:users,id',
        ]);
        $caregiver->update($validated);
        return response()->json($caregiver);
    }

    /**
     * Remove the specified caregiver from storage.
     */
    public function destroy($id)
    {
        $caregiver = \App\Models\Caregiver::findOrFail($id);
        $caregiver->delete();
        return response()->json(['message' => 'Caregiver deleted successfully']);
    }
}

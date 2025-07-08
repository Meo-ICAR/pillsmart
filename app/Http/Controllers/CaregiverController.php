<?php

namespace App\Http\Controllers;

use App\Models\Caregiver;
use Illuminate\Http\Request;

class CaregiverController extends Controller
{
    public function index(Request $request)
    {
        $query = Caregiver::query();
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('kind', 'like', "%$search%")
                  ->orWhere('user_id', $search);
            });
        }
        $caregivers = $query->orderBy('id', 'desc')->paginate(20)->withQueryString();
        return view('caregivers', compact('caregivers'));
    }

    public function create() { /* Not used, handled by modal */ }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'kind' => 'nullable|string|max:255',
            'user_id' => 'nullable|integer|exists:users,id',
        ]);
        Caregiver::create($validated);
        return redirect()->route('caregivers.index')->with('success', 'Caregiver created successfully!');
    }

    public function show(Caregiver $caregiver)
    {
        return $caregiver;
    }

    public function edit(Caregiver $caregiver) { /* Not used, handled by modal */ }

    public function update(Request $request, Caregiver $caregiver)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'kind' => 'nullable|string|max:255',
            'user_id' => 'nullable|integer|exists:users,id',
        ]);
        $caregiver->update($validated);
        return redirect()->route('caregivers.index')->with('success', 'Caregiver updated successfully!');
    }

    public function destroy(Caregiver $caregiver)
    {
        $caregiver->delete();
        return redirect()->route('caregivers.index')->with('success', 'Caregiver deleted successfully!');
    }
}

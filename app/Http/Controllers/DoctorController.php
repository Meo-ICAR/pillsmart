<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = Doctor::query();
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('user_id', $search);
            });
        }
        $doctors = $query->orderBy('id', 'desc')->paginate(20)->withQueryString();
        return view('doctors', compact('doctors'));
    }

    public function create() { /* Not used, handled by modal */ }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'user_id' => 'nullable|integer|exists:users,id',
        ]);
        Doctor::create($validated);
        return redirect()->route('doctors.index')->with('success', 'Doctor created successfully!');
    }

    public function show(Doctor $doctor)
    {
        return $doctor;
    }

    public function edit(Doctor $doctor) { /* Not used, handled by modal */ }

    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'user_id' => 'nullable|integer|exists:users,id',
        ]);
        $doctor->update($validated);
        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully!');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully!');
    }
}

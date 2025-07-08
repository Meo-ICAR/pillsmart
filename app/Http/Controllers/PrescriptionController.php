<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = Prescription::query();
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('medicine', 'like', "%$search%")
                  ->orWhere('patient_id', $search)
                  ->orWhere('doctor_id', $search);
            });
        }
        $prescriptions = $query->orderBy('id', 'desc')->paginate(20)->withQueryString();
        $patients = Patient::all();
        $doctors = Doctor::all();
        return view('prescriptions', compact('prescriptions', 'patients', 'doctors'));
    }

    public function create() { /* Not used, handled by modal */ }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|integer|exists:patients,id',
            'doctor_id' => 'required|integer|exists:doctors,id',
            'medicine' => 'required|string|max:255',
            'dosage' => 'nullable|string|max:255',
            'frequency' => 'nullable|string|max:255',
            'date_prescribed' => 'nullable|date',
            'instructions' => 'nullable|string',
        ]);
        Prescription::create($validated);
        return redirect()->route('prescriptions.index')->with('success', 'Prescription created successfully!');
    }

    public function show(Prescription $prescription)
    {
        return $prescription;
    }

    public function edit(Prescription $prescription) { /* Not used, handled by modal */ }

    public function update(Request $request, Prescription $prescription)
    {
        $validated = $request->validate([
            'patient_id' => 'required|integer|exists:patients,id',
            'doctor_id' => 'required|integer|exists:doctors,id',
            'medicine' => 'required|string|max:255',
            'dosage' => 'nullable|string|max:255',
            'frequency' => 'nullable|string|max:255',
            'date_prescribed' => 'nullable|date',
            'instructions' => 'nullable|string',
        ]);
        $prescription->update($validated);
        return redirect()->route('prescriptions.index')->with('success', 'Prescription updated successfully!');
    }

    public function destroy(Prescription $prescription)
    {
        $prescription->delete();
        return redirect()->route('prescriptions.index')->with('success', 'Prescription deleted successfully!');
    }
}

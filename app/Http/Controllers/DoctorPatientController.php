<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class DoctorPatientController extends Controller
{
    public function index(Request $request)
    {
        $links = \DB::table('doctor_patient')
            ->join('doctors', 'doctor_patient.doctor_id', '=', 'doctors.id')
            ->join('patients', 'doctor_patient.patient_id', '=', 'patients.id')
            ->select('doctor_patient.id', 'doctors.name as doctor_name', 'patients.name as patient_name', 'doctor_patient.doctor_id', 'doctor_patient.patient_id')
            ->orderBy('doctor_patient.id', 'desc')
            ->paginate(20);
        $doctors = Doctor::all();
        $patients = Patient::all();
        return view('doctor_patients', compact('links', 'doctors', 'patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
        ]);
        $doctor = Doctor::findOrFail($validated['doctor_id']);
        $doctor->patients()->attach($validated['patient_id']);
        return redirect()->route('doctor-patients.index')->with('success', 'Link added successfully!');
    }

    public function destroy($id)
    {
        $link = \DB::table('doctor_patient')->where('id', $id)->first();
        if ($link) {
            $doctor = Doctor::find($link->doctor_id);
            if ($doctor) {
                $doctor->patients()->detach($link->patient_id);
            }
        }
        return redirect()->route('doctor-patients.index')->with('success', 'Link removed successfully!');
    }
}

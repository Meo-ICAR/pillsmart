<?php

namespace App\Http\Controllers;

use App\Models\Caregiver;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CaregiverPatientController extends Controller
{
    public function index(Request $request)
    {
        $links = DB::table('caregiver_patient')
            ->join('caregivers', 'caregiver_patient.caregiver_id', '=', 'caregivers.id')
            ->join('patients', 'caregiver_patient.patient_id', '=', 'patients.id')
            ->select('caregiver_patient.id', 'caregivers.name as caregiver_name', 'patients.name as patient_name', 'caregiver_patient.caregiver_id', 'caregiver_patient.patient_id', 'caregiver_patient.fromdate', 'caregiver_patient.todate', 'caregiver_patient.deleted_at')
            ->orderBy('caregiver_patient.id', 'desc')
            ->paginate(20);
        $caregivers = Caregiver::all();
        $patients = Patient::all();
        return view('caregiver_patients', compact('links', 'caregivers', 'patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'caregiver_id' => 'required|exists:caregivers,id',
            'patient_id' => 'required|exists:patients,id',
            'fromdate' => 'nullable|date',
            'todate' => 'nullable|date|after_or_equal:fromdate',
        ]);
        $caregiver = Caregiver::findOrFail($validated['caregiver_id']);
        $caregiver->patients()->attach($validated['patient_id'], [
            'fromdate' => $validated['fromdate'] ?? null,
            'todate' => $validated['todate'] ?? null,
        ]);
        return redirect()->route('caregiver-patients.index')->with('success', 'Link added successfully!');
    }

    public function destroy($id)
    {
        $link = DB::table('caregiver_patient')->where('id', $id)->first();
        if ($link) {
            $caregiver = Caregiver::find($link->caregiver_id);
            if ($caregiver) {
                $caregiver->patients()->updateExistingPivot($link->patient_id, ['deleted_at' => now()]);
            }
        }
        return redirect()->route('caregiver-patients.index')->with('success', 'Link soft deleted successfully!');
    }

    public function restore($id)
    {
        $link = DB::table('caregiver_patient')->where('id', $id)->first();
        if ($link) {
            $caregiver = Caregiver::find($link->caregiver_id);
            if ($caregiver) {
                $caregiver->patients()->updateExistingPivot($link->patient_id, ['deleted_at' => null]);
            }
        }
        return redirect()->route('caregiver-patients.index')->with('success', 'Link restored successfully!');
    }
}

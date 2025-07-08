<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index(Request $request)
    {
        $query = Device::query();
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('mac', 'like', "%$search%");
            });
        }
        $devices = $query->orderBy('id', 'desc')->paginate(20)->withQueryString();
        return view('devices', compact('devices'));
    }

    public function create() { /* Not used, handled by modal */ }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'mac' => 'nullable|string|max:255',
            'nslots' => 'nullable|integer',
            'annotations' => 'nullable|string',
            'patient_id' => 'nullable|integer|exists:patients,id',
            'istoupdate' => 'nullable|boolean',
            'updated_at' => 'nullable|date',
        ]);
        Device::create($validated);
        return redirect()->route('devices.index')->with('success', 'Device created successfully!');
    }

    public function show(Device $device)
    {
        return $device;
    }

    public function edit(Device $device) { /* Not used, handled by modal */ }

    public function update(Request $request, Device $device)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'mac' => 'nullable|string|max:255',
            'nslots' => 'nullable|integer',
            'annotations' => 'nullable|string',
            'patient_id' => 'nullable|integer|exists:patients,id',
            'istoupdate' => 'nullable|boolean',
            'updated_at' => 'nullable|date',
        ]);
        $device->update($validated);
        return redirect()->route('devices.index')->with('success', 'Device updated successfully!');
    }

    public function destroy(Device $device)
    {
        $device->delete();
        return redirect()->route('devices.index')->with('success', 'Device deleted successfully!');
    }
}

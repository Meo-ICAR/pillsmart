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

    /**
     * @OA\Get(
     *     path="/api/devices/{id}",
     *     summary="Get a device by ID",
     *     tags={"Devices"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the device",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Device found"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Device not found"
     *     )
     * )
     */
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

    public function ping(Device $device)
    {
        $device->pinged_at = now();
        $device->save();
        if ($device->istoupdate) {
            return response()->json(['message' => 'Update required'], 201);
        }
        return response()->json(['message' => 'Ping received'], 200);
    }
}

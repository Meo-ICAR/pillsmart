<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Display a listing of the devices.
     */
    public function index()
    {
        $devices = \App\Models\Device::all();
        return response()->json($devices);
    }

    public function create() { /* Not used, handled by modal */ }

    /**
     * Store a newly created device in storage.
     */
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
        $device = \App\Models\Device::create($validated);
        return response()->json($device, 201);
    }

    /**
     * Display the specified device.
     */
    public function show($id)
    {
        $device = \App\Models\Device::findOrFail($id);
        return response()->json($device);
    }

    public function edit(Device $device) { /* Not used, handled by modal */ }

    /**
     * Update the specified device in storage.
     */
    public function update(Request $request, $id)
    {
        $device = \App\Models\Device::findOrFail($id);
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
        return response()->json($device);
    }

    /**
     * Remove the specified device from storage.
     */
    public function destroy($id)
    {
        $device = \App\Models\Device::findOrFail($id);
        $device->delete();
        return response()->json(['message' => 'Device deleted successfully']);
    }

    /**
     * @OA\Post(
     *     path="/api/devices/{device}/ping",
     *     summary="Ping a device",
     *     tags={"Devices"},
     *     @OA\Parameter(
     *         name="device",
     *         in="path",
     *         required=true,
     *         description="ID of the device to ping",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ping received"
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Update required"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Device not found (handled by route model binding)"
     *     )
     * )
     */
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

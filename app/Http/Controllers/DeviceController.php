<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/devices",
     *     summary="Get all devices",
     *     description="Retrieves a list of all devices in the system",
     *     tags={"Devices"},
     *     @OA\Response(
     *         response=200,
     *         description="List of devices retrieved successfully",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Device 1"),
     *                 @OA\Property(property="mac", type="string", example="00:11:22:33:44:55"),
     *                 @OA\Property(property="nslots", type="integer", example=4),
     *                 @OA\Property(property="annotations", type="string", example="Kitchen device"),
     *                 @OA\Property(property="patient_id", type="integer", example=1),
     *                 @OA\Property(property="istoupdate", type="boolean", example=false),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $devices = \App\Models\Device::all();
        return response()->json($devices);
    }

    public function create() { /* Not used, handled by modal */ }

    /**
     * @OA\Post(
     *     path="/devices",
     *     summary="Create a new device",
     *     description="Creates a new device with the provided information",
     *     tags={"Devices"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Device 1"),
     *             @OA\Property(property="mac", type="string", example="00:11:22:33:44:55"),
     *             @OA\Property(property="nslots", type="integer", example=4),
     *             @OA\Property(property="annotations", type="string", example="Kitchen device"),
     *             @OA\Property(property="patient_id", type="integer", example=1),
     *             @OA\Property(property="istoupdate", type="boolean", example=false)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Device created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Device 1"),
     *             @OA\Property(property="mac", type="string", example="00:11:22:33:44:55"),
     *             @OA\Property(property="nslots", type="integer", example=4),
     *             @OA\Property(property="annotations", type="string", example="Kitchen device"),
     *             @OA\Property(property="patient_id", type="integer", example=1),
     *             @OA\Property(property="istoupdate", type="boolean", example=false),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
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
     *     path="/api/devices/{mac}/ping",
     *     summary="Ping a device",
     *     description="Sends a ping to a device identified by its MAC address. Updates the device's ping timestamp and returns status information.",
     *     tags={"Devices"},
     *     @OA\Parameter(
     *         name="mac",
     *         in="path",
     *         required=true,
     *         description="MAC address of the device to ping",
     *         @OA\Schema(type="string", example="00:11:22:33:44:55")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ping received successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Ping received")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Update required for device",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Update required")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Device not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Device not found")
     *         )
     *     )
     * )
     */
    public function ping(Request $request, $mac)
    {
        $device = \App\Models\Device::where('mac', $mac)->first();
        if (!$device) {
            return response()->json(['message' => 'Device not found'], 404);
        }
        $device->pinged_at = now();
        $device->save();
        if ($device->istoupdate) {
            return response()->json(['message' => 'Update required'], 201);
        }
        return response()->json(['message' => 'Ping received'], 200);
    }

        /**
     * @OA\Get(
     *     path="/api/devices/{mac}/slots",
     *     summary="Get slots for a device by MAC address",
     *     description="Retrieves all non-deleted slots associated with a device identified by its MAC address. Returns slot number and operation time in YYYY-MM-dd HH:mm format.",
     *     tags={"Devices"},
     *     @OA\Parameter(
     *         name="mac",
     *         in="path",
     *         required=true,
     *         description="MAC address of the device",
     *         @OA\Schema(type="string", example="00:11:22:33:44:55")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Slots retrieved successfully",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="n", type="integer", description="Slot number", example=1),
     *                 @OA\Property(property="opentime", type="string", description="Operation time in YYYY-MM-dd HH:mm format", example="2025-07-09 08:30")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Device not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Device or slots not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Internal server error")
     *         )
     *     )
     * )
     */
    public function getSlotsByMac($mac)
    {
        $device = new Device();
        $slots = $device->getSlotsByMac($mac);

        if ($slots === null) {
            return response()->json(['message' => 'Device or slots not found'], 404);
        }

        return response()->json($slots);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    public function index(Request $request)
    {
        $query = Slot::query();
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('device_id', $search);
            });
        }
        $slots = $query->orderBy('id', 'desc')->paginate(20)->withQueryString();
        return view('slots', compact('slots'));
    }

    public function create() { /* Not used, handled by modal */ }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'nullable|integer|exists:devices,id',
            'n' => 'nullable|integer',
            'operhour' => 'nullable|date_format:H:i:s',
            'npill' => 'nullable|integer',
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);
        Slot::create($validated);
        return redirect()->route('slots.index')->with('success', 'Slot created successfully!');
    }

    public function show(Slot $slot)
    {
        return $slot;
    }

    public function edit(Slot $slot) { /* Not used, handled by modal */ }

    public function update(Request $request, Slot $slot)
    {
        $validated = $request->validate([
            'device_id' => 'nullable|integer|exists:devices,id',
            'n' => 'nullable|integer',
            'operhour' => 'nullable|date_format:H:i:s',
            'npill' => 'nullable|integer',
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);
        $slot->update($validated);
        return redirect()->route('slots.index')->with('success', 'Slot updated successfully!');
    }

    public function destroy(Slot $slot)
    {
        $slot->delete();
        return redirect()->route('slots.index')->with('success', 'Slot deleted successfully!');
    }
}

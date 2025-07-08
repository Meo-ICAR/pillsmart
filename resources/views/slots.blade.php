@extends('layouts.app')

@section('title', 'Slots')

@section('content')
<div class="flex flex-col gap-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Slots</h1>
        <button onclick="openCreateModal()" class="bg-green-500 text-white px-4 py-2 rounded shadow">Add Slot</button>
    </div>
    <form method="GET" action="{{ url('slots') }}" class="mb-4 flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or Device ID..." class="border rounded px-3 py-2 w-1/3">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
    </form>
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200" id="slotsTable">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2">Device ID</th>
                    <th class="px-4 py-2">Slot #</th>
                    <th class="px-4 py-2">Operation Hour</th>
                    <th class="px-4 py-2"># Pills</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($slots as $slot)
                    <tr>
                        <td class="px-4 py-2">{{ $slot->device_id }}</td>
                        <td class="px-4 py-2">{{ $slot->n }}</td>
                        <td class="px-4 py-2">{{ $slot->operhour }}</td>
                        <td class="px-4 py-2">{{ $slot->npill }}</td>
                        <td class="px-4 py-2">{{ $slot->name }}</td>
                        <td class="px-4 py-2">{{ $slot->description }}</td>
                        <td class="px-4 py-2 flex gap-2">
                            <button onclick="openEditModal({{ $slot->id }}, '{{ $slot->device_id }}', '{{ $slot->n }}', '{{ $slot->operhour }}', '{{ $slot->npill }}', '{{ addslashes($slot->name) }}', '{{ addslashes($slot->description) }}')" class="text-blue-600 hover:underline">Edit</button>
                            <form action="/slots/{{ $slot->id }}" method="POST" onsubmit="return confirm('Delete this slot?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $slots->links() }}
    </div>
</div>

<!-- Create/Edit Modal -->
<div id="crudModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
        <h2 id="crudModalTitle" class="text-xl font-bold mb-4">Add Slot</h2>
        <form id="crudForm" method="POST" action="/slots">
            @csrf
            <input type="hidden" name="_method" id="crudFormMethod" value="POST">
            <div class="mb-4">
                <label class="block mb-1 font-medium">Device ID</label>
                <input type="number" name="device_id" id="crudDeviceId" class="border rounded px-3 py-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Slot #</label>
                <input type="number" name="n" id="crudN" class="border rounded px-3 py-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Operation Hour</label>
                <input type="time" name="operhour" id="crudOperhour" class="border rounded px-3 py-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium"># Pills</label>
                <input type="number" name="npill" id="crudNpill" class="border rounded px-3 py-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Name</label>
                <input type="text" name="name" id="crudName" class="border rounded px-3 py-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Description</label>
                <input type="text" name="description" id="crudDescription" class="border rounded px-3 py-2 w-full">
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeCrudModal()" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Toast Notification -->
<div id="toast" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded shadow-lg z-50 hidden"></div>

@push('scripts')
<script>
function openCreateModal() {
    document.getElementById('crudModalTitle').innerText = 'Add Slot';
    document.getElementById('crudForm').action = '/slots';
    document.getElementById('crudFormMethod').value = 'POST';
    document.getElementById('crudDeviceId').value = '';
    document.getElementById('crudN').value = '';
    document.getElementById('crudOperhour').value = '';
    document.getElementById('crudNpill').value = '';
    document.getElementById('crudName').value = '';
    document.getElementById('crudDescription').value = '';
    document.getElementById('crudModal').classList.remove('hidden');
}
function openEditModal(id, device_id, n, operhour, npill, name, description) {
    document.getElementById('crudModalTitle').innerText = 'Edit Slot';
    document.getElementById('crudForm').action = '/slots/' + id;
    document.getElementById('crudFormMethod').value = 'PUT';
    document.getElementById('crudDeviceId').value = device_id;
    document.getElementById('crudN').value = n;
    document.getElementById('crudOperhour').value = operhour;
    document.getElementById('crudNpill').value = npill;
    document.getElementById('crudName').value = name;
    document.getElementById('crudDescription').value = description;
    document.getElementById('crudModal').classList.remove('hidden');
}
function closeCrudModal() {
    document.getElementById('crudModal').classList.add('hidden');
}
function showToast(message) {
    const toast = document.getElementById('toast');
    toast.innerText = message;
    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.add('hidden'), 3000);
}
</script>
@endpush
@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            showToast(@json(session('success')));
        });
    </script>
@endif
@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            showToast(@json($errors->first()));
        });
    </script>
@endif
@endsection

@extends('layouts.app')

@section('title', 'Devices')

@section('content')
<div class="flex flex-col gap-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Devices</h1>
        <button onclick="openCreateModal()" class="bg-green-500 text-white px-4 py-2 rounded shadow">Add Device</button>
    </div>
    <form method="GET" action="{{ url('devices') }}" class="mb-4 flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or MAC..." class="border rounded px-3 py-2 w-1/3">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
    </form>
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200" id="devicesTable">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">MAC</th>
                    <th class="px-4 py-2">Slots</th>
                    <th class="px-4 py-2">Annotations</th>
                    <th class="px-4 py-2">Patient ID</th>
                    <th class="px-4 py-2">istoupdate</th>
                    <th class="px-4 py-2">Updated At</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($devices as $device)
                    <tr>
                        <td class="px-4 py-2">{{ $device->name }}</td>
                        <td class="px-4 py-2">{{ $device->mac }}</td>
                        <td class="px-4 py-2">{{ $device->nslots }}</td>
                        <td class="px-4 py-2">{{ $device->annotations }}</td>
                        <td class="px-4 py-2">{{ $device->patient_id }}</td>
                        <td class="px-4 py-2">{{ $device->istoupdate ? 'Yes' : 'No' }}</td>
                        <td class="px-4 py-2">{{ $device->updated_at ? \Carbon\Carbon::parse($device->updated_at)->format('Y-m-d H:i') : '' }}</td>
                        <td class="px-4 py-2 flex gap-2">
                            <button onclick="openEditModal({{ $device->id }}, '{{ addslashes($device->name) }}', '{{ addslashes($device->mac) }}', '{{ $device->nslots }}', '{{ addslashes($device->annotations) }}', '{{ $device->patient_id }}', {{ $device->istoupdate }}, '{{ $device->updated_at }}' )" class="text-blue-600 hover:underline">Edit</button>
                            <form action="/devices/{{ $device->id }}" method="POST" onsubmit="return confirm('Delete this device?')">
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
        {{ $devices->links() }}
    </div>
</div>

<!-- Create/Edit Modal -->
<div id="crudModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
        <h2 id="crudModalTitle" class="text-xl font-bold mb-4">Add Device</h2>
        <form id="crudForm" method="POST" action="/devices">
            @csrf
            <input type="hidden" name="_method" id="crudFormMethod" value="POST">
            <div class="mb-4">
                <label class="block mb-1 font-medium">Name</label>
                <input type="text" name="name" id="crudName" class="border rounded px-3 py-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">MAC</label>
                <input type="text" name="mac" id="crudMac" class="border rounded px-3 py-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Slots</label>
                <input type="number" name="nslots" id="crudSlots" class="border rounded px-3 py-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Annotations</label>
                <input type="text" name="annotations" id="crudAnnotations" class="border rounded px-3 py-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Patient ID</label>
                <input type="number" name="patient_id" id="crudPatientId" class="border rounded px-3 py-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">istoupdate</label>
                <input type="checkbox" name="istoupdate" id="crudIstoupdate" value="1">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Updated At</label>
                <input type="datetime-local" name="updated_at" id="crudUpdatedAt" class="border rounded px-3 py-2 w-full">
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
    document.getElementById('crudModalTitle').innerText = 'Add Device';
    document.getElementById('crudForm').action = '/devices';
    document.getElementById('crudFormMethod').value = 'POST';
    document.getElementById('crudName').value = '';
    document.getElementById('crudMac').value = '';
    document.getElementById('crudSlots').value = '';
    document.getElementById('crudAnnotations').value = '';
    document.getElementById('crudPatientId').value = '';
    document.getElementById('crudIstoupdate').checked = false;
    document.getElementById('crudUpdatedAt').value = '';
    document.getElementById('crudModal').classList.remove('hidden');
}
function openEditModal(id, name, mac, nslots, annotations, patient_id, istoupdate, updated_at) {
    document.getElementById('crudModalTitle').innerText = 'Edit Device';
    document.getElementById('crudForm').action = '/devices/' + id;
    document.getElementById('crudFormMethod').value = 'PUT';
    document.getElementById('crudName').value = name;
    document.getElementById('crudMac').value = mac;
    document.getElementById('crudSlots').value = nslots;
    document.getElementById('crudAnnotations').value = annotations;
    document.getElementById('crudPatientId').value = patient_id;
    document.getElementById('crudIstoupdate').checked = istoupdate == 1 || istoupdate === true;
    document.getElementById('crudUpdatedAt').value = updated_at ? new Date(updated_at).toISOString().slice(0,16) : '';
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

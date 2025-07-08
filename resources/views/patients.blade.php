@extends('layouts.app')

@section('title', 'Patients')

@section('content')
<div class="flex flex-col gap-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Patients</h1>
        <button onclick="openCreateModal()" class="bg-green-500 text-white px-4 py-2 rounded shadow">Add Patient</button>
    </div>
    <form method="GET" action="{{ url('patients') }}" class="mb-4 flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name..." class="border rounded px-3 py-2 w-1/3">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
    </form>
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200" id="patientsTable">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Date of Birth</th>
                    <th class="px-4 py-2">Breakfast</th>
                    <th class="px-4 py-2">Lunch</th>
                    <th class="px-4 py-2">Dinner</th>
                    <th class="px-4 py-2">Wakeup</th>
                    <th class="px-4 py-2">Sleep</th>
                    <th class="px-4 py-2">Address</th>
                    <th class="px-4 py-2">User ID</th>
                    <th class="px-4 py-2">Anamnesi</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($patients as $patient)
                    <tr>
                        <td class="px-4 py-2">{{ $patient->name }}</td>
                        <td class="px-4 py-2">{{ $patient->date_of_birth }}</td>
                        <td class="px-4 py-2">{{ $patient->breakfast_hour }}</td>
                        <td class="px-4 py-2">{{ $patient->lunch_hour }}</td>
                        <td class="px-4 py-2">{{ $patient->dinner_hour }}</td>
                        <td class="px-4 py-2">{{ $patient->wakeup_hour }}</td>
                        <td class="px-4 py-2">{{ $patient->sleep_hour }}</td>
                        <td class="px-4 py-2">{{ $patient->address }}</td>
                        <td class="px-4 py-2">{{ $patient->user_id }}</td>
                        <td class="px-4 py-2">{{ Str::limit($patient->anamnesi, 50) }}</td>
                        <td class="px-4 py-2 flex gap-2">
                            <button onclick="openEditModal({{ $patient->id }}, '{{ addslashes($patient->name) }}', '{{ $patient->date_of_birth }}', '{{ $patient->breakfast_hour }}', '{{ $patient->lunch_hour }}', '{{ $patient->dinner_hour }}', '{{ $patient->wakeup_hour }}', '{{ $patient->sleep_hour }}', '{{ addslashes($patient->address) }}', '{{ $patient->user_id }}', '{{ addslashes($patient->anamnesi) }}')" class="text-blue-600 hover:underline">Edit</button>
                            <form action="/patients/{{ $patient->id }}" method="POST" onsubmit="return confirm('Delete this patient?')">
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
        {{ $patients->links() }}
    </div>
</div>

<!-- Create/Edit Modal -->
<div id="crudModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
        <h2 id="crudModalTitle" class="text-xl font-bold mb-4">Add Patient</h2>
        <form id="crudForm" method="POST" action="/patients">
            @csrf
            <input type="hidden" name="_method" id="crudFormMethod" value="POST">
            <div class="mb-4">
                <label class="block mb-1 font-medium">Name</label>
                <input type="text" name="name" id="crudName" class="border rounded px-3 py-2 w-full" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Date of Birth</label>
                <input type="date" name="date_of_birth" id="crudDob" class="border rounded px-3 py-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Breakfast Hour</label>
                <input type="time" name="breakfast_hour" id="crudBreakfast" class="border rounded px-3 py-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Lunch Hour</label>
                <input type="time" name="lunch_hour" id="crudLunch" class="border rounded px-3 py-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Dinner Hour</label>
                <input type="time" name="dinner_hour" id="crudDinner" class="border rounded px-3 py-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Wakeup Hour</label>
                <input type="time" name="wakeup_hour" id="crudWakeup" class="border rounded px-3 py-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Sleep Hour</label>
                <input type="time" name="sleep_hour" id="crudSleep" class="border rounded px-3 py-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Address</label>
                <input type="text" name="address" id="crudAddress" class="border rounded px-3 py-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">User ID</label>
                <input type="number" name="user_id" id="crudUserId" class="border rounded px-3 py-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Anamnesi</label>
                <textarea name="anamnesi" id="crudAnamnesi" class="border rounded px-3 py-2 w-full"></textarea>
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
    document.getElementById('crudModalTitle').innerText = 'Add Patient';
    document.getElementById('crudForm').action = '/patients';
    document.getElementById('crudFormMethod').value = 'POST';
    document.getElementById('crudName').value = '';
    document.getElementById('crudDob').value = '';
    document.getElementById('crudBreakfast').value = '';
    document.getElementById('crudLunch').value = '';
    document.getElementById('crudDinner').value = '';
    document.getElementById('crudWakeup').value = '';
    document.getElementById('crudSleep').value = '';
    document.getElementById('crudAddress').value = '';
    document.getElementById('crudUserId').value = '';
    document.getElementById('crudAnamnesi').value = '';
    document.getElementById('crudModal').classList.remove('hidden');
}
function openEditModal(id, name, dob, breakfast, lunch, dinner, wakeup, sleep, address, user_id, anamnesi) {
    document.getElementById('crudModalTitle').innerText = 'Edit Patient';
    document.getElementById('crudForm').action = '/patients/' + id;
    document.getElementById('crudFormMethod').value = 'PUT';
    document.getElementById('crudName').value = name;
    document.getElementById('crudDob').value = dob;
    document.getElementById('crudBreakfast').value = breakfast;
    document.getElementById('crudLunch').value = lunch;
    document.getElementById('crudDinner').value = dinner;
    document.getElementById('crudWakeup').value = wakeup;
    document.getElementById('crudSleep').value = sleep;
    document.getElementById('crudAddress').value = address;
    document.getElementById('crudUserId').value = user_id;
    document.getElementById('crudAnamnesi').value = anamnesi;
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

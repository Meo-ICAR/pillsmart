@extends('layouts.app')

@section('title', 'Doctors')

@section('content')
<div class="flex flex-col gap-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Doctors</h1>
        <button onclick="openCreateModal()" class="bg-green-500 text-white px-4 py-2 rounded shadow">Add Doctor</button>
    </div>
    <form method="GET" action="{{ url('doctors') }}" class="mb-4 flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or User ID..." class="border rounded px-3 py-2 w-1/3">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
    </form>
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200" id="doctorsTable">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">User ID</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($doctors as $doctor)
                    <tr>
                        <td class="px-4 py-2">{{ $doctor->name }}</td>
                        <td class="px-4 py-2">{{ $doctor->user_id }}</td>
                        <td class="px-4 py-2 flex gap-2">
                            <button onclick="openEditModal({{ $doctor->id }}, '{{ addslashes($doctor->name) }}', '{{ $doctor->user_id }}')" class="text-blue-600 hover:underline">Edit</button>
                            <form action="/doctors/{{ $doctor->id }}" method="POST" onsubmit="return confirm('Delete this doctor?')">
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
        {{ $doctors->links() }}
    </div>
</div>

<!-- Create/Edit Modal -->
<div id="crudModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
        <h2 id="crudModalTitle" class="text-xl font-bold mb-4">Add Doctor</h2>
        <form id="crudForm" method="POST" action="/doctors">
            @csrf
            <input type="hidden" name="_method" id="crudFormMethod" value="POST">
            <div class="mb-4">
                <label class="block mb-1 font-medium">Name</label>
                <input type="text" name="name" id="crudName" class="border rounded px-3 py-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">User ID</label>
                <input type="number" name="user_id" id="crudUserId" class="border rounded px-3 py-2 w-full">
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
    document.getElementById('crudModalTitle').innerText = 'Add Doctor';
    document.getElementById('crudForm').action = '/doctors';
    document.getElementById('crudFormMethod').value = 'POST';
    document.getElementById('crudName').value = '';
    document.getElementById('crudUserId').value = '';
    document.getElementById('crudModal').classList.remove('hidden');
}
function openEditModal(id, name, user_id) {
    document.getElementById('crudModalTitle').innerText = 'Edit Doctor';
    document.getElementById('crudForm').action = '/doctors/' + id;
    document.getElementById('crudFormMethod').value = 'PUT';
    document.getElementById('crudName').value = name;
    document.getElementById('crudUserId').value = user_id;
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

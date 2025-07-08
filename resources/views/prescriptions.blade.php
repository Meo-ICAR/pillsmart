@extends('layouts.app')

@section('title', 'Prescriptions')

@section('content')
<div class="flex flex-col gap-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Prescriptions</h1>
        <button onclick="openCreateModal()" class="bg-green-500 text-white px-4 py-2 rounded shadow">Add Prescription</button>
    </div>
    <form method="GET" action="{{ url('prescriptions') }}" class="mb-4 flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by medicine, patient, or doctor..." class="border rounded px-3 py-2 w-1/3">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
    </form>
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200" id="prescriptionsTable">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2">Patient</th>
                    <th class="px-4 py-2">Doctor</th>
                    <th class="px-4 py-2">Medicine</th>
                    <th class="px-4 py-2">Dosage</th>
                    <th class="px-4 py-2">Frequency</th>
                    <th class="px-4 py-2">Date Prescribed</th>
                    <th class="px-4 py-2">Instructions</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($prescriptions as $prescription)
                    <tr>
                        <td class="px-4 py-2">{{ optional($patients->find($prescription->patient_id))->name }}</td>
                        <td class="px-4 py-2">{{ optional($doctors->find($prescription->doctor_id))->name }}</td>
                        <td class="px-4 py-2">{{ $prescription->medicine }}</td>
                        <td class="px-4 py-2">{{ $prescription->dosage }}</td>
                        <td class="px-4 py-2">{{ $prescription->frequency }}</td>
                        <td class="px-4 py-2">{{ $prescription->date_prescribed }}</td>
                        <td class="px-4 py-2">{{ $prescription->instructions }}</td>
                        <td class="px-4 py-2 flex gap-2">
                            <button onclick="openEditModal({{ $prescription->id }}, '{{ $prescription->patient_id }}', '{{ $prescription->doctor_id }}', '{{ addslashes($prescription->medicine) }}', '{{ addslashes($prescription->dosage) }}', '{{ addslashes($prescription->frequency) }}', '{{ $prescription->date_prescribed }}', '{{ addslashes($prescription->instructions) }}')" class="text-blue-600 hover:underline">Edit</button>
                            <form action="/prescriptions/{{ $prescription->id }}" method="POST" onsubmit="return confirm('Delete this prescription?')">
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
        {{ $prescriptions->links() }}
    </div>
</div>

<!-- Create/Edit Modal -->
<div id="crudModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
        <h2 id="crudModalTitle" class="text-xl font-bold mb-4">Add Prescription</h2>
        <form id="crudForm" method="POST" action="/prescriptions">
            @csrf
            <input type="hidden" name="_method" id="crudFormMethod" value="POST">
            <div class="mb-4">
                <label class="block mb-1 font-medium">Patient</label>
                <select name="patient_id" id="crudPatientId" class="border rounded px-3 py-2 w-full" required>
                    <option value="">Select Patient</option>
                    @foreach ($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Doctor</label>
                <select name="doctor_id" id="crudDoctorId" class="border rounded px-3 py-2 w-full" required>
                    <option value="">Select Doctor</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Medicine</label>
                <input type="text" name="medicine" id="crudMedicine" class="border rounded px-3 py-2 w-full" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Dosage</label>
                <input type="text" name="dosage" id="crudDosage" class="border rounded px-3 py-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Frequency</label>
                <input type="text" name="frequency" id="crudFrequency" class="border rounded px-3 py-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Date Prescribed</label>
                <input type="date" name="date_prescribed" id="crudDatePrescribed" class="border rounded px-3 py-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Instructions</label>
                <input type="text" name="instructions" id="crudInstructions" class="border rounded px-3 py-2 w-full">
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
    document.getElementById('crudModalTitle').innerText = 'Add Prescription';
    document.getElementById('crudForm').action = '/prescriptions';
    document.getElementById('crudFormMethod').value = 'POST';
    document.getElementById('crudPatientId').value = '';
    document.getElementById('crudDoctorId').value = '';
    document.getElementById('crudMedicine').value = '';
    document.getElementById('crudDosage').value = '';
    document.getElementById('crudFrequency').value = '';
    document.getElementById('crudDatePrescribed').value = '';
    document.getElementById('crudInstructions').value = '';
    document.getElementById('crudModal').classList.remove('hidden');
}
function openEditModal(id, patient_id, doctor_id, medicine, dosage, frequency, date_prescribed, instructions) {
    document.getElementById('crudModalTitle').innerText = 'Edit Prescription';
    document.getElementById('crudForm').action = '/prescriptions/' + id;
    document.getElementById('crudFormMethod').value = 'PUT';
    document.getElementById('crudPatientId').value = patient_id;
    document.getElementById('crudDoctorId').value = doctor_id;
    document.getElementById('crudMedicine').value = medicine;
    document.getElementById('crudDosage').value = dosage;
    document.getElementById('crudFrequency').value = frequency;
    document.getElementById('crudDatePrescribed').value = date_prescribed;
    document.getElementById('crudInstructions').value = instructions;
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

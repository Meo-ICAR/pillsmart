@extends('layouts.app')

@section('title', 'Medicines')

@section('content')
<div class="flex flex-col gap-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Medicines</h1>
        <div class="flex gap-2">
            <button onclick="openImportModal()" class="bg-blue-500 text-white px-4 py-2 rounded shadow">Import CSV</button>
            <button onclick="openCreateModal()" class="bg-green-500 text-white px-4 py-2 rounded shadow">Add Medicine</button>
        </div>
    </div>
    <div class="flex justify-between items-center mb-2">
        <input type="text" id="searchInput" placeholder="Search..." class="border rounded px-3 py-2 w-1/3" oninput="filterTable()">
    </div>
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200" id="medicinesTable">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2">AIC</th>
                    <th class="px-4 py-2">Denomination</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2">Company</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($medicines as $medicine)
                    <tr>
                        <td class="px-4 py-2">{{ $medicine->codice_aic }}</td>
                        <td class="px-4 py-2">{{ $medicine->denominazione }}</td>
                        <td class="px-4 py-2">{{ $medicine->descrizione }}</td>
                        <td class="px-4 py-2">{{ $medicine->ragione_sociale }}</td>
                        <td class="px-4 py-2 flex gap-2">
                            <button onclick="openEditModal({{ $medicine->id }}, '{{ addslashes($medicine->denominazione) }}', '{{ addslashes($medicine->descrizione) }}', '{{ addslashes($medicine->ragione_sociale) }}')" class="text-blue-600 hover:underline">Edit</button>
                            <form action="/medicines/{{ $medicine->id }}" method="POST" onsubmit="return confirm('Delete this medicine?')">
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
    <!-- Pagination placeholder (for backend pagination) -->
    {{-- $medicines->links() if using pagination --}}
</div>

<!-- Import Modal -->
<div id="importModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Import Medicines CSV</h2>
        <form action="/medicines/import-csv" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" accept=".csv" required class="mb-4">
            <p class="text-sm text-gray-500 mb-2">Max file size: 60MB</p>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeImportModal()" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Import</button>
            </div>
        </form>
    </div>
</div>

<!-- Create/Edit Modal -->
<div id="crudModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
        <h2 id="crudModalTitle" class="text-xl font-bold mb-4">Add Medicine</h2>
        <form id="crudForm" method="POST" action="/medicines">
            @csrf
            <input type="hidden" name="_method" id="crudFormMethod" value="POST">
            <div class="mb-4">
                <label class="block mb-1 font-medium">AIC</label>
                <input type="text" name="codice_aic" id="crudAic" class="border rounded px-3 py-2 w-full" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Denomination</label>
                <input type="text" name="denominazione" id="crudDenomination" class="border rounded px-3 py-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Description</label>
                <input type="text" name="descrizione" id="crudDescription" class="border rounded px-3 py-2 w-full">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Company</label>
                <input type="text" name="ragione_sociale" id="crudCompany" class="border rounded px-3 py-2 w-full">
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
const MAX_FILE_SIZE = 60 * 1024 * 1024;
document.addEventListener('DOMContentLoaded', function () {
    const importForm = document.querySelector('#importModal form');
    if (importForm) {
        importForm.addEventListener('submit', function (e) {
            const fileInput = importForm.querySelector('input[type="file"]');
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                if (file.size > MAX_FILE_SIZE) {
                    e.preventDefault();
                    showToast('File is too large. Max allowed size is 60MB.');
                }
            }
        });
    }
});
function openImportModal() {
    document.getElementById('importModal').classList.remove('hidden');
}
function closeImportModal() {
    document.getElementById('importModal').classList.add('hidden');
}
function openCreateModal() {
    document.getElementById('crudModalTitle').innerText = 'Add Medicine';
    document.getElementById('crudForm').action = '/medicines';
    document.getElementById('crudFormMethod').value = 'POST';
    document.getElementById('crudAic').value = '';
    document.getElementById('crudDenomination').value = '';
    document.getElementById('crudDescription').value = '';
    document.getElementById('crudCompany').value = '';
    document.getElementById('crudModal').classList.remove('hidden');
}
function openEditModal(id, denomination, description, company) {
    document.getElementById('crudModalTitle').innerText = 'Edit Medicine';
    document.getElementById('crudForm').action = '/medicines/' + id;
    document.getElementById('crudFormMethod').value = 'PUT';
    document.getElementById('crudAic').value = id;
    document.getElementById('crudDenomination').value = denomination;
    document.getElementById('crudDescription').value = description;
    document.getElementById('crudCompany').value = company;
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
function filterTable() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#medicinesTable tbody tr');
    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(input) ? '' : 'none';
    });
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

@extends('layouts.app')

@section('title', 'Doctor-Patient Links')

@section('content')
<div class="flex flex-col gap-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Doctor-Patient Links</h1>
    </div>
    <form method="POST" action="{{ route('doctor-patients.store') }}" class="mb-4 flex gap-2 items-end">
        @csrf
        <div>
            <label class="block mb-1 font-medium">Doctor</label>
            <select name="doctor_id" class="border rounded px-3 py-2 w-full" required>
                <option value="">Select Doctor</option>
                @foreach ($doctors as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block mb-1 font-medium">Patient</label>
            <select name="patient_id" class="border rounded px-3 py-2 w-full" required>
                <option value="">Select Patient</option>
                @foreach ($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Add Link</button>
    </form>
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2">Doctor</th>
                    <th class="px-4 py-2">Patient</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($links as $link)
                    <tr>
                        <td class="px-4 py-2">{{ $link->doctor_name }}</td>
                        <td class="px-4 py-2">{{ $link->patient_name }}</td>
                        <td class="px-4 py-2">
                            <form action="{{ route('doctor-patients.destroy', $link->id) }}" method="POST" onsubmit="return confirm('Remove this link?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $links->links() }}
    </div>
</div>
@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            alert(@json(session('success')));
        });
    </script>
@endif
@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            alert(@json($errors->first()));
        });
    </script>
@endif
@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Smartpill')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-white shadow mb-8">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-blue-600">Smartpill</a>
            <ul class="flex gap-6">
                <li><a href="/medicines" class="text-gray-700 hover:text-blue-600 font-medium">Medicines</a></li>
                <li><a href="/patients" class="text-gray-700 hover:text-blue-600 font-medium">Patients</a></li>
                <li><a href="/devices" class="text-gray-700 hover:text-blue-600 font-medium">Devices</a></li>
                <li><a href="/slots" class="text-gray-700 hover:text-blue-600 font-medium">Slots</a></li>
                <li><a href="/doctors" class="text-gray-700 hover:text-blue-600 font-medium">Doctors</a></li>
                <li><a href="/caregivers" class="text-gray-700 hover:text-blue-600 font-medium">Caregivers</a></li>
                <li><a href="/prescriptions" class="text-gray-700 hover:text-blue-600 font-medium">Prescriptions</a></li>
                <li><a href="/doctor-patients" class="text-gray-700 hover:text-blue-600 font-medium">Doctor-Patient Links</a></li>
                <li><a href="/caregiver-patients" class="text-gray-700 hover:text-blue-600 font-medium">Caregiver-Patient Links</a></li>
            </ul>
        </div>
    </nav>
    <main class="container mx-auto px-4">
        @yield('content')
    </main>
    @stack('modals')
    @stack('scripts')
</body>
</html>

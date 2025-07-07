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
                <li><a href="#" onclick="openImportModal();return false;" class="text-gray-700 hover:text-blue-600 font-medium">Import</a></li>
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

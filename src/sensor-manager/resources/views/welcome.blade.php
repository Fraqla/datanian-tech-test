<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans leading-relaxed antialiased">
    <div class="min-h-screen py-12 px-6 md:px-12 lg:px-24 flex flex-col items-center">

        <!-- Welcome Card -->
        <div class="bg-white shadow-xl rounded-2xl p-10 w-full max-w-4xl text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-800 mb-4">👋 Welcome to the Sensor Monitoring System</h1>
            <p class="text-gray-600 text-lg mb-8">Manage your sensor and station data efficiently with real-time insights.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Station Module -->
                <a href="{{ route('station') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-6 px-6 shadow-lg transform hover:-translate-y-1 transition duration-300">
                    <h2 class="text-2xl font-semibold">📍 Station Manager</h2>
                    <p class="text-sm mt-2">Manage locations and station details</p>
                </a>

                <!-- Sensor Module -->
                <a href="{{ route('sensor') }}"
                   class="bg-green-600 hover:bg-green-700 text-white rounded-xl py-6 px-6 shadow-lg transform hover:-translate-y-1 transition duration-300">
                    <h2 class="text-2xl font-semibold">🔧 Sensor Manager</h2>
                    <p class="text-sm mt-2">Manage sensors and capabilities</p>
                </a>
            </div>
        </div>

        <!-- Analytics Section -->
        <div class="w-full max-w-6xl">
            <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">📊 System Overview</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                <!-- Total Stations -->
                <div class="bg-blue-100 text-center p-6 rounded-xl shadow-md">
                    <h3 class="text-lg font-bold text-blue-800">Total Stations</h3>
                    <p class="text-4xl text-blue-900 font-extrabold mt-2">{{ \App\Models\Station::count() }}</p>
                    <p class="text-sm text-blue-700 mt-1">All registered monitoring stations</p>
                </div>

                <!-- Active Stations -->
                <div class="bg-green-100 text-center p-6 rounded-xl shadow-md">
                    <h3 class="text-lg font-bold text-green-800">Active</h3>
                    <p class="text-4xl text-green-900 font-extrabold mt-2">
                        {{ \App\Models\Station::where('status', 'active')->count() }}
                    </p>
                    <p class="text-sm text-green-700 mt-1">Stations currently operating</p>
                </div>

                <!-- Inactive Stations -->
                <div class="bg-gray-100 text-center p-6 rounded-xl shadow-md">
                    <h3 class="text-lg font-bold text-gray-800">Inactive</h3>
                    <p class="text-4xl text-gray-900 font-extrabold mt-2">
                        {{ \App\Models\Station::where('status', 'inactive')->count() }}
                    </p>
                    <p class="text-sm text-gray-700 mt-1">Stations not in use or turned off</p>
                </div>

                <!-- Maintenance Stations -->
                <div class="bg-yellow-100 text-center p-6 rounded-xl shadow-md">
                    <h3 class="text-lg font-bold text-yellow-800">Maintenance</h3>
                    <p class="text-4xl text-yellow-900 font-extrabold mt-2">
                        {{ \App\Models\Station::where('status', 'maintenance')->count() }}
                    </p>
                    <p class="text-sm text-yellow-700 mt-1">Stations under maintenance or repair</p>
                </div>

                <!-- Total Sensors -->
                <div class="bg-purple-100 text-center p-6 rounded-xl shadow-md">
                    <h3 class="text-lg font-bold text-purple-800">Total Sensors</h3>
                    <p class="text-4xl text-purple-900 font-extrabold mt-2">{{ \App\Models\Sensor::count() }}</p>
                    <p class="text-sm text-purple-700 mt-1">All sensors installed across stations</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

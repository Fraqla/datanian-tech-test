<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans">
    <div class="flex items-center justify-center min-h-screen">
        <div class="text-center">
            <h1 class="text-4xl font-bold mb-4">Welcome to My App</h1>
            <p class="mb-8 text-gray-600">Choose a page to explore:</p>

            <div class="space-x-4">
                <!-- Button to go to Station page -->
                <a href="{{ route('station') }}" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Go to Station
                </a>
                <!-- Button to go to Sensor page -->
                <a href="{{ route('sensor') }}" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Go to Sensor
                </a>
            </div>
        </div>
    </div>
</body>

</html>
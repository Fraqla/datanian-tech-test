<div class="p-6 max-w-5xl mx-auto bg-white rounded-lg shadow-md">
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Sensor Management</h1>
        <p class="text-gray-600">Add, edit, or remove sensors from stations</p>
    </div>

    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ url('/') }}"
           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            ← Back to Home
        </a>
    </div>

    <!-- Flash success message -->
    @if (session()->has('message'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded">
            <p class="text-sm text-green-700">{{ session('message') }}</p>
        </div>
    @endif

    <!-- Sensor Form -->
    <div class="bg-gray-50 p-5 rounded-lg mb-8 border border-gray-200">
        <h2 class="text-lg font-medium text-gray-800 mb-4">{{ $isEditing ? 'Update Sensor' : 'Add New Sensor' }}</h2>

        <form wire:submit.prevent="{{ $isEditing ? 'updateSensor' : 'saveSensor' }}" class="space-y-4">
            <!-- Station dropdown -->
            <div>
                <label for="station_id" class="block text-sm font-medium text-gray-700 mb-1">Station</label>
                <select wire:model="station_id" id="station_id"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                    <option value="">-- Select Station --</option>
                    @foreach ($stations as $station)
                        <option value="{{ $station->id }}">{{ $station->name ?? 'Station #' . $station->id }}</option>
                    @endforeach
                </select>
                @error('station_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Sensor Type -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <input wire:model="type" type="text" id="type"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Capability -->
            <div>
                <label for="capability" class="block text-sm font-medium text-gray-700 mb-1">Capability</label>
                <input wire:model="capability" type="text" id="capability"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                @error('capability') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <input wire:model="status" type="text" id="status"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Buttons -->
            <div class="pt-2">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700">
                    {{ $isEditing ? 'Update Sensor' : 'Add Sensor' }}
                </button>
                @if ($isEditing)
                    <button type="button" wire:click="resetForm"
                        class="ml-2 inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                        Cancel
                    </button>
                @endif
            </div>
        </form>
    </div>

    <!-- Sensor Table -->
    <div class="overflow-x-auto">
        <h2 class="text-lg font-medium text-gray-800 mb-3">Sensor List</h2>
        <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Station</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Capability</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($sensors as $sensor)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $sensor->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $sensor->station->name ?? 'Station #' . $sensor->station_id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $sensor->type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $sensor->capability }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $sensor->status }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button wire:click="editSensor({{ $sensor->id }})" class="text-blue-600 hover:text-blue-900 mr-2">
                                Edit
                            </button>

                            @if ($confirmingDeleteId === $sensor->id)
                                <span class="inline-flex space-x-2">
                                    <button wire:click="deleteConfirmed" class="text-red-700 font-bold">
                                        Confirm Delete
                                    </button>
                                    <button wire:click="cancelDelete" class="text-gray-500">
                                        Cancel
                                    </button>
                                </span>
                            @else
                                <button wire:click="confirmDelete({{ $sensor->id }})" class="text-red-600 hover:text-red-900">
                                    Delete
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center px-6 py-4 text-sm text-gray-500">No sensors found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Confirmation Modal -->
    @if ($confirmingDeleteId)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                <h2 class="text-lg font-bold mb-4">Are you sure you want to delete this sensor?</h2>
                <div class="flex justify-end space-x-3">
                    <button wire:click="deleteConfirmed"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                        Yes, Delete
                    </button>
                    <button wire:click="cancelDelete"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

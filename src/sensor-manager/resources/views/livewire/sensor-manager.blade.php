<div class="p-4">
    <h2 class="text-xl font-bold mb-4">Sensor Manager</h2>

    {{-- Flash success message --}}
    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-2 mb-4">
            {{ session('message') }}
        </div>
    @endif

    {{-- Sensor Form: handles both creation and update based on $isEditing --}}
    <form wire:submit.prevent="{{ $isEditing ? 'updateSensor' : 'saveSensor' }}" class="space-y-4 mb-6">
        {{-- Station selection dropdown --}}
        <div>
            <label for="station_id">Station</label>
            <select wire:model="station_id" id="station_id" class="w-full border p-2">
                <option value="">-- Select Station --</option>
                @foreach ($stations as $station)
                    <option value="{{ $station->id }}">{{ $station->name ?? 'Station #' . $station->id }}</option>
                @endforeach
            </select>
            @error('station_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Input for Sensor Type --}}
        <div>
            <label for="type">Type</label>
            <input wire:model="type" type="text" id="type" class="w-full border p-2">
            @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Input for Sensor Capability --}}
        <div>
            <label for="capability">Capability</label>
            <input wire:model="capability" type="text" id="capability" class="w-full border p-2">
            @error('capability') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Input for Sensor Status --}}
        <div>
            <label for="status">Status</label>
            <input wire:model="status" type="text" id="status" class="w-full border p-2">
            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Submit & Cancel buttons --}}
        <div class="flex gap-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                {{ $isEditing ? 'Update Sensor' : 'Add Sensor' }}
            </button>
            @if ($isEditing)
                <button type="button" wire:click="resetForm" class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</button>
            @endif
        </div>
    </form>

    {{-- Table of existing sensors --}}
    <table class="w-full table-auto border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Station</th>
                <th class="border px-4 py-2">Type</th>
                <th class="border px-4 py-2">Capability</th>
                <th class="border px-4 py-2">Status</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            {{-- Loop through each sensor --}}
            @forelse ($sensors as $sensor)
                <tr>
                    <td class="border px-4 py-2">{{ $sensor->id }}</td>
                    <td class="border px-4 py-2">{{ $sensor->station->name ?? 'Station #' . $sensor->station_id }}</td>
                    <td class="border px-4 py-2">{{ $sensor->type }}</td>
                    <td class="border px-4 py-2">{{ $sensor->capability }}</td>
                    <td class="border px-4 py-2">{{ $sensor->status }}</td>
                    <td class="border px-4 py-2">
                        {{-- Edit button loads selected sensor data into form --}}
                        <button wire:click="editSensor({{ $sensor->id }})" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                        {{-- Delete button removes sensor --}}
                        <button wire:click="deleteSensor({{ $sensor->id }})" class="bg-red-500 text-white px-2 py-1 rounded ml-2">Delete</button>
                    </td>
                </tr>
            @empty
                {{-- If no sensors exist --}}
                <tr>
                    <td colspan="6" class="text-center p-4">No sensors found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

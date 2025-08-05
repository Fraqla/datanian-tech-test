<div class="p-6 max-w-3xl mx-auto">
    {{-- Flash message after saving/deleting --}}
    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    {{-- Form to create or update a station --}}
    <form wire:submit.prevent="save" class="space-y-4 mb-6">
        <input type="text" wire:model="name" placeholder="Station Name" class="w-full p-2 border rounded" />
        <input type="text" wire:model="location" placeholder="Location" class="w-full p-2 border rounded" />

        {{-- Dropdown for station status --}}
        <select wire:model="status" class="w-full p-2 border rounded">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>

        {{-- Submit button --}}
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
    </form>

    {{-- Table displaying list of stations --}}
    <table class="w-full table-auto border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">Name</th>
                <th class="border p-2">Location</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            {{-- Loop through each station and display its data --}}
            @foreach ($stations as $station)
                <tr>
                    <td class="border p-2">{{ $station->name }}</td>
                    <td class="border p-2">{{ $station->location }}</td>
                    <td class="border p-2">{{ $station->status }}</td>
                    <td class="border p-2 space-x-2">
                        {{-- Button to load data into form for editing --}}
                        <button wire:click="edit({{ $station->id }})" class="text-blue-500 hover:underline">Edit</button>

                        {{-- Button to delete the station --}}
                        <button wire:click="delete({{ $station->id }})" class="text-red-500 hover:underline">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Station;

class StationManager extends Component
{
    // Public properties bound to the form inputs
    public $name, $location, $status = 'active';
    public $station_id;
    public $confirmingDeleteId = null;
    public $searchInput = '';
    public $search = '';

    // Handles saving new station or updating existing one
    public function save()
    {
        //Validate input fields
        $this->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'status' => 'required|in:active,inactive,maintenance',
        ]);

        // Create or update a station record
        Station::updateOrCreate(
            ['id' => $this->station_id],
            [
                'name' => $this->name,
                'location' => $this->location,
                'status' => $this->status,
            ]
        );

        // Flash success message and reset the form fields
        session()->flash('message', 'Station saved successfully.');
        $this->resetForm();
    }

    // Load station details into form for editing
    public function edit($id)
    {
        $station = Station::findOrFail($id);
        $this->station_id = $station->id;
        $this->name = $station->name;
        $this->location = $station->location;
        $this->status = $station->status;
    }

    // Called when delete button is clicked
    public function confirmDelete($id)
    {
        $this->confirmingDeleteId = $id;
    }

    // Cancel delete
    public function cancelDelete()
    {
        $this->confirmingDeleteId = null;
    }

    // Called after user confirms deletion
    public function deleteConfirmed()
    {
        Station::findOrFail($this->confirmingDeleteId)->delete();
        $this->confirmingDeleteId = null;
        session()->flash('message', 'Station deleted successfully.');
    }

    // Reset form fields to default
    public function resetForm()
    {
        $this->name = '';
        $this->location = '';
        $this->status = 'active';
        $this->station_id = null;
    }

    public function applySearch()
    {
        $this->search = $this->searchInput;
    }

    public function clearSearch()
    {
        $this->searchInput = '';
        $this->search = '';
    }

    // Render the Livewire view with layout
    public function render()
    {
        $stations = Station::query();

        if (!empty($this->search) || !empty($this->searchInput)) {
            $searchTerm = $this->search ?: $this->searchInput;
            $stations->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('location', 'like', '%' . $searchTerm . '%');
            });
        }

        return view('livewire.station-manager', [
            'stations' => $stations->get()
        ])->layout('layouts.app');
    }
}

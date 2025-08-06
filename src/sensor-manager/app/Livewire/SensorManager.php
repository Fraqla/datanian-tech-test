<?php

namespace App\Livewire;

use App\Models\Sensor;
use App\Models\Station;
use Livewire\Component;

class SensorManager extends Component
{
    // Properties to store sensors and stations data, form input
    public $stations;
    public $sensor_id, $station_id, $type, $capability, $status;
    public $isEditing = false;
    public $confirmingDeleteId = null;
    public $searchInput = '';
    public $search = '';
    public $perPage = 10;


    // Runs when the component loads
    public function mount()
    {
        $this->stations = Station::all();
    }

    // Clear the form and reset editing state
    public function resetForm()
    {
        $this->sensor_id = null;
        $this->station_id = '';
        $this->type = '';
        $this->capability = '';
        $this->status = '';
        $this->isEditing = false;
        $this->confirmingDeleteId = null;
    }

    // Save a new sensor to the database
    public function saveSensor()
    {
        // Validate input fields
        $this->validate([
            'station_id' => 'required|exists:stations,id',
            'type' => 'required|string',
            'capability' => 'required|string',
            'status' => 'required|string',
        ]);

        // Create new sensor
        Sensor::create([
            'station_id' => $this->station_id,
            'type' => $this->type,
            'capability' => $this->capability,
            'status' => $this->status,
        ]);

        // Reset form, reload list, and show success message
        $this->resetForm();
        session()->flash('message', 'Sensor created successfully.');
    }

    // Load a sensor's data into the form for editing
    public function editSensor($id)
    {
        $sensor = Sensor::findOrFail($id);
        $this->sensor_id = $sensor->id;
        $this->station_id = $sensor->station_id;
        $this->type = $sensor->type;
        $this->capability = $sensor->capability;
        $this->status = $sensor->status;
        $this->isEditing = true;
        $this->confirmingDeleteId = null;
    }

    // Save changes to an existing sensor
    public function updateSensor()
    {
        // Validate input before updating
        $this->validate([
            'station_id' => 'required|exists:stations,id',
            'type' => 'required|string',
            'capability' => 'required|string',
            'status' => 'required|string',
        ]);

        // Find and update the sensor
        $sensor = Sensor::findOrFail($this->sensor_id);
        $sensor->update([
            'station_id' => $this->station_id,
            'type' => $this->type,
            'capability' => $this->capability,
            'status' => $this->status,
        ]);

        // Reset form, reload list, and show success message
        $this->resetForm();
        session()->flash('message', 'Sensor updated successfully.');
    }

    // Trigger delete confirmation
    public function confirmDelete($id)
    {
        $this->confirmingDeleteId = $id;
    }

    // Cancel delete confirmation
    public function cancelDelete()
    {
        $this->confirmingDeleteId = null;
    }

    // Delete method
    public function deleteConfirmed()
    {
        if ($this->confirmingDeleteId) {
            Sensor::findOrFail($this->confirmingDeleteId)->delete();
            $this->confirmingDeleteId = null;
            session()->flash('message', 'Sensor deleted successfully.');
        }
    }

    // Search functions
    public function applySearch()
    {
        $this->search = $this->searchInput;
    }

    public function clearSearch()
    {
        $this->searchInput = '';
        $this->search = '';
    }

    // Display the page with the layout
    public function render()
    {
        $sensors = Sensor::with('station')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('type', 'like', '%' . $this->search . '%')
                        ->orWhere('capability', 'like', '%' . $this->search . '%')
                        ->orWhere('status', 'like', '%' . $this->search . '%')
                        ->orWhereHas('station', function ($q) {
                            $q->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->get();

        return view('livewire.sensor-manager', [
            'sensors' => $sensors
        ])->layout('layouts.app');
    }
}

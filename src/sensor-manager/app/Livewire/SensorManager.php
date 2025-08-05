<?php

namespace App\Livewire;

use App\Models\Sensor;
use App\Models\Station;
use Livewire\Component;

class SensorManager extends Component
{
    // Properties to store sensors and stations data, form input
    public $sensors, $stations;
    public $sensor_id, $station_id, $type, $capability, $status;
    public $isEditing = false;

    // Runs when the component loads
    public function mount()
    {
        $this->stations = Station::all();
        $this->loadSensors();
    }

    // Fetch all sensors including their related station
    public function loadSensors()
    {
        $this->sensors = Sensor::with('station')->get();
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
        $this->loadSensors();
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
        $this->loadSensors();
        session()->flash('message', 'Sensor updated successfully.');
    }

    // Delete a sensor by ID
    public function deleteSensor($id)
    {
        Sensor::findOrFail($id)->delete();
        $this->loadSensors();
        session()->flash('message', 'Sensor deleted successfully.');
    }

    // Display the page with the layout
    public function render()
    {
        return view('livewire.sensor-manager')
            ->layout('layouts.app');
    }
}

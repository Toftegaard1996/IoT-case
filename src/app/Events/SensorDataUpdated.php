<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SensorDataUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sensorData;

    public function __construct($sensorData)
    {
        // Log the sensor data when the event is created
        \Log::info('Broadcasting SensorDataUpdated Event', ['sensorData' => $sensorData]);

        $this->sensorData = $sensorData;
    }
    public function broadcastWith(): array
    {
        return [
            'sensorData' => $this->sensorData,
        ];
    }
    public function broadcastOn()
    {
        //return new Channel('sensor-channel');
        return [
            new Channel('sensor-channel'),
        ];
    }


}

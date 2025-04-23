@php
    $features = [
        'air_conditioning' => 'Air Conditioning',
        'power_windows' => 'Power Windows',
        'power_door_locks' => 'Power Door Locks',
        'abs' => 'ABS',
        'cruise_control' => 'Cruise Control',
        'bluetooth_connectivity' => 'Bluetooth Connectivity',
        'gps_navigation' => 'GPS Navigation System',
        'heated_seats' => 'Heated Seats',
        'climate_control' => 'Climate Control',
        'rear_parking_sensors' => 'Rear Parking Sensors',
        'leather_seats' => 'Leather Seats',
    ];
@endphp

@foreach ($features as $name => $feature)
    <label class="checkbox">
        <input type="checkbox" name="features[{{ $name }}]" value="1" />
        {{ $feature }}
    </label>
@endforeach

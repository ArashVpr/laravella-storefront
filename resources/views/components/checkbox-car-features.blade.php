@props(['car' => null])

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

@foreach ($features as $key => $feature)
    <label class="relative flex items-start gap-3 p-3 border border-gray-200 rounded-lg cursor-pointer transition-all hover:bg-gray-50 has-[:checked]:bg-primary/5 has-[:checked]:border-primary">
        <input type="checkbox"
               name="features[{{ $key }}]"
               value="1"
               @checked(old('features.'.$key, $car?->features->$key))
               class="mt-0.5 h-5 w-5 rounded border-gray-300 text-primary focus:ring-primary" />
        <span class="text-sm font-medium text-gray-700">{{ $feature }}</span>
    </label>
@endforeach


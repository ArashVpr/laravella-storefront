@foreach ($fuelTypes as $fuelType)
    <option value="{{ $fuelType->id }}">{{ $fuelType->name }}</option>
@endforeach
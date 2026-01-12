@foreach ($fuelTypes as $fuelType)
<option value="{{ $fuelType->id }}" @selected($attributes->get('value') == $fuelType->id)>
    {{ __('fuel_types.'.$fuelType->name) }}
</option>
@endforeach
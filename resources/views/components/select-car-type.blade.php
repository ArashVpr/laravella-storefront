@foreach ($carTypes as $carType)
<option value="{{ $carType->id }}" @selected($attributes->get('value') == $carType->id)>
    {{ __("car_types.{$carType->name}") }}
</option>
@endforeach
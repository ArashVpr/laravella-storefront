@foreach ($carTypes as $carType)
    <option value="{{ $carType->id }}" @selected($attributes->get('value') == $carType->id)>
        {{ $carType->name }}
    </option>
@endforeach

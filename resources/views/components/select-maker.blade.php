@foreach ($makers as $maker)
    <option value="{{ $maker->id }}" @selected($attributes->get('value') == $maker->id)>
        {{ $maker->name }}
    </option>
@endforeach

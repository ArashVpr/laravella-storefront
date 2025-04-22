@foreach ($cities as $city)
    <option value="{{ $city->id }}" data-parent="{{ $city->state_id }}">
        {{ $city->name }}
    </option>
@endforeach

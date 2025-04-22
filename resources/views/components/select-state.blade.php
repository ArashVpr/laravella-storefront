@foreach ($states as $state)
    <option value="{{ $state->id }}" @selected($attributes->get('value') == $state->id)>
        {{ $state->name }}
    </option>
@endforeach

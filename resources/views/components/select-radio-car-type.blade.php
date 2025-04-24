<label class="col">
    @foreach ($radioCarTypes as $radioCarType)
        <input type="radio" name="car_type_id" value="{{ $radioCarType->id }}" @checked($attributes->get('value') == $radioCarType->id) />
        {{ $radioCarType->name }}
    @endforeach
</label>

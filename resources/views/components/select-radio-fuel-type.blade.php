<label class="col">
    @foreach ($radioFuelTypes as $radioFuelType)
        <input type="radio" name="fuel_type_id" value="{{ $radioFuelType->id }}" />
        {{ $radioFuelType->name }}
    @endforeach
</label>

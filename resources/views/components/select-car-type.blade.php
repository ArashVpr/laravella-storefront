@foreach ($carTypes as $carType)
    <option value="{{ $carType->id }}">{{ $carType->name }}</option>
@endforeach

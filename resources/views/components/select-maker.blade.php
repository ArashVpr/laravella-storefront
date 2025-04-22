@foreach($makers as $maker)
<option value="{{ $maker->id }}">{{ $maker->name }}</option>
@endforeach


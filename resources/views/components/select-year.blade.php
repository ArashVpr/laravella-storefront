@php
    $year = now()->year;
@endphp

<select name="year">
    <option value="">Year</option>
    @for ($i = $year; $i >= 1990; $i--)
        <option value="{{ $i }}" @selected($attributes->get('value') == $i)>{{ $i }}</option>
    @endfor
</select>

@php
$year = now()->year;
@endphp

<select name="year" {{ $attributes->merge(['class' => 'w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all']) }}>
    <option value="">{{ __('Year') }}</option>
    @for ($i = $year; $i >= 1990; $i--)
    <option value="{{ $i }}" @selected($attributes->get('value') == $i)>{{ $i }}</option>
    @endfor
</select>
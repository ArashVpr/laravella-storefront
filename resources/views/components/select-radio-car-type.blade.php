@foreach ($radioCarTypes as $radioCarType)
    <label class="relative flex items-center justify-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer transition-all hover:border-primary hover:bg-primary/5 has-[:checked]:border-primary has-[:checked]:bg-primary/10 has-[:checked]:shadow-lg has-[:checked]:shadow-primary/20">
        <input type="radio" name="car_type_id" value="{{ $radioCarType->id }}" @checked($attributes->get('value') == $radioCarType->id) class="sr-only peer" />
        <div class="text-center">
            <div class="font-semibold text-gray-900 peer-checked:text-primary">{{ $radioCarType->name }}</div>
        </div>
        <div class="absolute top-2 right-2 w-5 h-5 rounded-full border-2 border-gray-300 peer-checked:border-primary peer-checked:bg-primary flex items-center justify-center">
            <svg class="w-3 h-3 text-white hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
        </div>
    </label>
@endforeach

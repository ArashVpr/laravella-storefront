@foreach ($models as $model)
    <option value="{{ $model->id }}" data-parent="{{ $model->maker_id }}">
        {{ $model->name }}
    </option>
@endforeach

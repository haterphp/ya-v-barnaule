<input type="text" 
    name="{{ $name }}"
    id="{{ $id }}" 
    value="" 
    data-slider-min="{{ $min }}" 
    data-slider-max="{{ $max }}" 
    data-slider-step="{{ $step ?? 1 }}" 
    data-slider-value="[{{ $current['min'] }}, {{ $current['max'] }}]">
    <div class="wrap d-flex align-items-center justify-content-between mt-2">
        <p class="mb-0">{{ $min }}</p>
        <p class="mb-0">{{ $max }}</p>
    </div>

@push('js')
    <script>
        components[@json($name)] = {};
        components[@json($name)]['id'] = @json($id);
        components[@json($name)]['$form'] = @json($form);
        initRange(components[@json($name)]);
    </script>
@endpush

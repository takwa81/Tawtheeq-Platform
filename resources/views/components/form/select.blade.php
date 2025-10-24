@props([
    'id', 
    'name', 
    'label' => null, 
    'options' => [], 
    'value' => null,   {{-- old() or default value --}}
    'selected' => null, {{-- explicit selected value --}}
    'required' => false, 
    'errorId' => null,
    'col' => 6
])

<div class="mb-3 col-md-{{ $col }}">
    @if ($label)
        <label for="{{ $id }}" class="form-label">
            {{ $label }}
            @if ($required)
                <b class="text-danger">*</b>
            @endif
        </label>
    @endif

    @php
        $current = old($name, $selected ?? $value);
    @endphp

        <select 
            id="{{ $id }}" 
            name="{{ $name }}" 
            class="form-select"
            data-selected="{{ $selected ?? $value }}"
                >
            <option value="">اختر...</option>
            @foreach($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" {{ (string)$current === (string)$optionValue ? 'selected' : '' }}>
                    {{ $optionLabel }}
                </option>
            @endforeach
    </select>


    @if ($errorId)
        <div class="text-danger" id="{{ $errorId }}"></div>
    @endif

    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

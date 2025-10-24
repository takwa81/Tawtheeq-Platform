@props([
    'id', 
    'name', 
    'label' => null, 
    'checked' => false, 
    'required' => false, 
    'errorId' => null, 
    'col' => 6
])

<div class="mb-3 col-md-{{ $col }}">
    <div class="form-check">
        <input type="checkbox" class="form-check-input custom-checkbox" id="{{ $id }}" name="{{ $name }}" 
            value="1" {{ old($name, $checked) ? 'checked' : '' }}>
        @if($label)
            <label class="form-check-label" for="{{ $id }}">
                {{ $label }}
                @if ($required)
                    <b class="text-danger">*</b>
                @endif
            </label>
        @endif
    </div>

    @if ($errorId)
        <div class="text-danger" id="{{ $errorId }}"></div>
    @endif

    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>


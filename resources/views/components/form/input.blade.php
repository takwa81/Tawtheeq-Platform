@props([
    'id', 
    'name', 
    'label' => null, 
    'type' => 'text', 
    'value' => '', 
    'required' => false, 
    'errorId' => null, 
    'col' => 6,
    'readonly' => false, 
])

<div class="mb-3 col-md-{{ $col ?? 6 }}">
    @if ($label)
        <label for="{{ $id }}" class="form-label">
            {{ $label }}
            @if ($required)
                <b class="text-danger">*</b>
            @endif
        </label>
    @endif

    <input type="{{ $type }}" class="form-control" id="{{ $id }}" name="{{ $name }}"
        value="{{ old($name, $value) }}"
        autocomplete="{{ $type === 'password' ? 'new-password' : 'off' }}"
        {{ $readonly ? 'readonly' : '' }}> 

    @if ($errorId)
        <div class="text-danger" id="{{ $errorId }}"></div>
    @endif

    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

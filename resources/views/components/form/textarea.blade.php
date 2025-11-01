@props(['id', 'name', 'label' => null, 'value' => '', 'required' => false, 'errorId' => null, 'col' => 6])

<div class="mb-3 col-md-{{ $col }}">
    @if ($label)
        <label for="{{ $id }}" class="form-label">
            {{ $label }}
            @if ($required)
                <b class="text-danger">*</b>
            @else
                <span class="text-muted">({{ __('dashboard.optional') }})</span>
            @endif
        </label>
    @endif

    <textarea id="{{ $id }}" name="{{ $name }}" class="form-control" {{ $required ? 'required' : '' }}
        {{-- enforce HTML5 required --}}>{{ old($name, $value ?: $slot) }}</textarea>

    @if ($errorId)
        <div class="text-danger" id="{{ $errorId }}"></div>
    @endif

    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

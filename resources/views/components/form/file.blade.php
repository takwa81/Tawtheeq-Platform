@props([
    'id' => 'imageInput',
    'name' => 'image',
    'label' => 'الصورة',
    'required' => false,
    'errorId' => 'imageError',
    'col' => 12,
    'previewSrc' => asset('assets/images/upload.svg'),
])

<div class="mb-3 col-md-{{ $col }}">
    @if ($label)
        <label class="form-label">{{ $label }}
            @if ($required)
                <b class="text-danger">*</b>
            @else
                <span class="text-muted">({{ __('dashboard.optional') }})</span>
            @endif
        </label>
    @endif

    <div class="d-flex flex-column align-items-center gap-2 border rounded p-3">
        <img src="{{ old($name) ? asset('storage/' . old($name)) : $previewSrc }}" alt="preview"
            id="preview-{{ $id }}" class="img-fluid" style="max-height: 120px;">

        <input type="file" id="{{ $id }}" name="{{ $name }}" class="form-control" accept="image/*">

        @if ($errorId)
            <div class="text-danger" id="{{ $errorId }}"></div>
        @endif

        @error($name)
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

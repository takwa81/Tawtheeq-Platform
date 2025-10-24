<div class="">
    {{-- Edit --}}
    @if (!empty($editData))
        <a href="javascript:void(0)" class="btn btn-md rounded font-sm edit-data" data-id="{{ $id }}"
            @foreach ($editData ?? [] as $key => $value)
                @php
                    $attrValue = is_array($value) ? json_encode($value) : $value;
                @endphp
                data-{{ $key }}="{{ $attrValue }}" @endforeach>
            <i class="material-icons md-edit"></i>
        </a>
    @endif


    @if (!empty($editRoute))
        <a href="{{ $editRoute }}" class="btn btn-md rounded font-sm">
            <i class="material-icons md-edit"></i>
        </a>
    @endif

    {{-- Delete --}}
    @if (!empty($deleteRoute))
        <form class="d-inline delete-form" action="{{ $deleteRoute }}" method="POST" data-id="{{ $id }}">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-md bg-danger rounded font-sm delete-button">
                <i class="material-icons md-delete"></i>
            </button>
        </form>
    @endif
    {{-- Show (optional) --}}
    @if (!empty($showRoute))
        <a href="{{ $showRoute }}" class="btn btn-md rounded font-sm bg-secondary">
            <i class="material-icons md-remove_red_eye"></i>
        </a>
    @endif
</div>

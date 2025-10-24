<div class="content-header d-flex justify-content-between align-items-center">
    <h2 class="content-title card-title">{{ $title }}</h2>

    @if(!empty($addModalId))
        <a href="javascript:void(0)" 
           class="btn btn-md rounded font-sm" 
           data-bs-toggle="modal" 
           data-bs-target="#{{ $addModalId }}">
            <i class="material-icons md-plus"></i>
        </a>
    @elseif(!empty($addRoute))
        <a href="{{ $addRoute }}" class="btn btn-md rounded font-sm">
            <i class="material-icons md-plus"></i>
        </a>
    @endif
</div>

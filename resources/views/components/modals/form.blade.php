<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog {{ $size ?? '' }}">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modalId }}Label">{{ $title }}</h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal"></button> -->
            </div>
            <div class="modal-body">
                <form id="{{ $formId }}" action="{{ $action }}" method="POST">
                    @csrf
                    {{ $slot }}
                    <button type="submit" class="btn btn-primary" id="submitButton"> حفظ</button>
                </form>
            </div>
        </div>
    </div>
</div>

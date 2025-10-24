<div class="pagination-area mt-15 mb-50 d-flex justify-content-center">
    <b class="my-2 mx-3" >{{ __('dashboard.total_count') }} : {{ $paginator->total() }} </b>

    <nav aria-label="Page navigation example" >
        {{ $paginator->appends(request()->query())->links() }}
    </nav>
</div>

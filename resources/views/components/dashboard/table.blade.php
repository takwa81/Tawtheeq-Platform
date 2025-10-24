<div class="table-responsive">
    <table class="table table-hover">
        <thead class="bg-main">
            <tr>
                @if (!empty($checkColumn) && $checkColumn)
                    {{-- <th>اختيار</th> --}}
                    <th><input type="checkbox" id="selectAll" class="form-check-input"></th>
                @endif
                @foreach ($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody id="tableData">
            {{ $slot }}
        </tbody>
    </table>
</div>

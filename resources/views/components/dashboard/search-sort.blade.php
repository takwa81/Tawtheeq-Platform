@props(['route', 'showName' => true])

<form method="GET" action="{{ $route }}" class="row gx-3 my-2">
    @if ($showName)
        <div class="col-lg-3 col-md-3 mt-1">
            <input type="text" name="name" value="{{ request()->get('name') }}"
                placeholder="{{ __('dashboard.search_by_name') }}" class="form-control bg-white">
        </div>
    @endif
    <div class="col-lg-3 col-md-3 mt-1">
        <select name="sort" class="form-select bg-white">
            <option value="" {{ request()->get('sort') === '' ? 'selected' : '' }}> {{ __('dashboard.all') }}
            </option>
            <option value="latest" {{ request()->get('sort', 'latest') === 'latest' ? 'selected' : '' }}>
                {{ __('dashboard.latest') }}</option>
            <option value="oldest" {{ request()->get('sort') === 'oldest' ? 'selected' : '' }}>
                {{ __('dashboard.oldest') }}</option>
        </select>
    </div>
    {{ $slot }}
    <div class="col-md-1 mt-2">
        <button type="submit" class="btn w-100 btn-md bg-main">
            <i class="material-icons md-search"></i>
        </button>
    </div>
    <div class="col-md-1 mt-2">
        <a href="{{ $route }}" class="btn w-100 btn-md bg-secondary">
            <i class="material-icons md-refresh"></i>
        </a>
    </div>
</form>

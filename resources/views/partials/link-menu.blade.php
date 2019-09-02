<div class="dropdown">
    <button class="btn btn-outline-dark btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ __('More') }}
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="{{ $link->permalink }}">{{ __('Permalink') }}</a>

        @if($link->canDownloadArchive())
            <a class="dropdown-item" href="{{ route('link.archive-download', [$link->id, csrf_token()]) }}">{{ __('Download archive') }}</a>
        @endif

        @if(auth()->check())
            <h6 class="dropdown-header">{{ __('Manage') }}</h6>
            <a class="dropdown-item"
               href="{{ route('link.archive-form', $link->id) }}"
            >{{ __('Manage archive') }}</a>
            <a class="dropdown-item"
               href="{{ route('link.update-preview', [$link->id, csrf_token()]) }}"
            >{{ __('Update preview') }}</a>
            <a class="dropdown-item" href="{{ route('link.edit', $link->id) }}">{{ __('Edit') }}</a>
            <confirm class="dropdown-item" text="{{ __('Delete') }}" text-confirm="{{ __('Confirm') }}" href="{{ route('link.delete', [$link->id, csrf_token()]) }}"></confirm>
        @endif
    </div>
</div>
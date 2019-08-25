<div class="card {{ $link->is_private ? 'bg-light' : '' }} mb-4">
    <div class="card-body">
        <h5 class="card-title">
            <a href="{{ $link->url }}">{{ $link->title }}</a>
        </h5>

        <p class="card-text">
            {!! $link->content !!}
        </p>

        @if($link->extra)
        <div class="card-extra">
            {!! $link->extra !!}
        </div>
        @endif

        @if($link->tags->isNotEmpty())
            @foreach($link->tags as $tag)
                <a class="badge badge-secondary" href="{{ $tag->url }}">{{ $tag->name }}</a>
            @endforeach
        @endif
    </div>

    <div class="card-footer d-flex justify-content-between">
        <span>{{ $link->created_at->diffForHumans() }}</span>
        <div class="dropdown">
            <button class="btn btn-outline-dark btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ __('More') }}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ $link->permalink }}">{{ __('Permalink') }}</a>
                @if(auth()->check())
                <h6 class="dropdown-header">{{ __('Manage') }}</h6>
                <a class="dropdown-item" href="{{ route('link.edit', $link->id) }}">{{ __('Edit') }}</a>
                <a class="dropdown-item" href="{{ route('link.refresh', [$link->id, csrf_token()]) }}">{{ __('Refresh') }}</a>
                <a class="dropdown-item" href="{{ route('link.delete', [$link->id, csrf_token()]) }}">{{ __('Delete') }}</a>
                @endif
            </div>
        </div>
    </div>
</div>

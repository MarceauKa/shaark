<div class="card card--link {{ isset($index) && $index ? 'card-index' : 'card-single' }} mb-4">
    <div class="card-body">
        <h5 class="card-title">
            <span>{{ __('Link') }}</span> &mdash; <a href="{{ $link->url }}">{{ $link->title }}</a>
        </h5>

        <p class="card-text card-reduce">
            {!! $link->content !!}
        </p>

        @if($link->preview)
        <div class="card-preview card-reduce mb-3">
            {!! $link->preview !!}
        </div>
        @endif

        @if($post->tags->isNotEmpty())
            @foreach($post->tags as $tag)
                <a class="badge badge-secondary" href="{{ $tag->url }}">{{ $tag->name }}</a>
            @endforeach
        @endif
    </div>

    <div class="card-footer d-flex justify-content-between">
        <span>{{ $post->is_private ? '🔒 ' : '' }}{{ $post->created_at->diffForHumans() }}</span>

        <div class="dropdown">
            <button class="btn btn-outline-dark btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ __('More') }}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ $link->permalink }}">{{ __('Permalink') }}</a>
                @if($link->archive)
                    <a class="dropdown-item" href="{{ route('link.download-archive', [$link->id, csrf_token()]) }}">{{ __('Archive') }}</a>
                @endif
                @if(auth()->check())
                <h6 class="dropdown-header">{{ __('Actions') }}</h6>
                <a class="dropdown-item"
                   href="{{ route('link.create-archive', [$link->id, csrf_token()]) }}"
                >{{ __('Create archive') }}</a>
                <a class="dropdown-item"
                   href="{{ route('link.update-preview', [$link->id, csrf_token()]) }}"
                >{{ __('Update preview') }}</a>
                <h6 class="dropdown-header">{{ __('Manage') }}</h6>
                <a class="dropdown-item" href="{{ route('link.edit', $link->id) }}">{{ __('Edit') }}</a>
                <confirm class="dropdown-item" text="{{ __('Delete') }}" text-confirm="{{ __('Confirm') }}" href="{{ route('link.delete', [$link->id, csrf_token()]) }}"></confirm>
                @endif
            </div>
        </div>
    </div>
</div>

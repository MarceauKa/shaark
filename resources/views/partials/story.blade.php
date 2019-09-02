<div class="card card--story {{ isset($index) && $index ? 'card-index' : 'card-single' }} mb-4">
    <div class="card-body">
        <h5 class="card-title">
            <span>{{ __('Story') }}</span> &mdash; <a href="{{ $story->url }}">{{ $story->title }}</a>
        </h5>

        <div class="card-text card-reduce">
            <vue-markdown>{{ $story->content }}</vue-markdown>
        </div>

        @if($post->tags->isNotEmpty())
            <p class="card-text mt-1">
                @foreach($post->tags as $tag)
                    <a class="badge badge-secondary" href="{{ $tag->url }}">{{ $tag->name }}</a>
                @endforeach
            </p>
        @endif
    </div>

    <div class="card-footer d-flex justify-content-between">
        <span>{{ $post->is_private ? '🔒 ' : '' }}{{ $post->created_at->diffForHumans() }}</span>

        <div class="dropdown">
            <button class="btn btn-outline-dark btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ __('More') }}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ $story->url }}">{{ __('Permalink') }}</a>
                @if(auth()->check())
                <h6 class="dropdown-header">{{ __('Manage') }}</h6>
                <a class="dropdown-item" href="{{ route('story.edit', $story->id) }}">{{ __('Edit') }}</a>
                <confirm class="dropdown-item" text="{{ __('Delete') }}" text-confirm="{{ __('Confirm') }}" href="{{ route('story.delete', [$story->id, csrf_token()]) }}"></confirm>
                @endif
            </div>
        </div>
    </div>
</div>
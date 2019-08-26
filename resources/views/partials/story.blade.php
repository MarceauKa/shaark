<div class="card card--story {{ $post->is_private ? 'border-dark' : '' }} {{ isset($index) && $index ? 'card-index' : 'card-single' }} mb-4">
    <div class="card-body">
        <h5 class="card-title">
            <span>Story</span> &mdash; <a href="{{ $story->url }}">{{ $story->title }}</a>
        </h5>

        <div class="card-text card-reduce">
            <vue-markdown>{{ $story->content }}</vue-markdown>
        </div>

        @if($post->tags->isNotEmpty())
            @foreach($post->tags as $tag)
                <a class="badge badge-secondary" href="{{ $tag->url }}">{{ $tag->name }}</a>
            @endforeach
        @endif
    </div>

    <div class="card-footer d-flex justify-content-between">
        <span>{{ $post->created_at->diffForHumans() }}</span>
        <div class="dropdown">
            <button class="btn btn-outline-dark btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ __('More') }}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ $story->url }}">{{ __('Permalink') }}</a>
                @if(auth()->check())
                <h6 class="dropdown-header">{{ __('Manage') }}</h6>
                <a class="dropdown-item" href="{{ route('story.edit', $story->id) }}">{{ __('Edit') }}</a>
                <a class="dropdown-item" href="{{ route('story.delete', [$story->id, csrf_token()]) }}">{{ __('Delete') }}</a>
                @endif
            </div>
        </div>
    </div>
</div>
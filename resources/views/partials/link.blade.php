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
        @include('partials.link-menu')
    </div>
</div>

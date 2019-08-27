<div class="card card--chest {{ $post->is_private ? 'border-dark' : '' }} {{ isset($index) && $index ? 'card-index' : 'card-single' }} mb-4">
    <div class="card-body">
        <h5 class="card-title">
            <span>{{ __('Chest') }}</span> &mdash; <a href="{{ $chest->permalink }}">{{ $chest->title }}</a>
        </h5>

        <div class="card-reduce">
            <chest-lines :preview="{{ json_encode($chest->content) }}"></chest-lines>
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
                <a class="dropdown-item" href="{{ $chest->permalink }}">{{ __('Permalink') }}</a>
                @if(auth()->check())
                <h6 class="dropdown-header">{{ __('Manage') }}</h6>
                <a class="dropdown-item" href="{{ route('chest.edit', $chest->id) }}">{{ __('Edit') }}</a>
                <a class="dropdown-item" href="{{ route('chest.delete', [$chest->id, csrf_token()]) }}">{{ __('Delete') }}</a>
                @endif
            </div>
        </div>
    </div>
</div>
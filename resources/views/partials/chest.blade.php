<div class="card card--chest {{ isset($index) && $index ? 'card-index' : 'card-single' }} mb-4">
    <div class="card-body">
        <h5 class="card-title">
            <span>{{ __('Chest') }}</span> &mdash; <a href="{{ $chest->permalink }}">{{ $chest->title }}</a>
        </h5>

        <div class="card-reduce">
            <chest-lines :preview="{{ json_encode($chest->content) }}"></chest-lines>
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
                <a class="dropdown-item" href="{{ $chest->permalink }}">{{ __('Permalink') }}</a>
                @if(auth()->check())
                <h6 class="dropdown-header">{{ __('Manage') }}</h6>
                <a class="dropdown-item" href="{{ route('chest.edit', $chest->id) }}">{{ __('Edit') }}</a>
                <confirm class="dropdown-item" text="{{ __('Delete') }}" text-confirm="{{ __('Confirm') }}" href="{{ route('chest.delete', [$chest->id, csrf_token()]) }}"></confirm>
                @endif
            </div>
        </div>
    </div>
</div>
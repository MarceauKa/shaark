<div class="card mb-5 {{ $link->is_private ? ' bg-light' : '' }}">
    <div class="card-body">
        <h5 class="card-title">
            <a href="{{ $link->url }}" target="_blank" rel="nofollow">
                {{ $link->title }}
            </a>
        </h5>
        <p class="card-text">
            {!! $link->content !!}
        </p>
        @if($link->extra)
            {!! $link->extra !!}
        @endif

        @if($link->tags->isNotEmpty())
            @foreach($link->tags as $tag)
                <a class="badge badge-secondary" href="{{ route('tag', $tag->slug) }}">{{ $tag->name }}</a>
            @endforeach
        @endif
    </div>

    <div class="card-footer d-flex justify-content-between">
        <span>{{ $link->created_at->diffForHumans() }}</span>
        @if(auth()->check())
            <div class="dropdown">
                <button class="btn btn-outline-dark btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Edit
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ route('link.edit', $link->id) }}">Modifier</a>
                    <a class="dropdown-item" href="{{ route('link.delete', [$link->id, csrf_token()]) }}">Supprimer</a>
                </div>
            </div>
        @endif
    </div>
</div>
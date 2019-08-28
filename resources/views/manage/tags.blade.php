@extends('layouts.manage')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header">{{ __('Import') }}</div>

            <div class="card-body">
                @if($tags->isEmpty())
                    <div class="alert alert-info">Aucun tag.</div>
                @else
                <table class="table">
                    <thead>
                    <tr>
                        <td>Nom</td>
                        <td>Posts</td>
                        <td class="text-right">#</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tags as $tag)
                        <tr>
                            <td>
                                <a href="{{ $tag->url }}">{{ $tag->name }}</a>
                            </td>
                            <td>{{ $tag->posts_count }}</td>
                            <td class="text-right">
                                <confirm tag="button" class="btn btn-danger btn-sm" text="{{ __('Delete') }}" text-confirm="{{ __('Confirm') }}" href="{{ route('manage.tags.delete', [$tag->name, csrf_token()]) }}"></confirm>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

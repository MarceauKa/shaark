@extends('layouts.manage')

@section('content')
    <health-checks :enabled="{{ $enabled ? 'true' : 'false' }}"
                   :stats="{{ json_encode($stats) }}"></health-checks>
@endsection

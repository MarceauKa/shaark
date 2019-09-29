@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 mb-3">
            <chest-form @if(isset($chest)):chest="{{ json_encode(\App\Http\Resources\ChestResource::make($chest)) }}" @endif></chest-form>
        </div>
    </div>
</div>
@endsection

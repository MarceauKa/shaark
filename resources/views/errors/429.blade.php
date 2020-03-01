@extends('error')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message', __('Sorry, you are making too many requests to our servers.'))

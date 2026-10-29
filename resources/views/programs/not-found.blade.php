@extends('layouts.app')

@section('title', __('site.details_not_found'))

@section('content')
<div class="container py-5">
    <div class="alert alert-danger">
        {{ __('site.details_not_found') }}
    </div>
    <a href="{{ route('programs.index') }}" class="btn btn-outline-secondary">
        &laquo; {{ __('site.details_back') }}
    </a>
</div>
@endsection

@extends('layouts.admin')

@section('title')
    Intelli-Rate
@endsection

@section('content')
    <div class="container-fluid">
        @livewire('registered-banks-for-approval')
    </div>
@endsection

@extends('layouts.admin')

@section('title')
    Intelli-Rate
@endsection

@section('content')
    <div class="container-fluid">
        @livewire('view-detailed-customer-bank',['id'=>$id])
    </div>
@endsection

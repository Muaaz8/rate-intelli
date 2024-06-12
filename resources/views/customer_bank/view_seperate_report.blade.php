@extends('layouts.admin')

@section('title')
    Intelli-Rate
@endsection

@section('content')
<style>
    .table {
        border-radius: 0.2rem;
        width: 100%;
        overflow: auto;
        padding-bottom: 1rem;
        color: #212529;
        font-size: 13px;
        margin-bottom: 0;
    }

    thead {
        position: sticky;
        top: 0px;
    }

    .table-wrapper {
        height: 412px;
        overflow-y: auto;
    }

    /* Define scrollbar styles */
    .table-wrapper::-webkit-scrollbar {
        width: 8px;
        /* Width of the scrollbar */
    }

    /* Track */
    .table-wrapper::-webkit-scrollbar-track {
        background: #f1f1f1;
        /* Color of the track */
    }

    /* Handle */
    .table-wrapper::-webkit-scrollbar-thumb {
        background: #888;
        /* Color of the handle */
    }

    /* Handle on hover */
    .table-wrapper::-webkit-scrollbar-thumb:hover {
        background: #555;
        /* Color of the handle when hovered */
    }

    .first-col {
        position: sticky;
        left: 0;
        color: #373737;
        background: #fafafa
    }

    .table td {
        white-space: nowrap;
    }
</style>

    <div class="container-fluid">
        @livewire('seperate-report')
    </div>
@endsection

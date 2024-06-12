@extends('website_layout.app')

@section('title')
    Intelli-Rate
@endsection

@section('content')
    <!-- banner text div start -->
    <div class="login-signup-div">
        <div class="container">
            <div class="form-container">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link {{ \Request::path()=='signin'?'active':'' }}" id="login-tab" data-toggle="tab" href="#login-form">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ \Request::path()=='signup'?'active':'' }}" id="signup-tab" data-toggle="tab" href="#signup-form">Signup</a>
                    </li>
                </ul>
                <div class="tab-content">

                    <div class="tab-pane fade {{ \Request::path()=='signin'?'show active':'' }} transparent-bg shadow" id="login-form">
                        <form id="loginForm" class="d-flex align-items-center justify-content-center flex-column w-100"
                            action="{{ route('bank_login') }}" method="post">
                            @csrf
                            <div class="form-group my-4 w-100">
                                <label for="loginEmail">Email address</label>
                                <input type="email" class="form-control" name="email" id="loginEmail"
                                    placeholder="Enter email" required>
                            </div>
                            <div>
                                <button type="submit" class="btn my-btn-outline-secondary">Login</button>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade {{ \Request::path()=='signup'?'show active':'' }} transparent-bg shadow" id="signup-form">
                        @livewire('customer-signup')

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

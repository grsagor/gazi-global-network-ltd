@extends('auth.layout.app')
@section('content')
@if ($errors->any())
    {{-- <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $key => $error)
                <li><strong>{{ $key }}:</strong> {{ $error }}</li>
            @endforeach
        </ul>
    </div> --}}

    {{-- <pre>
        <?php
            print_r($errors);
            ?>
    </pre> --}}
@endif

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card px-sm-6 px-0">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="{{ route('admin.dashboard.index') }}" class="app-brand-link gap-2">
                                <img class="sidebar-logo w-100 h-100 object-fit-contain" src="{{ asset('assets/img/logo.jpg') }}" alt="">
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1">Welcome to Gazi Global Networking Ltd! 👋</h4>
                        <p class="mb-6">Please sign-in to your account and start the adventure</p>

                        <form id="formAuthentication" class="mb-6" action="{{ route('auth.login.post') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" value="{{ old('email') }}" id="email" name="email"
                                    placeholder="Enter your email" autofocus />
                                @if ($errors->has('email'))
                                    <div class="text-danger">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>

                            <div class="mb-6 form-password-toggle">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="********" aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="mb-6">
                                <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
@endsection

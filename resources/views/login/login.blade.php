@extends('layouts.app')
@section('title', 'Login')

@section('login')
<form action = "{{route('user_login')}}" method = "post">
    @csrf
    <div class="container d-flex align-items-center justify-content-center" style = "height: 80vh; max-width: 500px;">
        <div class="">
            <center><h2>Expense Manager</h2></center>
            <div class="mb-2">
                @if (session('fail'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> {{ session('fail') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" name = "email" id="email">
                <span>@error('email'){{$message}}@enderror</span>
            </div>
            <div class="mb-2">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name = "password" id="password">
                <span>@error('password'){{$message}}@enderror</span>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </div>
</form>
@endsection
@extends('layouts.app')
@section('title', 'Account')

@section('content')
<div class="d-flex mt-3">
    <h5>Change Password</h5>
    <ol class="breadcrumb" style = "margin-left: auto;">
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Change Password</a></li>
    </ol>
</div>
<div class="card">
    <div class="card-body">
        @if (session('fail'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Error</strong> {{ session('fail') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form action = "{{route('change_password')}}" method = "post">
            @csrf
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">New Password</label>
              <input type="password" class="form-control" id="exampleInputEmail1" name = "new_password" aria-describedby="emailHelp">
              <span>@error('new_password'){{$message}}@enderror</span>
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Current Password</label>
              <input type="password" class="form-control" name = "current_password" id="exampleInputPassword1">
              <span>@error('current_password'){{$message}}@enderror</span>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@endsection
@extends('layouts.app')
@section('title', 'Users')

@section('content')
<div class="d-flex mt-3">
    <h5>Users</h5>
    <ol class="breadcrumb" style = "margin-left: auto;">
        <li class="breadcrumb-item active" aria-current="page"><a href="#">User Management</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Users</a></li>
    </ol>
</div>
<div class="card">
    <div class="card-body">
        @if ($errors->any())
          <div class="alert alert-warning align-items-center" role="alert">
              <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
              @foreach ($errors->all() as $error)
                  <li>{{$error}}</li>
              @endforeach
          </div>
        @endif
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Email Address</td>
                    <td>Role</td>
                    <td>Created at</td>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class = "<?php if($user->role_type == 0){ echo 'table-row';}?>" user_id = "{{$user->id}}">
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->role}}</td>
                    <td>{{$user->created_at}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add User
        </button>
    </div>
</div>

  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('add_user')}}" method="post">
        @csrf
          <div class="modal-body">
            <div class="mb-3 row">
              <label for="displayName" class="col-sm-4 col-form-label">Name</label>
              <div class="col-sm-8">
                  <input type="text" class="form-control" id="displayName" name = "name" placeholder="Name" value="{{old('name')}}">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="desc" class="col-sm-4 col-form-label">Email</label>
              <div class="col-sm-8">
                  <input type="email" class="form-control" id="desc" name = "email" placeholder="Email" value="{{old('email')}}">
              </div>
            </div>
            <div class="mb-3 row">
            <label for="desc" class="col-sm-4 col-form-label">Role</label>
            <div class="col-sm-8">
              <select class="form-select" name = "role" aria-label="Default select example" value="{{old('role')}}">
                <option value="">Select Role</option>
                @foreach($roles as $role)
                  <option value="{{$role->role_type}}">{{$role->display_name}}</option>
                @endforeach
              </select>
            </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="edit_user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('edit_user')}}" method="post">
        @csrf
          <div class="modal-body">
            <input type="hidden" name = "user_id" id = "user_id">
            <div class="mb-3 row">
              <label for="name" class="col-sm-4 col-form-label">Name</label>
              <div class="col-sm-8">
                  <input type="text" class="form-control" id="name" name = "new_name" placeholder="Name">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="desc" class="col-sm-4 col-form-label">Email</label>
              <div class="col-sm-8">
                  <input type="email" class="form-control" id="email" name = "new_email" placeholder="Email">
              </div>
            </div>
            <div class="mb-3 row">
            <label for="desc" class="col-sm-4 col-form-label">Role</label>
            <div class="col-sm-8">
              <select class="form-select" name = "new_role" id = "role" aria-label="Default select example">
                <option value="">Select Role</option>
                @foreach($roles as $role)
                  <option value="{{$role->role_type}}" {{$role->role_type == $role->role_type ? 'selected' : ''}}>{{$role->display_name}}</option>
                @endforeach
              </select>
            </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger delete">Delete</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function(){
        $(document).on('click','.table-row', function(e){
            var user_id = $(this).attr('user_id');
            $('#edit_user').modal('show'); 
            $.ajax({
                type: "GET",
                url: "/user_data/"+user_id,
                dataType: "json",
                success: function(response){
                    console.log(response.user);
                    if(response.status == 200){
                        $('#user_id').val(user_id);
                        $('#name').val(response.user.name);
                        $('#email').val(response.user.email);
                    }else{
    
                    }
                
                }
            });
    
        });
        $(document).on('click','.delete', function(e){
          
          var data = {
              'user_id': $('#user_id').val(),
          }
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
              type: "post",
              url: "/delete_user",
              data: data,
              dataType: "json",
              success: function(response){
                  
                  if(response.status == 200){
                      location.reload();
                  }else{

                  }
              
              }
          });

      });
    });
    </script>
@endsection
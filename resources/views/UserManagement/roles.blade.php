@extends('layouts.app')
@section('title', 'Roles')

@section('content')
<div class="d-flex mt-3">
    <h5>Roles</h5>
    <ol class="breadcrumb" style = "margin-left: auto;">
        <li class="breadcrumb-item active" aria-current="page"><a href="#">User Management</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Role</a></li>
    </ol>
</div>
<div class="card">
    <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
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
                    <td>Display Name</td>
                    <td>Description</td>
                    <td>Created at</td>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                <tr class = "table-row" role_id = "{{$role->id}}">
                    <td>{{$role->display_name}}</td>
                    <td>{{$role->description}}</td>
                    <td>{{$role->created_at}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add Role
        </button>
    </div>
</div>
<!--ADD modal -->

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Role</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('add_role')}}" method = "post">
            @csrf
            <div class="modal-body">
                <div class="mb-3 row">
                    <label for="displayName" class="col-sm-4 col-form-label">Display Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="displayName" name = "display_name" placeholder="Display Name" value="{{old('display_name')}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="desc" class="col-sm-4 col-form-label">Description</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="desc" name = "description" placeholder="Description" value="{{old('description')}}">
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
<div class="modal fade" id="edit_role" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Role</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('edit_role')}}" method = "post">
            @csrf
            <div class="modal-body">
                <div class="mb-3 row">
                    <input type="hidden" name="edit_id" id="edit_id">
                    <label for="edit_name" class="col-sm-4 col-form-label">Display Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="edit_name" name = "new_display_name" placeholder="Display Name" value="">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="edit_description" class="col-sm-4 col-form-label">Description</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="edit_description" name = "new_description" placeholder="Description" value="">
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
        var role_id = $(this).attr('role_id');
        $('#edit_role').modal('show'); 
        $.ajax({
            type: "GET",
            url: "/role_data/"+role_id,
            dataType: "json",
            success: function(response){
                // console.log(response.role);
                if(response.status == 200){
                    $('#edit_id').val(role_id);
                    $('#edit_name').val(response.role.display_name);
                    $('#edit_description').val(response.role.description);
                }else{

                }
            
            }
        });

    });
    $(document).on('click','.delete', function(e){
        
        var data = {
            'delete_id': $('#edit_id').val(),
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "post",
            url: "/delete_role",
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
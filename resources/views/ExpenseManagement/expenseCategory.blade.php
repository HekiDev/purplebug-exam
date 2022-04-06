@extends('layouts.app')
@section('title', 'Categories')

@section('content')
<div class="d-flex mt-3">
    <h5>Expense Categories</h5>
    <ol class="breadcrumb" style = "margin-left: auto;">
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Expense Management</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Expense Categories</a></li>
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
                    <td>Display Name</td>
                    <td>Description</td>
                    <td>Created at</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr class = "table-row" category_id = "{{$category->id}}">
                    <td>{{$category->display_name}}</td>
                    <td>{{$category->description}}</td>
                    <td>{{$category->created_at}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add Category
        </button>
    </div>
</div>
<!-- Button trigger modal -->
  
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('add_category')}}" method = "post">
            @csrf
            <div class="modal-body">
                <div class="mb-3 row">
                    <label for="displayName" class="col-sm-4 col-form-label">Display Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="displayName" placeholder="Display Name" name = "display_name" value = "{{old('display_name')}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="desc" class="col-sm-4 col-form-label">Description</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="desc" placeholder="Description" name = "description" value = "{{old('description')}}">
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
<div class="modal fade" id="edit_category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('edit_category')}}" method = "post">
            @csrf
            <div class="modal-body">
                <input type="hidden" name = "category_id" id = "category_id">
                <div class="mb-3 row">
                    <label for="displayName" class="col-sm-4 col-form-label">Display Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="new_display_name" placeholder="Display Name" name = "new_display_name">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="desc" class="col-sm-4 col-form-label">Description</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="new_description" placeholder="Description" name = "new_description">
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
            var category_id = $(this).attr('category_id');
            $('#edit_category').modal('show'); 
            $.ajax({
                type: "GET",
                url: "/category_data/"+category_id,
                dataType: "json",
                success: function(response){
                    console.log(response.user);
                    if(response.status == 200){
                        $('#category_id').val(category_id);
                        $('#new_display_name').val(response.category.display_name);
                        $('#new_description').val(response.category.description);
                    }else{
    
                    }
                
                }
            });
    
        });
        $(document).on('click','.delete', function(e){
        
        var data = {
            'category_id': $('#category_id').val(),
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "post",
            url: "/delete_category",
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
@extends('layouts.app')
@section('title', 'Expenses')

@section('content')
<div class="d-flex mt-3">
    <h5>Expenses</h5>
    <ol class="breadcrumb" style = "margin-left: auto;">
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Expense Management</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Expenses</a></li>
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
                    <td>Expense Category</td>
                    <td>Amount</td>
                    <td>Entry Date</td>
                    <td>Created at</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($expenses as $expense)
                <tr class = "table-row" expense_id = {{$expense->id}}>
                  <td>{{$expense->category}}</td>
                  <td>{{$expense->amount}}</td>
                  <td>{{$expense->entry_date}}</td>
                  <td>{{$expense->created_at}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add Expense
        </button>
    </div>
</div>
<!-- Button trigger modal -->
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Expense</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('add_expense')}}" method = "post">
        @csrf
          <div class="modal-body">
              <div class="mb-3 row">
                  <label for="desc" class="col-sm-4 col-form-label">Expense Category</label>
                  <div class="col-sm-8">
                    <select class="form-select" name = "expense" aria-label="Default select example">
                      <option value = "">Select category</option>
                      @foreach ($categories as $category)
                        <option value="{{$category->display_name}}">{{$category->display_name}}</option>
                      @endforeach
                    </select>
                  </div>
              </div>
              <div class="mb-3 row">
                  <label for="displayName" class="col-sm-4 col-form-label">Amount</label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" id="displayName" placeholder="Amount" name = "amount" value = "{{old('amount')}}">
                  </div>
              </div>
              <div class="mb-3 row">
                  <label for="desc" class="col-sm-4 col-form-label">Entry Date</label>
                  <div class="col-sm-8">
                      <input type="date" class="form-control" id="desc" placeholder="Entry Date" name = "entry_date" value = "{{old('entry_date')}}">
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
  <div class="modal fade" id="edit_expense" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Expense</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('edit_expense')}}" method = "post">
        @csrf
          <div class="modal-body">
            <input type="hidden" name = "expense_id" id = "expense_id">
              <div class="mb-3 row">
                  <label for="desc" class="col-sm-4 col-form-label">Expense Category</label>
                  <div class="col-sm-8">
                    <select class="form-select" name = "new_expense" aria-label="Default select example">
                      <option value = "">Select category</option>
                      @foreach ($categories as $category)
                        <option value="{{$category->display_name}}">{{$category->display_name}}</option>
                      @endforeach
                    </select>
                  </div>
              </div>
              <div class="mb-3 row">
                  <label for="displayName" class="col-sm-4 col-form-label">Amount</label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" id="amount" placeholder="Amount" name = "new_amount">
                  </div>
              </div>
              <div class="mb-3 row">
                  <label for="desc" class="col-sm-4 col-form-label">Entry Date</label>
                  <div class="col-sm-8">
                      <input type="date" class="form-control" id="entry_date" placeholder="Entry Date" name = "new_entry_date">
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
            var expense_id = $(this).attr('expense_id');
            $('#edit_expense').modal('show'); 
            $.ajax({
                type: "GET",
                url: "/expense_data/"+expense_id,
                dataType: "json",
                success: function(response){
                    
                    if(response.status == 200){
                        $('#expense_id').val(expense_id);
                        $('#amount').val(response.expense.amount);
                        $('#entry_Date').val(response.expense.entry_date);
                    }else{
    
                    }
                
                }
            });
    
        });
        $(document).on('click','.delete', function(e){
        
        var data = {
            'expense_id': $('#expense_id').val(),
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "post",
            url: "/delete_expense",
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
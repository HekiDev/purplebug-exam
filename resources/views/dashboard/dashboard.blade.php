@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="d-flex mt-3">
    <h5>My Expenses</h5>
    <ol class="breadcrumb" style = "margin-left: auto;">
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Dashboard</a></li>
    </ol>
</div>
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-center">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td>Expense Categories</td>
                        <td>Total</td>
                    </tr>
                    @foreach ($expenses as $expense)
                    <tr>
                      <td>{{$expense->category}}</td>
                      <td>{{$expense->amount}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
            <canvas id="myChart" style="max-width:500px; max-height:500px;"></canvas>
        </div>
     
    </div>
</div>
<script>
var xValues = ["g", "France"];
var yValues = [55, 49];
var barColors = [
  "#b91d47",
  "#1e7145"
];

new Chart("myChart", {
  type: "pie",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    title: {
      display: true,
      text: "World Wide Wine Production 2018"
    }
  }
});
</script>
@endsection
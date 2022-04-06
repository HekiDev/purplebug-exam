<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;

class DashboardController extends Controller
{
    //
    public function dashboard(){

        if(session()->get('role') == 0){
            $expenses = Expense::where('expense_by', session()->get('id'))->get();
            
        }else{
            $expenses = Expense::all();
        }
        return view('dashboard.dashboard', compact('expenses'));
    }
}

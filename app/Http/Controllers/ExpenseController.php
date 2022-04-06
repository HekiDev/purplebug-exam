<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Category;

class ExpenseController extends Controller
{
    //
    public function category_data($id){
        $category = Category::where('id', $id)->first();
        if($category){
            return response()->json([
                'status' => 200,
                'category' => $category,
            ]);
        }
    }
    public function edit_category(Request $req){
        // return $req->all();
        $req->validate([
            'new_display_name' => 'required',
            'new_description' => 'required',
        ]);
        $category = Category::find($req->category_id);
        $category->display_name = $req->new_display_name;
        $category->description = $req->new_description;
        $category->updated_at = get_datetime();
        $category->save();

        return redirect('categories')->with('success','User has been updated.');
    }
    public function delete_category(Request $req){

        // return $req->all();
        $category = Category::find($req->category_id);
        $category->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Deleted',
        ]);
    }
    public function expense_data($id){
        $expense = Expense::where('id', $id)->first();
        if($expense){
            return response()->json([
                'status' => 200,
                'expense' => $expense,
            ]);
        }
    }
    public function edit_expense(Request $req){
        $req->validate([
            'new_expense' => 'required',
            'new_amount' => 'required',
            'new_entry_date' => 'required',
        ]);
        $expense = Expense::find($req->expense_id);
        $expense->category = $req->new_expense;
        $expense->amount = $req->new_amount;
        $expense->entry_date = $req->new_entry_date;
        $expense->updated_at = get_datetime();
        $expense->save();

        return redirect('expenses')->with('success','Expenses has been updated.');
        // return $req->all();
    }
    public function delete_expense(Request $req){

        // return $req->all();
        $expense = Expense::find($req->expense_id);
        $expense->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Deleted',
        ]);
    }
    public function add_expense(Request $req){
        $req->validate([
            'expense' => 'required',
            'amount' => 'required',
            'entry_date' => 'required',
        ]);

        $expense = new Expense;
        $expense->category = $req->expense;
        $expense->amount = $req->amount;
        $expense->entry_date = $req->entry_date;
        $expense->expense_by = session()->get('id');
        $expense->created_at = get_datetime();
        $expense->updated_at = get_datetime();
        $expense->save();

        return redirect('expenses');
    }
    public function add_category(Request $req){
        $req->validate([
            'display_name' => 'required',
            'description' => 'required',
        ]);

        $category = new Category;
        $category->display_name = $req->display_name;
        $category->description = $req->description;
        $category->created_at = get_datetime();
        $category->updated_at = get_datetime();
        $category->save();

        return redirect('categories');

        // return $req->all();
    }
    public function get_categories(){
        $categories = Category::all();
        return $categories;
    }
    public function categories(){
        $categories = $this->get_categories();
        return view('ExpenseManagement.expenseCategory',compact('categories'));
    }
    public function expenses(){
        $categories = $this->get_categories();
        if(session()->get('role') == 0){
            $expenses = Expense::where('expense_by', session()->get('id'))->get();
        }else{
            $expenses = Expense::all();
        }
        
        return view('ExpenseManagement.expenses',compact('categories','expenses'));
    }
}

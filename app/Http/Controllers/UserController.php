<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Hash;
class UserController extends Controller
{
    //
    public function user_data($id){
        $user = User::where('id', $id)->first();
        if($user){
            return response()->json([
                'status' => 200,
                'user' => $user,
            ]);
        }
    }
    public function edit_user(Request $req){
        $req->validate([
            'new_name' => 'required',
            'new_email' => 'required',
            'new_role' => 'required',
        ]);
        $user = User::find($req->user_id);
        $user->name = $req->new_name;
        $user->email = $req->new_email;
        $user->role = $req->new_role;
        $user->updated_at = get_datetime();
        $user->save();
        return redirect('users')->with('success','User has been updated.');
    }
    public function delete_user(Request $req){

        // return $req->all();
        $user = User::find($req->user_id);
        $user->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Deleted',
        ]);
    }
    public function add_role(Request $req){
        $req->validate([
            'display_name' => 'required',
            'description' => 'required',
        ]);
        $role = new Role;
        $role->display_name = $req->display_name;
        $role->description = $req->description;
        $role->created_at = get_datetime();
        $role->updated_at = get_datetime();
        $role->save();

        return redirect('roles');
    }
    
    public function login(){
        return view('login.login');
    }


    public function user_login(Request $req){

        // return hash::make($req->input('password'));
        $req->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', '=', $req->email)->first();

        if($user){
            if(Hash::check($req->password, $user->password)){
                $req->session()->put('id', $user->id);
                $req->session()->put('role', $user->role);
                $req->session()->put('name', $user->name);

                return redirect('/dashboard');
            }else{
                return redirect('/')->with('fail','Password not matched');
            }
           
        }else{
            return redirect('/')->with('fail','This email is not registered');
        }

    }
    public function logout(){
        if(session()->has('id')){
            session()->pull('id');
            return redirect('/');
        }
    }
    public function users(){
        $roles = Role::all();
        $users = User::all();
        $selectedID = 2;
        foreach($users as $user){
            if($user->role == 1){
                $user->role = "Administrator";
            }else{
                $user->role = "User";
            }
        }
        return view('UserManagement.users',compact('roles','users','selectedID'));
    }

    public function add_user(Request $req){
        $req->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'role' => 'required'
        ]);
        $user = new User;
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = hash::make('123'); //Default Password for all users
        $user->role = $req->role;
        $user->created_at = get_datetime();
        $user->updated_at = get_datetime();
        $user->save();

        return redirect('users');
        // return $req->all();
    }
    public function change_password(Request $req){
        $req->validate([
            'new_password' => 'required',
            'current_password' => 'required',
        ]);

        $user = User::where('id', session()->get('id'))->first();

        if(Hash::check($req->current_password, $user->password)){
            
            $update = User::find($user->id);
            $update->password = hash::make($req->new_password);
            $update->save();

            return redirect('account')->with('success', 'Password Updated.');
        }else{
            return redirect('account')->with('fail', 'Password is not correct.');
        }
    }
    public function account(){
        return view('account.account');
    }
}

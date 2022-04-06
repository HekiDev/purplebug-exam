<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    //
    public function roles(){
        $roles = Role::all();
        return view('UserManagement.roles', compact('roles'));
    }
    
    public function role_data($id){
        $role = Role::where('id', $id)->first();
        if($role){
            return response()->json([
                'status' => 200,
                'role' => $role,
            ]);
        }
    }

    public function edit_role(Request $req){
        $req->validate([
            'new_display_name' => 'required',
            'new_description' => 'required',
        ]);
        $role = Role::find($req->edit_id);
        $role->display_name = $req->new_display_name;
        $role->description = $req->new_description;
        $role->updated_at = get_datetime();
        $role->save();
        return redirect('roles')->with('success','Role has been updated.');
    }

    public function delete_role(Request $req){

        // return $req->all();
        $role = Role::find($req->delete_id);
        $role->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Deleted',
        ]);
    }
}

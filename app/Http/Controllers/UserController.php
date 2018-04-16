<?php

namespace App\Http\Controllers;

use App\Publication;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\User;
use App\Role;
use Auth;

class UserController extends Controller
{
    public function newUser() {
        $roles = Role::pluck('name', 'id');
        $publications = Publication::pluck('name', 'id');
        return view('admin.newUser', compact('roles', 'publications'));
    }

    public function editUser($id) {
        $user = User::findOrFail($id);
        $roles = Role::pluck('name', 'id');
        $publications = Publication::pluck('name', 'id');
        return view('admin.editUser', compact('user', 'roles', 'publications'));
    }

    public function updateUser(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $results = [];
        $input = $request->all();

        try {

            if($request->has('password')) {
                if ($request->password != $request->passwordComf) {

                    $results['errors'] = ['Passwords did not match'];

                } 
            }
            if (array_key_exists('errors', $results)) {
                // have error, dont do the rest
            } else {
     
                //Change Password
                $user = User::findOrFail($id);
                if($request->has('password') && $request->password != "") {
                    $user->password = bcrypt($request->get('password'));
                }
                $user->name = $request->name;
                $user->email = $request->email;
                $user->publication_id = $request->publication_id;
                $user->role_id = $request->role_id;
                if ($user->role->name == 'Super Admin')
                    $user->publication_id = 1;
                $user->save();
                $results['success'] = ["User added successfully."];
            }

        } catch(\Illuminate\Database\QueryException $e) {

            $results['errors'] = [$e->errorInfo[2]];

        }
        $pubId = Auth::user()->publication->id;
        if ($pubId === 1) {
            $users = User::all();
        } else {
            $users = User::where('publication_id', $pubId)->get();
        }
        $results['success'] = ["User updated successfully."];
        return view('admin.users', compact('users', 'results'));
    }

    public function deleteUser($id) {
        $user = User::findOrFail($id);
        $user->delete();
        $results['success'] = ['User Moved to trash.'];
        $pubId = Auth::user()->publication->id;
        if ($pubId === 1) {
            $users = User::all();
        } else {
            $users = User::where('publication_id', $pubId)->get();
        }
        return view('admin.users', compact('results', 'users'));
    }

    public function restoreUser($id) {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore($user);
        return redirect('/admin/users');
    }

    public function permanentDeleteUser($id) {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();
        return back();
    }

    public function storeUser(Request $request) {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8|same:password_confirmation',
            'password_confirmation' => 'required|min:8'
        ]);

        $input = $request->all();
        $input['password'] = bcrypt($request->get('password'));
        $user = User::create($input);
 
        $pubId = Auth::user()->publication->id;
        if ($pubId === 1) {
            $users = User::all();
        } else {
            $users = User::where('publication_id', $pubId)->get();
        }
        //$results['success'] = ["User added successfully."];
        return view('admin.users', compact('users'));

    }

    public function userViewTrash() {
        $pubId = Auth::user()->publication->id;
        if ($pubId === 1) {
            $users = User::onlyTrashed()->get();
        } else {
            $users = User::onlyTrashed()->where('publication_id', $pubId)->get();
        }

        
        return view('admin.userTrash', compact('users'));
    }

    public function showUsers() {
        $pubId = Auth::user()->publication->id;

        if ($pubId === 1) {
            $users = User::all();
        } else {
            $users = User::where('publication_id', $pubId)->get();
        }

        return view('admin.users', compact('users'));
    }
}

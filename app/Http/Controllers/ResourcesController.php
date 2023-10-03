<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ResourcesController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();

        return view('pages.resource.index', compact('users'));
    }

    public function store()
    {
        $user = request()->validate([
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|confirmed|min:8|max:255',
            'firstname' => 'required',
            'lastname' => 'required',
            'phone_number' => 'required|min:12|max:255',
        ]);

        // Set Attribute Default
        $user['status'] = "pending";
        $user['create_at'] = date('Y-m-d H:i:s');

        $user = User::create($user);

        return redirect()->back()->with('msg', 'User Berhasil Dibuat!');
    }

    public function show($id = null)
    {
        $users = null;
        if ($id) {
            $id = decrypt($id);
            $users = User::where('id', $id)->first();
        }
        return view('pages.user.detail', compact('users'));
    }

    public function update()
    {
        $validate = [
            'email' => 'required|email|max:255',
            'password' => 'required|confirmed|min:8|max:255',
            'firstname' => 'required',
            'lastname' => 'required',
            'phone_number' => 'required|min:12|max:255',
        ];

        $user = request();
        if (request()->password == null) {
            unset($validate['password']);
            unset($user['password']);
        }

        $id = decrypt($user['id']);

        $user = $user->validate($validate);
        $user = User::where('id', $id)->update($user);


        return back()->with('success', 'Profile succesfully updated');
    }

    public function approve($id)
    {
        $id = decrypt($id);
        User::where('id', $id)->update(['status' => 'active']);

        return back()->with('success', 'Profile succesfully Approved!');
    }

    public function delete($id)
    {
        $id = decrypt($id);
        User::where('id', $id)->update(['status' => 'deleted']);

        return back()->with('success', 'Profile succesfully Deleted!');
    }

    public function reject($id)
    {
        $id = decrypt($id);
        User::where('id', $id)->update(['status' => 'reject']);

        return back()->with('success', 'Profile succesfully Rejected!');
    }
}

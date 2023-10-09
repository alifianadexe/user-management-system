<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KingdomController extends Controller
{
    public function index()
    {
        $kingdoms = User::orderBy('created_at', 'desc')->get();

        return view('pages.kingdom.index', compact('kingdoms'));
    }

    public function store()
    {
        $kingdoms = request()->validate([
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|confirmed|min:8|max:255',
            'firstname' => 'required',
            'lastname' => 'required',
            'phone_number' => 'required|min:12|max:255',
        ]);

        // Set Attribute Default
        $kingdoms['status'] = "pending";
        $kingdoms['create_at'] = date('Y-m-d H:i:s');

        $kingdoms = User::create($kingdoms);

        return redirect()->back()->with('msg', 'User Berhasil Dibuat!');
    }

    public function show($id = null)
    {
        $kingdoms = null;
        if ($id) {
            $id = decrypt($id);
            $kingdoms = User::where('id', $id)->first();
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

        $kingdoms = request();
        if (request()->password == null) {
            unset($validate['password']);
            unset($user['password']);
        }

        $id = decrypt($kingdoms['id']);

        $kingdoms = $user->validate($validate);
        $kingdoms = User::where('id', $id)->update($kingdoms);


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

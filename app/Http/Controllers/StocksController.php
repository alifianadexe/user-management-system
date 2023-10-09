<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Stocks;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\User as Authenticatable;

class StocksController extends Controller
{
    public function index()
    {
        // $stocks = Stocks::orderBy('created_at', 'desc')->get();
        $title = "List Stocks";
        $userId = Auth::id();
        $stocks = DB::table('stocks')->where('stocks.user_id', $userId)->join('resources', 'resources.id', '=', 'stocks.resource_id')->get();
        return view('pages.stocks.index', compact('stocks', 'title'));
    }

    public function store()
    {
        $stocks = request()->validate([
            'email' => 'required|email|max:255|unique:stocks,email',
            'password' => 'required|confirmed|min:8|max:255',
            'firstname' => 'required',
            'lastname' => 'required',
            'phone_number' => 'required|min:12|max:255',
        ]);

        // Set Attribute Default
        $stocks['status'] = "pending";
        $stocks['create_at'] = date('Y-m-d H:i:s');

        $stocks = Stocks::create($stocks);

        return redirect()->back()->with('msg', 'stocks Berhasil Dibuat!');
    }

    public function show($id = null)
    {
        $stocks = null;
        if ($id) {
            $id = decrypt($id);
            $stocks = Stocks::where('id', $id)->first();
        }
        $resources_name = Resource::all();
        $title = 'Form Stocks';
        return view('pages.stocks.form', compact('stocks', 'title', 'resources_name'));
    }

    public function update()
    {
        $validate = [
            'email' => 'required|email|max:255',
            'password' => 'required|confirmed|min:8|max:255',
            'firstname' => 'required',
            'lastname' => 'required',
            'phone_number' => 'required|min:12|max:255',
            'ownership' => 'required',
            'status' => 'required'
        ];

        $stocks = request();
        if (request()->password == null) {
            unset($validate['password']);
            unset($stocks['password']);
        }

        $id = decrypt($stocks['id']);

        $stocks = $stocks->validate($validate);
        $stocks = Stocks::where('id', $id)->update($stocks);


        return back()->with('success', 'Profile succesfully updated');
    }

    public function approve($id)
    {
        $id = decrypt($id);
        Stocks::where('id', $id)->update(['status' => 'active']);

        return back()->with('success', 'Profile succesfully Approved!');
    }

    public function delete($id)
    {
        $id = decrypt($id);
        Stocks::where('id', $id)->update(['status' => 'deleted']);

        return back()->with('success', 'Profile succesfully Deleted!');
    }

    public function reject($id)
    {
        $id = decrypt($id);
        Stocks::where('id', $id)->update(['status' => 'reject']);

        return back()->with('success', 'Profile succesfully Rejected!');
    }
}

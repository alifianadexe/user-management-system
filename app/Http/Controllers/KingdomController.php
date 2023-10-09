<?php

namespace App\Http\Controllers;

use App\Models\Kingdoms;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KingdomController extends Controller
{
    public function index()
    {
        $kingdoms = Kingdoms::orderBy('created_at', 'desc')->get();

        return view('pages.kingdom.index', compact('kingdoms'));
    }

    public function store()
    {
        $kingdoms = request()->validate([
            'kingdom_id' => 'required',
            'desc' => 'required|min:12|max:255',
        ]);

        $kingdoms = Kingdoms::create($kingdoms);

        return redirect()->back()->with('success', 'Kingdoms Berhasil Dibuat!');
    }

    public function show($id = null)
    {
        $kingdoms = null;
        if ($id) {
            $id = decrypt($id);
            $kingdoms = Kingdoms::where('id', $id)->first();
        }
        return view('pages.kingdom.form', compact('kingdoms'));
    }

    public function update()
    {
        $kingdoms = request()->validate([
            'id' => 'required',
            'kingdom_id' => 'required',
            'desc' => 'required|min:12|max:255',
        ]);


        $kingdoms = Kingdoms::where('id', $kingdoms['id'])->update($kingdoms);


        return back()->with('success', 'Profile succesfully updated');
    }

    public function approve($id)
    {
        $id = decrypt($id);
        Kingdoms::where('id', $id)->update(['status' => 'active']);

        return back()->with('success', 'Profile succesfully Approved!');
    }

    public function delete($id)
    {
        $id = decrypt($id);

        Kingdoms::where('id', $id)->delete();
        Resource::where('kingdom_id', $id)->delete();

        return back()->with('success', 'Profile succesfully Deleted!');
    }

    public function reject($id)
    {
        $id = decrypt($id);
        Kingdoms::where('id', $id)->update(['status' => 'reject']);

        return back()->with('success', 'Profile succesfully Rejected!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Kingdoms;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KingdomController extends CustomController
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

        $data = [];

        foreach ($this->resources_name as $i => $resource_name) {
            $resource = [];

            $resource['kingdom_id'] = $kingdoms->id;
            $resource['description'] = '';

            $resource['resource_name'] = $resource_name;
            $resource['unit'] = 0;
            $resource['resource_price'] = 0;
            $resource['image_url'] = '';

            array_push($data, $resource);
        }

        Resource::insert($data);

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

        $id = decrypt($kingdoms['id']);
        unset($kingdoms['id']);

        $kingdoms = Kingdoms::where('id', $id)->update($kingdoms);


        return back()->with('success', 'Kingdoms succesfully updated');
    }

    public function delete($id)
    {
        $id = decrypt($id);

        Kingdoms::where('id', $id)->delete();
        Resource::where('kingdom_id', $id)->delete();

        return back()->with('success', 'Profile succesfully Deleted!');
    }
}

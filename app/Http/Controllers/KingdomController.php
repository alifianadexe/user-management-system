<?php

namespace App\Http\Controllers;

use App\Models\Kingdom;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KingdomController extends Controller
{
    public function index()
    {
        $kingdoms = Kingdom::orderBy('created_at', 'asc')->get();

        return view('pages.kingdom.index', compact('kingdoms'));
    }

        public function show($id = null)
    {
        $kingdom = null;
        if ($id) {
            $kingdom = Kingdom::find(decrypt($id));
        }
        return view('pages.kingdom.detail', compact('kingdom'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kingdom_id' => 'required|unique:kingdoms,kingdom_id',
            'desc' => 'required',
        ]);

        $validatedData['created_at'] = now();

        Kingdom::create($validatedData);

        return back()->with('msg', 'Kingdom Berhasil Dibuat!');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'kingdom_id' => [
                'required',
            ],
            'desc' => 'required',
        ]);

        $kingdom = Kingdom::find($id);

        if (!$kingdom) {
            return redirect()->back()->with('error', 'Kingdom tidak ditemukan!');
        }

        $kingdom->update($validatedData);

        return back()->with('success', 'Kingdom berhasil diperbarui');
    }

    public function delete($id)
    {
        $kingdom = Kingdom::find(decrypt($id));

        if (!$kingdom) {
            return redirect()->back()->with('error', 'Kingdom tidak ditemukan!');
        }

        $kingdom->delete();

        return back()->with('success', 'Kingdom berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Kingdoms;
use App\Models\Stocks;
use App\Models\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\User as Authenticatable;

class StocksController extends CustomController
{
    public function index()
    {
        // $stocks = Stocks::orderBy('created_at', 'desc')->get();
        $title = "List Stocks";
        $userId = Auth::id();
        $stocks = DB::table('stocks')->where('stocks.user_id', $userId)->join('resources', 'resources.id', '=', 'stocks.resource_id')->join('kingdoms', 'kingdoms.id', '=', 'resources.kingdom_id')->orderBy('stocks.created_at')->get();

        // $this->debug($stocks);

        return view('pages.stocks.index', compact('stocks', 'title'));
    }

    public function store(Request $request): RedirectResponse
    {
        $resources_unit = [
            "stone" => $request->unit_stone,
            "food" => $request->unit_food,
            "wood" => $request->unit_wood,
            "gold" => $request->unit_gold
        ];

        $data = [];

        $resource['kingdom_id'] = $request->kingdom_id;
        $resource_list = Resource::where('kingdom_id', $request->kingdom_id)->get();

        $userId = Auth::id();

        foreach ($resource_list as $i => $resource) {
            $stock = [];

            $amount = $resources_unit[strtolower($resource->resource_name)];

            if ($amount > 0) {
                $stock['user_id'] = $userId;
                $stock['resource_id'] = $resource->id;
                $stock['amount'] = $amount;
                $stock['status'] = 'pending';
                $stock['created_at'] = date('Y-m-d H:i:s');

                array_push($data, $stock);
            }
        }

        // $this->debug($data);

        Stocks::insert($data);

        return redirect()->back()->with('msg', 'Stocks Berhasil Dibuat!');
    }

    public function show($id = null)
    {
        $stocks = [];
        $resources = [];

        if (isset($id)) {
            $id = decrypt($id);
            $stocks = DB::table('stocks')->where('stocks.id', $id)->join('resources', 'resources.id', '=', 'stocks.resource_id')->join('kingdoms', 'kingdoms.id', '=', 'resources.kingdom_id')->first();
        } else {
            $resources = $this->get_resources_detail($id);
        }


        $title = "Form Stock";
        $resources_name = $this->resources_name;
        $kingdoms = Kingdoms::all();

        // $this->debug($stocks);

        return view('pages.stocks.form', compact('resources', 'stocks', 'kingdoms', 'title', 'resources_name'));
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
}

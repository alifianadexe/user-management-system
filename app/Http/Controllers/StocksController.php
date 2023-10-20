<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Kingdoms;
use App\Models\Stocks;
use App\Models\Resource;
use App\Models\Transactions;

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
        $stocks = DB::table('stocks')->where('transactions.user_id', $userId)
            ->join('transactions', 'transactions.id', '=', 'stocks.transaction_id')
            ->join('resources', 'resources.id', '=', 'stocks.resource_id')
            ->join('kingdoms', 'kingdoms.id', '=', 'resources.kingdom_id')
            ->select('stocks.id as stocks_id_main', 'stocks.created_at as created_at_time', 'kingdoms.kingdom_id as kingdom_id_at', 'stocks.*', 'kingdoms.*', 'transactions.*', 'resources.*')
            ->orderBy('stocks.created_at')->get();

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

        $transaction_id = Transactions::insertGetId(['user_id' => $userId, 'status' => 'pending', 'created_at' => date('Y-m-d H:i:s')]);

        foreach ($resource_list as $i => $resource) {
            $stock = [];

            $amount = $resources_unit[strtolower($resource->resource_name)];

            if ($amount > 0) {
                $stock['transaction_id'] = $transaction_id;
                $stock['resource_id'] = $resource->id;
                $stock['amount'] = $amount;

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
            // $this->debug($id);
            $stocks = DB::table('stocks')
                ->where('stocks.id', $id)
                ->join('resources', 'resources.id', '=', 'stocks.resource_id')
                ->join('kingdoms', 'kingdoms.id', '=', 'resources.kingdom_id')
                ->select('stocks.id as stocks_id_main', 'stocks.created_at as created_at_time', 'kingdoms.kingdom_id as kingdom_id_at', 'stocks.*', 'kingdoms.*', 'resources.*')
                ->first();

            $kingdoms = Kingdoms::where('id', $stocks->kingdom_id)->first();
            $resources =  $this->get_resources_detail($kingdoms);
        } else {
            $resources = $this->get_resources_detail($id);
        }


        $title = "Form Stock";
        $resources_name = $this->resources_name;
        $kingdoms = Kingdoms::all();

        // $this->debug($resources);

        return view('pages.stocks.form', compact('resources', 'stocks', 'kingdoms', 'title', 'resources_name'));
    }

    public function update()
    {
        $stocks = request();

        $id = decrypt($stocks['id']);

        $stocks = Stocks::where('id', $id)->update([
            'amount' => $stocks->amount
        ]);


        return back()->with('success', 'Stocks succesfully updated');
    }


    public function delete($id)
    {
        $id = decrypt($id);

        Stocks::where('id', $id)->delete();

        return back()->with('success', 'Profile succesfully Deleted!');
    }
}

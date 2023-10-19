<?php

namespace App\Http\Controllers;


use DB;
use Auth;
use App\Models\Kingdoms;
use App\Models\Stocks;
use App\Models\Resource;
use App\Models\Transactions;
use App\Models\HistorySell;
use App\Models\User;

use Illuminate\Http\Request;

class HomeController extends CustomController
{

    public function index()
    {
        // $stocks = Stocks::orderBy('created_at', 'desc')->get();
        $title = "Dashboard";

        $userId = Auth::id();

        $users = User::where('id', $userId)->first();

        // Get all kingdom
        $kingdoms = Kingdoms::all();

        // Get all resources
        $items = [];
        foreach ($kingdoms as $kingdom) {
            $item = array();
            $resources = Resource::all()->where('kingdom_id', '=', $kingdom->id);

            $item['id'] = $kingdom->id;
            $item['name'] = $kingdom->kingdom_id;
            $item['data'] = [];

            foreach ($resources as $resource) {
                array_push($item['data'], $resource);
            }

            array_push($items, $item);
        }

        $user = User::all();
        $userCount = $user->count();

        $history = HistorySell::all();
        $historySum = $history->sum('total_price');

        if ($users['ownership'] == 'user') {
            $transactions = Transactions::where('status', 'pending')->where('user_id', $userId)->get();
            $transactionCount = $history->count();
        } else {
            $transactions = Transactions::where('status', 'pending')->get();
            $transactionCount = $history->count();
        }


        return view('pages.dashboard', compact('userCount', 'historySum', 'transactionCount', 'items'));
    }
}

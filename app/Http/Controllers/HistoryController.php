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
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\User as Authenticatable;

class HistoryController extends CustomController
{
    public function index()
    {
        // $stocks = Stocks::orderBy('created_at', 'desc')->get();
        $title = "List History Sell";

        $userId = Auth::id();

        $users = User::where('id', $userId)->first();

        if ($users['ownership'] == 'user') {
            $history_sell = DB::table('history_sells')->where('transactions.user_id', $userId)
                ->join('stocks', 'stocks.id', '=', 'history_sells.stocks_id')
                ->join('transactions', 'transactions.id', '=', 'stocks.transaction_id')
                ->join('resources', 'resources.id', '=', 'stocks.resource_id')
                ->join('kingdoms', 'kingdoms.id', '=', 'resources.kingdom_id')
                ->join('users', 'users.id', '=', 'transactions.user_id')
                ->select('transactions.status as status_transactions', 'stocks.id as stock_id', 'transactions.id as transaction_id', 'transactions.*', 'history_sells.*', 'stocks.*', 'resources.*', 'kingdoms.*', 'users.*')
                ->orderBy('stocks.created_at')->get();
        } else {
            $history_sell = DB::table('history_sells')->join('stocks', 'stocks.id', '=', 'history_sells.stocks_id')
                ->join('transactions', 'transactions.id', '=', 'stocks.transaction_id')
                ->join('resources', 'resources.id', '=', 'stocks.resource_id')
                ->join('kingdoms', 'kingdoms.id', '=', 'resources.kingdom_id')
                ->join('users', 'users.id', '=', 'transactions.user_id')
                ->select('transactions.status as status_transactions', 'stocks.id as stock_id', 'transactions.id as transaction_id', 'transactions.*', 'history_sells.*', 'stocks.*', 'resources.*', 'kingdoms.*', 'users.*')
                ->orderBy('stocks.created_at')->get();
        }

        $ownership = $users['ownership'];
        $no = 1;
        // $this->debug($history_sell);
        return view('pages.history.index', compact('history_sell', 'title', 'ownership', 'no'));
    }
}

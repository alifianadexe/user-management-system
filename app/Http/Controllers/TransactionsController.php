<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Stocks;
use App\Models\HistorySell;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransactionsController extends CustomController
{
    public function index()
    {
        $transactions = DB::table('transactions')
            ->join('stocks', 'transactions.id', '=', 'stocks.transaction_id')
            ->join('resources', 'resources.id', '=', 'stocks.resource_id')
            ->join('kingdoms', 'kingdoms.id', '=', 'resources.kingdom_id')
            ->join('users', 'users.id', '=', 'transactions.user_id')
            ->leftJoin('history_sells', 'stocks.id', '=', 'history_sells.stocks_id')
            ->select('transactions.status as status_transactions',  'stocks.id as stock_id', 'transactions.*', 'stocks.*', 'resources.*', 'kingdoms.*', 'users.*', 'history_sells.qty')
            ->orderBy('stocks.created_at')->get();

        $transactions = $this->group_per_transactions($transactions);
        $resources_name = $this->resources_name;
        // $this->debug($transactions);

        return view('pages.transaction.index', compact('transactions', 'resources_name'));
    }

    public function show($id = null)
    {
        $transactions = null;
        if ($id) {
            $id = decrypt($id);
            $transactions = DB::table('transactions')
                ->join('stocks', 'transactions.id', '=', 'stocks.transaction_id')
                ->join('resources', 'resources.id', '=', 'stocks.resource_id')
                ->join('kingdoms', 'kingdoms.id', '=', 'resources.kingdom_id')
                ->join('users', 'users.id', '=', 'transactions.user_id')
                ->leftJoin('history_sells', 'stocks.id', '=', 'history_sells.stocks_id')
                ->select('transactions.status as status_transactions', 'stocks.id as stock_id', 'transactions.*', 'stocks.*', 'resources.*', 'kingdoms.*', 'users.*', 'history_sells.qty')
                ->where('transactions.id', $id)->orderBy('stocks.created_at')->get();
            $transactions = $this->group_per_transactions($transactions);
            $transactions = $transactions[$id];
            $transactions['transaction_id'] = $id;
        }
        $resources_name = $this->resources_name;

        // $this->debug($transactions);
        $title = 'Transactions Form';
        return view('pages.transaction.form', compact('transactions', 'resources_name', 'title'));
    }

    public function update()
    {

        $transactions = request();
        $id = decrypt($transactions['id']);

        Transactions::where('id', $id)->update(['status' => 'approved']);

        foreach ($this->resources_name as $key => $resource) {
            $history = [];
            $history['stocks_id'] = $transactions['stock_id_' . strtolower($resource)];
            $history['qty'] = $transactions[strtolower($resource)];
            $history['total_price'] = $transactions['resource_price_' . strtolower($resource)];
            $history['created_at'] = date('Y-m-d H:i:s');

            HistorySell::insert($history);
        }

        return back()->with('success', 'Profile succesfully updated');
    }

    public function approve($id)
    {
        $id = decrypt($id);

        Transactions::where('id', $id)->update(['status' => 'approved']);

        $stocks = DB::table('stocks')
            ->join('resources', 'resources.id', '=', 'stocks.resource_id')
            ->select('stocks.id as stocks_id', 'stocks.*', 'resources.*')
            ->where('transaction_id', $id)->get();

        foreach ($stocks as $key => $stock) {
            $history = [];
            $history['stocks_id'] = $stock->stocks_id;
            $history['qty'] = $stock->amount;

            $unit = $stock->unit <= 0 ? 1 : $stock->unit;
            $history['total_price'] = ($stock->amount / $unit) * $stock->resource_price;

            $history['created_at'] = date('Y-m-d H:i:s');

            HistorySell::insert($history);
        }

        return back()->with('success', 'Transaction succesfully Approved!');
    }

    public function reject($id)
    {
        $id = decrypt($id);

        Transactions::where('id', $id)->update(['status' => 'reject']);

        return back()->with('success', 'Transaction succesfully Rejected!');
    }
}

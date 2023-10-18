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
            ->select('transactions.status as status_transactions', 'transactions.*', 'stocks.*', 'resources.*', 'kingdoms.*', 'users.*')
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
                ->select('transactions.status as status_transactions', 'transactions.*', 'stocks.*', 'resources.*', 'kingdoms.*', 'users.*')
                ->where('transactions.id', $id)->orderBy('stocks.created_at')->get();
            $transactions = $this->group_per_transactions($transactions);
        }
        $resources_name = $this->resources_name;
        return view('pages.transaction.detail', compact('transactions', 'resources_name'));
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

        $transaction = request();
        if (request()->password == null) {
            unset($validate['password']);
            unset($transaction['password']);
        }

        $id = decrypt($transaction['id']);

        $transaction = $transaction->validate($validate);
        $transaction = Stocks::where('id', $id)->update($transaction);


        return back()->with('success', 'Profile succesfully updated');
    }

    public function approve($id)
    {
        $id = decrypt($id);

        Transactions::where('id', $id)->update(['status' => 'approved']);

        $stocks = DB::table('stocks')
            ->join('resources', 'resources.id', '=', 'stocks.resource_id')
            ->where('transaction_id', $id)->get();

        foreach ($stocks as $key => $stock) {
            $history = [];
            $history['stocks_id'] = $stock->id;
            $history['qty'] = $stock->amount;
            $history['total_price'] = $stock->resource_price * $stock->amount;
            $history['stocks_id'] = $stock->id;
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

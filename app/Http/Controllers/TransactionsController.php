<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Stocks;
use App\Models\HistorySell;
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
            ->join('users', 'users.id', '=', 'transactions.user_id')->orderBy('stocks.created_at')->get();

        $transactions = $this->group_per_transactions($transactions);
        $resources_name = $this->resources_name;
        // $this->debug($transactions);

        return view('pages.transaction.index', compact('transactions', 'resources_name'));
    }

    public function store()
    {
        $transaction = request()->validate([
            'email' => 'required|email|max:255|unique:transactions,email',
            'password' => 'required|confirmed|min:8|max:255',
            'firstname' => 'required',
            'lastname' => 'required',
            'phone_number' => 'required|min:12|max:255',
        ]);

        // Set Attribute Default
        $transaction['status'] = "pending";
        $transaction['create_at'] = date('Y-m-d H:i:s');

        $transaction = Stocks::create($transaction);

        return redirect()->back()->with('msg', 'transaction Berhasil Dibuat!');
    }

    public function show($id = null)
    {
        $transactions = null;
        if ($id) {
            $id = decrypt($id);
            $transactions = Stocks::where('id', $id)->first();
        }
        return view('pages.transaction.detail', compact('transactions'));
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
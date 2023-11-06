<?php

namespace App\Http\Controllers;

use App\Models\Profit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SalesController extends Controller
{
    //
    public $list_index = array();

    function index()
    {
      $title = "Sales";

      // Data profits
      $profits = DB::table('history_sells', 'hs')
        ->join('stocks as s'   , 's.id', '=', 'hs.stocks_id')
        ->join('resources as r', 'r.id', '=', 's.resource_id')
        ->join('kingdoms as k' , 'k.id', '=', 'r.kingdom_id')
        ->join('profits as p'  , 'p.transaction_id', '=', 's.transaction_id')
        ->select('s.transaction_id as id', 'k.kingdom_id as kingdom', 'r.resource_name as name', 'hs.qty', 'hs.total_price', 'p.created_at as buy_date', 'p.sell_price as sell_price', 'p.profit as profit')
        ->orderByDesc('buy_date', 'kingdom')
        ->get();

      // Turn into object - one transaction containe 4 resource
      $profits = collect($profits)
        ->chunkWhile(function ($value, $key, $chunk) {
          return $value->id === $chunk->last()->id;
        })
        ->map(function ($items, $key) {
          $sale = new Sale();

          foreach($items as $item){
            $sale->sell_price = $item->sell_price;
            $sale->profit = $item->profit;

            $sale->add_sale($item);
          }

          array_push($this->list_index, $sale->id);
          return $sale;
        });

      // Data sales
      // Using query builder
      $sales = DB::table('history_sells', 'hs')
                  ->join('stocks as s'   , 's.id', '=', 'hs.stocks_id')
                  ->join('resources as r', 'r.id', '=', 's.resource_id')
                  ->join('kingdoms as k' , 'k.id', '=', 'r.kingdom_id')
                  ->select('s.transaction_id as id', 'k.kingdom_id as kingdom', 'r.resource_name as name', 'hs.qty', 'hs.total_price', 'hs.created_at as buy_date')
                  ->orderByDesc('buy_date', 'kingdom')
                  ->get();
      
      // Turn into object - one transaction containe 4 resource
      $sales = collect($sales)
        ->chunkWhile(function ($value, $key, $chunk) {
          return $value->id === $chunk->last()->id;
        })
        ->map(function ($items, $key) {
          $sale = new Sale();
          foreach($items as $item){
            $sale->add_sale($item);
          }

          if (in_array($sale->id, $this->list_index)){
            $sale->active = true;
          }
          return $sale;
        });

      return view('pages.sales.index', compact('title', 'sales', 'profits'));
    }

    public function show($id = null)
    {
      $title = "Form Sales";

      if (isset($id)) {

        // Handling decrypt error
        try{
          $id = decrypt($id);
        }
        catch(Exception){
          return Redirect('/sales');
        }

        // Data sale
        // Using query builder
        $listSale = DB::table('history_sells', 'hs')
                  ->join('stocks as s'   , 's.id', '=', 'hs.stocks_id')
                  ->join('resources as r', 'r.id', '=', 's.resource_id')
                  ->join('kingdoms as k' , 'k.id', '=', 'r.kingdom_id')
                  ->select('s.transaction_id as id', 'k.kingdom_id as kingdom', 'r.resource_name as name', 'hs.qty', 'hs.total_price', 'hs.created_at as buy_date')
                  ->orderByDesc('buy_date', 'kingdom')
                  ->where('s.transaction_id', $id)
                  ->get();

        // Convert to Sale object
        $sale = new Sale();

        foreach($listSale as $item){
          $sale->add_sale($item);
        }
        
        return view('pages.sales.form', compact('title', 'sale'));
      } 
      
      return Redirect('/sales');
    }

    public function insert(Request $request)
    {
      // Success
      $data = [];
      
      $data['transaction_id'] = decrypt($request->id);
      $data['sell_price'] = $request->sell_price;
      $data['profit'] = $request->sell_price - $request->buy_price;
      $data['created_at'] = date('Y-m-d H:i:s');

      Profit::insert($data);

      return Redirect('/sales');
    }
}

class Sale {
  public $id;
  public $kingdom;
  public $resources;
  public $buy_date;
  public $profit;
  public $sell_price;
  public $active;
  
  public function add_sale($listSale){
    $this->id = $listSale->id;
    $this->kingdom = $listSale->kingdom;
    $this->buy_date = $listSale->buy_date;

    $this->resources[strtolower($listSale->name)] = new Resource(
      $listSale->name,
      $listSale->qty,
      $listSale->total_price
    );
  }

  public function get_sum(){
    $sum = 0;
    foreach($this->resources as $resource){
      $sum += $resource->total_price;
    }

    return $sum;
  }
}

class Resource {
  public $name;
  public $qty;
  public $total_price;

  function __construct($name, $qty, $total_price) {
    $this->name = $name;
    $this->qty = $qty;
    $this->total_price = $total_price;
  }
}

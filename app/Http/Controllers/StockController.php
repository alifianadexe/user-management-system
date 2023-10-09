<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Kingdom;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class StockController extends Controller
{
    /**
     * Page for add new Resource
     */
    public function add(Request $request)
    {

        $kingdom_id = decrypt($request->id);
        $kingdom_name = $request->name;

        // Get all resources
        $item = array();
        $resources = Resource::all()->where('kingdom_id', '=', $kingdom_id);
        
        $item['id'] = $kingdom_id;
        $item['name'] = $kingdom_name;
        $item['data'] = [];

        foreach ($resources as $resource){
            array_push($item['data'], $resource);
        }

        // items => item {}
        // [0]=> {name: 69, data:[1,2,3]}

        $title = "Add Resource";
        return view('pages.resource.form', compact("title", 'item'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Kingdom;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get all kingdom
        $kingdoms = Kingdom::all();

        // Get all resources
        $items = [];
        foreach ($kingdoms as $kingdom){
            $item = array();
            $resources = Resource::all()->where('kingdom_id', '=', $kingdom->id);
            
            $item['id'] = $kingdom->id;
            $item['name'] = $kingdom->name;
            $item['data'] = [];

            foreach ($resources as $resource){
                array_push($item['data'], $resource);
            }
            
            array_push($items, $item);
        }

        // items => item {}
        // [0]=> {name: 69, data:[1,2,3]}

        return view('pages.dashboard', compact('items'));
    }
}

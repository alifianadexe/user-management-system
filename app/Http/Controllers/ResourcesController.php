<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Kingdom;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ResourcesController extends Controller
{
    //
    public function index()
    {
        $resources = Resource::all();
        $title = "List Resources";

        return view('pages.resource.index', compact('resources', 'title'));
    }

    /**
     * Page for add new Resource
     */
    public function add(Request $request)
    {

        //
    }

    /**
     * Store a new resource.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the request...

        $resources_name = ["Stone", 'Food', 'Wood', 'Gold'];
        $resources_unit = [
            $request->unit_stone,
            $request->unit_food,
            $request->unit_wood,
            $request->unit_gold
        ];

        $resources_price = [
            $request->resource_price_stone,
            $request->resource_price_food,
            $request->resource_price_wood,
            $request->resource_price_gold
        ];

        $data = [];

        foreach ($resources_name as $i => $resource_name) {
            $resource = [];

            $resource['kingdom_id'] = $request->kingdom_id;
            $resource['description'] = $request->description;
            //
            $resource['resource_name'] = $resource_name;
            $resource['unit'] = $resources_unit[$i];
            $resource['resource_price'] = $resources_price[$i];
            $resource['image_url'] = '';
            $resource['created_at'] = date('Y-m-d H:i:s');
            //

            array_push($data, $resource);
        }

        Resource::insert($data);
        return redirect('/resources');
    }

    /**
     * Delete a resource.
     */
    public function delete(Request $request): RedirectResponse
    {
        $resource = Resource::find(decrypt($request->id));

        $resource->delete();

        return redirect('/resources');
    }
}

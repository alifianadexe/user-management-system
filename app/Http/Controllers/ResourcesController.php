<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\Resource;
use App\Models\Kingdoms;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ResourcesController extends CustomController
{

    public function index()
    {
        // $resources = DB::table('resources')->join('kingdoms', 'kingdoms.id', '=', 'resources.kingdom_id')->get();


        $kingdoms = Kingdoms::all();

        $resources = $this->get_resource();

        $title = "List Resources";

        return view('pages.resource.index', compact('resources', 'title'));
    }

    /**
     * Page for add new Resource
     */
    public function add()
    {
        $resources_name = $this->resources_name;
        $title = "Add Resource";
        return view('pages.resource.form', compact("title", 'resources_name'));
    }

    public function show($id = null)
    {
        if (isset($id)) {
            $id = decrypt($id);
            $resources = $this->get_resource($id);
        } else {
            $resources = $this->get_resources_detail($id);
        }

        $title = "Form Resource";
        $resources_name = $this->resources_name;
        $kingdoms = Kingdoms::all();

        return view('pages.resource.form', compact('resources', 'kingdoms', 'resources_name', 'title'));
    }



    public function update(Request $request): RedirectResponse
    {
        $resource_id = [
            $request->stone_id,
            $request->food_id,
            $request->wood_id,
            $request->gold_id
        ];

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

        foreach ($resource_id as $i => $id) {

            $resource = ['unit' => $resources_unit[$i], 'resource_price' => $resources_price[$i]];

            $resource = Resource::where('id', $id)->update($resource);
        }

        return back()->with('success', 'Resources succesfully updated');
    }

    /**
     * Store a new resource.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the request...
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

        foreach ($this->resources_name as $i => $resource_name) {
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

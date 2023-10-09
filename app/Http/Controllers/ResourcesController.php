<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Kingdoms;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ResourcesController extends Controller
{
    private $resources_name = ["Stone", 'Food', 'Wood', 'Gold'];
    private $kingdoms_list = [];
    //
    public function index()
    {
        // $resources = DB::table('resources')->join('kingdoms', 'kingdoms.id', '=', 'resources.kingdom_id')->get();


        $kingdoms = Kingdoms::all();
        $this->kingdoms_list = $kingdoms;

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
        $resources = null;
        if ($id) {
            $id = decrypt($id);
            $resources = $this->get_resource($id);
        }


        $title = "Form Resource";
        $resources_name = $this->resources_name;

        return view('pages.resource.form', compact('resources', 'resources_name', 'title'));
    }

    public function get_resource($kingdom_id = null)
    {
        $resources = [];
        if ($kingdom_id != null) {
            $kingdom = Kingdoms::where('id', $kingdom_id)->first();
            $resources = $this->get_resources_detail($kingdom);
        } else {
            $kingdoms = $this->kingdoms_list;
            foreach ($kingdoms as $kingdom) {
                array_push($resources, $this->get_resources_detail($kingdom));
            }
        }


        return $resources;
    }

    public function get_resources_detail($kingdom)
    {
        $resources = [];

        $res = Resource::where('kingdom_id', $kingdom->id)->get();
        $resources = [];
        $resources['id'] = $kingdom->id;
        $resources['kingdom_id'] = $kingdom->kingdom_id;
        $resources['desc'] = $kingdom->desc;

        foreach ($this->resources_name as $res_name) {
            $resources[$res_name] = 0;
            $resources[$res_name .  "_unit"] = 0;
            foreach ($res as $resource) {
                if ($resource->resource_name == $res_name) {
                    $resources[$res_name] = $resource->resource_price;
                    $resources[$res_name . "_unit"] = $resource->unit;
                }
            }
        }
        $resources['created_at'] = $kingdom->created_at;

        return $resources;
    }

    public function update(Request $request): RedirectResponse
    {
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

        foreach ($this->resources_name as $i) {

            $resource['unit'] = $resources_unit[$i];
            $resource['resource_price'] = $resources_price[$i];

            array_push($data, $resource);

            $resource = Resource::where('id', $resource['id'])->update($data);
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

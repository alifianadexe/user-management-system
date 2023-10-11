<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Kingdoms;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CustomController extends Controller
{
    public $resources_name = ["Stone", 'Food', 'Wood', 'Gold'];

    public function debug($str)
    {
        echo "<pre>";
        print_r($str);
        exit();
    }

    public function get_resource($kingdom_id = null)
    {
        $resources = [];
        if ($kingdom_id != null) {
            $kingdom = Kingdoms::where('id', $kingdom_id)->first();
            $resources = $this->get_resources_detail($kingdom);
        } else {
            $kingdoms = Kingdoms::all();
            foreach ($kingdoms as $kingdom) {
                array_push($resources, $this->get_resources_detail($kingdom));
            }
        }

        return $resources;
    }

    public function get_resource_stock($kingdom_id = null)
    {
        $resources = [];
        if ($kingdom_id != null) {
            $kingdom = Kingdoms::where('id', $kingdom_id)->first();
            $resources = $this->get_resources_detail($kingdom);
        } else {
            $kingdoms = Kingdoms::all();
            foreach ($kingdoms as $kingdom) {
                array_push($resources, $this->get_resources_detail($kingdom));
            }
        }

        return $resources;
    }

    public function get_resources_detail($kingdom)
    {
        $resources = [
            'id' => 0,
            'desc' => '',
            'kingdom_id' => 0,
            'created_at' => '',
        ];

        $res = [];
        if (isset($kingdom)) {
            $res = Resource::where('kingdom_id', $kingdom->id)->get();

            $resources['id'] = $kingdom->id;

            $resources['desc'] = $kingdom->desc;
            $resources['kingdom_id'] = $kingdom->kingdom_id;
            $resources['created_at'] = $kingdom->created_at;
        }

        foreach ($this->resources_name as $res_name) {

            $resources[$res_name] = 0;
            $resources[$res_name .  "_unit"] = 0;
            $resources[$res_name . '_id'] = 0;

            foreach ($res as $resource) {

                if ($resource->resource_name == $res_name) {
                    $resources[$res_name] = $resource->resource_price;
                    $resources[$res_name . "_unit"] = $resource->unit;
                    $resources[$res_name . "_id"] = $resource->id;
                }
            }
        }

        return $resources;
    }
}

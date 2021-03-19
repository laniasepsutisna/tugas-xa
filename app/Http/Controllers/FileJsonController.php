<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileJsonController extends Controller
{
    /**
     * Assign mass data variable.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data_json = [
            ["name"=>"customers.json","url"=>"data-json/customers.json"],
            ["name"=>"orders.json","url"=>"data-json/orders.json"],
            ["name"=>"orders-details.json","url"=>"data-json/orders-details.json"],
            ["name"=>"products.json","url"=>"data-json/products.json"]
        ];

        return view('file-json.index', compact('data_json'));
    }
}

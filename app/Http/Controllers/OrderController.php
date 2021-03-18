<?php

namespace App\Http\Controllers;

use Webpatser\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->path = public_path('data-json/orders.json'); //get data products-backup.json
        $this->orders = json_decode(file_get_contents($this->path), true);
    }

    /**
     * Assign mass data variable.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('orders.index');
    }
}

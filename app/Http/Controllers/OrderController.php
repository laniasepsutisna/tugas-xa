<?php

namespace App\Http\Controllers;

use Webpatser\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->customers = json_decode(file_get_contents(public_path('data-json/customers.json')), true);
        $this->products = json_decode(file_get_contents(public_path('data-json/products.json')), true);

        $this->path = public_path('data-json/orders.json'); //get data products-backup.json
        $this->orders = json_decode(file_get_contents($this->path), true);

        $this->path_order_detail = public_path('data-json/orders-details.json'); //get data products-backup.json
        $this->orders_details = json_decode(file_get_contents($this->path_order_detail), true);
    }

    //TODO Membuat relasi dengan nama customer,
    //TODO Membuat halama show detail order
    //TODO Update order
    //TODO Delete order
    //TODO Reporting order
    /**
     * Assign mass data variable.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->orders;
        return view('orders.index', compact('orders'));
    }

    /**
     * Assign mass data variable.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = $this->customers;
        $products = $this->products;
        return view('orders.create', compact('customers', 'products'));
    }

    /**
     * Assign mass data variable.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //store order
        $orders1 = $this->orders;
        $orders2[] = [
            'id' => Uuid::generate()->string,
            'customer_id' => $request->customer_id,
            'amount' => $request->amount,
            'shipping_address' => $request->shipping_address,
            'order_address' => $request->order_address,
            'order_email' => $request->order_email,
            'order_date' => $request->order_date,
            'order_status' => 'order',
        ];

        //add new order
        $data1 = array_merge($orders1, $orders2);

        //write file order
        $newJsonString1 = json_encode($data1, JSON_PRETTY_PRINT);
        file_put_contents(public_path('data-json/orders.json'), stripslashes($newJsonString1));

        //store order detail
        $orders_detail1 = $this->orders_details;
        foreach ($request->product_id as $key => $row){
            $orders_detail2[] = [
                'id' => Uuid::generate()->string,
                'order_id' => $orders2[0]['id'],
                'order_id' => $request->product_id[$key],
                'price' => null,
                'quantity' => $request->quantity[$key],
            ];
        }

        //add new order
        $data2 = array_merge($orders_detail1, $orders_detail2);

        //write file order
        $newJsonString = json_encode($data2, JSON_PRETTY_PRINT);
        file_put_contents(public_path('data-json/orders-details.json'), stripslashes($newJsonString));

        Session::flash('success','Data berhasil disimpan dalam bentuk json');

        return redirect(route('orders.index'));
    }

}

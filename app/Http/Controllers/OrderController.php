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
        $data = [];
        foreach ($orders as $key => $order){
            foreach ($this->customers as $customer){
                if($order['customer_id'] == $customer['id']){
                    $data[$key] = [
                        'id' => $order['id'],
                        'customer_id' => $customer['id'],
                        'customer_name' => $customer['name'],
                        'amount' => $order['amount'],
                        'shipping_address' => $order['shipping_address'],
                        'order_address' => $order['order_address'],
                        'order_email' => $order['order_email'],
                        'order_date' => $order['order_date'],
                        'order_status' => $order['order_status'],
                    ];
                }
            }
        }

        $orders = $data;
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
                'order_id' => end($data1)['id'],
                'product_id' => $request->product_id[$key],
                'price' => $request->price[$key],
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

    /**
     * Assign mass data variable.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products = $this->products;
        $customers = $this->customers;
        $orders = $this->orders;
        $order_details_o = $this->orders_details;
        foreach ($orders as $item){
            if($id == $item['id']){
                $order = $item;
            }
        }

        foreach ($order_details_o as $key => $order_detail){
            if($order_detail['order_id'] == $id){
                $order_details[$key] = $order_detail;
            }
        }

        return view('orders.edit', compact('order', 'order_details', 'customers', 'products'));
    }

    /**
     * Assign mass data variable.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $orders = $this->orders;
        foreach ($orders  as $key => $order){
            if($id == $order['id']){
                $orders[$key]['customer_id'] = $request->customer_id;
                $orders[$key]['amount'] = $request->amount;
                $orders[$key]['shipping_address'] = $request->shipping_address;
                $orders[$key]['order_address'] = $request->order_address;
                $orders[$key]['order_email'] = $request->order_email;
                $orders[$key]['order_date'] = $request->order_date;
            }
        }

        $newJsonString = json_encode($orders, JSON_PRETTY_PRINT);
        file_put_contents($this->path, stripslashes($newJsonString));

        //store order detail
        $orders_details = $this->orders_details;
        foreach ($request->product_id as $key => $row){
            if($request->order_id[$key] == $order['id']){
                $orders_details[$key]['id'] = $request->order_detail_id[$key];
                $orders_details[$key]['order_id'] = $request->order_id[$key];
                $orders_details[$key]['product_id'] = $request->product_id[$key];
                $orders_details[$key]['price'] = $request->price[$key];
                $orders_details[$key]['quantity'] = $request->quantity[$key];
            }
        }

        //write file order
        $newJsonString = json_encode($orders_details, JSON_PRETTY_PRINT);
        file_put_contents(public_path('data-json/orders-details.json'), stripslashes($newJsonString));

        Session::flash('success','Data berhasil diupdate dalam bentuk json');

        return redirect(route('orders.index'));
    }

    /**
     * Assign mass data variable.
     *
     * @return \Illuminate\Http\Response
     */
    public function invoice($id)
    {
        $products = $this->products;
        $customers = $this->customers;
        $orders = $this->orders;
        $order_details_o = $this->orders_details;
        foreach ($orders as $item){
            foreach ($this->customers as $customer){
                if($item['customer_id'] == $customer['id']){
                    if($id == $item['id']){
                        $order = [
                            'id' => $item['id'],
                            'customer_id' => $customer['id'],
                            'customer_name' => $customer['name'],
                            'email' => $customer['email'],
                            'country' => $customer['country'],
                            'default_shipping_address' => $customer['default_shipping_address'],
                            'phone' => $customer['phone'],
                            'amount' => $item['amount'],
                            'shipping_address' => $item['shipping_address'],
                            'order_address' => $item['order_address'],
                            'order_email' => $item['order_email'],
                            'order_date' => $item['order_date'],
                            'order_status' => $item['order_status'],
                        ];
                    }
                }
            }
        }

        foreach ($order_details_o as $key => $item){
            foreach ($products as $product){
                if($item['product_id'] == $product['id']){
                    if($item['order_id'] == $id){
                        $order_detail[$key] = [
                            'id' => $item['id'],
                            'order_id' => $item['order_id'],
                            'product_id' => $item['product_id'],
                            'product_name' => $product['title'],
                            'description' => $product['description'],
                            'price' => $item['price'],
                            'quantity' => $item['quantity'],
                            'height' => $product['height'],
                            'width' => $product['width'],
                            'rating' => $product['rating'],
                        ];
                    }
                }
            }
        }

        return view('orders.invoice', compact('order', 'order_detail'));
    }

    /**
     * Code Bubble Sorting.
     *
     * @return \Illuminate\Http\Response
     */
    function sorting($on, $order=SORT_ASC)
    {
        //data array order
        $orders = $this->orders;

        //logic bubble sorting : AMOUNT
       if ($on == 1){
           do
           {
               $tukar = false;
               for( $i = 0, $c = count( $orders ) - 1; $i < $c; $i++ )
               {
                   //jika amount i kurang dari mount + i
                   if( $orders[$i]['amount'] < $orders[$i + 1]['amount'] )
                   {
                       //maka akan disusun array yang + i dengan isi order mount yg ke i
                       list( $orders[$i + 1]['amount'], $orders[$i]['amount'] ) = array( $orders[$i]['amount'], $orders[$i + 1]['amount'] );
                       $tukar = true;
                   }
               }
           }
           while( $tukar );
       }else if($on == 2){
           do
           {
               $tukar = false;
               for( $i = 0, $c = count( $orders ) - 1; $i < $c; $i++ )
               {
                   //jika amount i kurang dari mount + i
                   if( $orders[$i]['order_date'] < $orders[$i + 1]['order_date'] )
                   {
                       //maka akan disusun array yang + i dengan isi order mount yg ke i
                       list( $orders[$i + 1]['order_date'], $orders[$i]['order_date'] ) = array( $orders[$i]['order_date'], $orders[$i + 1]['order_date'] );
                       $tukar = true;
                   }
               }
           }
           while( $tukar );
       }

        //logic relasi dengan data customer
        $data = [];
        foreach ($orders as $key => $order){
            foreach ($this->customers as $customer){
                if($order['customer_id'] == $customer['id']){
                    $data[$key] = [
                        'id' => $order['id'],
                        'customer_id' => $customer['id'],
                        'customer_name' => $customer['name'],
                        'amount' => $order['amount'],
                        'shipping_address' => $order['shipping_address'],
                        'order_address' => $order['order_address'],
                        'order_email' => $order['order_email'],
                        'order_date' => $order['order_date'],
                        'order_status' => $order['order_status'],
                    ];
                }
            }
        }

        $orders = $data;

        return view('orders.index', compact('orders'));

    }
}

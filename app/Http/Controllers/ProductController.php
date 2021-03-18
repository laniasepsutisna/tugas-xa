<?php

namespace App\Http\Controllers;

use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->path = public_path('data-json/products.json'); //get data products-backup.json
        $this->products = json_decode(file_get_contents($this->path), true);
    }

    /**
     * Assign mass data variable.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->products;
        return view('products.index', compact('products'));
    }

    /**
     * Assign mass data variable.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Assign mass data variable.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $products1 = $this->products;
        $products2[] = [
            'id' => Uuid::generate()->string,
            'title' => $request->title,
            'type' => $request->type,
            'description' => $request->description,
            'height' => $request->height,
            'width' => $request->width,
            'price' => $request->price,
            'rating' => $request->rating,
        ];

        //add new data
        $data = array_merge($products1, $products2);

        // Write File
        $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents(public_path('data-json/products.json'), stripslashes($newJsonString));

        Session::flash('success','Data berhasil disimpan dalam bentuk json');

        return redirect(route('products.index'));
    }

    /**
     * Assign mass data variable.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products = $this->products;
        foreach ($products as $item){
            if($id == $item['id']){
                $product = $item;
            }
        }
        return view('products.edit', compact('product'));
    }

    /**
     * Assign mass data variable.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $products = $this->products;
        foreach ($products as $key => $item){
            if($id == $item['id']){
                $products[$key]['title'] = $request->title;
                $products[$key]['type'] = $request->type;
                $products[$key]['description'] = $request->description;
                $products[$key]['height'] = $request->height;
                $products[$key]['width'] = $request->width;
                $products[$key]['price'] = $request->price;
                $products[$key]['rating'] = $request->rating;
            }
        }

        $newJsonString = json_encode($products, JSON_PRETTY_PRINT);
        file_put_contents($this->path, stripslashes($newJsonString));

        Session::flash('success','Data berhasil diupdate dalam bentuk json');

        return redirect(route('products.index'));
    }

    /**
     * Assign mass data variable.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $products = $this->products;
        // get array index to delete
        $arr_index = array();
        foreach ($products as $key => $item){
            if($id == $item['id']){
                $arr_index[] = $key;
            }
        }

        // delete data
        foreach ($arr_index as $i)
        {
            unset($products[$i]);
        }

        // rebase array
        $products = array_values($products);

        $newJsonString = json_encode($products, JSON_PRETTY_PRINT);
        file_put_contents($this->path, stripslashes($newJsonString));

        Session::flash('danger','Data berhasil dihapus dari bentuk   json');

        return redirect(route('products.index'));
    }
}

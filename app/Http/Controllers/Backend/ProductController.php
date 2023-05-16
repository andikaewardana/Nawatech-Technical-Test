<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $data = Product::latest()->get();

        return view('backend/product', compact('data'));
    }

    public function store(Request $request)
    {

        Product::insert([
            'nama'  => $request->nama, 
            'stok'  => $request->stok,
            'harga' => $request->harga,
        ]);

        return response()->json(['success'=>'Data Product Berhasil Disimpan']);
    }

    public function edit($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        Product::updateOrCreate(
            [
             'id' => $id
            ],
            [
             'nama'     => $request->nama,
             'stok'     => $request->stok,
             'harga'    => $request->harga,
            ]
        );

        return response()->json(['success'=>'Data Product Berhasil Disimpan']);
    }

    public function destroy($id)
    {
        Product::find($id)->delete();
      
        return response()->json(['success'=>'Data Product Berhasil Dihapus']);
    }
}

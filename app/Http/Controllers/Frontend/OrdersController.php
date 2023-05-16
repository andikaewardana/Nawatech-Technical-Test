<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;
use Illuminate\Support\Facades\Mail;
use App\Mail\CancelMail;
use App\Jobs\OrderJob;

class OrdersController extends Controller
{
    public function index()
    {
        $id = auth()->user()->id;
        $data = DB::table('orders')
                ->join('user', 'orders.user_id', '=', 'user.id')
                ->join('product', 'orders.product_id', '=', 'product.id')
                ->select('orders.id AS orders_id', 'user.id AS user_id', 'product.id AS product_id', 'user.email AS email_user', 'orders.qty', 'user.name AS nama_user', 'product.nama AS nama_product', 'product.harga AS harga_product', 'product.stok')
                ->where('orders.user_id', '=', $id)
                ->get();
        
        return view('frontend/orders', compact('data'));
    }

    public function update(Request $request)
    {

        $data = $request->all();

        dispatch(new OrderJob($data));

        $stok = $request->stok - $request->qty;

        Product::updateOrCreate(
            [
                'id' => $request->product_id
            ],
            [
            'stok'      => $stok,
        ]);

        return response()->json(['success'=>'Data Berhasil Disimpan']);
    }

    public function cancel(Request $request)
    {
        DB::table('orders')->where('id', '=', $request->orders_id)->delete();

        $stok = $request->stok + $request->qty;
        
        Product::updateOrCreate(
            [
                'id' => $request->product_id
            ],
            [
                'stok'      => $stok,
        ]);
            
        $mailData = [
            'title' => 'Cancel Orderan',
            'body' => 'Orderan Telah Dibatalkan'
        ];
            
        Mail::to($request->email)->send(new CancelMail($mailData));

        return response()->json(['success'=>'Data Berhasil Dihapus']);

    }

    public function export() 
    {
        return Excel::download(new OrdersExport, 'orders.xlsx');
    }

}

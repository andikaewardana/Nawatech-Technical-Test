<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $id = auth()->user()->id;
        $data = DB::table('orders')
        ->join('user', 'orders.user_id', '=', 'user.id')
        ->join('product', 'orders.product_id', '=', 'product.id')
        ->select('product.nama AS nama_product', 'user.name AS nama_user', 'product.harga AS harga_product', 'orders.qty')
        ->where('orders.user_id', '=', $id)
        ->get();
        
        return $data;
    }

    public function headings(): array
    {
        return ["Nama Product", "Nama User", "Harga Product", "Qty"];
    }
}

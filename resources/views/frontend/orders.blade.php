@extends('frontend.layout.base')

@section('content')

    <div class="card-body mb-3">
        <div class="row">
            <div class="col-md-2">
                <a href="{{ route('orders.export') }}" class="btn btn-success" >Export Orders</a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4>Nama</h4>
                </div>
                <div class="col-md-2">
                    <h4>Harga</h4>
                </div>
                <div class="col-md-2">
                    <h4>Qty</h4>
                </div>
                <div class="col-md-2">
                    <h4>Action</h4>
                </div>
            </div>
        </div>
    </div>

    @foreach ($data as $key => $value)
        <div class="card mt-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p>{{ $value->nama_product }}</p>
                    </div>
                    <div class="col-md-2">
                        <p>Rp. {{ $value->harga_product }}</p>
                    </div>
                    <div class="col-md-2">
                        <p>{{ $value->qty }}</p>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-danger" id="cancelCart" data-productid="{{ $value->product_id }}" data-ordersid="{{ $value->orders_id }}" data-qty="{{ $value->qty }}" data-stok="{{ $value->stok }}" data-email="{{ $value->email_user }}">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection

@section('scriptBottom')

    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 

        $("#cancelCart").click(function(){
            var ordersId    = $(this).data('ordersid');
            var productId   = $(this).data('productid');
            var qty         = $(this).data('qty');
            var stok        = $(this).data('stok');
            var email       = $(this).data('email');

            $.ajax({
                data: {orders_id:ordersId, product_id:productId, qty:qty, stok:stok, email:email},
                url: "{{ route('orders.cancel') }}",
                type:"POST",
                success: function (data) {
                    window.location.href = "{{ route('orders.index') }}";
                }
            })

        });

    </script>

@endsection


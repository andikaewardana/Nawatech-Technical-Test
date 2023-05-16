@extends('frontend.layout.base')

@section('content')

    @foreach ($data as $value)
        <div class="col-sm-3">
            <div class="card">
                <!-- <img class="card-img-top" src="../bootstrap4/img_avatar1.png" alt="Card image" style="width:100%"> -->
                <div class="card-body">
                    <h4 class="card-title">{{ $value->nama }}</h4>
                    <p class="card-text">Rp. {{ $value->harga }}</p>
                    @if (Auth::check())
                    <button type="submit" class="btn btn-primary" id="addCart" data-productid="{{ $value->id }}" data-userid="{{ auth()->user()->id }}" data-stok="{{ $value->stok }}" data-qty="1">Beli</a>
                    @else
                    <a href="{{ route('login.show') }}" class="btn btn-primary">Beli</a>
                    @endif
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
        
        $("#addCart").click(function(){
            var productId   = $(this).data('productid');
            var userId      = $(this).data('userid');
            var stok        = $(this).data('stok');
            var qty         = $(this).data('qty');

            $.ajax({
                data: {product_id:productId, user_id:userId, qty:qty, stok:stok},
                url: "{{ route('orders.update') }}",
                type:"POST",
                success: function (data) {
                    window.location.href = "{{ route('orders.index') }}";
                }
            })

        });

    </script>

@endsection
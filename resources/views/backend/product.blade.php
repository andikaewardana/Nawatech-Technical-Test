@extends('backend.layout.base')

@section('content')
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18"></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">List Product</li>
                </ol>
            </div>

        </div>
    </div>
    <div class="card border border-primary">
        <div class="card-header bg-transparent border-primary">
            <span class="mb-sm-0 font-size-20 text-primary">List Product</span>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahProduct" style="float: right;"><i class="fas fa-plus"></i></button>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped mb-0" id="dTable">

                    <thead>
                        <tr>
                            <th width="10">No</th>
                            <th>Nama</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th width="110" style="text-align:center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($data as $product)
                        <tr>
                            <th scope="row">{{ $no++ }}</th>
                            <td>{{ $product->nama }}</td>
                            <td>{{ $product->stok }}</td>
                            <td>Rp. {{ $product->harga }}</td>
                            <td>
                                <button type="button" class="btn btn-info getProduct" data-id="{{ $product->id }}" data-bs-toggle="modal" data-bs-target="#editProduct"><i class="fas fa-pen"></i></button>
                                <button type="button" class="btn btn-danger deleteProduct" data-id="{{ $product->id }}"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH -->
    <div class="modal fade" id="tambahProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahProduct" name="formTambahProduct">
                <div class="mb-3">
                    <label class="col-form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama">
                </div>
                <div class="mb-3">
                    <label class="col-form-label">Stok</label>
                    <input type="text" class="form-control" id="stok" name="stok">
                </div>
                <div class="mb-3">
                    <label class="col-form-label">Harga</label>
                    <input type="text" class="form-control" id="harga" name="harga">
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="simpanTambahProduct">Simpan</button>
            </div>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div class="modal fade" id="editProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditProduct" name="formEditProduct">
                <div class="mb-3">
                    <label class="col-form-label">Nama</label>
                    <input type="hidden" name="productId" id="productId">
                    <input type="text" class="form-control" id="editNama" name="nama">
                </div>
                <div class="mb-3">
                    <label class="col-form-label">Stok</label>
                    <input type="text" class="form-control" id="editStok" name="stok">
                </div>
                <div class="mb-3">
                    <label class="col-form-label">Harga</label>
                    <input type="text" class="form-control" id="editHarga" name="harga">
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="simpanEditProduct">Simpan</button>
            </div>
            </div>
        </div>
    </div>
@endsection

@section('scriptBottom')

    <script>

        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });  
            
            // TAMBAH DATA PRODUCT
            $("#simpanTambahProduct").click(function(){
        
                $.ajax({
                    data: $('#formTambahProduct').serialize(),
                    url: "{{ route('product.store') }}",
                    type:"POST",
                    success: function (data) {
                        $('#tambahProduct').modal('hide');
                        location.reload();
                    }
                })
        
            });

            // GET DATA PRODUCT
            $(".getProduct").click(function(){

                var productId = $(this).data('id');

                $.get("{{ route('product.index') }}" +'/' + productId +'/edit', function (data) {
                    $('#productId').val(data.id);
                    $('#editNama').val(data.nama);
                    $('#editStok').val(data.stok);
                    $('#editHarga').val(data.harga);
                })

            });

            // EDIT DATA PRODUCT
            $("#simpanEditProduct").click(function(){

                var id    = $('#productId').val();
        
                $.ajax({
                    data: $('#formEditProduct').serialize(),
                    url: "{{ route('product.store') }}" + '/' + id,
                    type:"PUT",
                    success: function (data) {
                        $('#editProduct').modal('hide');
                        location.reload();
                    }
                })
        
            });

            // DELETE DATA PRODUCT
            $(".deleteProduct").click(function(){

                var id  = $(this).data("id");
                confirm("Apakah Anda Yakin Ingin Menghapusnya?");

                $.ajax({
                    url: "{{ route('product.store') }}" + '/' + id,
                    type:"DELETE",
                    success: function (data) {
                        location.reload();
                    }
                })

            });


        });

        $(document).ready( function () {
            $('#dTable').DataTable();
        } );

    </script>

@endsection


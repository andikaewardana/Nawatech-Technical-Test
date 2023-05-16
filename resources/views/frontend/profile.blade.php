@extends('frontend.layout.base')

@section('content')
    @if($message = Session::get('success'))
        <div class="alert alert-success">
            {{ $message }}
        </div>
    @endif
    <div class="card">
        <!-- <img class="card-img-top" src="../bootstrap4/img_avatar1.png" alt="Card image" style="width:100%"> -->
        <div class="card-header">
            <p>Profile</p>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('profile.edit') }}" enctype="multipart/form-data">
            @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="hidden" class="form-control" id="id" name="id" value="{{ $dataUser->id }}">
                    <input type="text" class="form-control" id="name" name="name" value="{{ $dataUser->name }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" value="{{ $dataUser->email }}">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <img src="{{ url('images') }}/{{ $dataUser->picture }}" >
                <div class="mb-3">
                    <label class="form-label">Foto</label>
                    <input class="form-control" type="file" name="image">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

@endsection


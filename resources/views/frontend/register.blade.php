@extends('frontend.layout.base')

@section('content')
    <div class="card">
        <!-- <img class="card-img-top" src="../bootstrap4/img_avatar1.png" alt="Card image" style="width:100%"> -->
        <div class="card-header">
            <p>Register</p>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('register.perform') }}" enctype="multipart/form-data">
            @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="email" aria-describedby="emailHelp" name="name">
                    @if($errors->has('name'))
						<span class="text-danger">{{ $errors->first('name') }}</span>
					@endif
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email">
                    @if($errors->has('email'))
						<span class="text-danger">{{ $errors->first('email') }}</span>
					@endif
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    @if($errors->has('password'))
						<span class="text-danger">{{ $errors->first('password') }}</span>
					@endif
                </div>
                <div class="mb-3">
                    <label class="form-label">Foto</label>
                    <input class="form-control" type="file" name="image">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

@endsection


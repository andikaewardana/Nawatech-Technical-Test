<nav class="navbar navbar-expand-sm navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Nawatech</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="mynavbar">
        @if (Auth::check())
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown" style="margin-right: 100px;">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <img src="{{ url('images/') }}/{{ auth()->user()->picture }}" alt="Logo" style="width:40px;height: 40px;object-fit: cover;" class="rounded-pill">
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('profile.index') }}">Profile</a></li>
                    <li><a class="dropdown-item" href="{{ route('orders.index') }}">My Order</a></li>
                    <li><a class="dropdown-item" href="{{ route('logout.perform') }}">Logout</a></li>
                </ul>
            </li>
        </ul>
        @else
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register.show') }}">Register</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login.show') }}">Login</a>
            </li>
        </ul>
        @endif
    </div>
  </div>
</nav>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Nawatech</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  @include('frontend.layout.header')

  <div class="container-md mt-3">
      <div class="row">
          @yield('content')
      </div>
  </div>

  <script src="{{ url('assets/libs/jquery/jquery.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  @yield('scriptBottom')
</body>
</html>



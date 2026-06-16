<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet">

    <title>PROTRACK</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
          rel="stylesheet">

    <style>

        body{
            background:#f7fbff;
            font-family:'Segoe UI',sans-serif;
        }

        .navbar{

            background:
            linear-gradient(
                90deg,
                #8EC5FC,
                #F8BBD9
            ) !important;
        }

        .navbar-brand,
        .nav-link{

            color:white !important;
            font-weight:600;
        }

        .card{

            border:none;

            border-radius:20px;

            box-shadow:
            0 4px 20px rgba(0,0,0,.05);
        }

        .btn-primary{

            background:#8EC5FC;
            border:none;
        }

        .btn-primary:hover{

            background:#78b8fa;
        }

        .btn-pink{

            background:#F8BBD9;
            border:none;
        }

        .btn-pink:hover{

            background:#f4a8cc;
        }

    </style>

</head>

<body>

@if(Auth::check())

<div id="app">

    <nav class="navbar navbar-expand-md shadow-sm">

        ...

    </nav>

    <main class="py-4">

        @yield('content')

    </main>

</div>

@else

@yield('content')

@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>PROTRACK</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
          rel="stylesheet">

    <style>

        body{
            background:#f7fbff;
            margin:0;
            font-family:'Segoe UI',sans-serif;
        }

        .sidebar{

            width:250px;

            height:100vh;

            position:fixed;

            left:0;

            top:0;

            background:
            linear-gradient(
                180deg,
                #8EC5FC 0%,
                #F8BBD9 100%
            );

            color:white;
        }

        .sidebar-header{

            text-align:center;

            padding:25px;
        }

        .sidebar-header h3{

            margin:0;

            font-weight:700;
        }

        .sidebar-menu{

            padding:15px;
        }

        .sidebar-menu a{

            display:block;

            color:white;

            text-decoration:none;

            padding:12px 15px;

            border-radius:10px;

            margin-bottom:8px;

            transition:.3s;
        }

        .sidebar-menu a:hover{

            background:
            rgba(255,255,255,.2);
        }

        .content{

            margin-left:250px;

            min-height:100vh;
        }

        .topbar{

            background:white;

            padding:20px;

            display:flex;

            justify-content:space-between;

            align-items:center;

            box-shadow:
            0 2px 10px rgba(0,0,0,.05);
        }

        .page-content{

            padding:20px 30px;
        }

        .card-modern{

            border:none;

            border-radius:20px;

            box-shadow:
            0 4px 20px rgba(0,0,0,.05);
        }

        .dashboard-card{
            transition:.25s;
            cursor:pointer;
            border-radius:20px;
        }

        .dashboard-card:hover{
            transform:translateY(-5px);
            box-shadow:0 10px 25px rgba(0,0,0,.1);
        }

        .progress{
            height:22px;
            border-radius:15px;
        }

        .progress-bar{
            background:
            linear-gradient(
                90deg,
                #8EC5FC,
                #F8BBD9
            );

            font-size:12px;
            font-weight:600;
        }

        .deadline-warning{
            color:#dc3545;
            font-weight:600;
        }

        th a{
            text-decoration:none;
            color:#333;
            font-weight:600;
        }

        th a:hover{
            color:#e91e63;
        }

    </style>

</head>

<body>

<div class="sidebar">

    <div class="sidebar-header">

        <h3>PROTRACK</h3>

        <small>

            Monitoring Produksi

        </small>

    </div>

    <div class="sidebar-menu">

        @php
            $role = Auth::user()->role;
        @endphp

        <a href="/{{ $role }}">

            <i class="bi bi-speedometer2"></i>

            Dashboard

        </a>

        <a href="#"
           onclick="
           event.preventDefault();
           document.getElementById('logout-form').submit();
           ">

            <i class="bi bi-box-arrow-right"></i>

            Logout

        </a>

        <form
            id="logout-form"
            action="{{ route('logout') }}"
            method="POST"
            style="display:none;"
        >
            @csrf
        </form>

    </div>

</div>

<div class="content">

    <div class="page-content">

        @if(session('success'))

            <div class="alert alert-success">

                {{ session('success') }}

            </div>

        @endif

        @if(session('error'))

            <div class="alert alert-danger">

                {{ session('error') }}

            </div>

        @endif

        @yield('content')

    </div>

</div>

    @stack('scripts')
</body>

</html>
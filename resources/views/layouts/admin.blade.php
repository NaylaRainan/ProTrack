<!DOCTYPE html>

<html lang="en">

<head>

```
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
        margin:0;
        background:#f7fbff;
        font-family:'Segoe UI',sans-serif;
    }

    .sidebar{

        width:260px;

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

        overflow-y:auto;

        box-shadow:
        0 0 20px rgba(0,0,0,.08);
    }

    .sidebar-header{

        text-align:center;

        padding:30px 20px;

        color:white;
    }

    .sidebar-header h2{

        font-weight:700;

        margin:0;
    }

    .sidebar-menu{

        padding:10px;
    }

    .sidebar-menu a{

        display:block;

        color:white;

        text-decoration:none;

        padding:12px 18px;

        border-radius:12px;

        margin-bottom:8px;

        transition:.3s;
    }

    .sidebar-menu a:hover{

        background:
        rgba(255,255,255,.25);

        padding-left:24px;
    }

    .main-content{

        margin-left:260px;

        min-height:100vh;
    }

    .topbar{

        background:white;

        padding:18px 30px;

        box-shadow:
        0 2px 10px rgba(0,0,0,.05);

        display:flex;

        justify-content:space-between;

        align-items:center;
    }

    .page-content{

        padding:30px;
    }

    .card-modern{

        border:none;

        border-radius:20px;

        background:white;

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

        color:#444;
    }

    .btn-pink:hover{

        background:#f5aacd;
    }

    .table{

        background:white;
    }

</style>
```

</head>

<body>

<div class="sidebar">

```
<div class="sidebar-header">

    <h2>PROTRACK</h2>

    <small>
        Monitoring Produksi
    </small>

</div>

<div class="sidebar-menu">

    <a href="/admin">

        <i class="bi bi-speedometer2"></i>

        Dashboard

    </a>

    <a href="/spk">

        <i class="bi bi-folder2-open"></i>

        Data SPK

    </a>

    <a href="/import-xml">

        <i class="bi bi-upload"></i>

        Import XML

    </a>

    <hr class="text-white">

    <a href="/develop">

        <i class="bi bi-gear"></i>

        Develop

    </a>

    <a href="/offset">

        <i class="bi bi-printer"></i>

        Offset

    </a>

    <a href="/plotter">

        <i class="bi bi-bounding-box"></i>

        Plotter

    </a>

    <a href="/uv">

        <i class="bi bi-droplet"></i>

        UV

    </a>

    <a href="/finishing">

        <i class="bi bi-check2-square"></i>

        Finishing

    </a>

    <hr class="text-white">

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
```

</div>

<div class="main-content">

```
<div class="topbar">

    <h5 class="mb-0">

        Sistem Monitoring Produksi

    </h5>

    <div>

        {{ Auth::user()->name }}

    </div>

</div>

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
```

</div>

</body>

</html>

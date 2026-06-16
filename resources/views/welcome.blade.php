<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>PROTRACK</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        body{

            margin:0;

            font-family:'Segoe UI',sans-serif;

            background:
            linear-gradient(
                135deg,
                #8EC5FC 0%,
                #F8BBD9 100%
            );

            min-height:100vh;
        }

        .hero{

            min-height:100vh;

            display:flex;

            align-items:center;

            justify-content:center;
        }

        .hero-card{

            background:white;

            border-radius:30px;

            padding:60px;

            box-shadow:
            0 10px 40px rgba(0,0,0,.15);

            text-align:center;

            max-width:900px;
        }

        .hero-title{

            font-size:60px;

            font-weight:700;

            color:#4a4a4a;
        }

        .hero-subtitle{

            color:#777;

            font-size:20px;

            margin-top:15px;
        }

        .btn-login{

            background:#8EC5FC;

            border:none;

            color:white;

            padding:12px 30px;

            border-radius:15px;

            font-weight:600;
        }

        .btn-login:hover{

            background:#79b8fb;

            color:white;
        }

        .btn-register{

            background:#F8BBD9;

            border:none;

            color:#444;

            padding:12px 30px;

            border-radius:15px;

            font-weight:600;
        }

        .btn-register:hover{

            background:#f4a9cc;

            color:#444;
        }

        .feature-box{

            padding:20px;

            border-radius:20px;

            background:#f9fbff;

            margin-top:20px;
        }

        .emoji{

            font-size:50px;
        }

    </style>

</head>

<body>

<div class="container">

    <div class="hero">

        <div class="hero-card">

            <div class="emoji">

                📋

            </div>

            <h1 class="hero-title">

                PROTRACK

            </h1>

            <p class="hero-subtitle">

                Sistem Monitoring Produksi Percetakan

            </p>

            <hr>

            <div class="row">

                <div class="col-md-4">

                    <div class="feature-box">

                        <h5>

                            Monitoring SPK

                        </h5>

                        <p>

                            Pantau seluruh SPK secara realtime.

                        </p>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="feature-box">

                        <h5>

                            Tracking Produksi

                        </h5>

                        <p>

                            Cek progres tiap departemen dengan mudah.

                        </p>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="feature-box">

                        <h5>

                            Deadline Alert

                        </h5>

                        <p>

                            Notifikasi otomatis untuk SPK mendekati deadline.

                        </p>

                    </div>

                </div>

            </div>

            <div class="mt-5">

                @if (Route::has('login'))

                    @auth

                        <a
                            href="/home"
                            class="btn btn-login"
                        >

                            Dashboard

                        </a>

                    @else

                        <a
                            href="{{ route('login') }}"
                            class="btn btn-login"
                        >

                            Login

                        </a>

                        @if (Route::has('register'))

                            <a
                                href="{{ route('register') }}"
                                class="btn btn-register ms-2"
                            >

                                Register

                            </a>

                        @endif

                    @endauth

                @endif

            </div>

            <div class="mt-4 text-muted">

                PROTRACK © {{ date('Y') }}

            </div>

        </div>

    </div>

</div>

</body>

</html>
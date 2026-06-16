@extends('layouts.app')

@section('content')

<style>

body{
    min-height:100vh;
    background:
    linear-gradient(
        135deg,
        #8EC5FC 0%,
        #F8BBD9 100%
    );
}

.auth-card{

    background:white;

    border:none;

    border-radius:25px;

    padding:40px;

    box-shadow:
    0 15px 40px rgba(0,0,0,.15);
}

.logo-circle{

    width:90px;

    height:90px;

    border-radius:50%;

    background:#8EC5FC;

    color:white;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:40px;

    margin:auto;
    margin-bottom:20px;
}

.btn-login{

    background:#8EC5FC;

    border:none;

    border-radius:12px;

    padding:10px;

    font-weight:600;
}

.btn-login:hover{

    background:#7ab8fb;
}

.form-control{

    border-radius:12px;
}

.title{

    font-weight:700;
}

.subtitle{

    color:#777;
}

</style>


<div class="container">

    <div class="row min-vh-100 justify-content-center align-items-center">

        <div class="col-lg-10">

            <div class="auth-card">

                <div class="row align-items-center">

                    <!-- KIRI -->
                    <div class="col-md-6 text-center p-5">

                        <div class="logo-circle">
                            📋
                        </div>

                        <h1 class="title">
                            PROTRACK
                        </h1>

                        <p class="subtitle">
                            Sistem Monitoring Produksi Percetakan
                        </p>

                    </div>

                    <!-- KANAN -->
                    <div class="col-md-6 p-5">

                        <h3 class="mb-4 text-center">
                            Login
                        </h3>

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form method="POST"
                              action="{{ route('login') }}">

                            @csrf

                            <div class="mb-3">

                                <label>Email</label>

                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="form-control"
                                    required>

                            </div>

                            <div class="mb-3">

                                <label>Password</label>

                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    required>

                            </div>

                            <div class="form-check mb-3">

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="remember">

                                <label class="form-check-label">
                                    Remember Me
                                </label>

                            </div>

                            <button
                                type="submit"
                                class="btn btn-login text-white w-100">

                                Login

                            </button>

                        </form>

                        <div class="text-center mt-4">

                            Belum punya akun?

                            <a href="{{ route('register') }}"
                               class="fw-bold text-decoration-none">

                                Daftar

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
@endsection

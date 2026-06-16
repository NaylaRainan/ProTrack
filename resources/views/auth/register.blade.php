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

.register-card{

    border:none;

    border-radius:25px;

    overflow:hidden;

    box-shadow:
    0 10px 40px rgba(0,0,0,.15);
}

.register-left{

    background:
    linear-gradient(
        180deg,
        #8EC5FC,
        #B9E0FF
    );

    color:white;

    display:flex;

    justify-content:center;

    align-items:center;

    flex-direction:column;

    padding:50px;
}

.register-left h1{

    font-weight:700;

    margin-bottom:10px;
}

.register-left p{

    text-align:center;

    opacity:.9;
}

.register-right{

    background:white;

    padding:50px;
}

.form-control{

    border-radius:12px;
}

.btn-register{

    background:#8EC5FC;

    border:none;

    border-radius:12px;

    font-weight:600;

    padding:10px;
}

.btn-register:hover{

    background:#79b8fb;
}

.logo-circle{

    width:90px;

    height:90px;

    border-radius:50%;

    background:white;

    color:#8EC5FC;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:40px;

    margin-bottom:20px;
}

</style>

<div class="container">

    <div
        class="row justify-content-center align-items-center"
        style="min-height:90vh;"
    >

        <div class="col-lg-10">

            <div class="card register-card">

                <div class="row g-0">

                    <div class="col-md-5 register-left">

                        <div class="logo-circle">

                            👤

                        </div>

                        <h1>PROTRACK</h1>

                        <p>

                            Sistem Monitoring Produksi
                            Percetakan

                        </p>

                    </div>

                    <div class="col-md-7 register-right">

                        <h3 class="mb-4">

                            Register User

                        </h3>

                        <form
                            method="POST"
                            action="{{ route('register') }}"
                        >

                            @csrf

                            <div class="mb-3">

                                <label>

                                    Nama

                                </label>

                                <input
                                    id="name"
                                    type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                >

                                @error('name')

                                <span class="invalid-feedback">

                                    <strong>

                                        {{ $message }}

                                    </strong>

                                </span>

                                @enderror

                            </div>

                            <div class="mb-3">

                                <label>

                                    Email

                                </label>

                                <input
                                    id="email"
                                    type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                >

                                @error('email')

                                <span class="invalid-feedback">

                                    <strong>

                                        {{ $message }}

                                    </strong>

                                </span>

                                @enderror

                            </div>

                            <div class="mb-3">

                                <label>

                                    Password

                                </label>

                                <input
                                    id="password"
                                    type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password"
                                    required
                                >

                                @error('password')

                                <span class="invalid-feedback">

                                    <strong>

                                        {{ $message }}

                                    </strong>

                                </span>

                                @enderror

                            </div>

                            <div class="mb-3">

                                <label>

                                    Konfirmasi Password

                                </label>

                                <input
                                    id="password-confirm"
                                    type="password"
                                    class="form-control"
                                    name="password_confirmation"
                                    required
                                >

                            </div>

                            <div class="mb-3">

                                <label>Role</label>

                                <select
                                    name="role"
                                    class="form-control"
                                    required
                                >

                                    <option value="admin">
                                        Admin
                                    </option>

                                    <option value="develop">
                                        Develop
                                    </option>

                                    <option value="offset">
                                        Offset
                                    </option>

                                    <option value="plotter">
                                        Plotter
                                    </option>

                                    <option value="uv">
                                        UV
                                    </option>

                                    <option value="finishing">
                                        Finishing
                                    </option>

                                </select>

                            </div>
                            <button
                                type="submit"
                                class="btn btn-register text-white w-100"
                            >

                                Register

                            </button>

                        </form>

                        <hr>

                        <div
                            class="text-center text-muted"
                        >

                            PROTRACK © {{ date('Y') }}

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
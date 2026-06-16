@extends('layouts.admin')

@section('content')

<div class="container-fluid">

<div class="row justify-content-center">

    <div class="col-lg-8">

        <div class="card card-modern">

            <div class="card-body p-4">

                <div class="text-center mb-4">

                    <h2 class="fw-bold">

                        Import XML Accurate

                    </h2>

                    <p class="text-muted">

                        Upload file XML dari Accurate untuk membuat SPK otomatis

                    </p>

                </div>

                @if(session('success'))

                    <div class="alert alert-success">

                        <i class="bi bi-check-circle-fill"></i>

                        {{ session('success') }}

                    </div>

                @endif

                @if(session('error'))

                    <div class="alert alert-danger">

                        <i class="bi bi-exclamation-triangle-fill"></i>

                        {{ session('error') }}

                    </div>

                @endif

                @if($errors->any())

                    <div class="alert alert-danger">

                        <ul class="mb-0">

                            @foreach($errors->all() as $error)

                                <li>

                                    {{ $error }}

                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif

                <form
                    action="/import-xml"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf

                    <div class="mb-4">

                        <label class="form-label fw-bold">

                            Pilih File XML

                        </label>

                        <input
                            type="file"
                            name="xml_file"
                            class="form-control"
                            accept=".xml"
                            required>

                        <small class="text-muted">

                            Format file harus XML hasil export Accurate.

                        </small>

                    </div>

                    <div class="d-grid">

                        <button
                            type="submit"
                            class="btn btn-primary btn-lg">

                            <i class="bi bi-upload"></i>

                            Import XML

                        </button>

                    </div>

                </form>

            </div>

        </div>

        <div class="card card-modern mt-4">

            <div class="card-body">

                <h5 class="fw-bold mb-3">

                    Petunjuk Import

                </h5>

                <ol>

                    <li>
                        Export Delivery Order dari Accurate ke format XML.
                    </li>

                    <li>
                        Upload file XML melalui form di atas.
                    </li>

                    <li>
                        Sistem akan membuat Customer otomatis jika belum ada.
                    </li>

                    <li>
                        Sistem akan membuat SPK beserta detail item produksi.
                    </li>

                    <li>
                        Departemen akan ditentukan berdasarkan deskripsi pekerjaan.
                    </li>

                </ol>

            </div>

        </div>

    </div>

</div>

</div>

@endsection

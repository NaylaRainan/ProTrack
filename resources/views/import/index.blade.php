@extends('layouts.admin')

@section('content')

<div class="container">

    <h2>Import XML Accurate</h2>

    {{-- 🔥 FLASH MESSAGE DI SINI --}}
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

    <form action="/import-xml" method="POST" enctype="multipart/form-data">

        @csrf

        <div class="mb-3">
            <label>Pilih File XML</label>

            <input
                type="file"
                name="xml_file"
                class="form-control"
                accept=".xml"
                required>
        </div>

        <button type="submit" class="btn btn-primary">
            Import XML
        </button>

    </form>

</div>

@endsection
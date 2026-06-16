@extends('layouts.admin')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold">
            Tambah SPK
        </h2>

        <p class="text-muted mb-0">
            Buat Surat Perintah Kerja baru
        </p>

    </div>

</div>

<form action="/spk/store" method="POST">

    @csrf

    <div class="card card-modern mb-4">

        <div class="card-body">

            <h5 class="mb-3">
                Informasi SPK
            </h5>

            <div class="row">

                <div class="col-md-4 mb-3">

                    <label class="form-label">

                        Nomor SPK

                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="Otomatis dibuat sistem"
                        readonly>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="form-label">

                        Customer

                    </label>

                    <select
                        name="customer_id"
                        class="form-control"
                        required>

                        @foreach($customers as $customer)

                            <option
                                value="{{ $customer->id }}">

                                {{ $customer->nama_customer }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="form-label">

                        Departemen

                    </label>

                    <select
                        name="production_department_id"
                        class="form-control"
                        required>

                        @foreach($departments as $department)

                            <option
                                value="{{ $department->id }}">

                                {{ $department->nama_bagian }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="row">

                <div class="col-md-4 mb-3">

                    <label class="form-label">

                        Tanggal SPK

                    </label>

                    <input
                        type="date"
                        name="tanggal_spk"
                        value="{{ date('Y-m-d') }}"
                        class="form-control">

                </div>

                <div class="col-md-4 mb-3">

                    <label class="form-label">

                        Deadline

                    </label>

                    <input
                        type="date"
                        name="deadline_date"
                        min="{{ date('Y-m-d') }}"
                        class="form-control">

                </div>

                <div class="col-md-4 mb-3">

                    <label class="form-label">

                        Prioritas

                    </label>

                    <select
                        name="priority"
                        class="form-control">

                        <option value="normal">

                            Normal

                        </option>

                        <option value="high">

                            High

                        </option>

                        <option value="urgent">

                            Urgent

                        </option>

                    </select>

                </div>

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Keterangan

                </label>

                <textarea
                    name="keterangan"
                    rows="3"
                    class="form-control"></textarea>

            </div>

        </div>

    </div>

    <div class="card card-modern">

        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">

                <h5>
                    Detail Item Produksi
                </h5>

                <button
                    type="button"
                    class="btn btn-pink"
                    onclick="tambahDetail()">

                    + Tambah Item

                </button>

            </div>

            <div id="detail-container">

                <div class="detail-item border rounded p-3 mb-3">

                    <div class="row">

                        <div class="col-md-3">  
                            <label class="form-label">Nama File</label>
                            <input
                                type="text"
                                name="nama_file[]"
                                class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Bahan</label>
                            <input
                                type="text"
                                name="bahan[]"
                                class="form-control">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Finishing</label>
                            <input
                                type="text"
                                name="finishing[]"
                                class="form-control">
                        </div>

                        <div class="col-md-1">
                            <label class="form-label">Panjang</label>
                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="panjang[]"
                                class="form-control">
                        </div>

                        <div class="col-md-1">
                            <label class="form-label">Lebar</label>
                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="lebar[]"
                                class="form-control">
                        </div>

                        <div class="col-md-1">
                            <label class="form-label">Qty</label>
                            <input
                                type="number"
                                name="qty[]"
                                min="1"
                                value="1"
                                class="form-control">
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="mt-4">

        <button
            type="submit"
            class="btn btn-primary">

            Simpan SPK

        </button>

        <a
            href="/spk"
            class="btn btn-secondary">

            Kembali

        </a>

    </div>

</form>

</div>

<script>

function tambahDetail()
{
    let html = `

    <div class="detail-item border rounded p-3 mb-3">

        <div class="row">

            <div class="col-md-3">
                <label class="form-label">Nama File</label>
                <input
                    type="text"
                    name="nama_file[]"
                    class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label">Bahan</label>
                <input
                    type="text"
                    name="bahan[]"
                    class="form-control">
            </div>

            <div class="col-md-2">
                <label class="form-label">Finishing</label>
                <input
                    type="text"
                    name="finishing[]"
                    class="form-control">
            </div>

            <div class="col-md-1">
                <label class="form-label">Panjang</label>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    name="panjang[]"
                    class="form-control">
            </div>

            <div class="col-md-1">
                <label class="form-label">Lebar</label>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    name="lebar[]"
                    class="form-control">
            </div>

            <div class="col-md-1">
                <label class="form-label">Qty</label>
                <input
                    type="number"
                    name="qty[]"
                    min="1"
                    value="1"
                    class="form-control">
            </div>

        </div>
    
    </div>
    
    </div>

        <button
            type="button"
            class="btn btn-danger btn-sm mt-2"
            onclick="this.parentElement.remove()">

            Hapus Item

        </button>

    </div>

    `;

    document
        .getElementById('detail-container')
        .insertAdjacentHTML(
            'beforeend',
            html
        );
}

</script>

@endsection

@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Tambah SPK</h2>

    <form action="/spk/store" method="POST">

        @csrf

        <input
            type="text"
            class="form-control"
            value="SPK/26/06/0001"
            readonly
        >

        <div class="mb-3">

            <label>Customer</label>

            <select
                name="customer_id"
                class="form-control"
            >

                @foreach($customers as $customer)

                    <option
                        value="{{ $customer->id }}"
                    >
                        {{ $customer->nama_customer }}
                    </option>

                @endforeach

            </select>

        </div>

        <div class="mb-3">

            <label>Departemen</label>

            <select
                name="production_department_id"
                class="form-control"
            >

                @foreach($departments as $department)

                    <option
                        value="{{ $department->id }}"
                    >
                        {{ $department->nama_bagian }}
                    </option>

                @endforeach

            </select>

        </div>

        <div class="mb-3">

            <label>Tanggal SPK</label>

            <input
                type="date"
                name="tanggal_spk"
                class="form-control"
                value="{{ date('Y-m-d') }}"
            >

        </div>

        <div class="mb-3">

            <label>Deadline</label>

            <input
                type="date"
                name="deadline_date"
                class="form-control"
            >

        </div>

        <div class="mb-3">

            <label>Priority</label>

            <select
                name="priority"
                class="form-control"
            >

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

        <div class="mb-3">

            <label>Keterangan</label>

            <textarea
                name="keterangan"
                class="form-control"
                rows="3"
            ></textarea>

        </div>

        <hr>

        <h4>Detail Pekerjaan</h4>

        <div class="mb-3">

            <label>Nama File</label>

            <input
                type="text"
                name="nama_file"
                class="form-control"
            >

        </div>

        <div class="mb-3">

            <label>Bahan</label>

            <input
                type="text"
                name="bahan"
                class="form-control"
            >

        </div>

        <div class="row">

            <div class="col-md-3">

                <label>Panjang</label>

                <input
                    type="number"
                    name="panjang"
                    class="form-control"
                >

            </div>

            <div class="col-md-3">

                <label>Lebar</label>

                <input
                    type="number"
                    name="lebar"
                    class="form-control"
                >

            </div>

            <div class="col-md-3">

                <label>Qty</label>

                <input
                    type="number"
                    name="qty"
                    class="form-control"
                >

            </div>

            <div class="col-md-3">

                <label>Finishing</label>

                <input
                    type="text"
                    name="finishing"
                    class="form-control"
                >

            </div>

        <hr>

        <h4>Detail Item Produksi</h4>

        <div id="detail-container">

            <div class="detail-item border p-3 mb-2">

                <input
                    type="text"
                    name="nama_file[]"
                    class="form-control mb-2"
                    placeholder="Nama File"
                >

                <input
                    type="text"
                    name="bahan[]"
                    class="form-control mb-2"
                    placeholder="Bahan"
                >

                <input
                    type="number"
                    name="panjang[]"
                    class="form-control mb-2"
                    placeholder="Panjang"
                >

                <input
                    type="number"
                    name="lebar[]"
                    class="form-control mb-2"
                    placeholder="Lebar"
                >

                <input
                    type="number"
                    name="qty[]"
                    class="form-control mb-2"
                    placeholder="Qty"
                >

                <input
                    type="text"
                    name="finishing[]"
                    class="form-control mb-2"
                    placeholder="Finishing"
                >

            </div>

        </div>

        <button
            type="button"
            class="btn btn-info mb-3"
            onclick="tambahDetail()"
        >
            + Tambah Item
        </button>

        </div>
        <button
            type="submit"
            class="btn btn-primary"
        >
            Simpan
        </button>

    </form>

</div>

<script>

function tambahDetail()
{
    let html = `

    <div class="detail-item border p-3 mb-2">

        <input type="text"
               name="nama_file[]"
               class="form-control mb-2"
               placeholder="Nama File">

        <input type="text"
               name="bahan[]"
               class="form-control mb-2"
               placeholder="Bahan">

        <input type="number"
               name="panjang[]"
               class="form-control mb-2"
               placeholder="Panjang">

        <input type="number"
               name="lebar[]"
               class="form-control mb-2"
               placeholder="Lebar">

        <input type="number"
               name="qty[]"
               class="form-control mb-2"
               placeholder="Qty">

        <input type="text"
               name="finishing[]"
               class="form-control mb-2"
               placeholder="Finishing">

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


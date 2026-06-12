@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Edit SPK</h2>

    <form action="/spk/{{ $spk->id }}/update"
          method="POST">

        @csrf

        <div class="mb-3">

            <label>No SPK</label>

            <input
                type="text"
                class="form-control"
                value="{{ $spk->no_spk }}"
                readonly>

        </div>

        <div class="mb-3">

            <label>Deadline</label>

            <input
                type="date"
                name="deadline_date"
                class="form-control"
                value="{{ $spk->deadline_date }}">

        </div>

        <div class="mb-3">

            <label>Priority</label>

            <select
                name="priority"
                class="form-control">

                <option value="normal"
                {{ $spk->priority == 'normal' ? 'selected' : '' }}>
                    Normal
                </option>

                <option value="high"
                {{ $spk->priority == 'high' ? 'selected' : '' }}>
                    High
                </option>

                <option value="urgent"
                {{ $spk->priority == 'urgent' ? 'selected' : '' }}>
                    Urgent
                </option>

            </select>

        </div>

        <hr>

        <h4>Detail Item</h4>

        @foreach($spk->details as $detail)

        <div class="card mb-3">

            <div class="card-body">

                <input
                    type="hidden"
                    name="detail_id[]"
                    value="{{ $detail->id }}"
                >

                <div class="row">

                    <div class="col-md-4">

                        <label>Nama File</label>

                        <input
                            type="text"
                            name="nama_file[]"
                            value="{{ $detail->nama_file }}"
                            class="form-control"
                        >

                    </div>

                    <div class="col-md-3">

                        <label>Bahan</label>

                        <input
                            type="text"
                            name="bahan[]"
                            value="{{ $detail->bahan }}"
                            class="form-control"
                        >

                    </div>

                    <div class="col-md-2">

                        <label>Qty</label>

                        <input
                            type="number"
                            name="qty[]"
                            value="{{ $detail->qty }}"
                            class="form-control"
                        >

                    </div>

                    <div class="col-md-3">

                        <label>Finishing</label>

                        <input
                            type="text"
                            name="finishing[]"
                            value="{{ $detail->finishing }}"
                            class="form-control"
                        >

                    </div>

                </div>

            </div>

        </div>

        <div class="mt-2">

            <a
                href="{{ route('spk.detail.delete',$detail->id) }}"
                class="btn btn-danger btn-sm"
                onclick="return confirm('Hapus item ini?')"
            >
                Hapus Item
            </a>

        </div>

        <button
            type="button"
            class="btn btn-success mb-3"
            onclick="tambahItem()"
        >
            + Tambah Item
        </button>

        <div id="itemBaru"></div>

        @endforeach
        
        <button
            type="submit"
            class="btn btn-primary">
            Simpan
        </button>

    </form>

</div>

<script>

function tambahItem()
{
    let html = `

    <div class="card mb-3">

        <div class="card-body">

            <div class="row">

                <div class="col-md-4">
                    <label>Nama File</label>
                    <input type="text"
                           name="new_nama_file[]"
                           class="form-control">
                </div>

                <div class="col-md-3">
                    <label>Bahan</label>
                    <input type="text"
                           name="new_bahan[]"
                           class="form-control">
                </div>

                <div class="col-md-2">
                    <label>Qty</label>
                    <input type="number"
                           name="new_qty[]"
                           class="form-control">
                </div>

                <div class="col-md-3">
                    <label>Finishing</label>
                    <input type="text"
                           name="new_finishing[]"
                           class="form-control">
                </div>

            </div>

        </div>

    </div>
    `;

    document
        .getElementById('itemBaru')
        .insertAdjacentHTML(
            'beforeend',
            html
        );
}

</script>

@endsection
@extends('layouts.admin')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold">
            Edit SPK
        </h2>

        <p class="text-muted mb-0">

            {{ $spk->no_spk }}

        </p>

    </div>

    <a
        href="/spk?{{ request()->getQueryString() }}"
        class="btn btn-secondary">

        Kembali

    </a>

</div>

<form
    action="/spk/{{ $spk->id }}/update"
    method="POST">

    @csrf

    <input
        type="hidden"
        name="redirect_query"
        value="{{ http_build_query(request()->query()) }}">

    <div class="card card-modern mb-4">

        <div class="card-body">

            <h5 class="mb-3">

                Informasi SPK

            </h5>

            <div class="row">

                <div class="col-md-4 mb-3">

                    <label class="form-label">

                        No SPK

                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $spk->no_spk }}"
                        readonly>

                </div>

                <div class="col-md-4 mb-3">

                    <label class="form-label">

                        Deadline

                    </label>

                    <input
                        type="date"
                        name="deadline_date"
                        id="deadline_date"
                        class="form-control"
                        value="{{ $spk->deadline_date }}">

                </div>

                <div class="col-md-4 mb-3">

                    <label class="form-label">

                        Priority

                    </label>

                    <select
                        name="priority"
                        id="priority"
                        class="form-control">

                        <option
                            value="normal"
                            {{ $spk->priority == 'normal' ? 'selected' : '' }}>

                            Normal

                        </option>

                        <option
                            value="high"
                            {{ $spk->priority == 'high' ? 'selected' : '' }}>

                            High

                        </option>

                        <option
                            value="urgent"
                            {{ $spk->priority == 'urgent' ? 'selected' : '' }}>

                            Urgent

                        </option>

                    </select>

                </div>

            </div>

        </div>

    </div>

    <div class="card card-modern mb-4">

        <div class="card-body">

            <h5 class="mb-3">

                Detail Item Produksi

            </h5>

            @foreach($spk->details as $detail)

            <div class="border rounded p-3 mb-3">

                <input
                    type="hidden"
                    name="detail_id[]"
                    value="{{ $detail->id }}">

                <div class="row">
                    
                    <div class="col-md-3">
                        <label class="form-label">Nama File</label>
                        <input
                            type="text"
                            name="nama_file[]"
                            value="{{ $detail->nama_file }}"
                            class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Bahan</label>
                        <input
                            type="text"
                            name="bahan[]"
                            value="{{ $detail->bahan }}"
                            class="form-control">
                    </div>

                    <div class="col-md-1">
                        <label class="form-label">Panjang</label>
                        <input
                            type="number"
                            step="0.01"
                            name="panjang[]"
                            value="{{ $detail->panjang }}"
                            class="form-control">
                    </div>

                    <div class="col-md-1">
                        <label class="form-label">Lebar</label>
                        <input
                            type="number"
                            step="0.01"
                            name="lebar[]"
                            value="{{ $detail->lebar }}"
                            class="form-control">
                    </div>

                    <div class="col-md-1">
                        <label class="form-label">Qty</label>
                        <input
                            type="number"
                            name="qty[]"
                            value="{{ $detail->qty }}"
                            class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Finishing</label>
                        <input
                            type="text"
                            name="finishing[]"
                            value="{{ $detail->finishing }}"
                            class="form-control">
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                        <button
                            type="button"
                            class="btn btn-danger w-100"
                            onclick="hapusDetail({{ $detail->id }})">
                            Hapus
                        </button>
                    </div>

                </div>

                    <div class="col-md-2 d-flex align-items-end">

                </div>

            </div>

            @endforeach

        </div>

    </div>

    <div class="card card-modern mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h5 class="mb-0">

                    Tambah Item Baru

                </h5>

                <button
                    type="button"
                    class="btn btn-pink"
                    onclick="tambahItem()">

                    + Tambah Item

                </button>

            </div>

            <div id="itemBaru"></div>

        </div>

    </div>

    <button
        type="submit"
        class="btn btn-primary">

        Simpan Perubahan

    </button>

</form>

<form
    id="deleteForm"
    method="POST"
    style="display:none;">

    @csrf

</form>

</div>

<script>

function tambahItem()
{
    let html = `

    <div class="border rounded p-3 mb-3">

        <div class="row">

            <div class="col-md-3">
                <label class="form-label">Nama File</label>
                <input
                    type="text"
                    name="new_nama_file[]"
                    class="form-control">

            </div>

            <div class="col-md-3">
                <label class="form-label">Bahan</label>
                <input
                    type="text"
                    name="new_bahan[]"
                    class="form-control">

            </div>

            <div class="col-md-1">
                <label class="form-label">Panjang</label>
                <input
                    type="number"
                    step="0.01"
                    name="new_panjang[]"
                    class="form-control">

            </div>

            <div class="col-md-1">
                <label class="form-label">Lebar</label>
                <input
                    type="number"
                    step="0.01"
                    name="new_lebar[]"
                    class="form-control">

            </div>

            <div class="col-md-1">
                <label class="form-label">Qty</label>
                <input
                    type="number"
                    name="new_qty[]"
                    class="form-control">

            </div>

            <div class="col-md-2">
                <label class="form-label">Finishing</label>
                <input
                    type="text"
                    name="new_finishing[]"
                    class="form-control">

            </div>

            <div class="col-md-1 d-flex align-items-end">

                <button
                    type="button"
                    class="btn btn-danger"
                    onclick="this.closest('.border').remove()">

                    X

                </button>

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

<script>

function hitungPriority()
{
    let deadlineInput =
        document.getElementById('deadline_date');

    let priorityInput =
        document.getElementById('priority');

    if (!deadlineInput.value) return;

    let today = new Date();
    let deadline = new Date(deadlineInput.value);

    today.setHours(0,0,0,0);
    deadline.setHours(0,0,0,0);

    let selisihHari =
        Math.ceil(
            (deadline - today) /
            (1000 * 60 * 60 * 24)
        );

    if (selisihHari <= 2)
    {
        priorityInput.value = 'urgent';
    }
    else if (selisihHari <= 7)
    {
        priorityInput.value = 'high';
    }
    else
    {
        priorityInput.value = 'normal';
    }
}

document
    .getElementById('deadline_date')
    .addEventListener(
        'change',
        hitungPriority
    );

</script>

<script>

function hapusDetail(id)
{
    if(confirm('Hapus item ini?'))
    {
        let form =
            document.getElementById('deleteForm');

        form.action =
            '/spk-detail/' + id + '/delete';

        form.submit();
    }
}

</script>

@endsection

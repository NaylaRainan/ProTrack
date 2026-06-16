@extends('layouts.department')

@section('content')

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold">
            Detail SPK
        </h2>

        <p class="text-muted mb-0">
            {{ $spk->no_spk }}
        </p>

    </div>

    <a
        href="{{ request('back') ?? url()->previous() }}"
        class="btn btn-secondary">

        Kembali

    </a>

</div>

<div class="card card-modern mb-4">

    <div class="card-body">

        <div class="row">

            <div class="col-md-4 mb-3">

                <strong>No SPK</strong>
                <br>

                {{ $spk->no_spk }}

            </div>

            <div class="col-md-4 mb-3">

                <strong>Customer</strong>
                <br>

                {{ $spk->customer->nama_customer }}

            </div>

            <div class="col-md-4 mb-3">

                <strong>Departemen</strong>
                <br>

                {{ $spk->department->nama_bagian }}

            </div>

        </div>

        <div class="row">

            <div class="col-md-4 mb-3">

                <strong>Tanggal SPK</strong>
                <br>

                {{ $spk->tanggal_spk }}

            </div>

            <div class="col-md-4 mb-3">

                <strong>Deadline</strong>
                <br>

                {{ $spk->deadline_date ?? '-' }}

            </div>

            <div class="col-md-4 mb-3">

                <strong>Prioritas</strong>
                <br>

                @if($spk->priority=='urgent')

                    <span class="badge bg-danger">
                        URGENT
                    </span>

                @elseif($spk->priority=='high')

                    <span class="badge bg-warning text-dark">
                        HIGH
                    </span>

                @else

                    <span class="badge bg-primary">
                        NORMAL
                    </span>

                @endif

            </div>

        </div>

        <div class="mb-3">

            <strong>Keterangan</strong>
            <br>

            {{ $spk->keterangan ?? '-' }}

        </div>

    </div>

</div>

@php

$progress = match($spk->status) {

    'belum_diproses' => 0,
    'sedang_diproses' => 50,
    'menunggu_finishing' => 75,
    'sedang_finishing' => 90,
    'selesai' => 100,
    default => 0

};

@endphp

<div class="card card-modern mb-4">

    <div class="card-body">

        <h5 class="mb-3">
            Progress Produksi
        </h5>

        <div class="progress" style="height:30px;">

            <div
                class="progress-bar"
                role="progressbar"
                style="width: {{ $progress }}%;">

                {{ $progress }}%

            </div>

        </div>

        <div class="mt-3">

            <strong>Status Saat Ini :</strong>

            {{ str_replace('_',' ', $spk->status) }}

        </div>

    </div>

</div>

<div class="card card-modern mb-4">

    <div class="card-body">

        <h5 class="mb-3">
            Detail Item Produksi
        </h5>

        <table class="table table-hover">

            <thead>

                <tr>

                    <th>Nama File</th>
                    <th>Bahan</th>
                    <th>Panjang</th>
                    <th>Lebar</th>
                    <th>Qty</th>
                    <th>Finishing</th>

                </tr>

            </thead>

            <tbody>

            @forelse($spk->details as $detail)

                <tr>

                    <td>{{ $detail->nama_file }}</td>
                    <td>{{ $detail->bahan }}</td>
                    <td>{{ $detail->panjang }}</td>
                    <td>{{ $detail->lebar }}</td>
                    <td>{{ $detail->qty }}</td>
                    <td>{{ $detail->finishing }}</td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="text-center">

                        Belum ada detail item

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

<div class="card card-modern mb-4">

    <div class="card-body">

        <h5 class="mb-3">
            Update Status
        </h5>

        <form
            action="{{ url('/spk/'.$spk->id.'/update-status') }}"
            method="POST">

            @csrf

            <div class="mb-3">

                <label class="form-label">
                    Status
                </label>

                <select
                    name="status"
                    class="form-control">

                    <option value="belum_diproses">
                        Belum Diproses
                    </option>

                    <option value="sedang_diproses">
                        Sedang Diproses
                    </option>

                    <option value="menunggu_finishing">
                        Menunggu Finishing
                    </option>

                    <option value="sedang_finishing">
                        Sedang Finishing
                    </option>

                    <option value="selesai">
                        Selesai
                    </option>

                    <option value="terlambat">
                        Terlambat
                    </option>

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Catatan
                </label>

                <textarea
                    name="catatan"
                    rows="3"
                    class="form-control"></textarea>

            </div>

            <button
                type="submit"
                class="btn btn-primary">

                Update Status

            </button>

        </form>

    </div>

</div>

<div class="card card-modern">

    <div class="card-body">

        <h5 class="mb-3">
            Riwayat Progress
        </h5>

        <table class="table table-bordered">

            <thead>

                <tr>

                    <th>Waktu</th>
                    <th>Dari</th>
                    <th>Ke</th>
                    <th>Catatan</th>

                </tr>

            </thead>

            <tbody>

            @forelse($spk->progressLogs as $log)

                <tr>

                    <td>{{ $log->created_at }}</td>
                    <td>{{ $log->old_status }}</td>
                    <td>{{ $log->new_status }}</td>
                    <td>{{ $log->catatan }}</td>

                </tr>

            @empty

                <tr>

                    <td colspan="4" class="text-center">

                        Belum ada riwayat progress

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

</div>

@endsection
@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Detail SPK</h2>

    <div class="card mb-4">
        <div class="card-body">

            <p>
                <strong>No SPK :</strong>
                {{ $spk->no_spk }}
            </p>

            <p>
                <strong>Customer :</strong>
                {{ $spk->customer->nama_customer }}
            </p>

            <p>
                <strong>Departemen :</strong>
                {{ $spk->department->nama_bagian }}
            </p>

            <p>
                <strong>Tanggal SPK :</strong>
                {{ $spk->tanggal_spk }}
            </p>

            <p>
                <strong>Status :</strong>
                {{ $spk->status }}

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
            </p>

            <p>
                <strong>Deadline :</strong>
                {{ $spk->deadline_date ?? '-' }}
            </p>

        </div>
    </div>

    <hr>

    <h5>Progress Produksi</h5>

    <div class="progress">

        <div
            class="progress-bar"

            role="progressbar"

            style="width: {{ $progress }}%;"

        >

            {{ $progress }}%

        </div>

    </div>

    <hr>

    <h4>Detail Item SPK</h4>

    <table class="table table-bordered">

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

    <hr>

    <hr>

    <h4>Detail Produksi</h4>

    <table class="table table-bordered">

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

        @foreach($spk->details as $detail)

            <tr>

                <td>{{ $detail->nama_file }}</td>
                <td>{{ $detail->bahan }}</td>
                <td>{{ $detail->panjang }}</td>
                <td>{{ $detail->lebar }}</td>
                <td>{{ $detail->qty }}</td>
                <td>{{ $detail->finishing }}</td>

            </tr>

        @endforeach

        </tbody>

    </table>

    <h4>Update Status</h4>

    <form action="{{ url('/spk/'.$spk->id.'/update-status') }}"
          method="POST">

        @csrf

        <div class="mb-3">

            <label>Status</label>

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

            <label>Catatan</label>

            <textarea
                name="catatan"
                class="form-control">
            </textarea>

        </div>

        <button
            class="btn btn-success">
            Update Status
        </button>

    </form>

    <hr>

    <h4>Riwayat Progress</h4>

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

        @foreach($spk->progressLogs as $log)

            <tr>

                <td>
                    {{ $log->created_at }}
                </td>

                <td>
                    {{ $log->old_status }}
                </td>

                <td>
                    {{ $log->new_status }}
                </td>

                <td>
                    {{ $log->catatan }}
                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

@endsection
@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Data SPK</h2>

    <a
        href="/spk/create"
        class="btn btn-primary mb-3"
    >
        Tambah SPK
    </a>

    <a
        href="{{ route('spk.export', request()->query()) }}"
        class="btn btn-success mb-3"
    >
        Export Excel
    </a>

    <hr>

    <form method="GET">

        <div class="row mb-3">

            <div class="col-md-3">

                <input
                    type="text"
                    name="keyword"
                    class="form-control"
                    placeholder="Cari No SPK"
                    value="{{ request('keyword') }}"
                >

            </div>

            <div class="col-md-3">

                <select
                    name="customer"
                    class="form-control"
                >

                    <option value="">
                        Semua Customer
                    </option>

                    @foreach($customers as $customer)

                        <option
                            value="{{ $customer->id }}"
                            {{ request('customer') == $customer->id ? 'selected' : '' }}
                        >
                            {{ $customer->nama_customer }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-3">

                <select
                    name="department"
                    class="form-control"
                >

                    <option value="">
                        Semua Departemen
                    </option>

                    <option value="1">Develop</option>
                    <option value="2">Offset</option>
                    <option value="3">Plotter</option>
                    <option value="4">UV</option>
                    <option value="5">Finishing</option>

                </select>

            </div>

            <div class="col-md-3">

                <select
                    name="status"
                    class="form-control"
                >

                    <option value="">
                        Semua Status
                    </option>

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

        </div>

        <div class="row mb-3">

            <div class="col-md-3">

                <select
                    name="priority"
                    class="form-control"
                >

                    <option value="">
                        Semua Priority
                    </option>

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

            <div class="col-md-2">

                <label>
                    Tanggal SPK
                </label>

                <input
                    type="date"
                    name="tanggal_awal"
                    class="form-control"
                    value="{{ request('tanggal_awal') }}"
                >

            </div>

            <div class="col-md-2">

                <label>
                    Tanggal Deadline
                </label>

                <input
                    type="date"
                    name="deadline_awal"
                    class="form-control"
                    value="{{ request('deadline_awal') }}"
                >

            </div>

            <div class="col-md-1">

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Cari
                </button>

            </div>

        </div>

    </form>

    <hr>

    <table class="table table-bordered">

        <thead>
            <tr>
                <th>No SPK</th>
                <th>Customer</th>
                <th>Departemen</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Deadline</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

        @forelse($spks as $spk)

            <tr>

                <td>{{ $spk->no_spk }}</td>

                <td>{{ $spk->customer->nama_customer }}</td>

                <td>{{ $spk->department->nama_bagian }}</td>

                <td>{{ $spk->status }}</td>

                <td>{{ $spk->priority }}</td>

                <td>{{ $spk->deadline_date }}</td>

                <td>

                    <a
                        href="/spk/{{ $spk->id }}"
                        class="btn btn-info btn-sm"
                    >
                        Detail
                    </a>

                    <a
                        href="/spk/{{ $spk->id }}/edit"
                        class="btn btn-warning btn-sm"
                    >
                        Edit
                    </a>

                </td>

                <tr
                @if(
                    $spk->deadline_date &&
                    $spk->deadline_date < now()->toDateString() &&
                    $spk->status != 'selesai'
                )
                style="background:#ffe5e5;"
                @endif
                >

            </tr>

        @empty

            <tr>

                <td colspan="7" class="text-center">
                    Tidak ada data SPK
                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

    <div class="mt-3">
        {{ $spks->links() }}
    </div>

</div>

@endsection
@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">
            Data SPK
        </h2>

        <div>

            <a href="/spk/create" class="btn btn-primary">
                + Tambah SPK
            </a>

            <a href="/spk/export" class="btn btn-pink">
                Export Excel
            </a>

        </div>

    </div>

    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">

            <form method="GET"
                action="{{ url('/spk') }}" class="mb-3">

                <div class="input-group">

                    <span class="input-group-text">
                        🔍
                    </span>

                    <input
                        type="text"
                        id="searchInput"
                        name="search"
                        class="form-control"
                        placeholder="Cari No SPK, Customer, Status, Priority..."
                        value="{{ request('search') }}"
                    >

                    <button
                        class="btn btn-primary d-none"
                        type="submit">

                        Cari

                    </button>

                </div>

            </form>

        </div>
    </div>

    <div id="spk-table">

        <div class="card card-modern">

            <div class="card-body">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>
                                <a href="?{{ http_build_query(array_merge(request()->all(), [
                                    'sort' => 'no_spk',
                                    'direction' => request('direction') == 'asc' ? 'desc' : 'asc'
                                ])) }}">
                                    No SPK
                                </a>
                            </th>

                            <th>
                                <a href="?{{ http_build_query(array_merge(request()->all(), [
                                    'sort' => 'customer',
                                    'direction' => request('direction') == 'asc' ? 'desc' : 'asc'
                                ])) }}">
                                    Customer
                                </a>
                            </th>

                            <th>
                                <a href="?{{ http_build_query(array_merge(request()->all(), [
                                    'sort' => 'department',
                                    'direction' => request('direction') == 'asc' ? 'desc' : 'asc'
                                ])) }}">
                                    Department
                                </a>
                            </th>

                            <th>
                                <a href="?{{ http_build_query(array_merge(request()->all(), [
                                    'sort' => 'priority',
                                    'direction' => request('direction') == 'asc' ? 'desc' : 'asc'
                                ])) }}">
                                    Priority
                                </a>
                            </th>

                            <th>
                                <a href="?{{ http_build_query(array_merge(request()->all(), [
                                    'sort' => 'status',
                                    'direction' => request('direction') == 'asc' ? 'desc' : 'asc'
                                ])) }}">
                                    Status
                                </a>
                            </th>

                            <th>
                                Progress
                            </th>

                            <th>
                                <a href="?{{ http_build_query(array_merge(request()->all(), [
                                    'sort' => 'deadline_date',
                                    'direction' => request('direction') == 'asc' ? 'desc' : 'asc'
                                ])) }}">
                                    Deadline
                                </a>
                            </th>

                            <th width="200">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($spks as $spk)

                        <tr>

                            <td>

                                <strong>

                                    {{ $spk->no_spk }}

                                </strong>

                            </td>

                            <td>

                                {{ $spk->customer->nama_customer }}

                            </td>

                            <td>

                                {{ $spk->department->nama_bagian }}

                            </td>

                            <td>

                                @if($spk->priority=='urgent')

                                    <span class="badge bg-danger">
                                        URGENT
                                    </span>

                                @elseif($spk->priority=='high')

                                    <span class="badge bg-warning text-dark">
                                        HIGH
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        NORMAL
                                    </span>

                                @endif

                            </td>

                            <td>

                                @if(
                                    $spk->deadline_date &&
                                    $spk->deadline_date < date('Y-m-d') &&
                                    $spk->status != 'selesai'
                                )

                                    <span class="badge bg-danger">
                                        Terlambat
                                    </span>

                                @elseif($spk->status=='selesai')

                                    <span class="badge bg-success">
                                        Selesai
                                    </span>

                                @else

                                    <span class="badge bg-info text-dark">
                                        {{ str_replace('_',' ',$spk->status) }}
                                    </span>

                                @endif

                            </td>

                            <td>

                            @php

                                $progress = 0;

                                if($spk->status == 'belum_diproses')
                                {
                                    $progress = 0;
                                }
                                elseif($spk->status == 'sedang_diproses')
                                {
                                    $progress = 50;
                                }
                                elseif($spk->status == 'menunggu_finishing')
                                {
                                    $progress = 75;
                                }
                                elseif($spk->status == 'sedang_finishing')
                                {
                                    $progress = 90;
                                }
                                elseif($spk->status == 'selesai')
                                {
                                    $progress = 100;
                                }
                                elseif($spk->status == 'terlambat')
                                {
                                    $progress = 50;
                                }

                            @endphp

                            <div class="progress" style="height:20px;">

                                <div
                                    class="progress-bar"
                                    style="
                                        width: {{ $progress }}%;
                                        background: linear-gradient(
                                            90deg,
                                            #8EC5FC,
                                            #F8BBD9
                                        );
                                    ">

                                    {{ $progress }}%

                                </div>

                            </div>

                        </td>

                            <td>

                            @php

                            $deadline =
                            \Carbon\Carbon::parse(
                                $spk->deadline_date
                            );

                            $hari =
                            now()->diffInDays(
                                $deadline,
                                false
                            );

                            @endphp

                            @if($hari <= 1)

                            <span class="deadline-warning">

                                {{ $spk->deadline_date }}

                                <br>

                                <small>
                                    Deadline Dekat
                                </small>

                            </span>

                            @else

                            {{ $spk->deadline_date }}

                            @endif

                            </td>

                            <td>

                                <a
                                    href="/spk/{{ $spk->id }}?{{ http_build_query(request()->query()) }}"
                                    class="btn btn-sm btn-primary">

                                    Detail

                                </a>

                                <a
                                    href="/spk/{{ $spk->id }}/edit?{{ http_build_query(request()->query()) }}"
                                    class="btn btn-sm btn-pink">

                                    Edit

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="text-center">

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

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput =
        document.getElementById('searchInput');

    function reloadTable() {

        fetch(window.location.href)
            .then(response => response.text())
            .then(html => {

                const parser =
                    new DOMParser();

                const doc =
                    parser.parseFromString(
                        html,
                        'text/html'
                    );

                const newTable =
                    doc.getElementById(
                        'spk-table'
                    );

                const currentTable =
                    document.getElementById(
                        'spk-table'
                    );

                if (
                    newTable &&
                    currentTable
                ) {
                    currentTable.innerHTML =
                        newTable.innerHTML;
                }

            });
    }

    // AUTO REFRESH
    setInterval(() => {
        reloadTable();
    }, 5000);

    // LIVE SEARCH
    let typingTimer;

    searchInput.addEventListener(
        'keyup',
        function () {

            clearTimeout(typingTimer);

            typingTimer =
                setTimeout(() => {

                const url =
                    new URL(
                        window.location.href
                    );

                url.searchParams.set(
                    'search',
                    searchInput.value
                );

                history.pushState(
                    {},
                    '',
                    url
                );

                fetch(url)
                    .then(response =>
                        response.text()
                    )
                    .then(html => {

                        const parser =
                            new DOMParser();

                        const doc =
                            parser.parseFromString(
                                html,
                                'text/html'
                            );

                        const newTable =
                            doc.getElementById(
                                'spk-table'
                            );

                        document
                            .getElementById(
                                'spk-table'
                            )
                            .innerHTML =
                            newTable.innerHTML;

                    });

            }, 500);

        });

});

</script>
@endpush
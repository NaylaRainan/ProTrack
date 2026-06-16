@extends('layouts.department')

@section('content')

<div class="container-fluid">

<div class="mb-4">

    <h2 class="fw-bold">
        Dashboard {{ ucfirst(Auth::user()->role) }}
    </h2>

    <p class="text-muted">
        Daftar pekerjaan departemen
    </p>

</div>

    @if($isFinishing)

    <div class="row mb-4">

        <div class="col-md-4">

            <a href="?status=all" class="text-decoration-none">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center">

                        <h6 class="text-muted">
                            Total Finishing
                        </h6>

                        <h2 class="fw-bold text-primary">
                            {{ $totalSpk }}
                        </h2>

                    </div>

                </div>

            </a>

        </div>

        <div class="col-md-4">

            <a href="?status=menunggu_finishing" class="text-decoration-none">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center">

                        <h6 class="text-muted">
                            Menunggu Finishing
                        </h6>

                        <h2 class="fw-bold text-warning">
                            {{ $menungguFinishing }}
                        </h2>

                    </div>

                </div>
            
            </a>
        
        </div>

        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <a href="?status=sedang_finishing" class="text-decoration-none">

                    <div class="card-body text-center">

                        <h6 class="text-muted">
                            Sedang Finishing
                        </h6>

                        <h2 class="fw-bold text-success">
                            {{ $sedangFinishing }}
                        </h2>

                    </div>

                </a>

            </div>

        </div>

    </div>

    @else

    <div class="row mb-4">

            <div class="col-md-4">

                <a href="?status=all" class="text-decoration-none">

                    <div class="card border-0 shadow-sm">

                        <div class="card-body text-center">

                            <h6 class="text-muted">
                                Total SPK
                            </h6>

                            <h2 class="fw-bold text-primary">
                                {{ $totalSpk }}
                            </h2>

                        </div>

                    </div>

                </a>

            </div>

            <div class="col-md-4">
                
                <a href="?status=belum_diproses" class="text-decoration-none">
                
                    <div class="card border-0 shadow-sm">

                        <div class="card-body text-center">

                            <h6 class="text-muted">
                                Belum Diproses
                            </h6>

                            <h2 class="fw-bold text-warning">
                                {{ $belumDiproses }}
                            </h2>

                        </div>

                    </div>
                
                </a>
            
            </div>

            <div class="col-md-4">

                <a href="?status=sedang_diproses" class="text-decoration-none">

                    <div class="card border-0 shadow-sm">

                        <div class="card-body text-center">

                            <h6 class="text-muted">
                                Sedang Diproses
                            </h6>

                            <h2 class="fw-bold text-success">
                                {{ $sedangDiproses }}
                            </h2>

                        </div>

                    </div>

                </a>

            </div>

        </div>


    @endif

    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">

            <form method="GET" class="mb-3">

                <input
                    type="hidden"
                    name="sort"
                    value="{{ request('sort') }}"
                >

                <input
                    type="hidden"
                    name="direction"
                    value="{{ request('direction') }}"
                >

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
    
        <div class="card shadow-sm border-0">

            <div class="card-body">

                <h5 class="fw-bold mb-3">

                    Daftar SPK

                </h5>

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead class="table-light">

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
                                <th>Aksi</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($spks as $spk)

                            <tr>

                                <td>

                                    {{ $spk->no_spk }}

                                </td>

                                <td>

                                    {{ $spk->customer->nama_customer }}

                                </td>

                                <td>

                                    {{ $spk->department->nama_bagian }}

                                </td>

                                <td>

                                    @if($spk->priority == 'urgent')

                                        <span class="badge bg-danger">
                                            Urgent
                                        </span>

                                    @elseif($spk->priority == 'high')

                                        <span class="badge bg-warning text-dark">
                                            High
                                        </span>

                                    @else

                                        <span class="badge bg-primary">
                                            Normal
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    @if($spk->status == 'belum_diproses')

                                        <span class="badge bg-secondary">
                                            Belum Diproses
                                        </span>

                                    @elseif($spk->status == 'sedang_diproses')

                                        <span class="badge bg-info">
                                            Sedang Diproses
                                        </span>

                                    @elseif($spk->status == 'menunggu_finishing')

                                        <span class="badge bg-warning text-dark">
                                            Menunggu Finishing
                                        </span>

                                    @elseif($spk->status == 'sedang_finishing')

                                        <span class="badge bg-primary">
                                            Sedang Finishing
                                        </span>

                                    @elseif($spk->status == 'selesai')

                                        <span class="badge bg-success">
                                            Selesai
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            Terlambat
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
                                        href="/department/spk/{{ $spk->id }}?back={{ url()->current() }}"
                                        class="btn btn-sm btn-primary">

                                        Detail

                                    </a>

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td
                                    colspan="8"
                                    class="text-center text-muted">

                                    Tidak ada data SPK

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                    <div class="mt-4">
                        {{ $spks->links() }}
                    </div>

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
@extends('layouts.admin')

@section('content')

<div class="container-fluid">

<div class="mb-4">

    <h2 class="fw-bold">
        Dashboard Admin
    </h2>

    <p class="text-muted">
        Ringkasan monitoring produksi
    </p>

</div>

<div class="row">

    <div class="col-md-4 mb-3">

        <a href="/spk" class="text-decoration-none">

            <div class="card card-modern">

                <div class="card-body text-center">

                    <h6>Total SPK</h6>

                    <h2 class="fw-bold">
                        {{ $totalSpk }}
                    </h2>

                </div>

            </div>
        </a>

    </div>

    <div class="col-md-4 mb-3">

        <a href="/spk?status=belum_diproses" class="text-decoration-none">
            <div class="card card-modern">

                <div class="card-body text-center">

                    <h6>Belum Diproses</h6>

                    <h2 class="text-secondary fw-bold">
                        {{ $belumDiproses }}
                    </h2>

                </div>

            </div>
        </a>
    </div>

    <div class="col-md-4 mb-3">

        <a href="/spk?status=sedang_diproses" class="text-decoration-none">
            
            <div class="card card-modern">

                <div class="card-body text-center">

                    <h6>Sedang Diproses</h6>

                    <h2 class="text-primary fw-bold">
                        {{ $sedangDiproses }}
                    </h2>

                </div>

            </div>

        </a>

    </div>

<div class="row">

    <div class="col-md-4 mb-3">

        <a href="/spk?status=menunggu_finishing" class="text-decoration-none">

            <div class="card card-modern">

                <div class="card-body text-center">

                    <h6>Menunggu Finishing</h6>

                    <h2 class="text-warning fw-bold">
                        {{ $menungguFinishing }}
                    </h2>

                </div>

            </div>

        </a>    

    </div>

    <div class="col-md-4 mb-3">

        <a href="/spk?status=sedang_finishing" class="text-decoration-none">

            <div class="card card-modern">

                <div class="card-body text-center">

                    <h6>Sedang Finishing</h6>

                    <h2 class="text-info fw-bold">
                        {{ $sedangFinishing }}
                    </h2>

                </div>

            </div>

        </a>

    </div>

    
    <div class="col-md-4 mb-3">

        <a href="/spk?status=selesai" class="text-decoration-none">

            <div class="card card-modern">

                <div class="card-body text-center">

                    <h6>Selesai</h6>

                    <h2 class="text-success fw-bold">
                        {{ $selesai }}
                    </h2>

                </div>

            </div>
        </a>    

    </div>

</div>

<div class="row mb-4">

    <div class="col-md-4">

        <a href="/spk?status=terlambat" class="text-decoration-none text-dark">

            <div class="card-modern p-4">

                <div class="card-body text-center">

                    <h5>🚨 Terlambat</h5>

                    <h1 class="text-danger">
                        {{ $spkTerlambat }}
                    </h1>

                </div>

            </div>

        </a>

    </div>

    <div class="col-md-4">

        <a href="/spk?status=deadline_besok" class="text-decoration-none text-dark">

            <div class="card-modern p-4">

                <div class="card-body text-center">

                    <h5>⚠ Deadline Besok</h5>

                    <h1 class="text-warning">
                        {{ $deadlineBesok }}
                    </h1>

                </div>

            </div>

        </a>

    </div>

    <div class="col-md-4">

        <a href="/spk?priority=urgent" class="text-decoration-none text-dark">

            <div class="card-modern p-4">

                <div class="card-body text-center">

                    <h5>🔥 Urgent</h5>

                    <h1 class="text-danger">
                        {{ $urgent }}
                    </h1>

                </div>

            </div>

        </a>

    </div>

</div>

@if($deadlineBesok > 0)

<div class="alert alert-warning">

    Ada

    <strong>
        {{ $deadlineBesok }}
    </strong>

    SPK yang deadline besok.

</div>

@endif

@if($spkTerlambat > 0)

<div class="alert alert-danger">

    Ada

    <strong>
        {{ $spkTerlambat }}
    </strong>

    SPK yang melewati deadline.

</div>

@endif

<div class="row mb-4">

    <div class="col-md-6">

        <div class="card-modern p-4">

            <h5>Status Produksi</h5>

            <canvas id="statusChart"></canvas>

        </div>

    </div>

    <div class="col-md-3">

    <div class="card-modern p-3">

        <h5>Distribusi Departemen</h5>

        <canvas id="departmentChart"></canvas>

    </div>

</div>



</div>

<div class="card card-modern mt-4">

    <div class="card-body">

        <h5>
            SPK Terbaru
        </h5>

        <table class="table table-hover">

            <thead>

                <tr>

                    <th>No SPK</th>

                    <th>Customer</th>

                    <th>Departemen</th>

                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

            @forelse($latestSpks as $spk)

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

                        @if($spk->status == 'selesai')

                            <span class="badge bg-success">
                                Selesai
                            </span>

                        @elseif($spk->status == 'terlambat')

                            <span class="badge bg-danger">
                                Terlambat
                            </span>

                        @else

                            <span class="badge bg-primary">
                                {{ $spk->status }}
                            </span>

                        @endif

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="4" class="text-center">

                        Belum ada data

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(
    document.getElementById('statusChart'),
    {

        type:'bar',

        data:{

            labels:[
                'Belum Diproses',
                'Sedang Diproses',
                'Menunggu Finishing',
                'Sedang Finishing',
                'Selesai',
                'Terlambat'
            ],

            datasets:[{

                label:'Jumlah SPK',

                data:@json($statusChart)

            }]

        }

    }
);

new Chart(
    document.getElementById('departmentChart'),
    {

        type:'pie',

        data:{

            labels:[
                'Develop',
                'Offset',
                'Plotter',
                'UV',
                'Finishing'
            ],

            datasets:[{

                data:@json($departmentChart)

            }]

        }

    }
);

</script>

@endsection

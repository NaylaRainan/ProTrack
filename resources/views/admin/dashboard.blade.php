@extends('layouts.admin')

@section('content')

<div class="container">

    <h2>Dashboard Admin</h2>

    <hr>

    <div class="row">

        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5>Total SPK</h5>
                    <h2>{{ $totalSpk }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5>Belum Diproses</h5>
                    <h2>{{ $belumDiproses }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5>Sedang Diproses</h5>
                    <h2>{{ $sedangDiproses }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5>Selesai</h5>
                    <h2>{{ $selesai }}</h2>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5>Menunggu Finishing</h5>
                    <h2>{{ $menungguFinishing }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5>Sedang Finishing</h5>
                    <h2>{{ $sedangFinishing }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5>Terlambat</h5>
                    <h2>{{ $terlambat }}</h2>
                </div>
            </div>
        </div>

    </div>

    <hr>

    @if($deadlineBesok > 0)

    <div class="alert alert-warning">

        Ada

        <strong>
            {{ $deadlineBesok }}
        </strong>

        SPK yang deadline-nya besok.

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
    <hr>

    <h4>Deadline Mendekati Jatuh Tempo</h4>

    <table class="table table-bordered">

        <thead>
            <tr>
                <th>No SPK</th>
                <th>Customer</th>
                <th>Deadline</th>
            </tr>
        </thead>

        <tbody>

        @forelse($deadlineSoon as $spk)

            <tr>

                <td>
                    {{ $spk->no_spk }}
                </td>

                <td>
                    {{ $spk->customer->nama_customer }}
                </td>

                <td>
                    {{ $spk->deadline_date }}
                </td>

            </tr>

        @empty

            <tr>
                <td colspan="3" class="text-center">
                    Tidak ada deadline yang mendekati
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

    <hr>

    <h4>Prioritas Pekerjaan</h4>

    <div class="row">

        <div class="col-md-4 mb-3">

            <div class="card border-danger">

                <div class="card-body text-center">

                    <h5>URGENT</h5>

                    <h2>
                        {{ $urgent }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4 mb-3">

            <div class="card border-warning">

                <div class="card-body text-center">

                    <h5>HIGH</h5>

                    <h2>
                        {{ $high }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4 mb-3">

            <div class="card border-secondary">

                <div class="card-body text-center">

                    <h5>NORMAL</h5>

                    <h2>
                        {{ $normal }}
                    </h2>

                </div>

            </div>

        </div>

    </div>

    <hr>

    <h4>SPK Urgent Belum Selesai</h4>

    <table class="table table-bordered">

        <thead>

            <tr>
                <th>No SPK</th>
                <th>Customer</th>
                <th>Departemen</th>
                <th>Status</th>
            </tr>

        </thead>

        <tbody>

        @forelse($urgentSpks as $spk)

            <tr>

                <td>{{ $spk->no_spk }}</td>

                <td>{{ $spk->customer->nama_customer }}</td>

                <td>{{ $spk->department->nama_bagian }}</td>

                <td>{{ $spk->status }}</td>

            </tr>

        @empty

            <tr>

                <td colspan="4" class="text-center">

                    Tidak ada SPK urgent

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

    <hr>

    <h4>Grafik Status SPK</h4>

    <canvas id="statusChart"></canvas>

    <hr>

    <h4>Grafik SPK per Departemen</h4>

    <canvas id="departmentChart"></canvas>

    <h4>SPK Terbaru</h4>

    <table class="table table-bordered">

        <th>Progress</th>
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

        <td>

            <div class="progress">

                <div
                    class="progress-bar"
                    style="width: {{ $progress }}%;"
                >

                    {{ $progress }}%

                </div>

            </div>

        </td>

        <div class="alert alert-danger">

            <strong>
                SPK Terlambat Prioritas Urgent :
            </strong>

            {{ $terlambatUrgent }}

        </div>

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
                <td>{{ $spk->no_spk }}</td>
                <td>{{ $spk->customer->nama_customer }}</td>
                <td>{{ $spk->department->nama_bagian }}</td>
                <td>{{ $spk->status }}</td>
            </tr>

        @empty

            <tr>
                <td colspan="4" class="text-center">
                    Belum ada data SPK
                </td>
            </tr>

        @endforelse

        </tbody>
    </table> 
    
    <hr>

    <h4>SPK per Departemen</h4>

    <table class="table table-bordered">

        <tr>
            <th>Develop</th>
            <td>{{ $develop }}</td>
        </tr>

        <tr>
            <th>Offset</th>
            <td>{{ $offset }}</td>
        </tr>

        <tr>
            <th>Plotter</th>
            <td>{{ $plotter }}</td>
        </tr>

        <tr>
            <th>UV</th>
            <td>{{ $uv }}</td>
        </tr>

        <tr>
            <th>Finishing</th>
            <td>{{ $finishing }}</td>
        </tr>

    </table>    

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(
    document.getElementById('statusChart'),
    {

        type: 'bar',

        data: {

            labels: [

                'Belum Diproses',

                'Sedang Diproses',

                'Menunggu Finishing',

                'Sedang Finishing',

                'Selesai',

                'Terlambat'

            ],

            datasets: [{

                label: 'Jumlah SPK',

                data: @json($statusChart)

            }]

        }

    }
);

new Chart(
    document.getElementById('departmentChart'),
    {

        type: 'pie',

        data: {

            labels: [

                'Develop',

                'Offset',

                'Plotter',

                'UV',

                'Finishing'

            ],

            datasets: [{

                data: @json($departmentChart)

            }]

        }

    }
);

</script>

@endsection
@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Dashboard Departemen</h2>

    <table class="table table-bordered">

        <thead>

            <tr>
                <th>No SPK</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Deadline</th>
                <th>Aksi</th>
            </tr>

        </thead>

        <tbody>

        @foreach($spks as $spk)

            <tr>

                <td>
                    {{ $spk->no_spk }}
                </td>

                <td>
                    {{ $spk->customer->nama_customer }}
                </td>

                <td>
                    {{ $spk->status }}
                </td>

                <td>
                    {{ $spk->deadline_date }}
                </td>

                <td>

                    <a
                        href="/spk/{{ $spk->id }}"
                        class="btn btn-primary btn-sm">

                        Detail

                    </a>

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

@endsection
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Spk;

class DashboardController extends Controller
{
    public function index()
    {
        // Update otomatis SPK terlambat
        Spk::whereDate(
                'deadline_date',
                '<',
                now()->toDateString()
            )
            ->whereNotIn(
                'status',
                ['selesai', 'terlambat']
            )
            ->update([
                'status' => 'terlambat'
            ]);

        $totalSpk = Spk::count();

        $belumDiproses = Spk::where(
            'status',
            'belum_diproses'
        )->count();

        $sedangDiproses = Spk::where(
            'status',
            'sedang_diproses'
        )->count();

        $menungguFinishing = Spk::where(
            'status',
            'menunggu_finishing'
        )->count();

        $sedangFinishing = Spk::where(
            'status',
            'sedang_finishing'
        )->count();

        $selesai = Spk::where(
            'status',
            'selesai'
        )->count();

        $terlambat = Spk::where(
            'status',
            'terlambat'
        )->count();

        $develop = Spk::where(
            'production_department_id',
            1
        )->count();

        $offset = Spk::where(
            'production_department_id',
            2
        )->count();

        $plotter = Spk::where(
            'production_department_id',
            3
        )->count();

        $uv = Spk::where(
            'production_department_id',
            4
        )->count();

        $finishing = Spk::where(
            'production_department_id',
            5
        )->count();

        $latestSpks = Spk::with([
            'customer',
            'department'
        ])
        ->latest()
        ->take(5)
        ->get();

        $deadlineSoon = Spk::with([
            'customer',
            'department'
        ])
        ->whereNotNull('deadline_date')
        ->where('status', '!=', 'selesai')
        ->whereDate(
            'deadline_date',
            '<=',
            now()->addDays(1)
        )
        ->whereDate(
            'deadline_date',
            '>=',
            now()
        )
        ->get();

        $urgent = Spk::where('priority', 'urgent')->count();

        $high = Spk::where('priority', 'high')->count();

        $normal = Spk::where('priority', 'normal')->count();

        $urgentSpks = Spk::with([
                'customer',
                'department'
            ])
            ->where('priority', 'urgent')
            ->where('status', '!=', 'selesai')
            ->latest()
            ->take(5)
            ->get();

        $statusChart = [

        $belumDiproses,

        $sedangDiproses,

        $menungguFinishing,

        $sedangFinishing,

        $selesai,

        $terlambat

    ];

    $departmentChart = [

        $develop,

        $offset,

        $plotter,

        $uv,

        $finishing

    ]; 

    $terlambatUrgent = Spk::where(
        'status',
        'terlambat'
    )
    ->where(
        'priority',
        'urgent'
    )
    ->count();
            
    $deadlineBesok = Spk::whereDate(
            'deadline_date',
            now()->addDay()->toDateString()
        )
        ->where('status', '!=', 'selesai')
        ->count();

    $spkTerlambat = Spk::whereDate(
            'deadline_date',
            '<',
            now()->toDateString()
        )
        ->where('status', '!=', 'selesai')
        ->count();
            
        return view(
            'admin.dashboard',
            compact(
                'totalSpk',
                'belumDiproses',
                'sedangDiproses',
                'menungguFinishing',
                'sedangFinishing',
                'selesai',
                'terlambat',
                'develop',
                'offset',
                'plotter',
                'uv',
                'finishing',
                'latestSpks',
                'deadlineSoon',
                'urgent',
                'high',
                'normal',
                'urgentSpks',
                'statusChart',
                'departmentChart',
                'terlambatUrgent',
                'deadlineBesok',
                'spkTerlambat'
            )
        );
    }
}
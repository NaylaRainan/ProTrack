<?php

namespace App\Http\Controllers;

use App\Models\Spk;

class DepartmentController extends Controller
{
    public function department($id)
    {
        if ($id == 5) {

            $spks = Spk::with([
                'customer',
                'department'
            ])
            ->whereIn('status', [
                'menunggu_finishing',
                'sedang_finishing'
            ])
            ->latest()
            ->get();

        } else {

            $spks = Spk::with([
                'customer',
                'department'
            ])
            ->where('production_department_id', $id)
            ->whereNotIn('status', [
                'menunggu_finishing',
                'sedang_finishing',
                'selesai'
            ])
            ->latest()
            ->get();

        }

        $totalSpk = $spks->count();

        $belumDiproses = $spks
            ->where('status', 'belum_diproses')
            ->count();

        $sedangDiproses = $spks
            ->where('status', 'sedang_diproses')
            ->count();

        $selesai = $spks
            ->where('status', 'selesai')
            ->count();

        return view(
            'departments.index',
            compact(
                'spks',
                'totalSpk',
                'belumDiproses',
                'sedangDiproses',
                'selesai'
            )
        );
    }
}
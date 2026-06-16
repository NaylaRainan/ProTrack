<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spk;

class DepartmentController extends Controller
{
    public function index($id, Request $request)
    {
        $query = Spk::with([
            'customer',
            'department'
        ])
        ->leftJoin(
            'customers',
            'spks.customer_id',
            '=',
            'customers.id'
        )
        ->leftJoin(
            'production_departments',
            'spks.production_department_id',
            '=',
            'production_departments.id'
        )
        ->select('spks.*');

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('no_spk', 'like', "%{$search}%")
                ->orWhere('priority', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")

                ->orWhereHas('customer', function ($customer) use ($search) {
                    $customer->where('nama_customer', 'like', "%{$search}%");
                });

            });
        }

        if ($id == 5) {

            $query->whereIn('status', [
                'menunggu_finishing',
                'sedang_finishing'
            ]);

        } else {

            $query->where(
                    'production_department_id',
                    $id
                )
                ->whereNotIn('status', [
                    'menunggu_finishing',
                    'sedang_finishing',
                    'selesai'
                ]);
        }

        // ambil data asli untuk card
        $allSpks = (clone $query)->get();

        $totalSpk = $allSpks->count();

        $belumDiproses = $allSpks
            ->where('status', 'belum_diproses')
            ->count();

        $sedangDiproses = $allSpks
            ->where('status', 'sedang_diproses')
            ->count();

        $selesai = $allSpks
            ->where('status', 'selesai')
            ->count();

        // filter jika card diklik
        if (request()->filled('status') &&
            request('status') != 'all')
        {
            $query->where(
                'status',
                request('status')
            );
        }

        $sort = request()->get('sort', 'created_at');
        $direction = request()->get('direction', 'desc');

        $allowedSort = [
            'no_spk',
            'priority',
            'status',
            'deadline_date',
            'created_at'
        ];

        if (
            !in_array($sort, $allowedSort)
            && $sort != 'customer'
            && $sort != 'department'
        )
        {
            $sort = 'created_at';
        }

        switch ($sort)
        {
            case 'customer':

                $query->orderBy(
                    'customers.nama_customer',
                    $direction
                );

            break;

            case 'department':

                $query->orderBy(
                    'production_departments.nama_bagian',
                    $direction
                );

            break;

            default:

                $query->orderBy(
                    $sort,
                    $direction
                );
        }

        $spks = $query
            ->paginate(10)
            ->appends(request()->all());

        $isFinishing = ($id == 5);

        $menungguFinishing = $allSpks
            ->where('status', 'menunggu_finishing')
            ->count();

        $sedangFinishing = $allSpks
            ->where('status', 'sedang_finishing')
            ->count();

        return view(
            'departments.index',
            compact(
                'spks',
                'totalSpk',
                'belumDiproses',
                'sedangDiproses',
                'selesai',
                'isFinishing',
                'menungguFinishing',
                'sedangFinishing'
            )
        );
    }


    public function show($id)
    {
        $spk = Spk::with([
            'customer',
            'department',
            'details',
            'progressLogs.user'
        ])->findOrFail($id);

        return view(
            'departments.show',
            compact('spk')
        );
    }
}
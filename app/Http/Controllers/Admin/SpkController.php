<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Spk;
use App\Models\SpkDetail;
use App\Models\ProgressLog;
use App\Models\Customer;
use App\Models\ProductionDepartment;

use App\Exports\SpkExport;

use Maatwebsite\Excel\Facades\Excel;

class SpkController extends Controller
{
    public function index(Request $request)
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
            ->orWhere('deadline_date', 'like', "%{$search}%")

            ->orWhereHas('customer', function ($customer) use ($search) {
                $customer->where('nama_customer', 'like', "%{$search}%");
            });

        });
    }

        if ($request->status) {

            if ($request->status == 'deadline_besok') {

                $query->whereDate(
                    'deadline_date',
                    now()->addDay()->toDateString()
                )
                ->where(
                    'status',
                    '!=',
                    'selesai'
                );

            } else {

                $query->where(
                    'status',
                    $request->status
                );
            }
        }

        if ($request->department) {

            $query->where(
                'production_department_id',
                $request->department
            );
        }

        if ($request->priority) {

            $query->where(
                'priority',
                $request->priority
            );
        }

        if ($request->customer) {

            $query->where(
                'customer_id',
                $request->customer
            );
        }

        $sort = $request->get(
            'sort',
            'created_at'
        );

        $direction = $request->get(
            'direction',
            'desc'
        );

        switch($sort)
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
            ->appends($request->all());

        $customers = Customer::orderBy(
            'nama_customer'
        )->get();

        return view(
            'admin.spk.index',
            compact(
                'spks',
                'customers'
            )
        );
    }

    public function create()
    {
        $customers = Customer::all();

        $departments = ProductionDepartment::all();

        return view(
            'admin.spk.create',
            compact(
                'customers',
                'departments'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'customer_id' => 'required',

            'production_department_id' => 'required',

            'tanggal_spk' => 'required',

            'priority' => 'required'
        ]);

        $tahun = date('y');
        $bulan = date('m');

        $lastSpk = Spk::latest()->first();

        $urut = $lastSpk
            ? intval(substr($lastSpk->no_spk, -4)) + 1
            : 1;

        $noSpk =
            'SPK/' .
            $tahun . '/' .
            $bulan . '/' .
            str_pad(
                $urut,
                4,
                '0',
                STR_PAD_LEFT
            );

        $spk = Spk::create([

            'customer_id' =>
                $request->customer_id,

            'production_department_id' =>
                $request->production_department_id,

            'no_spk' =>
                $noSpk,

            'tanggal_spk' =>
                $request->tanggal_spk,

            'deadline_date' =>
                $request->deadline_date,

            'priority' =>
                $request->priority,

            'status' =>
                'belum_diproses',

            'keterangan' =>
                $request->keterangan,
        ]);

        if ($request->nama_file) {

            foreach (
                $request->nama_file
                as $key => $value
            ) {

                if (!$value) {
                    continue;
                }

                SpkDetail::create([

                    'spk_id' =>
                        $spk->id,

                    'nama_file' =>
                        $request->nama_file[$key] ?? null,

                    'bahan' =>
                        $request->bahan[$key] ?? null,

                    'panjang' =>
                        $request->panjang[$key] ?? null,

                    'lebar' =>
                        $request->lebar[$key] ?? null,

                    'qty' =>
                        $request->qty[$key] ?? null,

                    'finishing' =>
                        $request->finishing[$key] ?? null,
                ]);
            }
        }

        return redirect('/spk')
            ->with(
                'success',
                'SPK berhasil ditambahkan'
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
            'admin.spk.show',
            compact('spk')
        );
    }

    public function edit($id)
    {
        $spk = Spk::with(
            'details'
        )->findOrFail($id);

        return view(
            'admin.spk.edit',
            compact('spk')
        );
    }

    public function update(
        Request $request,
        $id
    ) {
        $spk = Spk::findOrFail($id);

        $spk->update([

            'deadline_date' =>
                $request->deadline_date,

            'priority' =>
                $request->priority
        ]);

        if ($request->detail_id) {

            foreach (
                $request->detail_id
                as $key => $detailId
            ) {

                $detail =
                    SpkDetail::find($detailId);

                if ($detail) {

                    $detail->update([

                        'nama_file' =>
                            $request->nama_file[$key],

                        'bahan' =>
                            $request->bahan[$key],
                        
                        'panjang' =>
                            $request->panjang[$key],

                        'lebar' =>
                            $request->lebar[$key],

                        'qty' =>
                            $request->qty[$key],

                        'finishing' =>
                            $request->finishing[$key]
                    ]);
                }
            }
        }

        if ($request->new_nama_file) {

            foreach (
                $request->new_nama_file
                as $key => $value
            ) {

                if (!$value) {
                    continue;
                }

                SpkDetail::create([

                    'spk_id' =>
                        $spk->id,

                    'nama_file' =>
                        $request->new_nama_file[$key],

                    'bahan' =>
                        $request->new_bahan[$key],
                    
                    'panjang' =>
                        $request->new_panjang[$key],

                    'lebar' =>
                        $request->new_lebar[$key],

                    'qty' =>
                        $request->new_qty[$key],

                    'finishing' =>
                        $request->new_finishing[$key]
                ]);
            }
        }

        return redirect(
            '/spk?' . $request->redirect_query
        )
        ->with(
            'success',
            'SPK berhasil diupdate'
        );
    }

    public function updateStatus(
        Request $request,
        $id
    ) {
        $spk = Spk::findOrFail($id);

        $oldStatus = $spk->status;

        if (
            $request->status == 'selesai'
            &&
            $spk->production_department_id != 5
        ) {

            $spk->update([

                'status' =>
                    'menunggu_finishing',

                'production_department_id' =>
                    5
            ]);

            ProgressLog::create([

                'spk_id' =>
                    $spk->id,

                'user_id' =>
                    auth()->id(),

                'old_status' =>
                    $oldStatus,

                'new_status' =>
                    'menunggu_finishing',

                'catatan' =>
                    'Otomatis dikirim ke finishing'
            ]);

            return back()->with(
                'success',
                'SPK otomatis dikirim ke Finishing'
            );
        }

        $spk->update([

            'status' =>
                $request->status
        ]);

        ProgressLog::create([

            'spk_id' =>
                $spk->id,

            'user_id' =>
                auth()->id(),

            'old_status' =>
                $oldStatus,

            'new_status' =>
                $request->status,

            'catatan' =>
                $request->catatan
        ]);

        return back()->with(
            'success',
            'Status berhasil diperbarui'
        );
    }

    public function export(Request $request)
    {
        return Excel::download(
            new SpkExport($request),
            'laporan-spk.xlsx'
        );
    }

    public function deleteDetail($id)
    {
        $detail = SpkDetail::findOrFail($id);

        $jumlahDetail = SpkDetail::where(
            'spk_id',
            $detail->spk_id
        )->count();

        if ($jumlahDetail <= 1) {

            return back()->with(
                'error',
                'Minimal harus ada 1 item pada SPK'
            );
        }

        $detail->delete();

        return back()->with(
            'success',
            'Detail item berhasil dihapus'
        );
    }
}
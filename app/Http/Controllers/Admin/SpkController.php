<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Spk;
use Illuminate\Http\Request;
use App\Models\ProgressLog;
use App\Exports\SpkExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Customer;
use App\Models\ProductionDepartment;
use App\Models\SpkDetail;

class SpkController extends Controller
{
    public function index(Request $request)
    {
        $query = Spk::with([
            'customer',
            'department'
        ]);

        if ($request->keyword) {

            $query->where(
                'no_spk',
                'like',
                '%' . $request->keyword . '%'
            );

        }

        if ($request->status) {

            $query->where(
                'status',
                $request->status
            );

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

        if ($request->tanggal_awal) {

            $query->whereDate(
                'created_at',
                '>=',
                $request->tanggal_awal
            );

        }

        if ($request->deadline_akhir) {

            $query->whereDate(
                'deadline_date',
                '<=',
                $request->deadline_akhir
            );

        }

        $spks = $query
            ->latest()
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
        $tahun = date('y');
        $bulan = date('m');

        $lastSpk = Spk::whereYear(
                'created_at',
                date('Y')
            )
            ->whereMonth(
                'created_at',
                date('m')
            )
            ->latest()
            ->first();

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
            'customer_id' => $request->customer_id,
            'production_department_id' => $request->production_department_id,
            'no_spk' => $noSpk,
            'tanggal_spk' => $request->tanggal_spk,
            'deadline_date' => $request->deadline_date,
            'priority' => $request->priority,
            'status' => 'belum_diproses',
            'keterangan' => $request->keterangan,
        ]);

        if ($request->nama_file) {

            foreach ($request->nama_file as $key => $value) {

                if (!$value) {
                    continue;
                }

                SpkDetail::create([

                    'spk_id'    => $spk->id,

                    'nama_file' => $request->nama_file[$key] ?? null,

                    'bahan'     => $request->bahan[$key] ?? null,

                    'panjang'   => $request->panjang[$key] ?? null,

                    'lebar'     => $request->lebar[$key] ?? null,

                    'qty'       => $request->qty[$key] ?? null,

                    'finishing' => $request->finishing[$key] ?? null,

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
        $spk = Spk::with('details')
            ->findOrFail($id);

        return view(
            'admin.spk.edit',
            compact('spk')
        );
    }

    public function update(Request $request, $id)
    {
        $spk = Spk::findOrFail($id);

        $spk->update([
            'deadline_date' => $request->deadline_date,
            'priority'      => $request->priority,
        ]);

        if ($request->detail_id) {

            foreach ($request->detail_id as $key => $detailId) {

                $detail = SpkDetail::find($detailId);

                if ($detail) {

                    $detail->update([

                        'nama_file' =>
                            $request->nama_file[$key],

                        'bahan' =>
                            $request->bahan[$key],

                        'qty' =>
                            $request->qty[$key],

                        'finishing' =>
                            $request->finishing[$key],

                    ]);
                }
            }
        }

        if ($request->new_nama_file) {

            foreach ($request->new_nama_file as $key => $value) {

                if (!$value) {
                    continue;
                }

                SpkDetail::create([

                    'spk_id'    => $spk->id,

                    'nama_file' =>
                        $request->new_nama_file[$key],

                    'bahan' =>
                        $request->new_bahan[$key],

                    'qty' =>
                        $request->new_qty[$key],

                    'finishing' =>
                        $request->new_finishing[$key],

                ]);
            }
        }
        return redirect('/spk')
            ->with(
                'success',
                'SPK berhasil diupdate'
            );
    }

    public function updateStatus(Request $request, $id)
    {
        $spk = Spk::findOrFail($id);

        $oldStatus = $spk->status;

        /*
        |--------------------------------------------------
        | Jika departemen produksi selesai
        | pindahkan ke finishing
        |--------------------------------------------------
        */
        if (
            $request->status == 'selesai'
            &&
            $spk->production_department_id != 5
        ) {

            $spk->update([
                'status' => 'menunggu_finishing',
                'production_department_id' => 5
            ]);

            ProgressLog::create([
                'spk_id' => $spk->id,
                'user_id' => auth()->id(),
                'old_status' => $oldStatus,
                'new_status' => 'menunggu_finishing',
                'catatan' => 'Otomatis dikirim ke finishing'
            ]);

            return back()->with(
                'success',
                'SPK otomatis dikirim ke Finishing'
            );
        }

        $spk->update([
            'status' => $request->status
        ]);

        ProgressLog::create([
            'spk_id' => $spk->id,
            'user_id' => auth()->id(),
            'old_status' => $oldStatus,
            'new_status' => $request->status,
            'catatan' => $request->catatan
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

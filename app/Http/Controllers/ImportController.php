<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Customer;
use App\Models\Spk;
use App\Models\SpkDetail;
use App\Models\ProductionDepartment;

class ImportController extends Controller
{
    public function index()
    {
        return view('import.index');
    }

    public function import(Request $request)
    {
        $request->validate([
            'xml_file' => 'required|file'
        ]);

        try {

            $xmlFile = $request->file('xml_file');

            $xml = simplexml_load_file(
                $xmlFile->getRealPath()
            );

            $deliveryOrder =
                $xml->TRANSACTIONS->DELIVERYORDER;

            $noSpk =
                (string) $deliveryOrder->INVOICENO;

            if (
                Spk::where(
                    'no_spk',
                    $noSpk
                )->exists()
            ) {
                return back()->with(
                    'error',
                    'SPK sudah pernah diimport'
                );
            }

            $customerName = trim(
                (string)
                $deliveryOrder->SHIPTO1
            );

            $customer = Customer::firstOrCreate([
                'nama_customer' => $customerName
            ]);

            $description = strtoupper(
                (string)
                $deliveryOrder->DESCRIPTION
            );

            if (
                str_contains(
                    $description,
                    'DEVELOP'
                )
            ) {
                $departmentName = 'Develop';

            } elseif (
                str_contains(
                    $description,
                    'OFFSET'
                )
            ) {
                $departmentName = 'Offset';

            } elseif (
                str_contains(
                    $description,
                    'PLOTTER'
                )
            ) {
                $departmentName = 'Plotter';

            } elseif (
                str_contains(
                    $description,
                    'UV'
                )
            ) {
                $departmentName = 'UV';

            } else {

                return back()->with(
                    'error',
                    'Departemen tidak ditemukan'
                );
            }

            $department =
                ProductionDepartment::where(
                    'nama_bagian',
                    $departmentName
                )->first();

            if (!$department) {
                return back()->with(
                    'error',
                    'Master departemen belum tersedia'
                );
            }

            $spk = Spk::create([
                'customer_id' => $customer->id,
                'production_department_id' => $department->id,
                'no_spk' => $noSpk,
                'tanggal_spk' => date('Y-m-d'),
                'status' => 'belum_diproses',
                'priority' => 'normal',
                'keterangan' => (string) $deliveryOrder->DESCRIPTION
            ]);

            foreach (
                $deliveryOrder->ITEMLINE
                as $item
            ) {

                SpkDetail::create([
                    'spk_id' => $spk->id,
                    'nama_file' => (string) $item->ITEMRESERVED1,
                    'bahan' => (string) $item->ITEMOVDESC,
                    'panjang' => (float) $item->ITEMRESERVED2,
                    'lebar' => (float) $item->ITEMRESERVED3,
                    'qty' => (int) $item->QUANTITY,
                    'finishing' => (string) $item->ITEMRESERVED6
                ]);
            }

            return back()->with(
                'success',
                'Import XML berhasil'
            );

        } catch (\Exception $e) {

            return back()->with(
                'error',
                'XML gagal diproses : '
                . $e->getMessage()
            );
        }
    }
}
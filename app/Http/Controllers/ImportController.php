<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\Spk;
use App\Models\SpkDetail;
use App\Models\ProductionDepartment;

use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function index()
    {
        return view('import.index');
    }

    public function import(Request $request)
    {
        $request->validate([
            'xml_file' => 'required'
        ]);

        $xmlFile = $request->file('xml_file');

        $xml = simplexml_load_file($xmlFile);

        $deliveryOrder = $xml->TRANSACTIONS->DELIVERYORDER;

        $noSpk = (string) $deliveryOrder->INVOICENO;

        if (Spk::where('no_spk', $noSpk)->exists()) {
            return back()->with(
                'error',
                'SPK sudah pernah diimport'
            );
        }

        $customerName = trim(
            (string) $deliveryOrder->SHIPTO1
        );

        $customer = Customer::firstOrCreate([
            'nama_customer' => $customerName
        ]);

        $description = strtoupper(
            (string) $deliveryOrder->DESCRIPTION
        );

        if (str_contains($description, 'DEVELOP')) {
            $departmentName = 'Develop';
        } elseif (str_contains($description, 'OFFSET')) {
            $departmentName = 'Offset';
        } elseif (str_contains($description, 'PLOTTER')) {
            $departmentName = 'Plotter';
        } elseif (str_contains($description, 'UV')) {
            $departmentName = 'UV';
        } else {
            return back()->with(
                'error',
                'Departemen tidak ditemukan'
            );
        }

        $department = ProductionDepartment::where(
            'nama_bagian',
            $departmentName
        )->first();

        $spk = Spk::create([
            'customer_id' => $customer->id,
            'production_department_id' => $department->id,
            'no_spk' => $noSpk,
            'tanggal_spk' => (string) $deliveryOrder->INVOICEDATE,
            'status' => 'belum_diproses',
            'keterangan' => (string) $deliveryOrder->DESCRIPTION
        ]);

        foreach ($deliveryOrder->ITEMLINE as $item) {

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
    }
}
<?php

namespace App\Exports;

use App\Models\Spk;
use Maatwebsite\Excel\Concerns\FromCollection;

class SpkExport implements FromCollection
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Spk::query();

        if ($this->request->keyword) {

            $query->where(
                'no_spk',
                'like',
                '%' . $this->request->keyword . '%'
            );

        }

        if ($this->request->status) {

            $query->where(
                'status',
                $this->request->status
            );

        }

        if ($this->request->department) {

            $query->where(
                'production_department_id',
                $this->request->department
            );

        }

        if ($this->request->priority) {

            $query->where(
                'priority',
                $this->request->priority
            );

        }

        if ($this->request->customer) {

            $query->where(
                'customer_id',
                $this->request->customer
            );

        }

        if ($this->request->tanggal_awal) {

            $query->whereDate(
                'created_at',
                '>=',
                $this->request->tanggal_awal
            );

        }

        if ($this->request->deadline_akhir) {

            $query->whereDate(
                'deadline_date',
                '<=',
                $this->request->deadline_akhir
            );

        }

        return $query->select(
            'no_spk',
            'tanggal_spk',
            'deadline_date',
            'priority',
            'status'
        )->get();
    }
}
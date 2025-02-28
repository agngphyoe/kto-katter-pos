<?php

namespace App\Exports;

use App\Models\StockReconciliation;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReconcileExport implements FromView
{
    protected $reconciliation_id;

    public function __construct($reconciliation_id)
    {
        $this->reconciliation_id = $reconciliation_id;
    }

    public function view(): View
    {
        $reconciliation = StockReconciliation::with(['products', 'location', 'createdBy'])
            ->findOrFail($this->reconciliation_id);

        if (!$reconciliation) {
            Log::error('Reconciliation not found', ['id' => $this->reconciliation_id]);
        }

        return view('exports.reconcile', [
            'reconciliation' => $reconciliation
        ]);
    }
}



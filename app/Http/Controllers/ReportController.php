<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $startDate = $request->query('start_date', now()->format('Y-m-d'));
        $endDate = $request->query('end_date', now()->format('Y-m-d'));

        $purchases = Purchase::whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->latest()->with(['products', 'user'])->paginate(5);

        $purchases->appends([
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        return view('reports.purchases', ['purchases' => $purchases]);
    }
}

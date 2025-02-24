<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrder;

class WorkOrderStatusController extends Controller
{
    public function index()
    {
        $workOrders = WorkOrder::latest()->get(); // Ambil semua data Work Order
        return view('workorder.status', compact('workOrders'));
    }
}

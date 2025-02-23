<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrder;
use App\Models\WorkOrderItem;
use Illuminate\Support\Carbon;

class WorkOrderController extends Controller
{
    // Menampilkan halaman pembuatan WO
    public function create()
    {
        return view('workorder.create');
    }

    // Menyimpan data WO baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'departemen' => 'required|string',
            'tanggal_pembuatan' => 'required|date',
            'target_selesai' => 'required|date',
            'jenis_pekerjaan' => 'required|array',
            'deskripsi' => 'required|string',
        ]);

        // Generate nomor WO otomatis
        $bulan = Carbon::parse($request->tanggal_pembuatan)->format('m');
        $tahun = Carbon::parse($request->tanggal_pembuatan)->format('y');
        $inisialDepartemen = strtoupper(substr($request->departemen, 0, 3));

        // Ambil jumlah WO yang sudah ada di bulan & tahun yang sama
        $count = WorkOrder::whereYear('tanggal_pembuatan', Carbon::parse($request->tanggal_pembuatan)->year)
            ->whereMonth('tanggal_pembuatan', Carbon::parse($request->tanggal_pembuatan)->month)
            ->count() + 1;

        $nomor_wo = sprintf('%02d/%02d/%s-%03d', $bulan, $tahun, $inisialDepartemen, $count);

        // Simpan ke database
        WorkOrder::create([
            'nomor_wo' => $nomor_wo,
            'nama_pemohon' => $request->nama_pemohon,
            'departemen' => $request->departemen,
            'tanggal_pembuatan' => $request->tanggal_pembuatan,
            'target_selesai' => $request->target_selesai,
            'jenis_pekerjaan' => $request->jenis_pekerjaan,
            'deskripsi' => $request->deskripsi,
            'status' => 'Open',
        ]);

        return redirect()->route('workorder.create')->with('success', "Work Order berhasil dibuat dengan nomor: $nomor_wo");
    }

    // Menampilkan halaman Update WO
    public function edit()
    {
        return view('workorder.update');
    }

    // Fungsi untuk pencarian WO via AJAX
    public function find(Request $request)
    {
        $request->validate([
            'nomor_wo' => 'required|string',
        ]);

        $workOrder = WorkOrder::where('nomor_wo', $request->nomor_wo)->first();

        if (!$workOrder) {
            return response()->json(['error' => 'Nomor WO tidak ditemukan'], 404);
        }

        return response()->json([
            'nomor_wo' => $workOrder->nomor_wo,
            'nama_pemohon' => $workOrder->nama_pemohon,
            'departemen' => $workOrder->departemen,
            'tanggal_pembuatan' => Carbon::parse($workOrder->tanggal_pembuatan)->format('Y-m-d'),
            'target_selesai' => Carbon::parse($workOrder->target_selesai)->format('Y-m-d'),
            'deskripsi' => $workOrder->deskripsi,
            'status' => $workOrder->status,
            'tindakan' => $workOrder->tindakan,
            'saran' => $workOrder->saran,
            'jenis_pekerjaan' => $workOrder->jenis_pekerjaan, // Pastikan ini ada
            'items' => $workOrder->items ? $workOrder->items->toArray() : [], // Pastikan dalam array
        ]);
    }

    // Memproses update data WO
    public function update(Request $request)
    {
        $request->validate([
            'nomor_wo' => 'required|exists:work_orders,nomor_wo',
            'status' => 'required',
            'tindakan' => 'required|string',
            'saran' => 'nullable|string',
            'items' => 'nullable|array',  // Pastikan bisa null
            'items.*.nama_barang' => 'required|string',
            'items.*.qty' => 'required|integer',
            'items.*.unit' => 'required|string',
            'items.*.nomor_pr' => 'nullable|string',
        ]);

        $workOrder = WorkOrder::where('nomor_wo', $request->nomor_wo)->firstOrFail();

        // Update data utama WO
        $workOrder->update([
            'status' => $request->status,
            'tindakan' => $request->tindakan,
            'saran' => $request->saran,
        ]);

        // Hapus item lama lalu insert baru
        WorkOrderItem::where('work_order_id', $workOrder->id)->delete();

        if (!empty($request->items)) {
            foreach ($request->items as $index => $item) {
                WorkOrderItem::create([
                    'work_order_id' => $workOrder->id,
                    'nomor' => $index + 1,
                    'nama_barang' => $item['nama_barang'],
                    'qty' => $item['qty'],
                    'unit' => $item['unit'],
                    'nomor_pr' => $item['nomor_pr'] ?? null,
                ]);
            }
        }

        return redirect()->route('workorder.edit')->with('success', 'WO berhasil diperbarui!');
    }

    // TOmbol hapus
    public function delete(Request $request)
    {
        $request->validate([
            'nomor_wo' => 'required|string',
        ]);

        $workOrder = WorkOrder::where('nomor_wo', $request->nomor_wo)->first();

        if (!$workOrder) {
            return response()->json(['error' => 'Work Order tidak ditemukan!'], 404);
        }

        $workOrder->delete();

        return response()->json(['success' => 'Work Order berhasil dihapus!']);
    }

}

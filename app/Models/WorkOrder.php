<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

    protected $table = 'work_orders'; // Nama tabel di database

    protected $fillable = [
        'nomor_wo',
        'nama_pemohon',
        'departemen',
        'tanggal_pembuatan',
        'target_selesai',
        'jenis_pekerjaan',
        'deskripsi',
        'status',
        'tindakan',
        'saran',
        'items'
    ];

    protected $casts = [
        'items' => 'array',
        'jenis_pekerjaan' => 'array', // Karena bisa lebih dari satu, disimpan dalam format JSON
        'tanggal_pembuatan' => 'date',
        'target_selesai' => 'date'
    ];
}

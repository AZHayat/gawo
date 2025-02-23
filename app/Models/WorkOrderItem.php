<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderItem extends Model
{
    use HasFactory;

    protected $table = 'work_order_items'; // Sesuaikan dengan nama tabel di database
    protected $fillable = ['work_order_id', 'nama_barang', 'qty', 'unit', 'nomor_pr']; // Sesuaikan dengan kolom tabel
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_order_id',
        'tindakan',
        'saran',
    ];
}
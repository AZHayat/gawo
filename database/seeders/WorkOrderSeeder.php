<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WorkOrderSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nomor_wo' => '02/25/ENG-001',
                'nama_pemohon' => 'John Doe',
                'departemen' => 'Engineering',
                'tanggal_pembuatan' => Carbon::create(2025, 2, 10),
                'target_selesai' => Carbon::create(2025, 3, 10),
                'jenis_pekerjaan' => json_encode(['Maintenance Building', 'Cleaning']),
                'deskripsi' => 'Perbaikan AC di ruang server.',
                'status' => 'Open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_wo' => '02/25/CPP-002',
                'nama_pemohon' => 'Alice Smith',
                'departemen' => 'CPP',
                'tanggal_pembuatan' => Carbon::create(2025, 2, 15),
                'target_selesai' => Carbon::create(2025, 3, 15),
                'jenis_pekerjaan' => json_encode(['Project']),
                'deskripsi' => 'Pembuatan jalur pipa baru.',
                'status' => 'Proses',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_wo' => '03/25/ENG-001',
                'nama_pemohon' => 'Bob Johnson',
                'departemen' => 'Engineering',
                'tanggal_pembuatan' => Carbon::create(2025, 3, 1),
                'target_selesai' => Carbon::create(2025, 4, 1),
                'jenis_pekerjaan' => json_encode(['Crafting']),
                'deskripsi' => 'Pembuatan alat custom untuk produksi.',
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_wo' => '03/25/SLI-002',
                'nama_pemohon' => 'Charlie Brown',
                'departemen' => 'Slitting',
                'tanggal_pembuatan' => Carbon::create(2025, 3, 5),
                'target_selesai' => Carbon::create(2025, 4, 5),
                'jenis_pekerjaan' => json_encode(['Ekspedisi']),
                'deskripsi' => 'Pengiriman bahan baku ke pabrik lain.',
                'status' => 'Open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_wo' => '04/25/LAB-001',
                'nama_pemohon' => 'David Wilson',
                'departemen' => 'Laboratorium',
                'tanggal_pembuatan' => Carbon::create(2025, 4, 12),
                'target_selesai' => Carbon::create(2025, 5, 12),
                'jenis_pekerjaan' => json_encode(['Cleaning', 'Project']),
                'deskripsi' => 'Pembersihan dan upgrade ruang lab.',
                'status' => 'Close',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('work_orders')->insert($data);
    }
}

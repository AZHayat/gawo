@extends('layouts.app')

@section('title', 'Buat Work Order')

@section('content')

@if(session('success'))
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050">
        <div id="toastNotif" class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif


<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>Buat Work Order</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('workorder.store') }}" method="POST">
                @csrf
                
                <!-- Nama Pemohon -->
                <div class="form-group">
                    <label for="nama_pemohon">Nama Pemohon</label>
                    <input type="text" class="form-control" id="nama_pemohon" name="nama_pemohon" required>
                </div>

                <!-- Departemen Pemohon -->
                <div class="form-group">
                    <label for="departemen">Departemen Pemohon</label>
                    <select class="form-control" id="departemen" name="departemen" required>
                        <option value="">-- Pilih Departemen --</option>
                        <option value="Engineering">Engineering</option>
                        <option value="CPP">CPP</option>
                        <option value="Metalize">Metalize</option>
                        <option value="Slitting">Slitting</option>
                        <option value="Warehouse & PPIC">Warehouse & PPIC</option>
                        <option value="Laboratorium">Laboratorium</option>
                        <option value="Direksi">Direksi</option>
                        <option value="Others">Others</option>
                    </select>
                    <input type="text" class="form-control mt-2 d-none" id="departemen_lainnya" name="departemen_lainnya" placeholder="Isi Departemen Lainnya">
                </div>

                <!-- Tanggal Pembuatan -->
                <div class="form-group">
                    <label for="tanggal_pembuatan">Tanggal Pembuatan</label>
                    <input type="date" class="form-control" id="tanggal_pembuatan" name="tanggal_pembuatan" value="{{ date('Y-m-d') }}" required>
                </div>

                <!-- Target Selesai -->
                <div class="form-group">
                    <label for="target_selesai">Target Selesai</label>
                    <input type="date" class="form-control" id="target_selesai" name="target_selesai" value="{{ date('Y-m-d', strtotime('+1 month')) }}" required>
                </div>

                <!-- Jenis Pekerjaan -->
                <div class="form-group">
                    <label>Jenis Pekerjaan</label><br>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="jenis_pekerjaan[]" value="Maintenance Building">
                        <label class="form-check-label">Maintenance Building</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="jenis_pekerjaan[]" value="Project">
                        <label class="form-check-label">Project</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="jenis_pekerjaan[]" value="Cleaning">
                        <label class="form-check-label">Cleaning</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="jenis_pekerjaan[]" value="Crafting">
                        <label class="form-check-label">Crafting</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="jenis_pekerjaan[]" value="Ekspedisi">
                        <label class="form-check-label">Ekspedisi</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="pekerjaan_others" value="Others">
                        <label class="form-check-label">Others</label>
                    </div>
                    <input type="text" class="form-control mt-2 d-none" id="jenis_pekerjaan_lainnya" name="jenis_pekerjaan_lainnya" placeholder="Isi Jenis Pekerjaan Lainnya">
                </div>

                <!-- Deskripsi Pekerjaan -->
                <div class="form-group">
                    <label for="deskripsi">Deskripsi Pekerjaan / Masalah</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('js/workorder_create.js') }}"></script>



@endsection

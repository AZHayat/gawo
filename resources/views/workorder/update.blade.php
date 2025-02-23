@extends('layouts.app')

@section('title', 'Update Work Order')

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
            <h3>Update Work Order</h3>
        </div>
        <div class="card-body">
        <form action="{{ route('workorder.update') }}" method="POST">
    @csrf
    @method('PATCH') <!-- Ganti dari POST ke PATCH -->


                <!-- Nomor WO -->
                <div class="form-group d-flex">
                    <input type="text" class="form-control me-2" id="nomor_wo" name="nomor_wo" placeholder="Masukkan Nomor WO" required style="max-width: 30ch;">
                    <button type="button" class="btn btn-secondary" id="btnCariWO">Cari</button>
                </div>

                <div id="woData" class="d-none">
                    <!-- Status -->
                    <div class="form-group mt-3">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Open">🟢 Open</option>
                            <option value="Proses">🔵 Proses</option>
                            <option value="Pending">🟡 Pending</option>
                            <option value="Close">🔴 Close</option>
                        </select>
                    </div>

                    <!-- Nama Pemohon -->
                    <div class="form-group mt-3">
                        <label for="nama_pemohon">Nama Pemohon</label>
                        <input type="text" class="form-control" id="nama_pemohon" name="nama_pemohon" disabled>
                    </div>

                    <!-- Departemen -->
                    <div class="form-group">
                        <label for="departemen">Departemen Pemohon</label>
                        <select class="form-control" id="departemen" name="departemen" disabled>
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
                    <div class="form-group mt-3">
                        <label for="tanggal_pembuatan">Tanggal Pembuatan</label>
                        <input type="date" class="form-control" id="tanggal_pembuatan" name="tanggal_pembuatan" value="{{ date('Y-m-d') }}" disabled>
                    </div>
                    

                    <!-- Target Selesai -->
                    <div class="form-group mt-3">
                        <label for="target_selesai">Target Selesai</label>
                        <input type="date" class="form-control" id="target_selesai" name="target_selesai" value="{{ date('Y-m-d', strtotime('+1 month')) }}" disabled>
                    </div>

                    <!-- Deskripsi -->
                    <div class="form-group mt-3">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" disabled></textarea>
                    </div>

                    <!-- Tindakan -->
                    <div class="form-group mt-3">
                        <label for="tindakan">Tindakan</label>
                        <textarea class="form-control" id="tindakan" name="tindakan" rows="3" required></textarea>
                    </div>

                    <!-- Saran -->
                    <div class="form-group mt-3">
                        <label for="saran">Saran</label>
                        <textarea class="form-control" id="saran" name="saran" rows="3"></textarea>
                    </div>

                    <!-- Tabel Barang -->
                    <h5 class="mt-4">Daftar Barang</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Nomor PR</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBarang">
                            <!-- Minimal 3 Baris Awal -->
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-sm btn-success" id="btnTambahBarang">Tambah Barang</button>

                    <br>
                    <br>
                    <!-- Tombol Submit -->
                    <div class="flex space-x-2">
                        <button id="btn-simpan" class="bg-green-500 text-white px-4 py-2 rounded flex items-center">
                            <i class="fas fa-save mr-2"></i> Simpan
                        </button>

                        <button id="btn-edit" class="bg-blue-500 text-white px-4 py-2 rounded flex items-center">
                            <i class="fas fa-edit mr-2"></i> Edit
                        </button>

                        <button id="btn-hapus" class="bg-red-500 text-white px-4 py-2 rounded flex items-center">
                            <i class="fas fa-trash-alt mr-2"></i> Hapus
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    function tambahBarisBarang(nomor = '', nama = '', qty = '', unit = '', pr = '') {
        let nomorOtomatis = $("#tableBarang tr").length + 1;
        $("#tableBarang").append(`
            <tr>
                <td>${nomor || nomorOtomatis}</td>
                <td><input type="text" name="barang[${nomorOtomatis}][nama_barang]" class="form-control" value="${nama}" required></td>
                <td><input type="number" name="barang[${nomorOtomatis}][qty]" class="form-control" value="${qty}" required></td>
                <td><input type="text" name="barang[${nomorOtomatis}][unit]" class="form-control" value="${unit}" required></td>
                <td><input type="text" name="barang[${nomorOtomatis}][nomor_pr]" class="form-control" value="${pr}"></td>
                <td><button type="button" class="btn btn-sm btn-danger btnHapusBarang">Hapus</button></td>
            </tr>
        `);
    }

    
    //Tambah barang
    $('#btnTambahBarang').click(function () {
        tambahBarisBarang();
    });

    $(document).on('click', '.btnHapusBarang', function () {
        $(this).closest('tr').remove();
    });



    // Cari WO
    $("#btnCariWO").click(function () { // ID sudah sesuai
        var nomorWO = $("#nomor_wo").val();

        if (nomorWO === "") {
            alert("Masukkan Nomor WO terlebih dahulu!");
            return;
        }

        $.ajax({
            url: "{{ route('workorder.find') }}",
            type: "POST", // Bisa diganti "GET" jika ingin lebih sederhana
            data: { nomor_wo: nomorWO, _token: "{{ csrf_token() }}" }, 
            success: function (response) {
                $("#nama_pemohon").val(response.nama_pemohon);
                $("#departemen").val(response.departemen);
                $("#tanggal_pembuatan").val(response.tanggal_pembuatan);
                $("#target_selesai").val(response.target_selesai);
                $("#deskripsi").val(response.deskripsi);
                $("#status").val(response.status);
                $("#tindakan").val(response.tindakan || ''); 
                $("#saran").val(response.saran || ''); 

                $("#tableBarang").empty(); // Pastikan tabel barang dikosongkan dulu

                if (response.items && response.items.length > 0) {
                    response.items.forEach(function (item, index) {
                        tambahBarisBarang(index + 1, item.nama_barang, item.qty, item.unit, item.nomor_pr || '');
                    });
                }

                $("#woData").removeClass("d-none"); // Tampilkan data WO
            },
            error: function (xhr) {
                alert(xhr.responseJSON.error);
            }
        });
    });

    function tambahBarisBarang(nomor, nama, qty, unit, pr) {
        let nomorOtomatis = $("#tableBarang tr").length + 1;
        $("#tableBarang").append(`
            <tr>
                <td>${nomor || nomorOtomatis}</td>
                <td><input type="text" name="barang[${nomorOtomatis}][nama_barang]" class="form-control" value="${nama}" required></td>
                <td><input type="number" name="barang[${nomorOtomatis}][qty]" class="form-control" value="${qty}" required></td>
                <td><input type="text" name="barang[${nomorOtomatis}][unit]" class="form-control" value="${unit}" required></td>
                <td><input type="text" name="barang[${nomorOtomatis}][nomor_pr]" class="form-control" value="${pr}"></td>
                <td><button type="button" class="btn btn-sm btn-danger btnHapusBarang">Hapus</button></td>
            </tr>
        `);
    }

    //TOmbol Edit
    $("#btn-edit").click(function () {
        // Aktifkan input yang sebelumnya disabled atau disabled
        $("#nama_pemohon").removeAttr("disabled");
        $("#departemen").removeAttr("disabled");
        $("#tanggal_pembuatan").removeAttr("disabled");
        $("#target_selesai").removeAttr("disabled");
        $("#deskripsi").removeAttr("disabled");

        // Beri efek visual agar terlihat bisa diedit
        $("#nama_pemohon, #departemen, #tanggal_pembuatan, #target_selesai, #deskripsi").addClass("border-blue-500");
    });


    // Tombol hapus
    $("#btn-hapus").click(function () {
        let nomorWO = $("#nomor_wo").val();
        if (!nomorWO) {
            alert("Masukkan Nomor WO terlebih dahulu!");
            return;
        }

        if (confirm("Apakah Anda yakin ingin menghapus WO ini?")) {
            $.ajax({
                url: "{{ route('workorder.delete') }}",
                type: "POST",
                data: {
                    nomor_wo: nomorWO,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    alert(response.success);
                    location.reload();
                },
                error: function (xhr) {
                    alert(xhr.responseJSON.error);
                }
            });
        }
    });


});
</script>

@endsection

$(document).ready(function () {
    const csrfToken = $('meta[name="csrf-token"]').attr("content");
    const workorderFindUrl = $('meta[name="workorder-find-url"]').attr(
        "content"
    );
    const workorderDeleteUrl = $('meta[name="workorder-delete-url"]').attr(
        "content"
    );

    function tambahBarisBarang(
        nomor = "",
        nama = "",
        qty = "",
        unit = "",
        pr = ""
    ) {
        let nomorOtomatis = $("#tableBarang tr").length + 1;
        $("#tableBarang").append(`
            <tr>
                <td>${nomor || nomorOtomatis}</td>
                <td><input type="text" name="items[${nomorOtomatis}][nama_barang]" class="form-control" value="${nama}" required></td>
                <td><input type="number" name="items[${nomorOtomatis}][qty]" class="form-control" value="${qty}" required></td>
                <td><input type="text" name="items[${nomorOtomatis}][unit]" class="form-control" value="${unit}" required></td>
                <td><input type="text" name="items[${nomorOtomatis}][nomor_pr]" class="form-control" value="${pr}"></td>
                <td><button type="button" class="btn btn-sm btn-danger btnHapusBarang">Hapus</button></td>
            </tr>
        `);
    }

    //Tambah barang
    $("#btnTambahBarang").click(function () {
        tambahBarisBarang();
    });

    $(document).on("click", ".btnHapusBarang", function () {
        $(this).closest("tr").remove();
    });

    // Fetch WO data if nomor_wo is provided
    function fetchWOData(nomorWO) {
        $.ajax({
            url: workorderFindUrl,
            type: "POST",
            data: { nomor_wo: nomorWO, _token: csrfToken },
            success: function (response) {
                $("#nama_pemohon").val(response.nama_pemohon);
                $("#departemen").val(response.departemen);
                $("#tanggal_pembuatan").val(response.tanggal_pembuatan);
                $("#target_selesai").val(response.target_selesai);
                $("#deskripsi").val(response.deskripsi);
                $("#status").val(response.status);
                $("#tindakan").val(response.tindakan || "");
                $("#saran").val(response.saran || "");

                // Isi checkbox jenis pekerjaan
                if (response.jenis_pekerjaan) {
                    response.jenis_pekerjaan.forEach(function (jenis) {
                        $(
                            "input[name='jenis_pekerjaan[]'][value='" +
                                jenis +
                                "']"
                        ).prop("checked", true);
                    });
                }

                $("#tableBarang").empty(); // Pastikan tabel barang dikosongkan dulu

                if (response.items && response.items.length > 0) {
                    response.items.forEach(function (item, index) {
                        tambahBarisBarang(
                            index + 1,
                            item.nama_barang,
                            item.qty,
                            item.unit,
                            item.nomor_pr || ""
                        );
                    });
                }

                $("#woData").removeClass("d-none"); // Tampilkan data WO
            },
            error: function (xhr) {
                alert(xhr.responseJSON.error);
            },
        });
    }

    // Reset form and disable inputs
    function resetForm() {
        $("#woData").addClass("d-none");
        $("#nama_pemohon").attr("disabled", true).val("");
        $("#departemen").attr("disabled", true).val("");
        $("#tanggal_pembuatan").attr("disabled", true).val("");
        $("#target_selesai").attr("disabled", true).val("");
        $("#deskripsi").attr("disabled", true).val("");
        $("input[name='jenis_pekerjaan[]']")
            .attr("disabled", true)
            .prop("checked", false);
        $("#pekerjaan_others").attr("disabled", true).prop("checked", false);
        $("#jenis_pekerjaan_lainnya").attr("disabled", true).val("");
        $("#tindakan").val("");
        $("#saran").val("");
        $("#tableBarang").empty();
    }

    // Cari WO
    $("#btnCariWO").click(function () {
        var nomorWO = $("#nomor_wo").val();

        if (nomorWO === "") {
            alert("Masukkan Nomor WO terlebih dahulu!");
            return;
        }

        resetForm();
        fetchWOData(nomorWO);
    });

    // Tombol Edit
    $("#btn-edit").click(function () {
        // Aktifkan input yang sebelumnya disabled atau readonly
        $("#nama_pemohon").removeAttr("disabled");
        $("#departemen").removeAttr("disabled");
        $("#tanggal_pembuatan").removeAttr("disabled");
        $("#target_selesai").removeAttr("disabled");
        $("#deskripsi").removeAttr("disabled");

        // Aktifkan checkbox jenis pekerjaan
        $("input[name='jenis_pekerjaan[]']").removeAttr("disabled");
        $("#pekerjaan_others").removeAttr("disabled");
        $("#jenis_pekerjaan_lainnya").removeAttr("disabled");

        // Beri efek visual agar terlihat bisa diedit
        $(
            "#nama_pemohon, #departemen, #tanggal_pembuatan, #target_selesai, #deskripsi"
        ).addClass("border-blue-500");
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
                url: workorderDeleteUrl,
                type: "POST",
                data: {
                    nomor_wo: nomorWO,
                    _token: csrfToken,
                },
                success: function (response) {
                    alert(response.success);
                    location.reload();
                },
                error: function (xhr) {
                    alert(xhr.responseJSON.error);
                },
            });
        }
    });

    // Check if nomor_wo is provided and fetch data
    var nomorWO = $("#nomor_wo").val();
    if (nomorWO) {
        fetchWOData(nomorWO);
    }
});

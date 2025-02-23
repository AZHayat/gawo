document.addEventListener("DOMContentLoaded", function () {
    console.log("Script berjalan!");

    // Menampilkan input tambahan jika memilih "Others" di dropdown Departemen
    let departemenSelect = document.getElementById("departemen");
    let departemenLainnyaInput = document.getElementById("departemen_lainnya");

    departemenSelect.addEventListener("change", function () {
        if (this.value === "Others") {
            departemenLainnyaInput.classList.remove("d-none");
            departemenLainnyaInput.setAttribute("required", "required");
        } else {
            departemenLainnyaInput.classList.add("d-none");
            departemenLainnyaInput.removeAttribute("required");
        }
    });

    // Menampilkan input tambahan jika memilih "Others" di checkbox Jenis Pekerjaan
    let pekerjaanOthers = document.getElementById("pekerjaan_others");
    let pekerjaanLainnyaInput = document.getElementById(
        "jenis_pekerjaan_lainnya"
    );

    pekerjaanOthers.addEventListener("change", function () {
        if (this.checked) {
            pekerjaanLainnyaInput.classList.remove("d-none");
            pekerjaanLainnyaInput.setAttribute("required", "required");
        } else {
            pekerjaanLainnyaInput.classList.add("d-none");
            pekerjaanLainnyaInput.removeAttribute("required");
        }
    });

    // Update target selesai jika tanggal pembuatan berubah
    let tanggalPembuatanInput = document.getElementById("tanggal_pembuatan");
    let targetSelesaiInput = document.getElementById("target_selesai");

    tanggalPembuatanInput.addEventListener("change", function () {
        console.log("Tanggal Pembuatan diubah!");

        let tglPembuatan = new Date(this.value);
        if (!isNaN(tglPembuatan.getTime())) {
            // Pastikan input valid
            tglPembuatan.setMonth(tglPembuatan.getMonth() + 1); // Tambah 1 bulan

            // Format YYYY-MM-DD untuk input date
            let year = tglPembuatan.getFullYear();
            let month = (tglPembuatan.getMonth() + 1)
                .toString()
                .padStart(2, "0");
            let day = tglPembuatan.getDate().toString().padStart(2, "0");

            let newTargetDate = `${year}-${month}-${day}`;
            targetSelesaiInput.value = newTargetDate;
            console.log("Tanggal Target Selesai diperbarui:", newTargetDate);
        } else {
            console.log("Error: Tanggal tidak valid!");
        }
    });

    // Notifikasi error jika form tidak diisi
    document.querySelectorAll("[required]").forEach((input) => {
        input.addEventListener("invalid", function (event) {
            event.target.setCustomValidity("Jangan lupa diisi ya!");
        });

        input.addEventListener("input", function (event) {
            event.target.setCustomValidity("");
        });
    });

    // Notifikasi sukses jika berhasil submit
    let toastElement = document.getElementById("toastNotif");
    if (toastElement) {
        let toast = new bootstrap.Toast(toastElement);
        toast.show();
    }
});

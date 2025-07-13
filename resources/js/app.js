import * as bootstrap from "bootstrap"; // Ini akan mengimport semua JS Bootstrap

// Contoh untuk tooltips
const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
);
const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
);

// document.addEventListener("DOMContentLoaded", function () {
//     if (window.jQuery && $("#tabel-pelanggan").length) {
//         $("#tabel-pelanggan").DataTable({
//             responsive: true,
//             language: {
//                 search: "Cari:",
//                 lengthMenu: "Tampilkan _MENU_ data",
//                 info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
//             },
//         });
//     }
// });

document.addEventListener("DOMContentLoaded", function () {
    const idPelFilter = document.getElementById("idPelFilter");
    const up3Filter = document.getElementById("up3Filter");
    const sektorFilter = document.getElementById("sektorFilter");
    const table = document.getElementById("tabel-pelanggan");

    if (idPelFilter && up3Filter && sektorFilter && table) {
        function filterTable() {
            const idPelValue = idPelFilter.value;
            const up3FilterValue = up3Filter.value;
            const sektorFilterValue = sektorFilter.value;
            const rows = table.querySelectorAll("tbody tr");

            rows.forEach((row) => {
                const idPelCell = row.querySelector("td:nth-child(2)"); // Kolom ID Pel
                const up3Cell = row.querySelector("td:nth-child(11)"); // Kolom UP3
                const sektorCell = row.querySelector("td:nth-child(9)"); // Kolom Sektor

                const idPelText = idPelCell ? idPelCell.textContent.trim() : "";
                const up3Text = up3Cell ? up3Cell.textContent.trim() : "";
                const sektorText = sektorCell
                    ? sektorCell.textContent.trim()
                    : "";

                const matchesIdPel = !idPelValue || idPelText === idPelValue;
                const matchesUp3 =
                    !up3FilterValue || up3Text === up3FilterValue;
                const matchesSektor =
                    !sektorFilterValue || sektorText === sektorFilterValue;

                row.style.display =
                    matchesIdPel && matchesUp3 && matchesSektor ? "" : "none";
            });
        }

        idPelFilter.addEventListener("change", filterTable);
        up3Filter.addEventListener("change", filterTable);
        sektorFilter.addEventListener("change", filterTable);
    }
});




import * as bootstrap from "bootstrap"; // Ini akan mengimport semua JS Bootstrap

// Contoh untuk tooltips
const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
);
const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
);

document.addEventListener("DOMContentLoaded", function () {
    if (window.jQuery && $("#tabel-pelanggan").length) {
        $("#tabel-pelanggan").DataTable({
            responsive: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            },
        });
    }
});

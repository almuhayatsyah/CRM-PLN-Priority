// import './bootstrap'; // Ini bisa dipertahankan jika file resources/js/bootstrap.js Anda sudah dimodifikasi
import * as bootstrap from "bootstrap"; // Ini akan mengimport semua JS Bootstrap

// Contoh untuk tooltips
const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
);
const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
);

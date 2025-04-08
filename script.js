document.addEventListener("DOMContentLoaded", function () {
    const pages = document.querySelectorAll(".page");
    const menu = document.getElementById("menu");

    // Fungsi untuk navigasi antar halaman
    function showPage(target) {
        pages.forEach(page => page.classList.add("hidden"));
        document.getElementById(target).classList.remove("hidden");
    }

    // Tombol navigasi ke halaman masing-masing
    document.getElementById("btn-profil").addEventListener("click", function () {
        showPage("profil");
    });

    document.getElementById("btn-privasi").addEventListener("click", function () {
        showPage("privasi");
    });

    document.getElementById("btn-notifikasi").addEventListener("click", function () {
        showPage("notifikasi");
    });

    document.getElementById("btn-kritik").addEventListener("click", function () {
        showPage("kritik");
    });

    // Tombol kembali
    document.querySelectorAll(".btn-back").forEach(button => {
        button.addEventListener("click", function () {
            showPage(this.dataset.target);
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll("button[data-target]");
    
    buttons.forEach(button => {
        button.addEventListener("click", function () {
            const targetId = this.getAttribute("data-target");
            const pages = document.querySelectorAll(".page");

            pages.forEach(page => page.classList.add("hidden"));
            document.getElementById(targetId).classList.remove("hidden");
        });
    });

    // Tambahkan event listener untuk tombol di menu utama
    document.getElementById("btn-tentang").addEventListener("click", function () {
        document.querySelectorAll(".page").forEach(page => page.classList.add("hidden"));
        document.getElementById("tentang").classList.remove("hidden");
    });
});
document.addEventListener("DOMContentLoaded", function () {
    // Tombol Navigasi
    document.querySelectorAll("button").forEach(button => {
        button.addEventListener("click", function () {
            let target = this.getAttribute("data-target");
            if (target) {
                document.querySelectorAll(".page").forEach(page => {
                    page.classList.add("hidden");
                });
                document.getElementById(target).classList.remove("hidden");
            }
        });
    });

    // Form Kritik & Saran
    document.getElementById("kritikForm").addEventListener("submit", function (event) {
        event.preventDefault();
        let nama = document.getElementById("nama-kritik").value;
        let pesan = document.getElementById("pesan-kritik").value;

        if (nama && pesan) {
            alert("Terima kasih atas kritik & saran Anda!");
            this.reset();
        } else {
            alert("Harap isi semua kolom!");
        }
    });
});
// Toggle password visibility
document.querySelectorAll('.toggle-password').forEach(button => {
    button.addEventListener('click', function () {
        let input = this.previousElementSibling;
        if (input.type === 'password') {
            input.type = 'text';
        } else {
            input.type = 'password';
        }
    });
});

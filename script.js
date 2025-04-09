const menuItems = document.querySelectorAll('.sidebar li');
const sections = document.querySelectorAll('.content-section');

menuItems.forEach(item => {
  item.addEventListener('click', () => {
    // Hapus kelas aktif
    menuItems.forEach(i => i.classList.remove('active'));
    sections.forEach(s => s.classList.remove('active'));

    // Tambahkan ke yang diklik
    item.classList.add('active');
    document.getElementById(item.dataset.target).classList.add('active');
  });
});
document.getElementById('form-akun').addEventListener('submit', function (e) {
    e.preventDefault(); // mencegah reload
  
    const data = {
      nama: document.getElementById('nama').value,
      tgl_lahir: document.getElementById('tgl_lahir').value,
      nik: document.getElementById('nik').value,
      no_hp: document.getElementById('no_hp').value,
      alamat: document.getElementById('alamat').value,
      email: document.getElementById('email').value
    };
  
    console.log("Data Akun:", data);
    alert("Data berhasil disimpan!");
  });
  document.getElementById('form-keamanan').addEventListener('submit', function(e) {
    e.preventDefault();
  
    const passwordLama = document.getElementById('password_lama').value;
    const passwordBaru = document.getElementById('password_baru').value;
    const konfirmasiPassword = document.getElementById('konfirmasi_password').value;
    const verifikasi2Langkah = document.getElementById('verifikasi_2langkah').checked;
    const sidikJari = document.getElementById('sidik_jari').checked;
  
    if (passwordBaru !== konfirmasiPassword) {
      alert("Konfirmasi sandi tidak cocok!");
      return;
    }
  
    const dataKeamanan = {
      passwordLama,
      passwordBaru,
      verifikasi2Langkah,
      sidikJari
    };
  
    console.log("Pengaturan Keamanan:", dataKeamanan);
    alert("Pengaturan privasi dan keamanan berhasil disimpan!");
  });
  function togglePassword(id) {
    const input = document.getElementById(id);
    if (input.type === "password") {
      input.type = "text";
    } else {
      input.type = "password";
    }
  }
// NOTIFIKASI - Simpan dan Muat Data dari localStorage
document.addEventListener("DOMContentLoaded", () => {
    const formNotif = document.getElementById("form-notifikasi");
  
    // Cek dan isi data jika sudah pernah disimpan
    if (localStorage.getItem("notifikasi")) {
      const saved = JSON.parse(localStorage.getItem("notifikasi"));
      document.getElementById("notif_email").checked = saved.notif_email;
      document.getElementById("notif_sms").checked = saved.notif_sms;
      document.getElementById("notif_aplikasi").checked = saved.notif_aplikasi;
      document.getElementById("bunyi_notif").value = saved.bunyi_notif;
      document.getElementById("waktu_notif").value = saved.waktu_notif;
    }
  
    // Saat form disubmit, simpan ke localStorage
    formNotif.addEventListener("submit", (e) => {
      e.preventDefault();
  
      const data = {
        notif_email: document.getElementById("notif_email").checked,
        notif_sms: document.getElementById("notif_sms").checked,
        notif_aplikasi: document.getElementById("notif_aplikasi").checked,
        bunyi_notif: document.getElementById("bunyi_notif").value,
        waktu_notif: document.getElementById("waktu_notif").value
      };
  
      localStorage.setItem("notifikasi", JSON.stringify(data));
      alert("Pengaturan notifikasi berhasil disimpan!");
    });
  });
  document.addEventListener("DOMContentLoaded", function () {
    const kritikForm = document.getElementById("form-kritik");
    const alertBox = document.getElementById("kritik-alert");
  
    kritikForm.addEventListener("submit", function (e) {
      e.preventDefault();
  
      // Ambil data dari form
      const nama = document.getElementById("kritik-nama").value;
      const email = document.getElementById("kritik-email").value;
      const pesan = document.getElementById("kritik-pesan").value;
  
      // Proses kirim data (simulasi, bisa ganti jadi fetch ke backend)
      console.log("Kritik terkirim:", { nama, email, pesan });
  
      // Reset form dan tampilkan notifikasi
      kritikForm.reset();
      alertBox.style.display = "block";
  
      // Sembunyikan alert setelah 3 detik
      setTimeout(() => {
        alertBox.style.display = "none";
      }, 3000);
    });
  });
      
# Materi 4: Membuat Aplikasi Kotak Saran dengan PHP dan MySQL

Selamat datang di materi keempat! Dalam sesi ini, kita akan membangun sebuah aplikasi web fungsional dari awal, yaitu **Aplikasi Kotak Saran**. Aplikasi ini memungkinkan pengguna untuk mengirimkan saran, kritik, atau aspirasi secara anonim, dan memungkinkan admin untuk melihat serta menanggapi pesan-pesan tersebut.

Materi ini dibagi menjadi dua bagian utama:

1.  **`tutorial/`**: Direktori ini berisi panduan langkah demi langkah untuk membangun aplikasi. Setiap `step` di dalamnya mewakili satu tahap pengembangan, memungkinkan Anda untuk belajar secara bertahap.
2.  **`kotak-saran/`**: Direktori ini berisi versi lengkap dan final dari aplikasi yang kita bangun. Anda bisa melihatnya sebagai referensi atau hasil akhir dari tutorial.

---

## Fitur Aplikasi

Aplikasi Kotak Saran ini memiliki beberapa fitur utama:

- **Formulir Pengiriman Anonim**: Pengguna dapat mengirimkan pesan tanpa perlu login.
- **Kategori Pesan**: Pengguna dapat memilih kategori untuk pesannya (misalnya, Umum, Akademik, dll.).
- **Kode Unik**: Setelah mengirim pesan, pengguna akan mendapatkan kode unik untuk melacak status dan balasan pesannya.
- **Cek Balasan**: Halaman khusus bagi pengguna untuk memasukkan kode unik dan melihat balasan dari admin.
- **Panel Admin**:
  - Login untuk admin.
  - Melihat semua saran yang masuk dengan paginasi.
  - Filter dan pencarian saran berdasarkan kategori atau isi pesan.
  - Memberikan balasan untuk setiap saran.
  - Manajemen akun admin (tambah, edit, hapus admin).

---

## Teknologi yang Digunakan

- **Backend**: PHP
- **Database**: MySQL
- **Frontend**: HTML dan CSS (dengan sedikit JavaScript untuk interaktivitas)

---

## Panduan Tutorial Step-by-Step

Direktori `tutorial/` memandu Anda melalui proses pembuatan aplikasi ini dalam 5 langkah.

### Step 1: Setup Awal dan Form Pengiriman

Pada tahap ini, kita fokus pada fondasi aplikasi:

- **`database.sql`**: Skema database untuk tabel `saran` dan `users`.
- **`config.php`**: Konfigurasi koneksi ke database.
- **`index.php`**: Halaman utama yang berisi formulir untuk mengirimkan saran. Pengguna akan mendapatkan kode unik setelah berhasil mengirim.
- **`assets/style.css`**: Styling dasar untuk tampilan aplikasi.

### Step 2: Fitur Cek Balasan

Tahap ini menambahkan fungsionalitas bagi pengguna untuk melihat status dan balasan dari saran mereka:

- **`cek_balasan.php`**: Halaman di mana pengguna dapat memasukkan kode unik mereka untuk melihat detail pesan dan balasan dari admin.

### Step 3: Sistem Login dan Halaman Admin

Di sini, kita mulai membangun sisi admin:

- **`login.php`**: Halaman login untuk admin.
- **`admin.php`**: Halaman admin yang dilindungi sesi. Halaman ini menampilkan daftar semua saran yang masuk, lengkap dengan paginasi, filter, dan fitur pencarian.
- **`logout.php`**: Skrip untuk mengakhiri sesi admin.
- **`seed.php`**: Skrip opsional untuk membuat akun admin pertama kali.

### Step 4: Fitur Membalas Pesan

Admin kini dapat berinteraksi dengan pengguna:

- **`proses_balasan.php`**: Skrip yang menangani logika untuk menyimpan balasan dari admin ke database.
- Formulir balasan diintegrasikan ke dalam halaman `admin.php` untuk setiap pesan.

### Step 5: Manajemen Admin

Tahap terakhir melengkapi panel admin dengan fitur manajemen pengguna:

- **`manage_admins.php`**: Halaman di mana admin utama dapat menambah, mengedit (mengubah password), atau menghapus akun admin lainnya.
- Fitur ini memastikan bahwa aplikasi dapat dikelola oleh lebih dari satu orang jika diperlukan.

---

## Aplikasi Final (`kotak-saran/`)

Direktori `kotak-saran/` adalah hasil akhir dari semua langkah dalam tutorial. Ini adalah aplikasi yang sudah jadi dan siap digunakan. Anda dapat menjalankan aplikasi ini secara langsung untuk melihat bagaimana semua fitur bekerja bersama.

### Cara Menjalankan Aplikasi:

1.  **Database**:

    - Buat database baru di MySQL (misalnya, `db_kotak_saran`).
    - Impor skema dari `tutorial/step-1/database.sql`.
    - Pastikan kredensial database di `kotak-saran/config.php` sudah sesuai.

2.  **Web Server**:

    - Jalankan folder `kotak-saran/` menggunakan web server lokal seperti XAMPP.

3.  **Akun Admin**:
    - Jalankan file `tutorial/step-3/seed.php` sekali untuk membuat akun admin default (`username: admin`, `password: admin123`).
    - Setelah itu, Anda bisa login dan mengelola admin lain melalui halaman manajemen admin.

Selamat belajar dan bereksperimen! `Semangat comit, salam teknologi!!`

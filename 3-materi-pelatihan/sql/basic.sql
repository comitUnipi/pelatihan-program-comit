-- membuat database
CREATE DATABASE toko;

-- menggunakan database toko
USE toko;

-- membuat tabel produk
CREATE TABLE produk (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100),
  harga DECIMAL(10, 2),
  stok INT,
);

-- menambah data ke tabel produk
INSERT INTO produk (nama, harga, stok) 
VALUES ('Roti Tawar', 10000, 50);


-- melihat semua data di tabel produk
SELECT * FROM produk;

-- melihat data dengan kolom tertentu
SELECT nama, harga FROM produk;

-- mengupdate data di tabel produk
UPDATE produk
SET harga = 12000
WHERE id = 1;

-- menghapus data di tabel produk
DELETE FROM produk
WHERE id = 1;

-- relasi 2 tabel
-- membuat tabel kategori
-- Membuat tabel kategori
CREATE TABLE kategori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100)
);

-- membuat tabel produk dengan relasi ke kategori
CREATE TABLE produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_produk VARCHAR(100),
    harga DECIMAL(10,2),
    kategori_id INT,
    FOREIGN KEY (kategori_id) REFERENCES kategori(id)
);

-- menambah data ke tabel kategori
INSERT INTO kategori (nama_kategori) 
VALUES ('Makanan'), ('Minuman');

-- menambah data ke tabel produk
INSERT INTO produk (nama_produk, harga, kategori_id) 
VALUES ('Roti Tawar', 10000, 1), ('Teh Botol', 5000, 2);

-- menampilkan data produk dengan kategori
SELECT * FROM produk
JOIN kategori ON produk.kategori_id = kategori.id;
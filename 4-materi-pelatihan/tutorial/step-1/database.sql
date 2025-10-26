CREATE DATABASE db_kotak_saran;

USE db_kotak_saran;

CREATE TABLE saran (
  id int AUTO_INCREMENT PRIMARY KEY,
  pesan text NOT NULL,
  waktu_dibuat timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  kategori varchar(50) DEFAULT 'Umum',
  status varchar(50) DEFAULT 'Baru',
  kode_unik varchar(255) NOT NULL,
  balasan text
);

CREATE TABLE users (
  id int AUTO_INCREMENT PRIMARY KEY,
  username varchar(50) NOT NULL,
  password varchar(255) NOT NULL,
  created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP
);

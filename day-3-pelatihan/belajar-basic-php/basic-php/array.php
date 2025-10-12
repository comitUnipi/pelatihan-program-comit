<?php
$buah = ["Apel", "Jeruk", "Mangga"];

foreach ($buah as $item) {
  echo "Buah: $item <br>";
}


// Contoh array asosiatif
$mahasiswa = [
  "nama" => "Jhon Doe",
  "umur" => 20,
  "jurusan" => "Teknologi Informasi"
];

echo "Nama: " . $mahasiswa["nama"] . "<br>";
echo "Umur: " . $mahasiswa["umur"] . "<br>";
echo "Jurusan: " . $mahasiswa["jurusan"];


// Contoh array multidimensi
$produk = [
  ["nama" => "Laptop", "harga" => 8000000],
  ["nama" => "Mouse", "harga" => 150000],
  ["nama" => "Keyboard", "harga" => 300000],
];

foreach ($produk as $item) {
  echo "Produk: " . $item["nama"] . ", Harga: " . $item["harga"] . "<br>";
}

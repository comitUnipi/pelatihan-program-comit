<?php
function halo($nama)
{
  return "Halo, $nama!";
}

echo halo("Comit");


function tambah($a, $b)
{
  return $a + $b;
}

echo "<br>";
echo "Hasil penjumlahan: 100 + 500 = ";
echo tambah(100, 500);


function cekUmur($umur)
{
  if ($umur >= 18) {
    return "Kamu sudah dewasa.";
  } else {
    return "Kamu masih anak-anak.";
  }
}

echo "<br>";
echo cekUmur(20);

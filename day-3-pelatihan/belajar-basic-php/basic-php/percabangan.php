<?php
$nilai = 80;

if ($nilai >= 70) {
  echo "Selamat, Anda lulus ujian!";
} else {
  echo "Maaf, Anda tidak lulus ujian.";
}

echo "<br>";

// percabangan menggunakan switch
$hari = "Minggu";

switch ($hari) {
  case "Senin":
    echo "Hari ini kuliah.";
    break;
  case "Minggu":
    echo "Hari ini ada pelatihan COMIT.";
    break;
  default:
    echo "Hari libur atau tidak terdaftar.";
}

echo "<br>";

// contoh menggabung beberapa kondisi
// dengan menggunakan operator logika
// && (AND) dan || (OR)

$umur = 25;
$memiliki_sim = true;

if ($umur >= 17 && $memiliki_sim) {
  echo "Anda boleh mengemudi.";
} else {
  echo "Anda belum boleh mengemudi.";
}

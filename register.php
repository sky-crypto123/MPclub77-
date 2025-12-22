<?php
include "config.php";

$data = json_decode(file_get_contents("php://input"), true);
$nama = trim($data['nama']);

if(!$nama){
  echo json_encode(["status"=>"error","msg"=>"Nama player wajib diisi"]);
  exit;
}

if(!str_contains($nama, "_")){
  echo json_encode(["status"=>"error","msg"=>"Gunakan format Nama_Belakang"]);
  exit;
}

/* cek sudah terdaftar */
$cek = mysqli_query($conn, "SELECT id FROM whitelist_players WHERE nama_player='$nama'");
if(mysqli_num_rows($cek) > 0){
  echo json_encode(["status"=>"error","msg"=>"Nama player sudah terdaftar"]);
  exit;
}

/* simpan */
mysqli_query($conn, "INSERT INTO whitelist_players (nama_player) VALUES ('$nama')");

echo json_encode(["status"=>"ok"]);
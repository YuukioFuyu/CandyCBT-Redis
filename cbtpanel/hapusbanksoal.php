<?php
// require("../config/config.default.php");
include("core/c_admin.php"); 
require("../config/config.function.php");

(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
($id_pengawas==0) ? header('location:index.php'):null;


$kode = $_POST['kode'];
$exec = mysqli_query($koneksi, "DELETE a.*, b.* FROM mapel a JOIN soal b ON a.id_mapel = b.id_mapel WHERE a.id_mapel in (" . $kode . "')");
$exec = mysqli_query($koneksi, "DELETE FROM soal WHERE id_mapel in (" . $kode . ")");
$exec = mysqli_query($koneksi, "DELETE FROM mapel  WHERE id_mapel in (" . $kode . ")");
$exec = mysqli_query($koneksi, "DELETE FROM file_pendukung  WHERE id_mapel in (" . $kode . ")");
$db->DelRedisAll();
if ($exec) {
	echo 1;
} else {
	echo 0;
}

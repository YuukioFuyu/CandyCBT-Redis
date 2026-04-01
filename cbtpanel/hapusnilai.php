<?php

require("../config/config.default.php");
require("../config/config.function.php");

(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
($id_pengawas==0) ? header('location:index.php'):null;

$kode = $_POST['id'];

$exec = mysqli_query($koneksi, "DELETE FROM nilai_pindah WHERE id_ujian='$kode' and ujian_selesai<>''");

<?php

require("../config/config.default.php");
require("../config/config.function.php");
(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
($id_pengawas==0) ? header('location:index.php'):null;

$kode = $_POST['id'];
$query = mysqli_query($koneksi, "UPDATE nilai set online='0', selesai=null where id_siswa = '$kode'");
	mysqli_query($koneksi, "DELETE FROM login where id_siswa = '$kode'");
if ($query) {
	echo 1;
} else {
	echo 0;
}

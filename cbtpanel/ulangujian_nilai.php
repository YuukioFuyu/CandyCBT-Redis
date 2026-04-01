<?php
require("../config/config.default.php");
require("../config/config.function.php");
require("../config/functions.crud.php");
if (!isset($_SESSION['id_pengawas']))
{
 	jump("$homeurl");
exit;
}
$tabel='nilai_pindah';
$idnilai = $_POST['id'];
$nilai = fetch($koneksi, $tabel, array('id_nilai' => $idnilai));
$idu = $nilai['id_ujian'];
$idm = $nilai['id_mapel'];
$ids = $nilai['id_siswa'];
$where2 = array(
    'id_mapel' => $idm,
    'id_siswa' => $ids,
    'id_ujian' => $idu
);
delete($koneksi, $tabel, ['id_nilai' => $idnilai]);
delete($koneksi, 'pengacak', $where2);
//delete($koneksi, 'pengacakopsi', $where2);
delete($koneksi, 'jawaban', $where2);
delete($koneksi, 'jawaban_copy', $where2);

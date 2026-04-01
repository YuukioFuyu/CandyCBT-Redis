<?php
require "../config/config.database.php";
// $exec = mysqli_query($koneksi, "truncate siswa");
// $exec = mysqli_query($koneksi, "truncate mapel");
// $exec = mysqli_query($koneksi, "truncate soal");
// $exec = mysqli_query($koneksi, "truncate ujian");
$sql = mysqli_query($koneksi, "DELETE FROM soal");
$sql = mysqli_query($koneksi, "ALTER TABLE soal AUTO_INCREMENT =1");
$sql = mysqli_query($koneksi, "DELETE FROM mapel");
$sql = mysqli_query($koneksi, "ALTER TABLE mapel AUTO_INCREMENT =1");
$sql = mysqli_query($koneksi, "DELETE FROM mata_pelajaran");
$sql = mysqli_query($koneksi, "ALTER TABLE mata_pelajaran AUTO_INCREMENT =1");
$sql = mysqli_query($koneksi, "DELETE FROM ujian");
$sql = mysqli_query($koneksi, "ALTER TABLE ujian AUTO_INCREMENT =1");

$sql = mysqli_query($koneksi, "DELETE FROM kelas");
$sql = mysqli_query($koneksi, "ALTER TABLE kelas AUTO_INCREMENT =1");
$sql = mysqli_query($koneksi, "DELETE FROM level");
$sql = mysqli_query($koneksi, "ALTER TABLE level AUTO_INCREMENT =1");
$sql = mysqli_query($koneksi, "DELETE FROM pk ");
$sql = mysqli_query($koneksi, "ALTER TABLE pk AUTO_INCREMENT =1");
;
$sql = mysqli_query($koneksi, "DELETE FROM sesi");
$sql = mysqli_query($koneksi, "ALTER TABLE sesi AUTO_INCREMENT =1");
$sql = mysqli_query($koneksi, "DELETE FROM ruang");
$sql = mysqli_query($koneksi, "ALTER TABLE ruang AUTO_INCREMENT =1");

$sql = mysqli_query($koneksi, "DELETE FROM siswa");
$sql = mysqli_query($koneksi, "ALTER TABLE siswa AUTO_INCREMENT =1");
$sql = mysqli_query($koneksi, "DELETE FROM siswa");
$sql = mysqli_query($koneksi, "ALTER TABLE siswa AUTO_INCREMENT =1");


$exec = mysqli_query($koneksi, "update sinkron set jumlah='', status_sinkron='0',tanggal='' where nama_data='JURUSAN'");
$exec = mysqli_query($koneksi, "update sinkron set jumlah='', status_sinkron='0',tanggal='' where nama_data='KELAS'");
$exec = mysqli_query($koneksi, "update sinkron set jumlah='', jumlah='', status_sinkron='0',tanggal='' where nama_data='SISWA'");
$exec = mysqli_query($koneksi, "update sinkron set jumlah='', status_sinkron='0',tanggal='' where nama_data='MAPEL'");
$exec = mysqli_query($koneksi, "update sinkron set jumlah='', status_sinkron='0',tanggal='' where nama_data='SOAL'");
$exec = mysqli_query($koneksi, "update sinkron set jumlah='', status_sinkron='0',tanggal='' where nama_data='JADWAL'");
$exec = mysqli_query($koneksi, "update sinkron set jumlah='', status_sinkron='0',tanggal='' where nama_data='SETTING'");
$exec = mysqli_query($koneksi, "update sinkron set jumlah='', status_sinkron='0',tanggal='' where nama_data='BANK_SOAL'");
$exec = mysqli_query($koneksi, "update sinkron set jumlah='', status_sinkron='0',tanggal='' where nama_data='FILE_PENDUKUNG'");
$files = glob('../files/*'); //get all file names
foreach ($files as $file) {
    if (is_file($file))
        unlink($file); //delete file
}
echo "Reset berhasil ...";

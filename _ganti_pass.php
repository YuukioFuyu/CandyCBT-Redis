<?php
include("core/c_user.php"); 
require("config/config.function.php");
require("config/functions.crud.php");

if(!isset($_SESSION['id_siswa'])){
    header('location:logout.php');
}else{
$pass = $_POST['pass'];

$id_siswa = $_SESSION['id_siswa'];
    $data = array(
        'password' => $pass
    );
    $where = array(
        'id_siswa' => $id_siswa,
    );
        //insert($koneksi, 'jawaban_tugas', $data);
    $exc = update($koneksi, 'siswa', $data, $where);
   if($exc =='OK'){
    echo 1;
   }
   else{
    echo 0;
   }
}


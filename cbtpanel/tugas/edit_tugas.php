<?php
require("../../config/config.default.php");
require("../../config/config.function.php");
require("../../config/functions.crud.php");
cek_session_guru();
$id = $_POST['id'];
$id_mapel = addslashes($_POST['mapel']);
// $id_guru = $_SESSION['id_pengawas'];
if(empty($_POST['idguru'])){ $id_guru = $_SESSION['id_pengawas']; }else{ $id_guru =$_POST['idguru']; }
$tugas = addslashes($_POST['isitugas']);
$judul = $_POST['judul'];
$tgl_mulai = $_POST['tgl_mulai'];
$tgl_selesai = $_POST['tgl_selesai'];
$status_tugas = $_POST['status_tugas'];
$kelas = serialize($_POST['kelas']);
$id_guru = $_POST['idguru'];


$ektensi = ['jpg', 'png','xlsx','pdf','docx','doc','xls','ppt','pptx'];
if ($_FILES['file']['name'] <> '') {
    $file = str_replace(" ","_",$_FILES['file']['name']);
    $temp = $_FILES['file']['tmp_name'];
    $ext = explode('.', $file);
    $ext = end($ext);
    if (in_array($ext, $ektensi)) {
        $dest = '../../'.$linkguru.'/tugas/'.$id_guru.'/';
        $path = $dest . $file;
        $upload = move_uploaded_file($temp, $path);
        if ($upload) {
            $data = array(
                'mapel' => strtoupper($id_mapel),
                'id_guru' => $id_guru,
                'kelas' => $kelas,
                'judul' => strtoupper($judul),
                'tugas' => $tugas,
                'tgl_mulai' => $tgl_mulai,
                'tgl_selesai' => $tgl_selesai,
                'file' => $file,
                'status' =>$status_tugas,
                
            );
            update($koneksi, 'tugas', $data, ['id_tugas' => $id]);
            echo 'ok';
        } else {
            echo "gagal";
        }
    }
} else {
    $data = array(
        'mapel' => strtoupper($id_mapel),
        'kelas' => $kelas,
        'id_guru' => $id_guru,
        'judul' => strtoupper($judul),
        'tugas' => $tugas,
        'tgl_mulai' => $tgl_mulai,
        'tgl_selesai' => $tgl_selesai,
        'status' =>$status_tugas,
        

    );
    update($koneksi, 'tugas', $data, ['id_tugas' => $id]);
   
    echo "ok";
}

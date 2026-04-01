<?php
class Nilai extends Db{
  /*
    -&materi
  */
  private function idsiswa(){ 
    $idsiswa = $_SESSION['id_siswa'];
    return $idsiswa;
   }
   private function idkelas(){ 
    $idkelas = $_SESSION['id_kelas'];
    return $idkelas;
   }

//kirim nilai
   function send_nilai(){
    print_r($_POST);
   }
   function cek_jawaban($idujian,$idmapel,$idsiswa,$soal,$jenis){
    $sql="SELECT * FROM jawaban WHERE id_ujian=$idujian and id_mapel=$idmapel and id_siswa=$idsiswa and id_soal=$soal and jenis=$jenis ";
    $log=$this->con->query($sql) or die($this->con->error);
    $total = mysqli_num_rows($log);
    return $total;
   }
   function insert($table,$data=null) {
        $command = 'INSERT INTO '.$table;
        $field = $value = null;
        foreach($data as $f => $v) {
            $field  .= ','.$f;
            $value  .= ", '".$v."'";
        }
        $command .=' ('.substr($field,1).')';
        $command .=' VALUES('.substr($value,1).')';
        //$exec = mysqli_query($koneksi, $command);
        $exec = $this->con->query($command) or die($this->con->error);
        ($exec) ? $status = 1 : $status = 0;
        return $status;
    }
    function update($table,$data=null,$where=null) {
        $command = 'UPDATE '.$table.' SET ';
        $field = $value = null;
        foreach($data as $f => $v) {
            $field  .= ",".$f."='".$v."'";
        }
        $command .= substr($field,1);
        if($where!=null) {
          foreach($where as $f => $v) {
            $value .= "#".$f."='".$v."'";
          }
          $command .= ' WHERE '.substr($value,1);
          $command = str_replace('#',' AND ',$command);
        }
            //$exec = mysqli_query($koneksi, $command);
        $exec = $this->con->query($command) or die($this->con->error);
            ($exec) ? $status = 1 : $status = 0;
            return $status; 
    }
    function v_ujian_histori($id){
   
    $sql="SELECT history FROM ujian where id_ujian='$id'";
    $log=$this->con->query($sql) or die($this->con->error);
    $sett=mysqli_fetch_array($log);
    return $sett;
    
  }
  function Status_sudah_ujian($id_siswa,$id_ujian){
      $sql="SELECT selesai FROM nilai WHERE id_ujian='$id_ujian' AND id_siswa='$id_siswa'";
      $log=$this->con->query($sql) or die($this->con->error);
      $sett=mysqli_fetch_array($log);
      return $sett;

    }
   
}
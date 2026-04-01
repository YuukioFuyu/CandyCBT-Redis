<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_anso extends CI_model {

	function __construct(){
    parent::__construct(); 
    $this->db->protect_identifiers('mapel', TRUE);
    $this->db->protect_identifiers('pengawas', TRUE);
  }
  
  public function v_daftar_ujia($id=null){ 
    if($id != null){
      $query =$this->db->select('mapel.id_mapel,ujian.nama as nama_mapel,ujian.jml_soal,ujian.jml_esai,ujian.tampil_pg,ujian.tampil_esai,ujian.bobot_pg,ujian.bobot_esai,ujian.level,ujian.opsi,pengawas.nama as nama_guru');
      $query = $this->db->join('pengawas', 'pengawas.id_pengawas=mapel.idguru');
      $query = $this->db->join('ujian', 'ujian.id_mapel=mapel.id_mapel');
      $query = $this->db->get_where('mapel', array('idguru'=>$id));
    }
    else{
      $query =$this->db->select('mapel.id_mapel,ujian.nama as nama_mapel,ujian.jml_soal,ujian.jml_esai,ujian.tampil_pg,ujian.tampil_esai,ujian.bobot_pg,ujian.bobot_esai,ujian.level,ujian.opsi,pengawas.nama as nama_guru');
      $query = $this->db->join('pengawas', 'pengawas.id_pengawas=mapel.idguru');
      $query = $this->db->join('ujian', 'ujian.id_mapel=mapel.id_mapel');
      $query = $this->db->get('mapel');
    }
    return $query->result();
  }
  function select_ujian($id){
    return $this->db->get_where('mapel', array('id_mapel'=>$id))->result();
  }
  function select_soal($id){
    return $this->db->get_where('soal', array('id_mapel'=>$id))->result();
  }
  function nilai_rata2($id){
    $this->db->select('ROUND(((SUM(skor)+SUM(nilai_esai))/COUNT(id_nilai)),2) AS jml_nilai');
    return $this->db->get_where('nilai', array('id_mapel'=>$id))->row_array();
  }
  function jawaban_siswa($id){
    //melakukan pencocokan jawaban benar pada semua siswa yg sudah ujian
    $log=$this->db->select('id_siswa,id_soal,jawaban ');
    $log=$this->db->get_where('nilai', array('id_mapel'=>$id))->result();

    // tahap ke 1 -------------------------------
   foreach ($log as $soal) {
      //tampung semua data nilai di array
      $data[]= array(
        'id_siswa' =>$soal->id_siswa,
        'id_soal'=>$soal->id_soal,
        'jawaban'=>$soal->jawaban,
      );
    }

    // tahap ke 2 -------------------------------
    //tamnpung ke array semua dari looping 
    foreach ($data as $value) {  //data dari tabel nilai
      //$array[]=explode(',',$value['id_soal']);
      $id_siswa_array[]=$value['id_siswa'];
      $jawab[]=$value['jawaban'];
      
    }
    
    return $jawab;
  }


}
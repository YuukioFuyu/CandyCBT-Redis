<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_excel extends CI_model {

	function __construct(){
    parent::__construct(); 
   
  }
  public function setting(){
    $this->db->cache_on();
    return $this->db->get('setting')->row_array();
  }
// untuk export nilai ke excel  
  public function get_row_ujian($idujian){
    $this->db->cache_off();
    $this->db->select('*');
    $this->db->from('ujian');
    $this->db->where('id_ujian',$idujian);
    return $this->db->get()->row_array();
  }
  public function get_soal($idmapel,$num)
  {
    $this->db->cache_off();
    $this->db->select('*');
    $this->db->from('soal');
    $this->db->where('id_mapel',$idmapel);
    $this->db->where('nomor',$num);
    return $this->db->get()->row_array();
  }
  public function get_excel_siswa($idkelas,$idjurusan,$idujian)
  {
    $this->db->cache_off();
    // if($idkelas != null and $idujian != ""){
    //   $where = $this->db->where('id_kelas',$idkelas);
    //   $where = $this->db->where('nilai.id_ujian',$idujian);
    // }
    // elseif($idjurusan !=null and $idujian != ""){
    //   $where = $this->db->where('idpk',$idjurusan);
    //   $where = $this->db->where('nilai.id_ujian',$idujian);
    // }
    // else{
      $where = $this->db->where('nilai.id_ujian',$idujian);
    //}
    $this->db->select('*');
    $this->db->from('siswa');
    $this->db->join('nilai', 'siswa.id_siswa = nilai.id_siswa','LEFT');
    $where;
    $this->db->order_by('id_kelas ASC');
    return $this->db->get()->result();
  }
  public function get_excel_nilai($id_mapel,$id_siswa){
    $this->db->cache_off();
    $this->db->select('*');
    $this->db->from('nilai');
    $this->db->where('id_mapel',$id_mapel);
    $this->db->where('id_siswa',$id_siswa);
    return $this->db->get()->row_array();
   }
  public function get_soal_byid($idsoal)
  {
    $this->db->cache_off();
    $this->db->select('*');
    $this->db->from('soal');
    $this->db->where('id_soal',$idsoal);
    $this->db->order_by('nomor ASC');
    return $this->db->get()->row_array();
  }
// end untuk export nilai ke excel

// untuk export nilai tugas
  function get_tugas_id($id){
    return $this->db->get_where('tugas', array('id_tugas' => $id))->row_array();
  }
  function get_nilai_tugas($id){
    $this->db->cache_off();
    $this->db->join('siswa', 'jawaban_tugas.id_siswa = siswa.id_siswa','INNER');
    $this->db->order_by('nama ASC');
    return $this->db->get_where('jawaban_tugas', array('id_tugas' => $id))->result();
  }
// end export nilai tugas

}
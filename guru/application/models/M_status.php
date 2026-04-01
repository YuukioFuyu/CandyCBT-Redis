<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_status extends CI_model {

	function __construct(){
    parent::__construct(); 
    $this->db->protect_identifiers('nilai', TRUE);
  }
  
  public function v_statsu_ujian($id){ 
    $this->db->select("id_nilai, nis, siswa.nama, kelas.nama AS kelas, ujian.nama AS mapel, ipaddress, mapel.level,nilai.kode_ujian,IF(ujian_selesai !='', 'Tes Selesai','Masih Dikerjakan') AS status_ujian,total, jml_benar, jml_salah,skor,ujian_berlangsung, ujian_mulai, ujian_selesai,TIMEDIFF(ujian_berlangsung, ujian_mulai) AS selisih");
    $this->db->from('nilai');
    $this->db->join('ujian', 'nilai.id_ujian=ujian.id_ujian');
    $this->db->join('siswa', 'nilai.id_siswa=siswa.id_siswa');
    $this->db->join('kelas', 'siswa.id_kelas=kelas.id_kelas');
    $this->db->join('mapel', 'nilai.id_mapel = mapel.id_mapel');
    $this->db->where("ujian.status='1' AND nilai.id_siswa<>''AND DATE(ujian_mulai) = CURDATE() AND  siswa.id_kelas='".$id."'");
    return $this->db->get()->result();
  }


}
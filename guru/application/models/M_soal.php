<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_soal extends CI_model {

	function __construct(){
    parent::__construct(); 
    $this->db->protect_identifiers('mapel', TRUE);
    $this->db->protect_identifiers('pengawas', TRUE);
  }
  
  public function v_daftar_ujia($id=null){ 
    if($id != null){
      $query =$this->db->select('mapel.id_mapel,mapel.nama as nama_mapel,mapel.jml_soal,mapel.kelas,mapel.jml_esai,mapel.tampil_pg,mapel.tampil_esai,mapel.bobot_pg,mapel.bobot_esai,mapel.level,mapel.opsi,pengawas.nama as nama_guru');
      $query = $this->db->join('pengawas', 'pengawas.id_pengawas=mapel.idguru','LEFT');
      $query = $this->db->get_where('mapel', array('idguru'=>$id));
    }
    else{
      $query =$this->db->select('mapel.id_mapel,mapel.nama as nama_mapel,mapel.jml_soal,mapel.kelas,mapel.jml_esai,mapel.tampil_pg,mapel.tampil_esai,mapel.bobot_pg,mapel.bobot_esai,mapel.level,mapel.opsi,pengawas.nama as nama_guru');
      $query = $this->db->join('pengawas', 'pengawas.id_pengawas=mapel.idguru');
      $query = $this->db->get('mapel');
    }
    return $query->result();
  }
  function select_ujian($id){
    return $this->db->get_where('mapel', array('id_mapel'=>$id))->result();
  }
  function select_ujian2($id){
    return $this->db->get_where('mapel', array('id_mapel'=>$id));
  }
  function select_soal_pg($id){
    return $this->db->get_where('soal', array('id_mapel'=>$id,'jenis'=>1))->result();   
  }
  function select_soal_pg2($id){
    return $this->db->get_where('soal', array('id_mapel'=>$id));   
  }
  function select_soal_id($id){
    return $this->db->get_where('soal', array('id_soal'=>$id,'jenis'=>1))->result();
  }
  
  


}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kls_lv_pk extends CI_model {

	function __construct(){
    parent::__construct(); 
  }
  function cache($id){
    $this->output->cache($id); 
  }

  
//&program_keahlian -------------------------------------------------------------------  
  public function get_pk()
  {
    $this->db->order_by('program_keahlian', 'ASC');
    return $this->db->get('pk');
  }
//&level -------------------------------------------------------------------  
  public function get_level()
  {
    return $this->db->get('level');
  }
//&kelas -------------------------------------------------------------------  
  public function get_kelas_by($id)
  {
    if($id=="semua"){
      return $this->db->get_where('kelas');
    }
    else{
      return $this->db->get_where('kelas',array('id_level' => $id));
    }
  }
//&siswa -------------------------------------------------------------------  
  public function get_siswa_by($id){
    if($id=="semua"){
      $this->db->select('id_siswa,nama');
      return $this->db->get('siswa');
    }
    else{
      $this->db->select('id_siswa,nama');
      return $this->db->get_where('siswa',array('level' => $id));
    }
    
  }



}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_login extends CI_model {

	function __construct(){
    parent::__construct(); 
    $this->db->protect_identifiers('pengawas', TRUE);
  }
  function cache($id){
    $this->output->cache($id); 
  }
  
  public function setting(){
    $this->db->select('*');
    $this->db->from('setting');
    return $this->db->get()->row_array();
  }
  function cek_login($data,$tabel){
    return $this->db->get_where($tabel,$data);
  }





}
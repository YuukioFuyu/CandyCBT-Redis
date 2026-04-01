<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_mapel extends CI_model {

	function __construct(){
    parent::__construct();
  }
  function cache($id){
    $this->output->cache($id); 
  }
  
  
//&mapel_ujian -------------------------------------------------------------------  
  public function get_mapel_ujian()
  {
    $this->db->order_by('nama_mapel', 'ASC');
    return $this->db->get('mata_pelajaran');
  }




}
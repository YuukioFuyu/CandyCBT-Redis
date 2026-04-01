<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_savesoal extends CI_model {

	function __construct(){
    parent::__construct(); 
  }
  
  public function select_max(){ //jumlah soal
    $this->db->select_max('qid', 'maxi');
    $query = $this->db->get('savsoft_qbank');
    return $query->result();
  }
  public function select_max2(){ //jumlah opsi
    $this->db->select_max('oid', 'maxop');
    $query = $this->db->get('savsoft_options');
    return $query->result();
  }

  public function select_savsoft_qbank($where=null){ // selelct tabel savsof_qbank
    if($where != null){
      return $this->db->get_where('savsoft_qbank', array('qid' => $where));
    }
    else{
       return $this->db->get('savsoft_qbank')->result();
    }
   
  }
  public function select_savsoft_options($id){ // selelct tabel savsoft_options by id
    $this->db->select_min('oid', 'mini');
    return $this->db->get_where('savsoft_options', array('qid' => $id))->result_array();
  }
  public function select_savsoft_options2($id1,$id2){
    return $this->db->get_where('savsoft_options', array('qid' => $id1,'oid'=>$id2));
  }
  public function select_savsoft_options3($id){
    return $this->db->get_where('savsoft_options', array('qid' => $id));
  }
  public function hapus_savsoft_options2($id1,$id2){
    return $this->db->delete('savsoft_options', array('qid' => $id1,'oid'=>$id2));
  }
  public function insert_soal($data){
    return $this->db->insert('soal', $data);
  }
  public function insert_dukung($data){
    return $this->db->insert('file_pendukung', $data);
  }
  public function truncate($tabel){
    return $this->db->truncate($tabel);
  }
  
  
  


}
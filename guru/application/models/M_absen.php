<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_absen extends CI_model {

	function __construct(){
    parent::__construct(); 
    $this->db->protect_identifiers('pengawas', TRUE);
  }
  function cache($id){
    $this->output->cache($id); 
  }
  

  
  
//&absen ------------------------------
  public function getTahun()
  {
    $this->db->distinct();
    $this->db->select('YEAR(amaTgl) AS tahun');
    return $this->db->get('absensi_mapel_anggota')->result();
  }
  public function get_absen_mapel($kelas=null,$mapel=null)
  {
    if(!empty($kelas)){
      $where=array(
        'amKelas' => $kelas,
        'amIdMapel'=> $mapel,
      );
      $this->db->select('*');
      $this->db->from('absensi_mapel');
      $this->db->where($where);
      return $this->db->get()->result();
    }
    
  }
  public function get_absen_mapel_by_id($idguru=null)
  {
    if(!empty($idguru)){
      $where=array(
        'amIdGuru' => $idguru,
      );
      $this->db->select('*');
      $this->db->from('absensi_mapel');
      $this->db->join('mata_pelajaran', 'absensi_mapel.amIdMapel = mata_pelajaran.idmapel');
      $this->db->join('kelas', 'absensi_mapel.amKelas = kelas.idkls');
      $this->db->where($where);
      return $this->db->get()->result();
    }
    
  }
  public function get_absen_mapel_siswa(){
    $tahun = @$_GET['tahun'];
    $bulan = @$_GET['bulan'];
    $kelas = @$_GET['kelas'];
    $mapel = @$_GET['mapel'];
    
    if(!empty($tahun)){
      $kelas2 = $this->db->get_where('kelas', array('idkls' => $kelas))->row_array();
      $mapel_absen = $this->db->get_where('absensi_mapel', array('amId' => $mapel))->row_array();
      $mapel2 = $this->db->get_where('mata_pelajaran', array('idmapel' => $mapel_absen['amIdMapel']))->row_array();
      $allsiswa=$this->db->get_where('siswa', array('id_kelas' => $kelas2['id_kelas'],'status_siswa' => 1))->result();
      foreach ($allsiswa as $value) {
          $where=array(
          'amaIdSiswa' => $value->id_siswa,
          'amaIdKelas' => $kelas,
          'amaIdAbsenMapel'  =>$mapel,
          'YEAR(amaTgl)' => $tahun,
          'MONTH(amaTgl)' => $bulan,
        );
        $this->db->where($where);
        
        $this->db->from('absensi_mapel_anggota');
        // $this->db->join('absensi_mapel', 'absensi_mapel_anggota.amaIdAbsenMapel = absensi_mapel.amId');
        $this->db->join('mata_pelajaran', 'absensi_mapel_anggota.amaIdMapel = mata_pelajaran.idmapel');
        //$this->db->join('kelas', 'absensi_mapel_anggota.amaIdKelas = kelas.idkls');
        $this->db->join('siswa', 'absensi_mapel_anggota.amaIdSiswa = siswa.id_siswa');
        $siswa = $this->db->get()->row_array();
        if($siswa > 1){
          $dataabse = array(
          'nama_siswa'  =>$value->nama,
          'kelas'  =>$value->id_kelas,
          'mapel'  =>$mapel2['nama_mapel'],
          'tgl'  =>$siswa['amaTgl'],
          'hari'  =>$mapel_absen['amHari'],
          'jamin'  =>$siswa['amaJamIn'],
          'status'  =>$siswa['amaStatus'],
          );
          
        }
        else{
          $dataabse = array(
          'nama_siswa'  =>$value->nama,
          'kelas'  =>$value->id_kelas,
          'mapel'  =>$mapel2['nama_mapel'],
          'tgl'  =>'-',
          'hari'  =>$mapel_absen['amHari'],
          'jamin'  =>'-',
          'status'  =>'A',
          );
          
        }
        $data3[]=$dataabse;
        

      }
      return $data3;

      


    }
    else{
      $data3=array();
    }
  }
  


}
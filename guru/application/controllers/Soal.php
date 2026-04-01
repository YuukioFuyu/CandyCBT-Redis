<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Soal extends CI_Controller {
	
	function __construct(){
    parent::__construct(); 
    //cek_session(); // untuk cek_sesion login di helper, agar bisa akases conttroler
    $this->load->model('M_login'); 
    $this->load->model('M_soal','soal'); 
    $this->load->model('M_mapel');
    $this->load->model('M_kls_lv_pk','klp'); 
    $this->load->helper(array('fungsi','crud'));  
    date_default_timezone_set('Asia/Jakarta');
    // $error = $db->error()
  }
  function cache($id){
  	$this->output->cache($id); 
  }
  function clear_cache(){
		$this->db->cache_delete_all();
		
    $path = $this->config->item('cache_path');

    $cache_path = ($path == '') ? APPPATH.'cache/' : $path;

    $handle = opendir($cache_path);
    while (($file = readdir($handle))!== FALSE) 
    {
        //Leave the directory protection alone
        if ($file != '.htaccess' && $file != 'index.html')
        {
           @unlink($cache_path.'/'.$file);
        }
    }
    closedir($handle); 
		redirect('admin/', 'refresh');
  }
  
 
//&siswa----------------------------------------------------------	
	function session_kelas(){ return $this->session->userdata('id_kelas');}
	function session_jurusan(){ return $this->session->userdata('id_jurusan');}
	function session_idguru(){ return $this->session->userdata('id_pengawas');}
	
	function daftar_soal(){ //
	//$this->cache(1);
		$data['setting'] = $this->M_login->setting();
		$data['mapel_ujian'] = $this->M_mapel->get_mapel_ujian()->result();
		$data['pk'] = $this->klp->get_pk()->result();
		$data['level'] = $this->klp->get_level()->result();
		$data['konten'] = "soal/v_soal.php";
		
		$this->load->view('admin',$data);
	}
	function get_kelas_by(){
		$data= $this->klp->get_kelas_by($_POST['idlevel'])->result();
		$ops=array("semua","khusus");
		foreach ($data as $kelas) {
			$data2[] = $kelas->id_kelas;
		}
		$cek = array_merge($ops, $data2); 
		echo json_encode($cek);
	}
	function get_siswa_by(){
		$data= $this->klp->get_siswa_by($_POST['idlevel'])->result();
		// $opss=array(
		// 	'id_siswa' =>'semua',
		// 	'nama' =>'semua',
		// );
		foreach ($data as $siswa) {
			$data2[] = $siswa;
		}
		//$cek2 = array_merge($opss, $data2); 
		echo json_encode($data2);
	}
	function v_daftar_soal_json(){
		$data= $this->soal->v_daftar_ujia($this->session_idguru());
		$data2 = array();
		$no=1;
		foreach ($data as $value) {
			//---------------------------------------------------------------
			$kelas = unserialize($value->kelas);
			foreach ($kelas as $key => $value2) :
				$data_kelas[]=  "<small class='label label-success'>".$value2."</small>&nbsp;";
			endforeach;
			$kelas2 = implode(' | ',$data_kelas);
			//---------------------------------------------------------------
			$cek = $this->soal->select_soal_pg2($value->id_mapel)->row_array();
			if ($cek > 0) {
				$status = '<label class="label label-success"> aktif </label>';
			} else {
				$status = '<label class="label label-warning"> Soal Kosong </label>';
			}

			$href = base_url('soal/lihat_soal?idmapel=').encrypt_url($value->id_mapel);
			$href2 = base_url('soal/import_soal?idmapel=').encrypt_url($value->id_mapel);
			//$href3 = base_url('soal/hapus_soal?idmapel=').encrypt_url($value->id_mapel);
			//------------------------------------------------------------------------
			$kumpulData = array();
			$kumpulData[]=$no++;
			$kumpulData[]=$value->nama_mapel;
			$kumpulData[]='<small class="label label-warning">'.$value->jml_soal.'/'.$value->tampil_pg.'</small>&nbsp;<small class="label label-danger">'.$value->bobot_pg.' %</small>&nbsp;<small class="label label-danger">'.$value->opsi.'</small>';
			$kumpulData[]='<small class="label label-warning">'.$value->jml_esai.'/'.$value->tampil_esai.'</small>&nbsp;<small class="label label-danger">'.$value->bobot_esai.' %</small>';
			$kumpulData[]=$kelas2;
			$kumpulData[]=$status;
			$kumpulData[]=$value->nama_guru;
			$kumpulData[]='<a href="'.$href.'" class="btn btn-flat btn-success btn-flat btn-xs"><i class="fa fa-search"></i></a> <a href="'.$href2.'" class="btn btn-info btn-flat btn-xs"><i class="fa fa-upload"></i></a> <button  data-id="'.encrypt_url($value->id_mapel).'" class="btn btn-danger btn-flat btn-xs hapus_banksoal"><i class="fa fa-trash"></i></button>';

			$data2[] = $kumpulData;
		}
		$json_data = array(
			'data' =>$data2
		);
		echo json_encode($json_data);
	}
	function lihat_soal(){
		//$this->cache(1);
		$idmapel = decrypt_url($_GET['idmapel']);
		$data['setting'] = $this->M_login->setting();
		$data['konten'] = "soal/lihat_soal";
		
		$data['select_soal'] = $this->soal->select_soal_pg($idmapel);
		
		$this->load->view('admin',$data);
	}
	function import_soal(){
		//$this->cache(1);
		$idmapel = decrypt_url($_GET['idmapel']);
		$data['setting'] = $this->M_login->setting();
		$data['konten'] = "soal/import_soal";
		
		$data['mapel'] = $this->soal->select_ujian2($idmapel)->row_array();
		
		$this->load->view('admin',$data);
	}
	function hapus_soal_id(){
		$id = $_POST['id'];
		$soal = $this->soal->select_soal_id($id);
		foreach ($soal as $value) {
			$file = '../files/'.$value->file;
			$file1 = '../files/'.$value->file1;
			$fileA = '../files/'.$value->fileA;
			$fileB = '../files/'.$value->fileB;
			$fileC = '../files/'.$value->fileC;
			$fileD = '../files/'.$value->fileD;
			$fileE = '../files/'.$value->fileE;

			unlink($file);
			unlink($file1);
			unlink($fileA);
			unlink($fileB);
			unlink($fileC);
			unlink($fileD);
			unlink($fileE);
			
		}
		$where = array(
			'id_soal'=>$id
		);
		
		// if (file_exists('../files/15905903563.png')){
		// 	unlink('../files/15905903563.png');
		// }
		// else{
		// 	echo"tidak ada";
		// }
		$ex = Hapus_data($where,'soal');
		if($ex == true){ echo 1; }else{ echo 0; }
		$this->clear_cache();
	}
	function hapus_banksoal_id(){

		$idmapel = decrypt_url($_POST['id']);
		//echo $id;
		$soal = $this->soal->select_soal_pg2($idmapel)->result();
		foreach ($soal as $value) {
			//looping untuk hapus gambar file pendukung
			$file = '../files/'.$value->file;
			$file1 = '../files/'.$value->file1;
			$fileA = '../files/'.$value->fileA;
			$fileB = '../files/'.$value->fileB;
			$fileC = '../files/'.$value->fileC;
			$fileD = '../files/'.$value->fileD;
			$fileE = '../files/'.$value->fileE;

			unlink($file);
			unlink($file1);
			unlink($fileA);
			unlink($fileB);
			unlink($fileC);
			unlink($fileD);
			unlink($fileE);
		}
		//print_r($aa);
		$where = array(
			'id_mapel'=>$idmapel
		);
		$ex = Hapus_data($where,'soal');
		$ex1 = Hapus_data($where,'mapel');
		$ex2 = Hapus_data($where,'file_pendukung');
		if($ex == true and $ex1 == true){ echo 1; }else{ echo 0; }
		$this->clear_cache();
	}
	
	
}

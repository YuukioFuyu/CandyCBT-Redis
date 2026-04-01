<?php
class Word_import extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->lang->load('basic', $this->config->item('language'));
   $this->load->helper('url');
   $this->load->helper('security');
   $this->load->helper('savesoall'); //load helper simpan ke tabel soal
   $this->load->helper('word_import_helper');
   $this->load->model('word_import_model','',TRUE);
   $this->load->model('M_savesoal','savesoal'); 
 }

 function index($limit='0',$cid='0')
 {
  $logged_in=$this->session->userdata('beeuser');		
  $config['upload_path']          = './upload/';
  $config['allowed_types']        = 'docx';
  $config['max_size']             = 10000;
  $this->load->library('upload', $config);
  if ( ! $this->upload->do_upload('word_file'))
  {
   $error = array('error' => $this->upload->display_errors());
   $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$error['error']." </div>");
					//redirect('qbank');				
   exit;
 }
 else
 {
   $data = array('upload_data' => $this->upload->data());
   $targets = 'upload/';
   $targets = $targets . basename($data['upload_data']['file_name']);
   $Filepath = $targets;               

 }
 $this->load->helper('word_import_helper');
 $questions=word_file_import($Filepath);
 $this->word_import_model->import_ques($questions);

 // $id_soal= $_POST['id_bank_soal'];
 $id_soal2 = $_POST['id_mapel'];
 // $id_soal3 = encrypt_url($_POST['id_mapel']);
 $id_lokal= $_POST['id_lokal'];
 $sip = $_SERVER['SERVER_NAME'];
 $ex = save_soal($id_soal2);
$this->session->set_flashdata('success', $this->lang->line('data_imported_successfully'));
 // if($ex){ //terdapat masalah pada gambar jadi tidak sukses pesanya tapi tetep bisa di import
  header('location: soal/lihat_soal?idmapel='.$id_soal2);  
 // }


}



}

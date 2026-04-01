<?php if (!defined("BASEPATH")) exit("No direct script access allowed");


function save_soal($id_mapel) {
  $ci = & get_instance();

  $sip = $_SERVER['SERVER_NAME'];
  $smax = $ci->savesoal->select_max();
  foreach ($smax as $hmax) :
    $jumsoal = $hmax->maxi;
  endforeach;

  $smaop = $ci->savesoal->select_max2();
  foreach ($smaop as $hmaop) :
    $jumop = $hmaop->maxop;
  endforeach;
  

  $b_op = ($jumop != 0) ? ($jumop / $jumsoal) : 0;
  $no = 1;
  $sqlcek = $ci->savesoal->select_savsoft_qbank();
  foreach ($sqlcek as $r) {
    $s_soal = $ci->savesoal->select_savsoft_qbank($no)->row_array();
    $soal_tanya = $s_soal['question'];
    $l_soal = $s_soal['lid'];
    $c_id = $s_soal['cid'];
    $g_soal = $s_soal['description'];
    $g_soal = str_replace(" ", "", $g_soal);
    $smin = $ci->savesoal->select_savsoft_options($no)->row_array();
    // foreach ($smin as $hmin) {
      $min_op = $hmin['mini'];
    //}
    $sqlopc = $ci->savesoal->select_savsoft_options2($no,$min_op);
    $ropc = $sqlopc->row_array();
    $opj1 = $ropc['q_option'];
    $opj1 = str_replace(" &ndash;", "-", $opj1);
    $opjs1 = $ropc['score'];
    $fileA = $ropc['q_option_match'];
    $fileA = str_replace(" ", "", $fileA);

    $dele = $ci->savesoal->hapus_savsoft_options2($no,$min_op);
    //---------------------------------------------------------------------------------------
    $smin = $ci->savesoal->select_savsoft_options($no)->row_array();
    // foreach ($smin as $hmin) {
      $min_op = $hmin['mini'];
    //}
    $sqlopc = $ci->savesoal->select_savsoft_options2($no,$min_op);
    $rubah = $ci->savesoal->select_savsoft_options3($no);
    $ck_jum = $rubah->num_rows();

    $ropc = $sqlopc->row_array();
    $opj2 = $ropc['q_option'];
    $opj2 = str_replace(" &ndash;", "-", $opj2);
    $opjs2 = $ropc['score'];
    $fileB = $ropc['q_option_match'];
    $fileB = str_replace(" ", "", $fileB);
    $dele = $ci->savesoal->hapus_savsoft_options2($no,$min_op);
    //----------------------------------------------------------------------------------------
    $smin = $ci->savesoal->select_savsoft_options($no)->row_array();
    // foreach ($smin as $hmin) {
      $min_op = $hmin['mini'];
    //}
    $sqlopc = $ci->savesoal->select_savsoft_options2($no,$min_op);
    $ropc = $sqlopc->row_array();
    $opj3 = $ropc['q_option'];
    $opj3 = str_replace(" &ndash;", "-", $opj3);
    $opjs3 = $ropc['score'];
    $fileC = $ropc['q_option_match'];
    $fileC = str_replace(" ", "", $fileC);
    $dele = $ci->savesoal->hapus_savsoft_options2($no,$min_op);
    //----------------------------------------------------------------------------------------
    $smin = $ci->savesoal->select_savsoft_options($no)->row_array();
    // foreach ($smin as $hmin) {
      $min_op = $hmin['mini'];
    //}
    $sqlopc = $ci->savesoal->select_savsoft_options2($no,$min_op);
    $ropc = $sqlopc->row_array();
    $opj4 = $ropc['q_option'];
    $opj4 = str_replace(" &ndash;", "-", $opj4);
    $opjs4 = $ropc['score'];
    $fileD = $ropc['q_option_match'];
    $fileD = str_replace(" ", "", $fileD);
    $dele = $ci->savesoal->hapus_savsoft_options2($no,$min_op);
    //----------------------------------------------------------------------------------------
    $smin = $ci->savesoal->select_savsoft_options($no)->row_array();
    // foreach ($smin as $hmin) {
      $min_op = $hmin['mini'];
    //}
    $sqlopc = $ci->savesoal->select_savsoft_options2($no,$min_op);
    $ropc = $sqlopc->row_array();
    $opj5 = $ropc['q_option'];
    $opj5 = str_replace(" &ndash;", "-", $opj5);
    $opjs5 = $ropc['score'];
    $fileE = $ropc['q_option_match'];
    $fileE = str_replace(" ", "", $fileE);
    $dele = $ci->savesoal->hapus_savsoft_options2($no,$min_op);
    //----------------------------------------------------------------------------------------
    if ($opjs1 == 1) {
      $kunci = "A";
    }
    if ($opjs2 == 1) {
      $kunci = "B";
    }
    if ($opjs3 == 1) {
      $kunci = "C";
    }
    if ($opjs4 == 1) {
      $kunci = "D";
    }
    if ($opjs5 == 1) {
      $kunci = "E";
    }
    if ($ck_jum !== 0) {
      $jns = "1";
    }
    if ($ck_jum == 0) {
      $jns = "2";
    }
        // $jwb522 = str_replace("&amp;lt;", "<", $jwb521);
        // $jwb422 = str_replace("&amp;lt;", "<", $jwb421);
        // $jwb322 = str_replace("&amp;lt;", "<", $jwb321);
        // $jwb222 = str_replace("&amp;lt;", "<", $jwb221);
        // $jwb122 = str_replace("&amp;lt;", "<", $jwb121);
    $soal_tanya2 = str_replace("&amp;lt;", "<", $soal_tanya);
        // $jwb52 = str_replace("&amp;gt;", ">", $jwb522);
        // $jwb42 = str_replace("&amp;gt;", ">", $jwb422);
        // $jwb32 = str_replace("&amp;gt;", ">", $jwb322);
        // $jwb22 = str_replace("&amp;gt;", ">", $jwb222);
        // $jwb12 = str_replace("&amp;gt;", ">", $jwb122);
    $soal_tanya = str_replace("&amp;gt;", ">", $soal_tanya2);
    $soal_tanya = str_replace('"', '"', $soal_tanya);
    $soal_tanya = str_replace("&#34;", '"', $soal_tanya);
    $data22 = array(
      'id_mapel' =>$id_mapel,
      'nomor' =>$no,
      'soal' =>$soal_tanya,
      'pilA' =>$opj1,
      'pilB' =>$opj2,
      'pilC' =>$opj3,
      'pilD' =>$opj4,
      'pilE' =>$opj5,
      'jawaban' =>$kunci,
      'jenis' =>$jns,
      'file1' =>$g_soal,
      'fileA' =>$fileA,
      'fileB' =>$fileB,
      'fileC' =>$fileC,
      'fileD' =>$fileD,
      'fileE' =>$fileE,
    );
    $exec = $ci->savesoal->insert_soal($data22);
    // $exec = mysqli_query($koneksi, "INSERT INTO soal (id_mapel,nomor,soal,pilA,pilB,pilC,pilD,pilE,jawaban,jenis,file1,fileA,fileB,fileC,fileD,fileE) VALUES ('$id_mapel','$no','$soal_tanya','$opj1','$opj2','$opj3','$opj4','$opj5','$kunci','$jns','$g_soal','$fileA','$fileB','$fileC','$fileD','$fileE')");

    if ($g_soal <> "") {
      $data_soal = array(
        'nama_file' => $g_soal,
        'id_mapel' => $id_mapel,
      );
      $file = $ci->savesoal->insert_dukung($data_soal);
      // $file = mysqli_query($koneksi, "INSERT INTO file_pendukung (nama_file,id_mapel) values ('$g_soal','$id_mapel')");
    }
    if ($fileA <> "") {
      $data_fileA = array(
        'nama_file' => $fileA,
        'id_mapel' => $id_mapel,
      );
      $file = $ci->savesoal->insert_dukung($data_fileA);
      // $file = mysqli_query($koneksi, "INSERT INTO file_pendukung (nama_file,id_mapel) values ('$fileA','$id_mapel')");
    }
    if ($fileB <> "") {
      $data_fileB = array(
        'nama_file' => $fileB,
        'id_mapel' => $id_mapel,
      );
      $file = $ci->savesoal->insert_dukung($data_fileB);
    }
    if ($fileC <> "") {
     $data_fileC = array(
        'nama_file' => $fileC,
        'id_mapel' => $id_mapel,
      );
      $file = $ci->savesoal->insert_dukung($data_fileC);
    }
    if ($fileD <> "") {
      $data_fileD = array(
        'nama_file' => $fileD,
        'id_mapel' => $id_mapel,
      );
      $file = $ci->savesoal->insert_dukung($data_fileD);
    }
    if ($fileE <> "") {
      $data_fileE = array(
        'nama_file' => $fileE,
        'id_mapel' => $id_mapel,
      );
      $file = $ci->savesoal->insert_dukung($data_fileE);
    }
    $no++;
  }
  $hasil2 = $ci->savesoal->truncate('savsoft_qbank');
  $hasil2 = $ci->savesoal->truncate('savsoft_options');

}
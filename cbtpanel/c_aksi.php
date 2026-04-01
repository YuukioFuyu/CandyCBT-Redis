<?php
//require("../config/m_admin.php");
/*
&1.tombol selesai
&2. Nilai Essai
&3.Materi
&4.Materi
&5.Absen
&6.Absen perMapel
&7.Kelas
&8.Bot Telegram
&9.Absen Siswa Mapel
&10.Mata_Pelajaran
&11.Pindah Nilai
&12.Nilai Tugas Manual
&13.Selesaikan Semua Ujian Peserta
14.Bank Soal
&15.Konek Server MKKS
&16.Nilai
*/
require("../config/config.function.php");
require("../config/functions.crud.php");
include("core/c_admin.php"); 

$db= new Budut(); // panggil model 

 function tbAbsensi(){ return 'absensi'; }
 function tbNilai(){ return 'nilai'; }
?>
<?php
if($token == $token1)
{
  if($setting['izin_status'] == 1){
  if(isset($_GET['adm'])){
  //&1.tombol selesai -------------------------------------
      if($_GET['adm']=="tombol_selesai"){
        $cek = $db->tombol_selesai_paksa();
        echo $cek;
      }
      elseif($_GET['adm']=="kunci_tombol_selesai"){
        $cek = $db->kunci_tombol_selesai_paksa();
        echo $cek;
      }
      elseif($_GET['adm']=="cek_siswa"){
        $kls = $_POST['kelas'];
        $ujian = $_POST['ujian'];
        $jrs = $_POST['jrs'];
        $cek = $db->siswa_tidak_ujian($kls,$jrs,$ujian);
        echo $cek;
      }
      elseif($_GET['adm']=="cek_siswabanksoal"){
        $kls = $_POST['kelas'];
        $ujian = $_POST['ujian'];
        $jrs = $_POST['jrs'];
        $cek = $db->siswa_tidak_ujian_banksoal($kls,$jrs,$ujian);
        echo $cek;
      }
      else{
        echo 100;
      }

      } //END isset($_GET['adm'])
      if(isset($_GET['esai'])){
  //&2. Nilai Essai-------------------------------------
      if($_GET['esai']=="oke"){
        
        $id_nilai =$_POST['id_nilai'];
        $id_ujian =$_POST['id_ujian'];
        $id_mapel =$_POST['id_mapel'];
        $id_siswa =$_POST['id_siswa'];
        $bobot =$_POST['bobot'];

        if(isset($_POST)){
          $id = $_POST;
          //hapus array yang bukan nilia dari soal esai
          unset($id['bobot']);
          unset($id['id_ujian']);
          unset($id['id_mapel']);
          unset($id['id_nilai']);
          unset($id['id_siswa']);

          $esai_total=0;
          foreach ($id as $key => $value) {
            $esai_total += $value;
          }
          $nilai_essai = serialize($id);

        }

        $total = ($esai_total*$bobot)/100;
        
        
        $data_nilai = array(
          'nilai_esai2' => $nilai_essai,
          'nilai_esai' => $total
        );
        $where = array(
          'id_nilai' =>$id_nilai,
          'id_ujian' =>$id_ujian,
          'id_mapel' =>$id_mapel,
          'id_siswa' =>$id_siswa
        );
        
        $tabel='nilai_pindah';

        $exc = $db->update($tabel,$data_nilai,$where);
        if($exc == 1){
          echo $exc;
        }
        else{
          echo $exc;
        }
        
        //print_r($data_nilai);
      }
      }
  //&3.Materi -----------
    if(isset($_GET['nilai'])){
      if($_GET['nilai']=='remidi'){
        $id = $_POST;
        
        $where = array(
          // 'id_siswa' => $id['id_siswa'],
          // 'id_mapel' => $id['id_mapel']
          'id_nilai' => $id['id_nilai']
        );
        
        $total = ($id['pg'] + $id['esai'] );
        
        $data= array(
          'jml_benar' => $id['jml_bener'],
          'jml_salah' => $id['jml_salah'],
          'skor' => $id['pg'],
          'nilai_esai' => $id['esai'],
          'total' => $total
        );
        
        $tabel ='nilai_pindah';
        
        
        $exc = $db->update($tabel,$data,$where);
        if($exc == 1){
          echo $exc;
        }
        else{
          echo $exc;
        }
      }
      //update nilai 0
      if($_GET['nilai']=='nilai_update'){
        $id = $_POST;
        
        $data= array(
          'jml_benar' => $id['benar'],
          'jml_salah' => $id['salah'],
          'skor' => $id['nilai'],
          'total' => $id['nilai'],
          'jawaban' =>$id['sejawab'],
          'jawaban_esai'=>$id['sejawabesai'],
        );
        
        $where = array(
          'id_siswa' => $id['idsiswa'],
          'id_mapel' => $id['idmapel'],
          'id_ujian' => $id['idujian'],
        );
        $tabel ='nilai';
        $exc = $db->update($tabel,$data,$where);
        if($exc == 1){
          echo $exc;
        }
        else{
          echo $exc;
        }

      }

      else{

      }
    }

    if(isset($_GET['hapus'])){
      if($_GET['hapus']=='history'){
        //$id = $_POST;
        $tabel ="jawaban_copy";
        $exc = $db->truncate($tabel);
        if($exc == 1){
          echo $exc; //out 1
        }
        else{
          echo $exc; //out 0
        }
      }
      else if($_GET['hapus']=='redis'){ //hapus all cache redis
        $exc = $db->DelRedisAll();
        return $exc;
      }
      else{
        echo 100;
      }
    }
  //&4.Materi -----------
    if(isset($_GET['materi'])){
      if($_GET['materi']=='cari_mapel'){
        $tabel ="mata_pelajaran";
        $where = array(
          'kode_level' => $_POST['id']
        );
        $exc = $db->cari_data_byid($tabel,$where);
      }
    }
  //&5.Absen -----------
    if(isset($_GET['absen'])){
      if($_GET['absen']=='getabsen'){
        $exc = $db->getAbsen($_POST['tahun'],$_POST['bulan'],$_POST['kelas']);
      }
      else if($_GET['absen']=='getsiswa'){
        $kelas = $db->v_kelas2($_POST['id']);
        foreach ($kelas as $kls) {
          $idkelas = $kls['id_kelas'];
        }
        $idjrs='semua';
        $siswas = $db->v_siswa($idkelas,$idjrs);
        foreach ($siswas as $siswa) {
          $data = array(
            'idsiswa' => $siswa['id_siswa'],
            'namasiswa' => $siswa['nama'],
          );
          $data2[]=$data;
        }
        echo json_encode($data2);
      }
      else if($_GET['absen']=='upabsen'){ //update asbensi siswa
        // print_r($_POST);
        $status_asben = $_POST['status_absen'];
        $idsiswa = $_POST['idsiswa'];
        $jam = $db->getJamSkl();
          if($status_asben =='H'){
            $jamin=date($jam['jamIn']);
            $jamout=date($jam['jamOut']);
            $jenis=1;
          }
          else if($status_asben =='T'){
            $jamin=date($jam['jamTerlambat']);
            $jamout=date($jam['jamOut']);
            $jenis=1;
          }
          else if($status_asben =='S'){
            $jamin=date($jam['jamAlpah']);
            $jamout=date($jam['jamAlpah']);
            $jenis=2;
          }
          else if($status_asben =='I'){
            $jamin=date($jam['jamAlpah']);
            $jamout=date($jam['jamAlpah']);
            $jenis=2;
          }
          else if($status_asben =='A'){
            $jamin=date($jam['jamAlpah']);
            $jamout=date($jam['jamAlpah']);
            $jenis=2;
          }
          else{
            $jamin=date('07:30');
            $jamout=date($jam['jamAlpah']);
            $jenis=1;
          }
          $data = array(
            'absJamIn'  =>$jamin,
            'absJamOut' =>$jamout,
            'absStatus' =>$status_asben,
            'absJenis'  =>$jenis,
          );
          $where = array(
            'absId' =>$idsiswa
          );

          $exc = $db->update(tbAbsensi(),$data,$where);
          if($exc == 1){
            echo $exc;
          }
          else{
            echo $exc;
          }

      }
      else if($_GET['absen']=='delabsen'){
        $idabsen = $_POST['idabsen'];
        $where = array('absId'  =>$idabsen);
        $exc = $db->delete(tbAbsensi(),$where);
        if($exc == 'OK'){
            echo 1;
          }
          else{
            echo 0;
          }
        
      }
      else if($_GET['absen']=='jamabsen'){
        $data = array(
            'jamIn' =>$_POST['jamin'],
            'jamOut'  =>$_POST['jamout'],
            'jamAlpah'  =>$_POST['jamalpa'],
            'jamTerlambat'  =>$_POST['jamterlambat'],
          );
          $where = array(
            'jmId'  =>$_POST['jamid']
          );
        $exc = $db->update('jam_skl',$data,$where);
        if($exc == 1){
            echo $exc;
          }
          else{
            echo $exc;
          }
      }
      else if($_GET['absen']=='tahunabsen'){
        $data = array(
            'thKode'  =>$_POST['kodetahun'],
            'thNama'  =>$_POST['namatahun'],
          );
        
        $table='tahun';
        
        $exc = $db->insert($table,$data);
        if($exc == 1){
            echo $exc;
          }
          else{
            echo $exc;
          }
      }
      else if($_GET['absen']=='updatetahun'){
        $data = array(
            'thKode'  =>$_POST['kode'],
            'thNama'  =>$_POST['nama'],
            'thAktif' =>$_POST['status'],
          );

        $where = array(
            'thId'  =>$_POST['id']
          );
        
        $table='tahun';
        
        $exc = $db->update($table,$data,$where);
        if($exc == 1){
            echo $exc;
          }
          else{
            echo $exc;
          }
      }
      else if($_GET['absen']=='deletetahun'){
        $table='tahun';
        $id = $_POST['id'];
        $where = array('thId' =>$id);
        
        $exc = $db->delete($table,$where);
        if($exc == 'OK'){
            echo 1;
          }
          else{
            echo 0;
          }
      }
      else{

      }
    }
  //&6.Absen perMapel-----------
    if(isset($_GET['absen_mapel'])){
      if($_GET['absen_mapel']=='insert'){
        $table='absensi_mapel';
        $mapel = $db->getMata_pelajaran($_POST['mapel']);
        $datamapel = mysqli_fetch_assoc($mapel);
        //-------------------
        if($_SESSION['level']=='admin'){
          $idguru = $_POST['idguru'];
        }
        else{
          $idguru = $_SESSION['id_pengawas'];
        }
        $data=array(
          'amKelas' =>$_POST['idkelas'],
          'amIdMapel'=>$_POST['mapel'],
          'amIdGuru'=>$idguru,
          'amNamaMapel'=>$datamapel['nama_mapel'],
          'amSlag'=>$datamapel['nama_mapel'],
          'amJamMulai'=>$_POST['jamin'],
          'amJamAkhir'=>$_POST['jamout'],
          'amHari'=>$_POST['hari'],
        );
        //-----------
        $where= array(
          'amIdMapel'=>$_POST['mapel'],
          'amIdGuru'=>$_SESSION['id_pengawas'],
          'amKelas' =>$_POST['idkelas'],
          'amHari'  =>$_POST['hari'],
        );
        $cek = $db->fetch($table,$where);
        if(count($cek) > 1){ echo 99; }
        else{
          
          $exc =  $db->insert($table,$data);
          if($exc == 1){ echo $exc; }else{ echo $exc; }
        }
        
      }
      else if($_GET['absen_mapel']=='update'){
        $table='absensi_mapel';
        $data=array(
          'amSlag'=>$_POST['mapel'],
          'amJamMulai'=>$_POST['jamin2'],
          'amJamAkhir'=>$_POST['jamout2'],
          'amHari'=>$_POST['hari2'],
        );
        //-----------
        $where= array('amId'=>$_POST['id']);
      
        $exc = $db->update($table,$data,$where);
        if($exc == 1){ echo $exc; }else{ echo $exc; }
        
      }
      else if($_GET['absen_mapel']=='delet'){
        $table='absensi_mapel';
        
        $where= array('amId'=>$_POST['id']);
        $exc = $db->delete($table,$where);
        if($exc == 'OK'){ echo 1; }else{ echo 0; }
      }
      else if($_GET['absen_mapel']=='getkelas'){
        //print_r($_POST);
        return $db->kelas_by_level($_POST['idlevel']);
      }
      else if($_GET['absen_mapel']=='getmapel'){
        return $db->getMata_pelajaran_by_level($_POST['idlevel']);
      }
      else{

      }
    }
  //&7.Kelas-------------------------------------------------------
    if(isset($_GET['kelas'])){
      if($_GET['kelas']=='getkelas'){
        return $db->kelas_by_level($_POST['idlevel']);
      }
    }
  //&8.Bot Telegram-------------------------------------------------------
    if(isset($_GET['telegram'])){
      if($_GET['telegram']=='addchatid'){
        $where= array(
          'tlIdGuru'=>$_POST['idguru'],
        );
        $data=array(
          'tlChatId'  =>$_POST['chatid'],
          //'tlNama'=>$_POST['mapel'],
          'tlIdBotTelegram'=>1,
          'tlIdGuru'=>$_POST['idguru'],
        );
        $cek = $db->fetch('telegram_bot',$where);
        if(count($cek) > 1){ echo 99; }
        else{
          $exc =  $db->insert('telegram_bot',$data);
          echo $exc;
        }
      }
      else if($_GET['telegram']=='updatechatid'){
        $where= array(
          'tlId'=>$_POST['id'],
        );
        $data=array(
          'tlChatId'  =>$_POST['chatid'],
        );
        $exc = $db->update('telegram_bot',$data,$where);
        echo $exc;

      }
      else if($_GET['telegram']=='addbottelegram'){
        $where= array(
          'botId'=>1,
        );
        $data=array(
          'botToken'  =>$_POST['bot_token'],
          'botChatId' =>$_POST['id_grub'],
        );
        $exc = $db->update('bot_telegram',$data,$where);
        echo $exc;
      }
      else if($_GET['telegram']=='hapustelegram'){
        $where= array(
          'tlId'=>$_POST['id'],
        );
        $exc = $db->delete('telegram_bot',$where);
        if($exc == 'OK'){ echo 1; }else{ echo 0; }
      }
      else if($_GET['telegram']=='aktifsend'){
        if($_POST['id']=='mapel'){ $kolom ='botSendAbsenMapel';}
        else if($_POST['id']=='sekolah'){ $kolom ='botSendAbsenSekolah';}
        else if($_POST['id']=='tugas'){ $kolom ='botSendTugas';}
        else{}
        $where= array(
          'botId'=>1,
        );
        $data=array(
          $kolom =>$_POST['aksi'],
        );
        $exc = $db->update('bot_telegram',$data,$where);
        echo $exc;
      }
      else{ }
    }
  //&9.Absen Siswa Mapel --------------------------------------------
    if(isset($_GET['absen_mapel_siswa'])){
      if($_GET['absen_mapel_siswa']=='insert'){
        //print_r($_POST);
        $table='absensi_mapel_anggota';

        $idmapel = $_POST['idabsenmapel']; //id mapel
        $idjadwalmapel = $_POST['kodemapel'];

        $mapel = $db->getMapelAbsen($idjadwalmapel); //cari jam masuk mapel
        foreach ($mapel as $value) {
          $jamMulai = $value['amJamMulai'];
        }

        $idsiswa = $_POST['idsiswa'];
        $tgl = date("Y-m-d",strtotime($_POST['tgl']));

        $jml = count($idsiswa);
        for ($i=0; $i <$jml ; $i++) { 
          $data=array(
            'amaIdAbsenMapel'=> $idjadwalmapel,
            'amaIdKelas'=> $_POST['idkelas'],
            'amaIdMapel'=>$idmapel,
            'amaIdSiswa'=> $idsiswa[$i],
            'amaTgl'=> $tgl ,
            'amaJamIn'=> $jamMulai,
            'amaStatus'=> 'H',

          );
          $where=array(
            'amaTgl' => $tgl,
            'amaIdSiswa' =>$idsiswa[$i],
            'amaIdAbsenMapel'=>$idjadwalmapel,
            );

          $cek = $db->fetch($table,$where);
          if(count($cek) > 1){ }
          else{
            $exc =  $db->insert($table,$data);
          }
          
        } //end for
      
        echo($exc);
        
      }
      else if($_GET['absen_mapel_siswa']=='izin'){
        $table='absensi_mapel_anggota';
        // $mapel = $db->getMapelAbsen($_POST['kodemapel']); //cari jam masuk mapel
        // foreach ($mapel as $value) {
        //  $jamMulai = $value['amJamMulai'];
        // }
        //untuk absen sekolah ------------------------
        $status_asben = $_POST['ket'];
        $jam = $db->getJamSkl();
          if($status_asben =='H'){
            $jamin=date($jam['jamIn']);
            $jamout=date($jam['jamOut']);
            $jenis=1;
          }
          else if($status_asben =='T'){
            $jamin=date($jam['jamTerlambat']);
            $jamout=date($jam['jamOut']);
            $jenis=2;
          }
          else if($status_asben =='S'){
            $jamin=date($jam['jamAlpah']);
            $jamout=date($jam['jamAlpah']);
            $jenis=2;
          }
          else if($status_asben =='I'){
            $jamin=date($jam['jamAlpah']);
            $jamout=date($jam['jamAlpah']);
            $jenis=2;
          }
          else if($status_asben =='A'){
            $jamin=date($jam['jamAlpah']);
            $jamout=date($jam['jamAlpah']);
            $jenis=2;
          }
          else{
            $jamin=date('07:30');
            $jamout=date($jam['jamAlpah']);
            $jenis=2;
          }
        //untuk absen sekolah ------------------------

        $idmapel = $_POST['idabsenmapel']; //id mapel
        $idjadwalmapel = $_POST['kodemapel'];

        $idsiswa = $_POST['idsiswa'];
        $tgl = date("Y-m-d",strtotime($_POST['tgl']));
        $jml = count($idsiswa);
        for ($i=0; $i <$jml ; $i++) { 
          $data=array(
            'amaIdAbsenMapel'=> $idjadwalmapel,
            'amaIdKelas'=> $_POST['idkelas'],
            'amaIdMapel'=> $idmapel,
            'amaIdSiswa'=> $idsiswa[$i],
            'amaTgl'=> $tgl ,
            'amaJamIn'=> '00:00:00',
            'amaStatus'=> $status_asben,
            'amaKeterangan'=> $_POST['ktrs'],

          );
          $where=array(
            'amaTgl' => $tgl,
            'amaIdSiswa' =>$idsiswa[$i],
            'amaIdAbsenMapel'=>$idjadwalmapel,
          );

          //cek kondisi absen sekolah---------
          $table2 = 'absensi';
          $where_skl=array(
            'absTgl' => $tgl,
            'absIdSiswa' =>$idsiswa[$i],
          );
          $data_skl=array(
            'absTgl' => $tgl,
            'absIdSiswa' =>$idsiswa[$i],
            'absIdKelas'=> $_POST['idkelas'],
            'absStatus'=> $status_asben,
            'absJamIn'=> $jamin,
            'absJamOut'=> $jamout,
            'absJenis'=> $jenis,
            'absKeterangan'=> $_POST['ktrs'],
          );
          //cek kondisi absen sekolah---------

          $cek = $db->fetch($table,$where);
          if(count($cek) > 1){ }
          else{
            $exc =  $db->insert($table,$data);

            $cek2 = $db->fetch($table2,$where_skl); //cek absen sekolah
            if(count($cek2) > 1){ $db->update($table2,$data_skl,$where_skl); }
            else{ $db->insert($table2,$data_skl); }
            
          }
          
        } //end for
      
        echo($exc);

      }
      else if($_GET['absen_mapel_siswa']=='edit'){
        $table='absensi_mapel_anggota';
        
        //untuk absen sekolah ------------------------
        $status_asben = $_POST['status'];
        $jam = $db->getJamMapel($_POST['idmapel']);
        if($status_asben =='H'){
            $jamin=date($jam['amJamMulai']);
          }
          else if($status_asben =='T'){
            $jamin=date('00:00:00');
          }
          else if($status_asben =='S'){
            $jamin=date('00:00:00');
          }
          else if($status_asben =='I'){
            $jamin=date('00:00:00');
          }
          else if($status_asben =='A'){
            $jamin=date('00:00:00');
          }
          else{
            $jamin=date('00:00:00');
          }
          $tgl = date("Y-m-d",strtotime($_POST['tgl']));
          $data=array(
            'amaTgl'=> $tgl ,
            'amaJamIn'=> $jamin,
            'amaStatus'=> $status_asben,
            'amaKeterangan'=> $_POST['ktr'],

          );
          $where=array(
            'amaId' =>$_POST['idsiswa'],
          );
          
          $exc = $db->update($table,$data,$where);
          if($exc == 1){
            echo $exc;
          }
          else{
            echo $exc;
          }
        

      }
      else{ }

    }
  //&10.Mata_Pelajaran ---------------------------------------------
    if(isset($_GET['mapel_pelajaran'])){
      $tabel = 'mata_pelajaran';
      if($_GET['mapel_pelajaran']=="delete"){
        $where = array('idmapel' => $_POST['idmapel']);
        $exc = $db->delete($tabel,$where);
        if($exc == 'OK'){
            echo 1;
          }
          else{
            echo 0;
          }
        $db->RedisDelKey('mata_pelajaran');
      }
    }
  //&11.Pindah Nilai --------------------------------------------
    if(isset($_GET['pindah_nilai'])){
      if($_GET['pindah_nilai']=="pindah"){
        $tabel = 'nilai';
        $tabel_tujuan='nilai_pindah';
        $idujian = $_POST['idujian'];
        $where = array(
          'id_ujian' => $idujian,
          'selesai'=>1,
        );

        $data = $db->getWhereUjian($tabel,$where);
        echo $data;
      }
      elseif ($_GET['pindah_nilai']=="hapusnilai") {
        $tabel_tujuan='nilai_pindah';
        $idujian = $_POST['idujian'];
        $where = array(
          'id_ujian' => $idujian,
          'selesai' => 1,
        );
        $exc = $db->delete($tabel_tujuan,$where);
        if($exc == 'OK'){
            echo 1;
          }
          else{
            echo 0;
          }
      }
      else{ }
    };
  //&12.Nilai Tugas Manual --------------------------------------------
    if(isset($_GET['nilai_tugas'])){
      if($_GET['nilai_tugas']=="manual_save"){
        $table = 'jawaban_tugas';
        $idsiswa = $_POST['idsiswa'];
        $idtugas = $_POST['idtugas'];
        $idguru = $_POST['idguru'];
        $nilai = $_POST['nilai'];

        $index =0;
        foreach ($idsiswa as $value) {
          $where= array(
            'id_siswa' => $value,
            'id_tugas' => $idtugas[$index],
          );
          //cek data nilai apakah sudaha da
          $cek = $db->fetch($table,$where);
          if(empty($cek)){ 
            //jika tidak ada tampung ke dalam array
            $dataArray=array(
              'id_siswa' => $value,
              'id_tugas' => $idtugas[$index],
              'id_guru' =>$idguru[$index],
              'tgl_dikerjakan' => date('Y-m-d H:i:s') ,
              'nilai'   => $nilai[$index],
            );
            //$data2[]=$dataArray;
            $exc =  $db->insert($table,$dataArray);
          }
          else{
            $dataArray=array(
              'id_siswa' => $value,
              'id_tugas' => $idtugas[$index],
              'id_guru' =>$idguru[$index],
              'tgl_dikerjakan' => date('Y-m-d H:i:s') ,
              'nilai'   => $nilai[$index],
            );
            $exc =  $exc = $db->update($table,$dataArray,$where);
          }
          $index++;
        }
        
        echo $exc;
      }
    }
  //&13.Selesaikan Semua Ujian Peserta --------------------------------------------
    if(isset($_GET['selesaikan'])){
      if($_GET['selesaikan']=="semua"){
        $idujian = $_POST['idujian'];
        $datanilai = $db->select('nilai', array('id_ujian' => $idujian,'selesai' => 0));
        
        $yes=$no=0;
        if(!empty($datanilai)){
          //loping semua nilai ujian siswa yang belum selesai
          foreach ($datanilai as $nilai) {
            $idm = $nilai['id_mapel'];
            $ids = $nilai['id_siswa'];
            $idu = $nilai['kode_ujian'];
            $iduj = $nilai['id_ujian'];

            $where = array(
              'id_siswa' => $ids,
              'id_mapel' => $idm
            );
            
            $where2 = array(
              'id_siswa' => $ids,
              'id_mapel' => $idm,
              'id_ujian' => $iduj
            );
            $benar='benar_';
            $salah='salah_';
            $mapel =  $db->fetch('mapel', array('id_mapel' => $idm));
            $siswa = $db->fetch('siswa', array('id_siswa' => $ids));
            $ceksoal = $db->select('soal', array('id_mapel' => $idm, 'jenis' => 1));
            $ceksoalesai = $db->select('soal', array('id_mapel' => $idm, 'jenis' => 2));
            $arrayjawab = array();
            $arrayjawabesai = array();

            //proses perhitungan
            foreach ($ceksoalesai as $getsoalesai) {
              $w2 = array(
                'id_siswa' => $ids,
                'id_mapel' => $idm,
                'id_soal' => $getsoalesai['id_soal'],
                'jenis' => 2
              );
              $getjwb2 = $db->fetch('jawaban', $w2);
              $arrayjawabesai[$getjwb2['id_soal']] = str_replace("'"," ",$getjwb2['esai']);
            }

            foreach ($ceksoal as $getsoal) {
              $w = array(
                'id_siswa' => $ids,
                'id_mapel' => $idm,
                'id_soal' => $getsoal['id_soal'],
                'jenis' => 1
              );

              $cekjwb = $db->rowcount('jawaban', $w);
              if ($cekjwb <> 0) {
                $getjwb = $db->fetch('jawaban', $w);
                $arrayjawab[$getjwb['id_soal']] = $getjwb['jawaban'];
                ($getjwb['jawaban'] == $getsoal['jawaban']) ? ${$benar.$ids}++ : ${$salah.$ids}++;
              } else {
                ${$salah.$ids}++;
              }
            }

            ${$jumsalah.$ids} = $mapel['tampil_pg'] - ${$benar.$ids};
            $bagi = $mapel['tampil_pg'] / 100;
            $bobot = $mapel['bobot_pg'] / 100;
            $skorx = (${$benar.$ids} / $bagi) * $bobot;
            $skor = number_format($skorx, 2, '.', '');

            $data = array(
              'ujian_selesai' => $datetime,
              'jml_benar' => ${$benar.$ids},
              'jml_salah' => ${$jumsalah.$ids},
              'skor' => $skor,
              'total' => $skor,
              'online' => 0,
              'selesai' => 1,
              'jawaban' => serialize($arrayjawab),
              'jawaban_esai' => serialize($arrayjawabesai)
            );

            $da2=$db->Status_sudah_ujian($ids,$idm,$iduj);

            if($da2==1){
              $no++;
            }
            else{
              $upnilai = $db->update('nilai', $data, $where);
              if($upnilai == 1){
                $yes++;
                $db->delete('jawaban', $where2);
                $db->delete('pengacak', $where);
              }
              
              
            }

          }//end foreach
          $cekarray=array(
              'status'=>1,
              'data' => $yes,
            );

          $json = json_encode($cekarray);
          echo $json ;
        }
        else{
          $cekarray=array(
              'status'=>2,
            );

          $json = json_encode($cekarray);
          echo $json ;
        }

      }
    }
  //&14.Bank Soal --------------------------------------------
    if(isset($_GET['banksoal'])){
      if($_GET['banksoal']=="status"){
        $status = $_POST['status'];
        foreach ($_POST['data'] as $val) {
          $data = array(
            'status' =>$status,
          );
          $where = array(
            'id_mapel' => $val,
          );
          $update = $db->update('mapel', $data, $where);
        }
        if($update){
          $db->RedisDelKey('banksoal'.$db->KodeSekolah().$_SESSION['id_pengawas']);
          $db->RedisDelKey('json_bank_soal');
          $db->RedisDelKey('json_soal');
          echo 1;
        }
        else{
          echo 0;
        }

        
      }
    }
  //&15.Konek Server MKKS --------------------------------------------
    if(isset($_GET['sinkronmkks'])){
      if($_GET['sinkronmkks']=="idserver"){
        $data = array(
          'id_server' =>$_POST['kodeserver'],
          'tokenApi'  =>$_POST['tokeapi'],
          'db_host' =>$_POST['urlserver'],
        );
        $where = array(
          'id_setting' => 1,
        );
        $update = $db->update('setting', $data, $where);
        if($update){
          echo 1;
        }
        else{
          echo 0;
        }

      }
      elseif($_GET['sinkronmkks']=="getdataserver"){
        
        $data = $db->getDataServer($_POST['id']);
        echo  json_encode($data);
        
      }
      elseif($_GET['sinkronmkks']=="resetsinkron"){
        $data = $db->ResetSingkron($_POST['id']);
        echo  json_encode($data);
      }
      else{

      }

    };


    } //if izin_status
  //&16.Nilai ---------------------------------------------------------------------------------
    if(isset($_GET['menunilai'])){
      if($_GET['menunilai']=="cari_banksoal"){
        //cari bank soal berdasarkan id mata pelajaran
        $tabel ="mapel";
        $where = array(
          'KodeMapel' => $_POST['id']
        );
        $exc = $db->CariDataById($tabel,$where);
        foreach ($exc as $value) {
          $array[] = array(
            'id_mapel' =>$value['id_mapel'],
            'KodeMapel' =>$value['KodeMapel'],
            'nama' => $value['nama'],
          );
        }
        $myJSON = json_encode($array);
        echo $myJSON;
      }
    }

    //&16.Blok User ---------------------------------------------------------------------------------
    if(isset($_GET['blok'])){
      if($_GET['blok']=="user"){
        $status = $_POST['nilai'];

        $id_siswa = $_POST['id'];
        $id_nilai = $_POST['nilai'];
        $aksi = $_POST['aksi'];

        $where = array(
          'id_nilai' => $id_nilai
        );
        
        if($aksi==1){
          $data = array(
          'blok' =>1
          );
        }
        
        else{
          $data = array(
            'blokBukaAdmin' =>1
          );
        }
        $update = $db->update('nilai', $data, $where);

        if($update){
          $db->RedisDelKey('blok'.$db->KodeSekolah().$id_nilai.$id_siswa);
          $sql="SELECT blok FROM nilai WHERE id_nilai=$id_nilai";
          $db->getDataRedis('blok'.$db->KodeSekolah().$id_nilai.$id_siswa,$sql);
          echo 1;
        }
        else{
          echo 0;
        }
        
      

        
      }

    }

} //end if token

else{
  jump("$homeurl");
  
}
?>




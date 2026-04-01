<?php
/**
 * load config redis dari mana pun
 */

//setting up one redis-----------------------------------------
require "../vendor/autoload.php";
use RedisClient\RedisClient;
use RedisClient\Client\Version\RedisClient2x6;
use RedisClient\ClientFactory;

//setting up one redis-----------------------------------------
#$setting = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM setting WHERE id_setting='1'"));

class RedisBudut extends Db{
  //cache redis ---------------------
  public $redis;
  
 
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
        $cek = mysqli_fetch_array($log);
        if(empty($cek)){
          $array = array();
          $data_json = json_encode($array);
        }
        else{
          foreach ($log as $value) { $array[]=$value; }
          $data_json = json_encode($array);
          $this->RedisKoneksi()->set($key, $data_json);
          $this->RedisKoneksi()->expire($key,$this->WaktuLamaCache());
        }
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
  
  function KodeSekolah()
  {
    $sql = "SELECT kode_sekolah FROM setting";
    $log = $this->getDataRedis('kodesekolah', $sql);
    
    return $log[0]->kode_sekolah;
    
  }



}//end class
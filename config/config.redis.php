<?php
include 'setting_url.php';

//setting up one redis-----------------------------------------
// using native phpredis extension
//setting up one redis-----------------------------------------


class Budut extends Db{
  //cache redis ---------------------
  public $redis;
  
 
  function RedisKoneksi(){
    $redis = new Redis();
    $host = isset($_ENV['REDIS_HOST']) ? $_ENV['REDIS_HOST'] : '127.0.0.1';
    $port = isset($_ENV['REDIS_PORT']) ? $_ENV['REDIS_PORT'] : 6379;
    $timeout = isset($_ENV['REDIS_TIMEOUT']) ? $_ENV['REDIS_TIMEOUT'] : 0;
    $password = isset($_ENV['REDIS_PASSWORD']) ? $_ENV['REDIS_PASSWORD'] : '';
    $username = isset($_ENV['REDIS_USERNAME']) ? $_ENV['REDIS_USERNAME'] : '';
    $database = isset($_ENV['REDIS_DATABASE']) ? $_ENV['REDIS_DATABASE'] : 0;
    
    try {
        $redis->connect($host, $port, $timeout);
        if (!empty($password)) {
            if (!empty($username)) {
                $redis->auth([$username, $password]);
            } else {
                $redis->auth($password);
            }
        }
        if ($database > 0) {
            $redis->select($database);
        }
    } catch (Exception $e) { }
    return $this->redis = $redis;
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
  //cache redis ---------------------
  function KodeSekolah()
  {
    $sql = "SELECT kode_sekolah FROM setting";
    $log = $this->getDataRedis('kodesekolah', $sql);
    
    return $log[0]->kode_sekolah;
    
  }



}//end class
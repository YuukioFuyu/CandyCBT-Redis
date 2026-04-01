<?php
error_reporting(0);

session_cache_expire(0);
session_cache_limiter(0);
session_start();
set_time_limit(0);

(isset($_SESSION['id_user'])) ? $id_user = $_SESSION['id_user'] : $id_user = 0;

include 'setting_url.php';

class Login extends Db{
  //cache tabel setting 
   function CacheSetting(){
      $sql="SELECT * FROM setting WHERE id_setting='1'";
      $log=$this->con->query($sql) or die($this->con->error);
      return $log;
   
  }
}

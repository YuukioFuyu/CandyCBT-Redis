<?php
require "../config/config.default.php";
if($_POST['id']==1){ $status='lokal'; }else if($_POST['id']==0){ $status = 'pusat';}else{ $status = 'error';}
$exec = mysqli_query($koneksi, "update setting set server='$status' where id_setting='1'");

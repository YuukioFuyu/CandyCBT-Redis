<?php

require("../config/config.default.php");
require("../config/config.function.php");
require("../config/functions.crud.php");

(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
($id_pengawas==0) ? header('location:index.php'):null;

	$id = $_POST;

	$a = serialize($id);
	print_r($id);

?>
	
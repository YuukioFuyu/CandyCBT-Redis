<?php
	require("config/config.login_siswa.php");
	$db = new Login();

	$username = htmlspecialchars($_POST['username'], ENT_QUOTES);
	$password = htmlspecialchars($_POST['password'], ENT_QUOTES);
	
	return $db->cekLogin($username, $password);
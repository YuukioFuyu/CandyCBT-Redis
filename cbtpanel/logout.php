<?php
require("../config/config.login_admin.php");
	require("../config/dis.php");
	session_destroy();
	echo "<script>location.href = '.';</script>";

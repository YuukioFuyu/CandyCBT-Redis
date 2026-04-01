<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
include('../../config/config_import_word.php');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => $sq_hostname2,
	'username' => $sq_dbusername2,
	'password' => $sq_dbpassword2,
	'database' => $sq_dbname2,
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);




// $db['serverdb'] = array(
// 	'dsn'	=> '',
// 	'hostname' => $sq_hostname,
// 	'username' => $sq_dbusername,
// 	'password' => $sq_dbpassword,
// 	'database' => 'sv3_super_admin',
// 	'dbdriver' => 'mysqli',
// 	'dbprefix' => '',
// 	'pconnect' => FALSE,
// 	'db_debug' => (ENVIRONMENT !== 'production'),
// 	'cache_on' => FALSE,
// 	'cachedir' => '',
// 	'char_set' => 'utf8',
// 	'dbcollat' => 'utf8_general_ci',
// 	'swap_pre' => '',
// 	'encrypt' => FALSE,
// 	'compress' => FALSE,
// 	'stricton' => FALSE,
// 	'failover' => array(),
// 	'save_queries' => TRUE
// );

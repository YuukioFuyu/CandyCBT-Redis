<?php
include 'copyright.php';
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<?php $this->load->view('thema/head.php'); ?>
<body class='hold-transition skin-green-light sidebar-mini fixed '>
	<div id='pesan'></div>
	<div class='loader'>
		<div class="loading">
   	 <p id="pesanku" >Harap Tunggu</p>
  	</div>
	</div>
	<div class='wrapper'>
		
		<header class='main-header'>
			<?php $this->load->view('thema/header_menu.php');
			?>
		</header>

		<aside class='main-sidebar'>
			<?php $this->load->view('thema/sidebar_menu.php'); ?>
		</aside>
		
		<div class='content-wrapper'>
			<?php $this->load->view($konten); ?>
		</div>
		<footer class='main-footer hidden-xs'>
			<?php  $this->load->view('thema/footer_menu.php'); ?>
		</footer>
	
	</div><!-- ./wrapper -->
	<?php  $this->load->view('thema/footer_js.php'); ?>
</body>
</html>
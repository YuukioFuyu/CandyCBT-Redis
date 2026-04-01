<head>
	<meta charset="utf-8">
	<meta http-equiv='X-UA-Compatible' content='IE=edge'>
	<title>Admin</title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<link rel='stylesheet' href='../../dist/bootstrap/css/bootstrap.min.css' />
	<link rel='stylesheet' href='../../plugins/fontawesome/css/all.css' />
	<link rel='stylesheet' href='../../plugins/select2/select2.min.css' />
	<link rel='stylesheet' href='../../dist/css/AdminLTE.css' />
	<link rel='stylesheet' href='../../dist/css/skins/skin-green-light.min.css' />
	<link rel='stylesheet' href='../../plugins/jQueryUI/jquery-ui.css'>
	<link rel='stylesheet' href='../../plugins/iCheck/square/green.css' />
	<link rel='stylesheet' href='../../plugins/slidemenu/jquery-slide-menu-admin.css'>
	<link rel='stylesheet' href='../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'>
	<link rel='stylesheet' href='../../plugins/datatables/dataTables.bootstrap.css' />
	<link rel='stylesheet' href='../../plugins/datatables/extensions/Responsive/css/dataTables.responsive.css' />
	<link rel='stylesheet' href='../../plugins/datatables/extensions/Select/css/select.bootstrap.css' />
	<link rel='stylesheet' href='../../plugins/animate/animate.min.css'>
	<link rel='stylesheet' href='../../plugins/datetimepicker/jquery.datetimepicker.css' />
	<link rel='stylesheet' href='../../plugins/notify/css/notify-flat.css' />
	<link rel='stylesheet' href='../../plugins/sweetalert2/dist/sweetalert2.min.css'>
	<link rel='stylesheet' href='../../plugins/toastr/toastr.min.css'>
	<link rel='stylesheet' href='../../dist/css/costum.css' />
	<link href="../../plugins/summernote/summernote-bs4.css" rel="stylesheet">
	<script src='../../plugins/tinymce/tinymce.min.js'></script>
	<script src='../../plugins/jQuery/jquery-3.1.1.min.js'></script>
	<script src='../../plugins/datatables/jquery.dataTables.min.js'></script>
	<script src='../../plugins/datatables/dataTables.bootstrap.min.js'></script>
	<script src='../../plugins/datatables/extensions/Select/js/dataTables.select.min.js'></script>
	<script src='../../plugins/datatables/extensions/Select/js/select.bootstrap.min.js'></script>
	<script src='../../plugins/jstoexcel/jquery.table2excel.js'></script>
	<script src="../../plugins/summernote/summernote-bs4.js"></script>
	<style type="text/css">
		::selection { background-color: #E13300; color: white; }
		::-moz-selection { background-color: #E13300; color: white; }

		body {
			background-color: #fff;
			margin: 10px;
			font: 13px/20px normal Helvetica, Arial, sans-serif;
			color: #4F5155;
		}

		a {
			color: #003399;
			background-color: transparent;
			font-weight: normal;
		}

		h1 {
			color: #444;
			background-color: transparent;
			border-bottom: 1px solid #D0D0D0;
			font-size: 19px;
			font-weight: normal;
			margin: 0 0 14px 0;
			padding: 14px 15px 10px 15px;
		}

		code {
			font-family: Consolas, Monaco, Courier New, Courier, monospace;
			font-size: 12px;
			background-color: #f9f9f9;
			border: 1px solid #D0D0D0;
			color: #002166;
			display: block;
			margin: 14px 0 14px 0;
			padding: 12px 10px 12px 10px;
		}

		#body {
			margin: 0 15px 0 15px;
		}

		p.footer {
			text-align: right;
			font-size: 11px;
			border-top: 1px solid #D0D0D0;
			line-height: 32px;
			padding: 0 10px 0 10px;
			margin: 20px 0 0 0;
		}

		#container {
			margin: 10px;
			border: 1px solid #D0D0D0;
			box-shadow: 0 0 8px #D0D0D0;
		}
		.loading {
		  position: absolute;
		  left: 50%;
		  top: 70%;
		  transform: translate(-50%,-50%);
		  font: 14px arial;
		  }
		 .warnayes{
		  background-color: #1fc8db;
		  background-image: linear-gradient(141deg, #9fb8ad 0%, #1fc8db 51%, #2cb5e8 75%);
		  color: white;
		  opacity: 0.95;
		  }
	</style>
	<style type="text/css">
		.skin-green-light .sidebar-menu>li:hover>a, .skin-green-light .sidebar-menu>li.active>a{
			color: #fff;
			background:#0030a7;
			<?php 
			if($setting['jenjang'] =='SMK' ){
				echo "color: #fff;";
				//echo "background:#00a896;";
				//echo "background: #5fc3ca;";
				echo"background-color: #1fc8db;background-image: linear-gradient(141deg, #9fb8ad 0%, #1fc8db 51%, #2cb5e8 75%);color: white;opacity: 0.95;";
			}
			elseif($setting['jenjang'] =='SMP'){
				echo "color: #fff;";
				echo "background:#0030a7;";
			}
			elseif($setting['jenjang'] =='SD'){
				echo "color: #fff;";
				echo "background:#c74230;";
			}
			else{
				echo "color: #fff;";
				echo "background:#00a896;";
			}
			?>
		}
		.loading {
	  position: absolute;
	  left: 50%;
	  top: 70%;
	  transform: translate(-50%,-50%);
	  font: 14px arial;
	  }
	  .title_bar_table{
	  	background-color: #05405a; 
	  	color: white;
	  }
	  <?php 
		if($setting['jenjang'] =='SMK' ){
			$style="height:102px;z-index:0; background:#00a896";
			// $style="background-color: #02305d; background-image: linear-gradient(141deg, #9fb8ad 0%, #02305d 51%, #02305d 75%);color: white;opacity: 0.95;";
		}
		elseif($setting['jenjang'] =='SMP'){
			$style="height:102px;z-index:0; background:#0030a7;";
		}
		elseif($setting['jenjang'] =='SD'){
			$style="height:102px;z-index:0; background:#c74230;";
		}
		else{
			$style="height:102px;z-index:0; background:#00a896;";
		}
		?>
	</style>
</head>
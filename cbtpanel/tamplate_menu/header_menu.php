<a href='?' class='logo' style='background-color:#f9fafc'>
	<span class='animated bounce logo-mini'>
		<img src="<?= $homeurl . '/' . $setting['logo'] ?>" height="30px">
	</span>
	<span class='animated bounce logo-lg'>
		<img src="<?= $homeurl . '/' . $setting['logo'] ?>" height="40px"> <?= $setting['sekolah'] ?>
	</span>
</a>

	<?php 
	//pada bagian header web
	if($setting['jenjang'] =='SMK' ){
		// $style="style='background-color:#00a896;box-shadow: 0px 10px 10px 0px rgba(0,0,0,0.1)'";

		$style="style='z-index:0; background: linear-gradient(to left, #05405a, #1cb5e0)'";
	}
	elseif($setting['jenjang'] =='SMP'){
		//$style="style='background-color:#060151;box-shadow: 0px 10px 10px 0px rgba(0,0,0,0.1)'";
		$style="style='background-image: linear-gradient(to right, #4086EF, #6826e8);'"; // #26B0E8
	}
	elseif($setting['jenjang'] =='SD'){
		$style="style='background-color:#dd4c39;box-shadow: 0px 10px 10px 0px rgba(0,0,0,0.1)'";
	}
	else{
		$style="style='background-color:#00a896;box-shadow: 0px 10px 10px 0px rgba(0,0,0,0.1)'";
	}
	?>

<nav class='navbar navbar-static-top'  <?= $style; ?>   role='navigation'>
	<a href='#' class='sidebar-baru' data-toggle='offcanvas' role='button'>
		<i class="fa fa-bars fa-lg fa-fw"></i>
	</a>
	<div class='navbar-custom-menu' >
		
		<ul class='nav navbar-nav'>
			<li class='dropdown user user-menu hidden-xs'>
					<a href='#' class='dropdown-toggle' data-toggle='dropdown' style="padding-top: 22px">
						<span class="hidden-xs" style='font-size:15px'>
							<?php   
							echo round(memory_get_usage()/1048576,2).''.' MB';?>
						</span>
					</a>
				</li>
			<?php if ($pengawas['level'] == 'admin') : ?>
				<li class='dropdown user user-menu hidden-xs'>
					<a href='#' class='dropdown-toggle' data-toggle='dropdown' style="padding-top: 22px">
						<i style="padding-top: 2px;" class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Jika Cache Redis tidak Aktif, Cek Apakah Penyedia Hosting menyediakan Cache Redis dan Server Redis Sudah Aktif. Jika Offline Cek Server Cache Redis Apakah Sudah Aktif "></i>
						<span class="hidden-xs" style='font-size:15px'>
							<?php
									try {
									    $Redis->ping();
									    echo('<span class="label label-success" style="font-size:15px; border-radius: 90%;"> &nbsp;&nbsp;</span>');
									} catch (Exception $e) {
									    if($e->getMessage()){
									      echo('<span class="label label-danger" style="font-size:15px;border-radius: 90%;"> &nbsp;&nbsp;</span>');
									    }
									} 
								
								?>

						</span>
					</a>
				</li>
				
				

				<li class='dropdown user user-menu'>
					<?php if ($setting['server'] == 'lokal') { ?>
					<a href='#' class='dropdown-toggle' data-toggle='dropdown' style="padding-top: 22px">
						<i class="fas fa-desktop fa-lg fa-fw"></i> <span class="hidden-xs" style='font-size:15px'><?= strtoupper($setting['server']) ?></span>
					<?php } else { ?>
					<a href='#' class='dropdown-toggle' data-toggle='dropdown' style="padding-top: 22px">
						<i class="fas fa-desktop fa-lg fa-fw"></i> <span class="hidden-xs" style='font-size:15px'><?= strtoupper($setting['server']) ?></span>
					<?php } ?>
					</a>
					
				</li>
				<li class="dropdown user user-menu">
					<a href='?pg=pengaturan'style="padding-top: 20px">
						<img src="icon/customer-support.svg" width="25" height="25">  
						<span class="hidden-xs" style='font-size:15px'>Pengaturan</span></a>
				</li>
				<li class="dropdown user user-menu">
					<a style="padding-top: 20px" href='?pg=pengumuman'>
						<img src="icon/megaphone.svg" width="25" height="25">  
						<span class="hidden-xs" style='font-size:15px'> Pengumuman </span>
					</a>
				</li>
			<?php endif; ?>
			<!-- mryes menu -->
			<!-- <li><a href='?pg=pengumuman'><i class="fas fa-bullhorn fa-lg fa-fw"></i> &nbsp; Pengumuman</a></li> -->
			<!-- <li><a href='prober.php' target='blank'><img src='../dist/img/svg/statistics.svg' width='20'> &nbsp; System</a></li> -->
			<!-- <li><a href='?pg=informasi'><i class="fas fa-comment-dots fa-lg  "></i> &nbsp; Info Candy</a></li> -->
			<li class='dropdown user user-menu'>
				<a href='#' class='dropdown-toggle' data-toggle='dropdown'>
					<?php if ($pengawas['foto_pengawas'] <> '') {
								echo "<img src='$homeurl/guru/fotoguru/$pengawas[id_pengawas]/$pengawas[foto_pengawas]' class='img-circle' alt='User Image' width='30'>";
							} else {
								echo "<img src='$homeurl/dist/img/avatar-6.png' class='img-circle' alt='User Image' width='30'>";
							}?>
					<!-- <img src='<?= $homeurl ?>/dist/img/avatar-6.png' class='user-image' alt='+'> -->
					<span class='hidden-xs'><?= $pengawas['nama'] ?> &nbsp; <i class='fa fa-caret-down'></i></span>
				</a>
				
				<ul class='dropdown-menu'>
					<li class='user-header' <?= $style ?>>
						<?php
						if ($pengawas['level'] == 'admin') :
							echo "<img src='$homeurl/dist/img/avatar-6.png' class='img-circle' alt='User Image'>";
						elseif ($pengawas['level'] == 'guru') :
							if ($pengawas['foto_pengawas'] <> '') {
								echo "<img src='$homeurl/guru/fotoguru/$pengawas[id_pengawas]/$pengawas[foto_pengawas]' class='img-circle' alt='User Image'>";
							} else {
								echo "<img src='$homeurl/dist/img/avatar-6.png' class='img-circle' alt='User Image'>";
							}
						endif
						?>
						<p>
							<?= $pengawas['nama'] ?>
							<small>NIP. <?= $pengawas['nip'] ?></small>
						</p>
					</li>
					<li class='user-footer'>
						<div class='pull-left'>
							<?php
							if ($pengawas['level'] == 'admin') :
								echo "<a href='?pg=pengaturan' class='btn btn-sm btn-default btn-flat'><i class='fa fa-gear'></i> Pengaturan</a>";
							elseif ($pengawas['level'] == 'guru') :
								echo "<a href='?pg=editguru' class='btn btn-sm btn-default btn-flat'><i class='fa fa-gear'></i> Edit Profil</a>";
							endif
							?>
						</div>
						<div class='pull-right'>
							<a href='logout.php' class='btn btn-sm btn-default btn-flat'><i class='fa fa-sign-out'></i> Keluar</a>
						</div>
					</li>
				</ul>
			</li>

		</ul>
	</div>
</nav>
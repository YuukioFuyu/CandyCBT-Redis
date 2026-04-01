<section class='sidebar' style="background-color: #fff">
	
	<hr style="margin:0px">
	<div class="user-panel" style="text-align:center">
		<span>APLIKASI UJIAN</span><br>
		<span>BERBASIS KOMPUTER</span>
	</div>
	<hr style="margin:0px">
	<ul class=' sidebar-menu tree data-widget=' tree>
		<li class="header" style="background-color: #1fc8db;background-image: linear-gradient(141deg, #9fb8ad 0%, #1fc8db 51%, #2cb5e8 75%);color: white;opacity: 0.95; "><b>MENU UTAMA</b></li>
		<li><a href='<?php echo base_url('admin/'); ?>'><i style="color: #36b8e8;" class="fas fa-home fa-2x fa-fw"></i> <span>Beranda</span></a></li>

		<li><a href='<?php echo base_url('admin/v_siswa'); ?>'><i style="color: #36b8e8;" class="fas fa-user fa-2x fa-fw"></i> <span>Siswa</span></a></li>
		
		<li><a href='<?php echo base_url('admin/no_ujian'); ?>'><i style="color: #36b8e8;" class="fas fa-user-secret fa-2x fa-fw"></i> <span>Siswa Tidak Ikut Ujian</span></a></li>
		
		<li><a href='<?php echo base_url('admin/daftar_ujian'); ?>'><i style="color: #36b8e8;" class="fas fa-2x fa-fw fa-toolbox    "></i><span> Download Nilai</span></a></li>

		<li><a href='<?php echo base_url('admin/status_peserta'); ?>'><i style="color: #36b8e8;" class="fas fa-2x fa-fw fa-book-reader    "></i><span> Status peserta Ujian</span></a></li>

		<?php if($setting['izin_materi'] ==1){ ?>
		<li class='treeview'>
			<a href='#'>

				<i class="fas fa-school fa-2x fa-fw" style="color: #36b8e8;"></i>
				<span> Elerning </span><span class='pull-right-container'> <i class='fa fa-angle-down pull-right'></i> </span></a>
				<ul class='treeview-menu'>
					<li><a href='<?php echo base_url('admin/materi'); ?>'><i class='fas fa-dot-circle fa-fw'></i> <span>Materi</span></a></li>
					<li><a href='<?php echo base_url('admin/tugas'); ?>'><i class='fas fa-dot-circle fa-fw'></i> <span>Tugas</span></a></li>
				</ul>
			</li>
			<?php } ?>
		
		<li class='treeview'>
			<a href='#'>
				<i style="color: #36b8e8;"   class="fas fa-chart-line fa-2x fa-fw"></i>
				<span> Analisa</span><span class='pull-right-container'> <i class='fa fa-angle-down pull-right'></i> </span></a>
				<ul class='treeview-menu'>
					<li><a href='<?= base_url('anso/daftar_soal'); ?>'><i class='fas fa-dot-circle fa-fw'></i> <span>Analisa Per Soal</span></a></li>
					<!-- <li><a href='?pg=anso_nilai'><i class='fas fa-dot-circle fa-fw'></i> <span>Analisa Nilai Mapel</span></a></li>
					<li><a href='?pg=anso_ranking'><i class='fas fa-dot-circle fa-fw'></i> <span>Analisa Nilai Ranking</span></a></li> -->
				</ul>
			</li>

			<li class='treeview'>
			<a href='#'>
				<i style="color: #36b8e8;"   class="fas fa-chart-line fa-2x fa-fw"></i>
				<span> Soal</span><span class='pull-right-container'> <i class='fa fa-angle-down pull-right'></i> </span></a>
				<ul class='treeview-menu'>
					<li><a href='<?= base_url('soal/daftar_soal'); ?>'><i class='fas fa-dot-circle fa-fw'></i> <span>Daftar Soal Ujian</span></a></li>
					<!-- <li><a href='?pg=anso_nilai'><i class='fas fa-dot-circle fa-fw'></i> <span>Analisa Nilai Mapel</span></a></li>
					<li><a href='?pg=anso_ranking'><i class='fas fa-dot-circle fa-fw'></i> <span>Analisa Nilai Ranking</span></a></li> -->
				</ul>
			</li>
			<hr>
		<li><a href='<?php echo base_url('login/log_out'); ?>'><i style="color: #36b8e8;" class="fas fa-sign-out-alt fa-2x fa-fw "></i> <span>Keluar / Logout</span></a></li>

		</ul><!-- /.sidebar-menu -->
		
	</section>
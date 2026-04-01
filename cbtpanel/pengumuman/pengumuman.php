<div class='row'>
	<div class='col-md-8'>
		<div class='box box-solid direct-chat direct-chat-warning'>
			<div class='box-header with-border'>
				<h3 class='box-title'><i class='fa fa-bullhorn'></i> Pengumuman Guru
				</h3>
				<div class='box-tools pull-right'></div>
			</div><!-- /.box-header -->
			<div class='box-body'>
				<div id='pengumumanguru'>
					<ul class='timeline'>
						<li class='time-label'><span class='bg-blue'>- Terbaru -</span></li>
						<?php foreach ($db->getDashborPengumumanGuru() as $value){ ?>
							<li><i class='fa fa-envelope bg-blue'></i>
								<div class='timeline-item'>
									<span class='time'> <i class='fa fa-calendar'></i> <?= buat_tanggal('d-m-Y', $value->date)?> <i class='fa fa-clock-o'></i> <?= buat_tanggal('h:i', $value->date) ?></span>
									<h3 class='timeline-header' style='background-color:#f9f0d5'><a class='$color' href='#'><?= $value->judul ?></a> <small> <?= $value->nama ?></small></h3>
									<div class='timeline-body'>
										<?= $value->text ?>
									</div>
								</div>
							</li>
						<?php } ?>
						
					</ul>
				</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
	<div class='col-md-4'>
		<div class='box box-solid '>
			<div class='box-body'>
				<strong><i class='fa fa-building-o'></i> <?= $setting['sekolah'] ?></strong><br />
				<?= $setting['alamat'] ?><br /><br />
				<strong><i class='fa fa-phone'></i> Telepon</strong><br />
				<?= $setting['telp'] ?><br /><br />
				<strong><i class='fa fa-fax'></i> Fax</strong><br />
				<?= $setting['fax'] ?><br /><br />
				<strong><i class='fa fa-globe'></i> Website</strong><br />
				<?= $setting['web'] ?><br /><br />
				<strong><i class='fa fa-at'></i> E-mail</strong><br />
				<?= $setting['email'] ?><br />
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
</div>
<?php 
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!'); 
?>
<?php if ($ac == '') : ?>
	<div class='row'>
		<div class='col-md-3'></div>
		<div class='col-md-6'>
			<div class='box box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>Atur Informasi Block</h3>
					<div class='box-tools pull-right '>
						<button id="simpan_kartu" class='btn btn-sm btn-flat btn-primary' ><i class='fa fa-save'></i> Simpan Dulu</button>
						<button class='btn btn-sm btn-flat btn-success' onclick="frames['frameresult'].print()"><i class='fa fa-print'></i> Print</button>
						<a href='?pg=siswa' class='btn btn-sm bg-maroon' title='Batal'><i class='fa fa-times'></i></a>
					</div>
				</div><!-- /.box-header -->
				<div class='box-body'>
					<?= $info ?>
					<div class='form-group'>
						<label>Header Kartu</label>
						<!--  onchange='kirim_form();' -->
						<textarea id='headerkartu' class='form-control' rows='3'><?= $setting['header_kartu'] ?></textarea>
					</div>
					<!-- mryes -->
					<center><label>Atur Posisi Tanda Tanggan</label></center>
					<div class='row' style="padding-bottom: 20px;">
						<div class='form-group'>
							<div class="col-md-6">
								<label> Atas Ke Bawah dalam Ukuran Pixcel</label>
								<input  value="<?= $setting['kartu_atas'] ?>" type="number" id="atas" name="" class="form-control" placeholder="Geser Atas Ke bawah">
							</div>
							<div class="col-md-6">
								<label>Kiri Ke Kanan dalam Ukuran Pixcel</label>
								<input value="<?= $setting['kartu_kiri'] ?>" id="kiri" type="number" name="" class="form-control" placeholder="Geser Atas Ke bawah">
							</div>
						</div>
					</div>
					<!-- /mryes -->

					<div class='form-group'>
						<label>Kelas</label>
						<div class='row'>
							<div class='col-xs-4'>
								<?php
								$total = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kelas"));
								$limit = number_format($total / 3, 0, '', '');
								$limit2 = number_format($limit * 2, 0, '', '');
								$sql_kelas = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY nama ASC LIMIT 0,$limit");
								?>
								<?php while ($kelas = mysqli_fetch_array($sql_kelas)) : ?>
									<div class='radio'>
										<label><input type='radio' name='idk' value="<?= $kelas['id_kelas'] ?>" onclick="printkartu('<?= $kelas[0] ?>')" /> <?= $kelas['nama'] ?></label>
									</div>
								<?php endwhile ?>
							</div>
							<div class='col-xs-4'>
								<?php
								$sql_kelas = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY nama ASC LIMIT $limit,$limit");
								?>
								<?php while ($kelas = mysqli_fetch_array($sql_kelas)) : ?>
									<div class='radio'>
										<label><input type='radio' name='idk' value="<?= $kelas['id_kelas'] ?>" onclick="printkartu('<?= $kelas[0] ?>')" /> <?= $kelas['nama'] ?></label>
									</div>
								<?php endwhile ?>
							</div>
							<div class='col-xs-4'>
								<?php
								$sql_kelas = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY nama ASC LIMIT $limit2,$total");
								?>
								<?php while ($kelas = mysqli_fetch_array($sql_kelas)) : ?>
									<div class='radio'>
										<label><input type='radio' name='idk' value="<?= $kelas['id_kelas'] ?>" onclick="printkartu('<?= $kelas[0] ?>')" /> <?= $kelas['nama'] ?></label>
									</div>
								<?php endwhile ?>
							</div>
						</div>
					</div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>
	<iframe id='loadframe' name='frameresult' src='kartu.php' style='border:none;width:1px;height:1px;'></iframe>
	<?php endif ?>
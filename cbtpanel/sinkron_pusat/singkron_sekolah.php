<?php 
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!'); 
?>
<?php if(empty($_GET['aksi'])){ ?>
<div class='row'>
	<div class='col-md-12'>
		<div class='box box-solid'>
			<div class='box-header with-border'>
				<h3 class='box-title'>Data Sekolah Sinkron</h3>
				<div class='box-tools pull-right '>
					
				</div>
			</div><!-- /.box-header -->
			<div class='box-body'>
					<div id='tablereset' class='table-responsive'>
						<div id='tablereset' class='table-responsive'>
							<table id='example1' class='table table-bordered '>
								<thead class="color-mryes">
									<tr>
										<th width='5px'>
											<input type='checkbox' id='ceksemua'></th>
											<th width='5px'>#</th>
											<th>Kode Sekolah</th>
											<th>Nama Sekolah</th>
											<th>Cek Data</th>
											<!-- <th>Data Sinkron</th>
											<th>Total Sinkron</th>
											<th>Date Sinkron</th> -->
											
										</tr>
									</thead>
									<tbody>
										<?php
											$da2=$db->getSekolahSudahSinkronKode();
											$no=1; 
										  foreach ($da2 as $value) {
										?>
											<tr>
												<td><input type='checkbox' name='cekpilih[]' class='cekpilih' id='cekpilih-<?= $no ?>' value="<?= $login['id_siswa'] ?>"></td>
												<td><?= $no++ ?></td>
												<td><?= $value['tssKode'] ?></td>
												<td><?= $value['tssNama'] ?></td>
												<td>
													<button class="cekdata btn btn-primary" data-kode="<?= $value['tssKode'] ?>" ><i class="fa fa-search"></i> Cek Data</button>
												</td>
												<!-- <td><?= $value['tssNamaSinkron'] ?></td>
												<td><?= $value['tssJmlDataOk'] ?></td>
												<td><?= $value['tssDateSinkron'] ?></td> -->
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
</div>
<?php }else{ ?>
<div class='row'>
	<div class='col-md-12'>
		<div class='box box-solid'>
			<div class='box-header with-border'>
				<h3 class='box-title'>Data Detail Sekolah Sinkron</h3>
				<button id="back" class="btn btn-warning"><i class="fas fa-arrow-left"></i> Kembali </button>
				<div class='box-tools pull-right '>
					
				</div>
			</div><!-- /.box-header -->
			<div class='box-body'>
					<div id='tablereset' class='table-responsive'>
						<div id='tablereset' class='table-responsive'>
							<table id='example1' class='table table-bordered '>
								<thead class="color-mryes">
									<tr>
										<th width='5px'>
											<input type='checkbox' id='ceksemua'></th>
											<th width='5px'>#</th>
											<th>Kode Sekolah</th>
											<th>Nama Sekolah</th>
											<th>Data Sinkron</th>
											<th>Total Sinkron</th>
											<th>Date Sinkron</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$da2=$db->getSekolahSudahSinkron($_GET['kode']);
											$no=1; 
										  foreach ($da2 as $value) {
										?>
											<tr>
												<td><input type='checkbox' name='cekpilih[]' class='cekpilih' id='cekpilih-<?= $no ?>' value="<?= $login['id_siswa'] ?>"></td>
												<td><?= $no++ ?></td>
												<td><?= $value['tssKode'] ?></td>
												<td><?= $value['tssNama'] ?></td>
												<td><?= $value['tssNamaSinkron'] ?></td>
												<td><?= $value['tssJmlDataOk'] ?></td>
												<td><?= $value['tssDateSinkron'] ?></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
</div>
<?php  } ?>


	<script type="text/javascript">
		$(document).ready(function() {
			$(document).on('click','.cekdata',function(){ // tamabah id dana
				var kode = $(this).data('kode');
				location.replace("?pg=singkron_sekolah&aksi=detail&kode="+kode);
			}); 
			$(document).on('click','#back',function(){ // tamabah id dana
				location.replace("?pg=singkron_sekolah");
			}); 

		}); 
	</script>		

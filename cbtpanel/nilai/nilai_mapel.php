<?php
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!');
?>

<div class='row'>
	<div class='col-md-12'>
		<div class='box box-solid'>
			<div class='box-header with-border'>
				<h3 class='box-title'> NILAI PER PAKET BANK SOAL</h3>
				<div class='box-tools pull-right btn-grou'>
					<a class='btn btn-sm btn-danger' href='?pg=jadwal'><i class='fa fa-times'></i></a>
				</div>
			</div><!-- /.box-header -->
			<div class='box-body'>
				<div class='table-responsive'>
					<table id="tablenilai" class='table table-bordered table-striped'>
						<thead>
								<tr>
									<th width='5px'>#</th>
									<th>Nama Mapel</th>
									<th>Download PG</th>
									<th>Download Esai</th>
								</tr>
							</thead>
							<tbody>
								<?php $np = $db->Tampil_nilai_per_mapel(); 
								$no=1;
								foreach ($np as $value) { 
									$id_ujian = $value['id_ujian'];
								?>
									<tr>
										<td><?= $no++;?></td>
										<td><?= $value['nama'];?></td>
										<td><a class='btn btn-sm btn-success' href='report_excel.php?m=<?= $id_ujian ?>'><i class='fa fa-download'></i> Download Excel</a></td>
										<td>
											<?php if($value['jml_esai'] > 0){ ?>
												<a class='btn btn-sm btn-primary' href='report_excel_esai.php?m=<?= $id_ujian ?>'><i class='fa fa-download'></i> Download Esai Excel</a>
											<?php } ?>
										</td>
									</tr>
								<?php } ?>
							</tbody>
					</table>
				</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
</div>
<script type="text/javascript">
	$('#tablenilai').dataTable();
</script>
	

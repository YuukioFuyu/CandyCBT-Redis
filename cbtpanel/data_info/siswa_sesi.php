<?php 
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!'); 
?>

<div class='row'>
	<div class='col-md-12'>
		<div class='box box-solid'>
			<div class='box-header with-border'>
				<h3 class='box-title'>Siswa Per Sesi</h3>
				<div class='box-tools pull-right '>
					
				</div>
			</div><!-- /.box-header -->
			<div class='box-body'>
				<?= $info ?>
				
					<div id='tablereset' class='table-responsive'>
						<div id='tablereset' class='table-responsive'>
							<table id='example1' class='table table-bordered table-striped'>
								<thead>
									<tr>
										<th width='5px'>
											<input type='checkbox' id='ceksemua'></th>
											<th width='5px'>#</th>
											<th>Nama Sesi</th>
											<th>Jumlah Peserta</th>
											
										</tr>
									</thead>
									<tbody>
										<?php
											$da2=$db->V_siswa_sesi();
											$no=1; 
										  foreach ($da2 as $value) {
										?>
											<tr><td></td>
												<!-- <td><input type='checkbox' name='cekpilih[]' class='cekpilih' id='cekpilih-<?= $no ?>' value="<?= $login['id_siswa'] ?>"></td> -->
												<td><?= $no ?></td>
												<td><?= $value['sesi'] ?></td>
												<td><?= $value['jml'] ?></td>
												
											</tr>
										<?php $no++; $total += $value['jml']; } ?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="3" align="right"><b>Total</b></td>
											<td><b><?= $total ?></b></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$(document).on('click','#btn_kelas',function(){ // tamabah id dana
				var nm=1;
			//alert(nm);

			$.ajax({
					//url:'koneksi/cekadm.php?adm=t_dana',
					url:'../config/c_admin.php?adm=sv_cek',
					data:'nm='+nm,
					type:'post',
					success: function(cek){
						alert(cek);
					}
				});

		}); 

		}); 
	</script>		

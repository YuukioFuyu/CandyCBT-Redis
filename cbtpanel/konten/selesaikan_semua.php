<?php 
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!'); 
?>
<?php $info = ''; ?>
<div class='row'>
	<div class='col-md-12'>
		<div class='box box-solid'>
			<div class='box-header with-border'>
				<h3 class='box-title'>Selesaikan Semua Ujian Peserta</h3>
				<div class='box-tools pull-right '>
					<div class='box-tools pull-right '>
						<a href="?pg=status2" class='btn btn-sm  btn-info' ><i class='fas fa-users'></i> <span class='hidden-xs'>Status Peserta Ujian</span></a>
						<a href="?pg=pindah_nilai" class='btn btn-sm btn-success' ><i class='glyphicon glyphicon glyphicon-transfer'></i> <span class='hidden-xs'>Pindah Nilai</span></a>
						<a class='btn btn-sm btn-flat btn-primary' data-toggle='modal' data-backdrop='static' data-target='#infojadwal'><i class='glyphicon glyphicon-info-sign'></i> <span class='hidden-xs'>Info Selesaikan Ujian</span></a>
					</div>
				</div>
			</div><!-- /.box-header -->
			<div class='box-body'>
				<ul class="nav nav-pills">
					<li class="active"><a data-toggle="pill" href="#home">Status Ujian</a></li>
				</ul>
				<div class="tab-content" style="padding-top: 20px;">
					<div id="home" class="tab-pane fade in active">
						<div class='table-responsive'>
							<table id='example1' class='table table-bordered table-striped'>
								<thead>
									<tr>
										<th width='5px'>#</th>
										<th>AKSI</th>
										<th>JML UJIAN SELESAI</th>
										<th>JML UJIAN BELUM SELESAI</th>
										<th>KODE UJIAN</th>
										<th>NAMA MAPEL</th>
										<th>TANGGAL UJIAN</th>
										<th>TANGGAL SELESAI</th>
									</tr>
								</thead>
								<tbody>
									<?php $getUjian = $db->getUjianBerjalan('nilai'); $no=1; foreach ($getUjian as $data) : ?>
										<tr>
											<td><?= $no++; ?></td>
											<td><button data-id="<?= $data['id_ujian'] ?>" class="pindah_nilai btn btn-sm btn-primary "><i class='glyphicon glyphicon glyphicon-transfer'></i>&nbsp; &nbsp;SELESAIKAN</button></td>
											<td><center><?= $db->getJumlahDataUjian($data['id_ujian'],'nilai',1)?></center></td>
											<td><center><?= $db->getJumlahDataUjian($data['id_ujian'],'nilai',0)?></center></td>
											<td><center><?= $data['kode_ujian'] ?></center></td>
											<td><?= $data['nama'] ?></td>
											<td><?= date('d-m-Y H:i:s',strtotime($data['tgl_ujian'])); ?></td>
											<td><?= date('d-m-Y H:i:s',strtotime($data['tgl_selesai'])); ?></td>
										</tr>
									<?php endforeach ?>
								</tbody>
							</table>
						</div>
					</div>

				
				</div>
				
				<!-- /pengacak mryes -->
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
	<script type="text/javascript">
		$(document).ready(function() {

			$('#pindah_nilai').DataTable({ select: true });

			$(document).on('click', '.pindah_nilai', function() {
				let idujian = $(this).data('id');
				swal({
					title: 'Yakin Akan Menyelesaikan Semua Ujian Ini ?',
					text: 'Proses ini akan memaksa semua peserta menyelesaikan ujian, tanpa terkeculi',
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya, Selesaikan Ujian!'
				}).then((result) => {
					if (result.value) {
						$.ajax({
							type: 'POST',
							url: 'c_aksi.php?selesaikan=semua',
							data: {idujian:idujian},
							beforeSend: function() {
								$('.loader').css('display', 'block');
							},
							success: function(response) {
								$('.loader').css('display', 'none');
								var datacek = JSON.parse(response);
								//console.log(datacek);
								if(datacek.status==1){
									swal({
										title: "BERHASIL",
										text: datacek.data+" Peserta Berhasil di Selesaikan",
										icon: "success",
										button: "Oke",
									}).then(function() {
										location.reload();
									});
								}
								else if(datacek.status==2){
									swal({
										title: "KOSONG !!!",
										text: "Tidak ada Peserta Ujian !!! ",
										icon: "danger",
										buttons: "No",
										dangerMode: true,
									}); 
								}
								else{
									swal({
										title: "GAGAL !!!",
										text: "Opssss Gagal !!! ",
										icon: "warning",
										buttons: "No",
										dangerMode: true,
									}); 
								}
							}
						});
					}
				});
			});
			$(document).on('click','#hapus_nilai',function(){
				let idujian = $(".kodeujian").val();
				if(idujian != ''){
					swal({
						title: 'Yakin Akan Menghapus Nilai ?',
						text: 'Nilai Ujian yang sudah di Hapus tidak akan bisa di kembalikan',
						type: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Ya, Hapus Nilai'
					}).then((result) => {
						if (result.value) {
							$.ajax({
								type: 'POST',
								url: 'c_aksi.php?pindah_nilai=hapusnilai',
								data: {idujian:idujian},
								beforeSend: function() {
									$('.loader').css('display', 'block');
								},
								success: function(response) {
									$('.loader').css('display', 'none');
									if(response==1){
										toastr.success('Semua Nilai Berhasil di Hapus');
										setInterval(function() {
											location.reload();
										}, 1000);
										
									}
									else{
										toastr.error('Gagal Hapus Nilai');
									}
								}
							});
						}
					});
				}
				else{
					alert('Pilih Kode Ujian Terlebih Dahulu');
				}
			});
		});
	</script>
	<div class='modal fade' id='infojadwal' style='display: none;'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header bg-maroon'>
						<button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
						<h4 class='modal-title'><i class="fas fa-business-time fa-fw"></i> Infromasi Selesaikan Semua Ujian</h4>
					</div>
					<!-- tambah jadwal mryes -->
					<div class='modal-body'>
						<p>
							Silahkan pilih <b>Ujian</b> mana yang akan di selesaikan semua peserta yang mengikuti ujianya <br>
							<b>secara paksa tanpa terkecuali</b>
						</p>
					</div>
				</div>
			</div>
		</div>
</div>

<?php 
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!'); 
?>
<?php $info = ''; ?>
<div class='row'>
	<div class='col-md-12'>
		<div class='box box-solid'>
			<div class='box-header with-border'>
				<h3 class='box-title'>Pindah Nilai Ujain</h3>
				<div class='box-tools pull-right '>
					<div class='box-tools pull-right '>
						<a href="?pg=status2" class='btn btn-sm  btn-success' ><i class='fas fa-users'></i> <span class='hidden-xs'>Status Peserta Ujian</span></a>
						<a class='btn btn-sm btn-flat btn-primary' data-toggle='modal' data-backdrop='static' data-target='#infojadwal'><i class='glyphicon glyphicon-info-sign'></i> <span class='hidden-xs'>Info Pindah Nilai</span></a>
					</div>
				</div>
			</div><!-- /.box-header -->
			<div class='box-body'>
				<ul class="nav nav-pills">
					<li class="active"><a data-toggle="pill" href="#home">Nilai Ujian</a></li>
					<li><a data-toggle="pill" href="#menu1">Nilai Ujian yang di Pindah</a></li>
					<li><a data-toggle="pill" href="#menu2">Hapus Nilai Ujian</a></li>
				</ul>
				<div class="tab-content" style="padding-top: 20px;">
					<div id="home" class="tab-pane fade in active">
						<div class="row">
							<div class="col-md-12">
								<blockquote class="blockquote">Jumlah Siswa <?= $siswa;?></blockquote>
									<i style="color: red">Catatn : Pastikan jumlah nilai ujian beleum selesai 0 atau pastikan semua peserta ujian sudah selesai, Baru melakukan pindah nilai</i>
							</div>
						</div>
						<div class='table-responsive'>
							<table id='example1' class='table table-bordered table-striped'>
								<thead>
									<tr>
										<th width='5px'>#</th>
										<th>PINDAH NILAI</th>
										<th>JML NILAI UJIAN SELESAI</th>
										<th>JML NILAI UJIAN BELUM SELESAI</th>
										<th>KODE UJIAN</th>
										<th>NAMA UJIAN</th>
										<th>NAMA MAPEL</th>
										<th>TANGGAL UJIAN</th>
										<th>TANGGAL SELESAI</th>
									</tr>
								</thead>
								<tbody>
									<?php $getUjian = $db->getUjianBerjalan('nilai'); $no=1; foreach ($getUjian as $data) : ?>
										<tr>
											<td><?= $no++; ?></td>
											<td><button data-id="<?= $data['id_ujian'] ?>" class="pindah_nilai btn btn-sm btn-primary "><i class='glyphicon glyphicon glyphicon-transfer'></i>&nbsp; &nbsp;PINDAH</button></td>
											<td><center><?= $db->getJumlahDataUjian($data['id_ujian'],'nilai',1)?></center></td>
											<td><center><?= $db->getJumlahDataUjian($data['id_ujian'],'nilai',0)?></center></td>
											<td><center><?= $data['kode_ujian'] ?></center></td>
											<td><?= $data['nama'] ?></td>
											<td><?= $data['slagNama'] ?></td>
											<td><?= date('d-m-Y H:i:s',strtotime($data['tgl_ujian'])); ?></td>
											<td><?= date('d-m-Y H:i:s',strtotime($data['tgl_selesai'])); ?></td>
										</tr>
									<?php endforeach ?>
								</tbody>
							</table>
						</div>
					</div>

					<div id="menu1" class="tab-pane fade">
						<div class='table-responsive'>
							<table id='pindah_nilai' class='table table-bordered table-striped'>
								<thead>
									<tr>
										<th width='5px'>#</th>
										<th>JML NILAI UJIAN PINDAH</th>
										<th>KODE UJIAN</th>
										<th>NAMA UJIAN</th>
										<th>NAMA MAPEL</th>
										<th>TANGGAL UJIAN</th>
										<th>TANGGAL SELESAI</th>
									</tr>
								</thead>
								<tbody>
									<?php $getNilaiPindah = $db->getUjianBerjalan('nilai_pindah'); $noo=1; foreach ($getNilaiPindah as $data) : ?>
										<tr>
											<td><?= $noo++; ?></td>
											<td><center><?= $db->getJumlahDataUjian($data['id_ujian'],'nilai_pindah',1)?></center></td>
											<td><center><?= $data['kode_ujian'] ?></center></td>
											<td><?= $data['nama'] ?></td>
											<td><?= $data['slagNama'] ?></td>
											<td><?= date('d-m-Y H:i:s',strtotime($data['tgl_ujian'])); ?></td>
											<td><?= date('d-m-Y H:i:s',strtotime($data['tgl_selesai'])); ?></td>
										</tr>
									<?php endforeach ?>
								</tbody>
							</table>
						</div>
					</div>

					<div id="menu2" class="tab-pane fade">
						<legend style="font-size: 15px;"><i>Hapus semua nilai yang ada, berdasarkan kode ujian  | Nilai yang sudah di pindah yang akan di hapus</i></legend>
						<div class="row">
							<div class="col-md-2" style="padding-bottom: 20px;">
								<select class="form-control select2 kodeujian" style="width: 150px;">
									<option value=""> Pilih Kode Ujian</option>
									<?php foreach ($getNilaiPindah as $datas) : ?>
										<option value="<?= $datas['id_ujian'] ?>"><?= $datas['nama'] ?></option>
									<?php endforeach ?>
								</select>
							</div>
							<div class="col-md-3" >
								<button id="hapus_nilai" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus Nilai</button>
							</div>
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
					title: 'Yakin Akan Memindah Nilai ?',
					text: 'Nilai Ujian yang sudah di pindah tidak akan bisa di kembalikan, Pastikan semua peserta ujian sudah menyelesaikan ujian',
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya, Pindah Nilai!'
				}).then((result) => {
					if (result.value) {
						$.ajax({
							type: 'POST',
							url: 'c_aksi.php?pindah_nilai=pindah',
							data: {idujian:idujian},
							beforeSend: function() {
								$('.loader').css('display', 'block');
							},
							success: function(response) {
								$('.loader').css('display', 'none');
								var datacek = JSON.parse(response);
								//console.log(datacek.data);
								if(datacek.status==1){
									swal({
										title: "BERHASIL",
										text: "Nilai Ujian "+datacek.data+" Berhasil Di Pindah ",
										icon: "success",
										button: "Oke",
									}).then(function() {
										location.reload();
									});
								}
								else{
									swal({
										title: "GAGAL !!!",
										text: "Nilai Ujian "+datacek.data+" Gagal Di Pindah ",
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
						<h4 class='modal-title'><i class="fas fa-business-time fa-fw"></i> Infromasi Pindah Nilai Ujian</h4>
					</div>
					<!-- tambah jadwal mryes -->
					<div class='modal-body'>
						<p>
							Pindah Nilai Ujian di gunakan untuk memindah semua nilai ujian peserta yang suda menyelesaikan ujian 
							<br>pada <b>Menu UBK -> Status Peserta</b> <br>
							Agar mengurangi beban Load server pada saat ujian berlangsung
							<hr>
							JML NILAI UJIAN SELESAI merupakan jumlah peserta ujian yang sudah menyelesaikan ujian.
							<hr>
							JML NILAI UJIAN BELUM SELESAI merupakan jumlah peserta ujian yang sedang melakukan ujian dan belum menyelesaikan ujian
							<hr>
							JML NILAI PINDAH merupakan jumlah peserja ujian yang sudah di pindah 
							<br>ke <b>TABEL peserta ujain 2</b> dan tidak akan tampil di menu status peserta 
							<hr>
							HAPUS NILAI UJIAN di gunakan untuk menghapus semua data nilai ujian peserta berdasarkan kode ujian atau ujian yang di ikuti peserta 
						</p>
					</div>
				</div>
			</div>
		</div>
</div>

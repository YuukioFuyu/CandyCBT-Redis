<?php 
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!'); 
?>
<?php if ($ac == '') : ?>
	<div class='row'>
		<div class='col-md-3'></div>
		<div class='col-md-6'>
			<div class='box box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>Daftar Hadir Peserta</h3>
					<div class='box-tools pull-right '>
						<button id='btnabsen' class='btn btn-sm btn-flat btn-success' onclick="frames['frameresult'].print()"><i class='fa fa-print'></i> Print</button>
					</div>
				</div><!-- /.box-header -->
				<div class='box-body'>
					<?= $info ?>
					<div class='form-group'>
						<div class='form-group'>
							<label>Pilih Mapel</label>
							<select id='absenmapel' class='select2 form-control' required='true' onchange=printabsen();>
								<?php $sql_mapel = mysqli_query($koneksi, "SELECT * FROM ujian"); ?>
								<option value=''>Pilih Jadwal Ujian</option>
								<?php while ($mapel = mysqli_fetch_array($sql_mapel)) : ?>
									<option value="<?= $mapel['id_mapel'] ?>"><?php echo "$mapel[nama] $mapel[level] $mapel[id_pk]" ?></option>
								<?php endwhile ?>
							</select>
						</div>

						<div class='form-group'>
							<label>Pilih Ruang</label>
							<select id='absenruang' class='form-control select2' onchange=printabsen();>";

							</select>
						</div>
						<div class='form-group'>
							<label>Pilih Sesi</label>
							<select id='absensesi' class='form-control select2' onchange=printabsen();>
							</select>
						</div>
						<div class='form-group'>
							<label>Pilih Kelas</label>
							<select id='absenkelas' class='form-control select2' onchange=printabsen();>
								<option value='KLS'>Pilih Kelas</option>
							</select>
						</div>
						<span><i style="color: red;">*Mohon Di Perhatikan <br>Pilih Semua Kelas Jika Ingin Cetak Daftar Hadir Per Ruangan dan Sesi</i></span>
					</div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>
	<iframe id='loadabsen' name='frameresult' src='absen.php' style='border:none;width:0px;height:0px;'></iframe>
	<?php endif ?>
	<script type="text/javascript">
			$(document).ready(function() {
				$("#absenmapel").change(function() {
				var mapel_id = $(this).val();
				console.log(mapel_id);
				$.ajax({
					type: "POST", // Method pengiriman data bisa dengan GET atau POST
					url: "dataabsen_ruang.php", // Isi dengan url/path file php yang dituju
					data: "mapel_id=" + mapel_id, // data yang akan dikirim ke file yang dituju
					success: function(response) { // Ketika proses pengiriman berhasil
						$("#absenruang").html(response);
						console.log(response);
					},
					error: function(xhr, status, error) {
						console.log(error);
					}
				});
			});

			$("#absenruang").change(function() {

				var ruang = $(this).val();
				console.log(ruang);
				$.ajax({
					type: "POST", 
					url: "dataabsen_sesi.php", 
					data: "ruang=" + ruang, 
					success: function(response) { 
						$("#absensesi").html(response);
						console.log(response);
					},
					error: function(xhr, status, error) {
						console.log(error);
					}
				});
			});

			$("#absensesi").change(function() {
				var sesi = $(this).val();
				var mapel_id = $("#absenmapel").val();
				var ruang = $("#absenruang").val();
				$.ajax({
					type: "POST", 
					url: "dataabsen_kelas.php", 
					data: "mapel_id=" + mapel_id + '&sesi=' + sesi + '&ruang=' + ruang, 
					
					success: function(response) { 
						$("#absenkelas").html(response);
						console.log(response);
					},
					error: function(xhr, status, error) {
						console.log(error);
					}
				});
			});


			});
	</script>
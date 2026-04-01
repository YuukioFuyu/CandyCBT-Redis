<?php
cek_session_guru();
if (isset($_POST['simpanpengumuman'])) {
	if($_POST['tipe']=='internal'){
		$kelas = '';
		$kode_level = '';
	}
	else{
		$kelas = serialize($_POST['kelas']);
		$kode_level = $_POST['idlevel'];
	}
	

	$exec = mysqli_query($koneksi, 
		"INSERT INTO pengumuman (judul,text,user,type,pnKelas,pnLevel) 
		VALUES ('$_POST[judul]','$_POST[pengumuman]','$pengawas[id_pengawas]','$_POST[tipe]','$kelas','$kode_level')");

	if (!$exec) {
		$db->RedisDelKey('pengumuman');
		$db->RedisDelKey('pengumumanguru');
		$info = info("Gagal menyimpan!", "NO");
	} else {
		$db->RedisDelKey('pengumuman');
		$db->RedisDelKey('pengumumanguru');
		jump("?pg=$pg");
	}
}
?>
<div class='row'>
	<form action='' method='post'>
		<div class='col-md-6'>
			<div class='box box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'> Tulis Pengumuman</h3>
					<div class='box-tools pull-right'>
						<button type='submit' name='simpanpengumuman' class='btn btn-sm btn-flat btn-success'><i class='fa fa-edit'></i> Simpan</button>
						<a href='?pg=<?= $pg ?>' class='btn btn-sm bg-maroon'><i class='fa fa-times'></i></a>
					</div>
				</div><!-- /.box-header -->
				<div class='box-body'>
					<div class='col-sm-12'>
						<div class='form-group'>
							<label>Jenis Pengumuman </label><br>
							<select id="infotipe" name='tipe' class='form-control select2' style='width:100%' required='true' >
								<option value=''>Pilih</option>
								<option value='eksternal'>Siswa</option>
								<?php if($_SESSION['level']=="admin"){ ?>
								<option value='internal'>Guru</option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-sm-12 psiswa" style="display: none;">
						<div class="form-group">
							<select  id="idlevel" name="idlevel" class="form-control select2" style="width: 200px" >
								<option value=''>Pilih Level</option>
								<?php $db2 = $db->v_level(); 
								foreach ($db2 as $value) { ?>
									<option value="<?= $value['kode_level']; ?>"><?= $value['kode_level']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-sm-12 psiswa" style="display: none;">
						<label>Pilih Kelas</label><br>
						<select id="kelas1" name='kelas[]' class='form-control select2' style='width:100%' multiple >
						</select>
					</div>
					<div class='col-sm-12' style="padding-top: 10px;">
						<div class='form-group'>
							<label>Judul </label>
							<input type='text' class='form-control' name='judul' placeholder='Judul' required>
						</div>
					</div>
					
					<div class='col-sm-12'>
						<div class='form-group'>
							<label>Informasi Pengumuman </label>
							<textarea id='txtpengumuman' name='pengumuman' class='form-control'></textarea>
						</div>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</div>
	</form>
	<div class='col-md-6'>
		<div class='box box-solid'>
			<div class='box-header with-border'>
				<h3 class='box-title'> Pengumuman</h3>
			</div><!-- /.box-header -->
			<div class='box-body'>
				<div class='table-responsive'>
					<table id='example1' class='table table-bordered table-striped'>
						<thead>
							<tr>
								<th width='2px'>No</th>
								<th >Aksi</th>
								<th>Pengumuman</th>
								<th>Untuk</th>
								<th>Level</th>
								<th>Kelas</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							if($_SESSION['level']=="admin"){
								$pengumumanq = $db->getPengumumanAdmin(); 
							}
							else{
								$pengumumanq = $db->getPengumumanGuru(); 
							}

							?>
							<?php foreach ($pengumumanq as $pengumuman) { ?>
								<?php $no++; ?>
								<tr>
									<td><?= $no ?></td>
									<td align='center'>
													<div class=''>
														<button title="Hapus Pengumuman" class='btn bg-maroon btn-flat btn-xs' data-toggle='modal' data-target="#hapus<?= $pengumuman['id_pengumuman'] ?>"><i class='fa fa-trash'></i></button>
													</div>
												</td>
									<td><?= $pengumuman['judul'] ?></td>
									<td>
										<?php if ($pengumuman['type'] == 'eksternal') : ?>
											<small class='label bg-blue'>siswa</label>
												<?php else : ?>
													<small class='label bg-green'>guru</label>
													<?php endif ?>
												</td>
												<td><?= $pengumuman['pnLevel'] ?></td>
												<td>
													<?php 
													$kelass = unserialize($pengumuman['pnKelas']);
													foreach ($kelass as $value) {
														echo ' | '.$value;
													}
													?>
												</td>
												
											</tr>
											<?php $info = info("Anda yakin akan menghapus pengumuman ini ?"); ?>
											<?php
											if (isset($_POST['hapus'])) {
												$exec = mysqli_query($koneksi, "DELETE FROM pengumuman WHERE id_pengumuman = '$_REQUEST[idu]'");
												(!$exec) ? info("Gagal menyimpan", "NO") : jump("?pg=$pg");
											}
											?>
											<div class='modal fade' id="hapus<?= $pengumuman['id_pengumuman'] ?>" style='display: none;'>
												<div class='modal-dialog'>
													<div class='modal-content'>
														<div class='modal-header bg-maroon'>
															<button class='close' data-dismiss='modal'><span aria-hidden='true'><i class='glyphicon glyphicon-remove'></i></span></button>
															<h3 class='modal-title'>Hapus Pengumuman</h3>
														</div>
														<div class='modal-body'>
															<form action='' method='post'>
																<input type='hidden' id='idu' name='idu' value="<?= $pengumuman['id_pengumuman'] ?>" />
																<div class='callout '>
																	<h4><?= $info ?></h4>
																</div>
																<div class='modal-footer'>
																	<div class='box-tools pull-right '>
																		<button type='submit' name='hapus' class='btn btn-sm bg-maroon'><i class='fa fa-trash'></i> Hapus</button>
																		<button type='button' class='btn btn-default btn-sm pull-left' data-dismiss='modal'>Close</button>
																	</div>
																</div>
															</form>
														</div>
													</div>
												</div>
											</div>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div>
			</div>
			<script type="text/javascript">
				$(document).ready(function() {
					$('#infotipe').change(function() {
						var info = $('#infotipe').val();
						if(info=='internal'){
							$('.psiswa').css("display","none");
						}
						else{
							$('.psiswa').removeAttr("style");
						}
						
					});
					$('#idlevel').change(function() {
						var idlevel = $('#idlevel').val();
						$("#kelas1").empty();
			      //get kelas json
			      $.ajax({
			      	url: "<?php echo "c_aksi.php?kelas=getkelas"; ?>",
			      	data:{idlevel:idlevel},
			      	type: 'post',

			      	dataType: "json",
			      	success: function(data){
			      		var dataMapel = [];
			      		$.each(data, function(index, objek){
			      			var option = '<option value="'+objek.id_kelas+'">'+objek.nama+'</option>';
			      			dataMapel.push(option);
			      		});
			      		$('#kelas1').append('<option value="">Pilih Kelas</option><option value="semua">Semua Kelas</option>'+dataMapel);
			        //console.log(data);
			      }
			    });
			    });
					tinymce.init({
						selector: '#txtpengumuman',
						plugins: [
						'advlist autolink lists link image charmap print preview hr anchor pagebreak',
						'searchreplace wordcount visualblocks visualchars code fullscreen',
						'insertdatetime media nonbreaking save table contextmenu directionality',
						'emoticons template paste textcolor colorpicker textpattern imagetools uploadimage paste'
						],

						toolbar: 'bold italic fontselect fontsizeselect | alignleft aligncenter alignright bullist numlist  backcolor forecolor | emoticons code | imagetools link image paste ',
						fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
						paste_data_images: true,
						paste_as_text: true,
						images_upload_handler: function(blobInfo, success, failure) {
							success('data:' + blobInfo.blob().type + ';base64,' + blobInfo.base64());
						},
						image_class_list: [{
							title: 'Responsive',
							value: 'img-responsive'
						}],
					});
				});
			</script>
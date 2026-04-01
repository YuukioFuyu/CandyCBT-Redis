<?php
 defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!'); 
 if(!empty($_GET['id_mapel'])){
 		$id = $_GET['id_mapel'];
 }
 else{
 	$id="";
 }

 if(!empty($_GET['kls'])){
 		$idkls = $_GET['kls'];
 }
 else{
 	$idkls="";
 }
 if(!empty($_GET['jrs'])){
 		$idjrs = $_GET['jrs'];
 }
 else{
 	$idjrs="";
 }

$nm_mapel = $db->v_nm_mapel($id);
?> 
<div class='row'>
	<div class='col-md-12'>
		<div class='box box-solid '>
			<div class='box-header with-border '>
				<h3 class='box-title'><i class='fa fa-briefcase'></i> History Nilai Siswa</h3>
			</div><!-- /.box-header -->
			<div class="row" style="padding-left: 10px;">
				<div class="col-md-12">
					<legend style="font-size: 15px;"><i>Pilih Salah Satu, Jurusan atau Kelas, Silahkan di Pilih : Pilih Jurusan atau Pilih Kelas Agar Kosong </i></legend>
				</div>
			</div>
			<div class="row" style="padding-left: 10px; padding-top: 10px; padding-bottom: 10px;">
				<?php if($setting['jenjang']=='SMK'): ?>
				<div class="col-md-3">
					<select class="form-control select2 jurusan">
						<?php $jurusan = $db->v_jurusan(); ?>
						<option value=""> Pilih Jurusan</option>
						<?php foreach ($jurusan as $jrs) : ?>
							<option <?php if($idjrs==$jrs['id_pk']){ echo "selected";}else{} ?> value="<?= $jrs['id_pk'] ?>"><?= $jrs['id_pk'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<?php else : ?>
							<select class="jurusan" style="display: none;">
								<option value="" selected="selected"></option>
							</select>
						<?php endif ?>
				<div class="col-md-3">
					<select class="form-control select2 kelas">
						<?php $kelas = $db->v_kelas(); ?>
						<option value=""> Pilih Kelas</option>
						<?php foreach ($kelas as $value) : ?>
							<option <?php if($idkls==$value['id_kelas']){ echo "selected";}else{} ?>  value="<?= $value['id_kelas'] ?>"><?= $value['nama'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="col-md-3">
					<select class="form-control select2 ujian">
						<?php $ujian = $db->v_mapel($id=null,$_SESSION['id_pengawas'],$_SESSION['level']); ?>
						<option> Pilih Jadwal</option>
						<?php foreach ($ujian as $uj) : ?>
							<option <?php if($id==$uj['id_mapel']){ echo "selected";}else{} ?> value="<?= $uj['id_mapel'] ?>"><?= $uj['nama'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-3">
					<button id="cari_nilai" class="btn btn-info"><i class="fa fa-search"></i> Cari Data</button>
				</div>
			</div>
			<div class='box-body'>
				<?php if(!empty($_GET['id_mapel'])){?>
				<div class="row">
					<div class="col-md-6">
						<a id="down_excel"  class='btn btn-sm btn-success' ><i class="fa fa-download"></i> Download to Excel</a>
					</div>
				</div>
				<?php }?>
				<div class="row" style="padding-top: 10px;">
					<div class="col-md-12">
						<div id="tbexcel" class="col-md-12">
						<div style="padding-bottom: 20px;">Histori Jawaban dari Mapel : &nbsp;&nbsp;<b><?= $nm_mapel['nama']?></b></div>
						<div class='table-responsive'>
							<table id='table_copy' class='table table-striped'>
								<thead>
									<th>NO</th>
									<th>NIS</th>
									<th>NAMA SISWA</th>
									<th>MAPEL</th>
									<th>BENAR</th>
									<th>SALAH</th>
									<th>NILAI PG</th>
									<th>STATUS</th>
									<th>UPDATE NILAI</th>
								</thead>
								<tbody>
									<?php 
									$no=1;
									$data_copy =  $db->v_nilai_copy();
									foreach ($data_copy as $value) { ?>
									<tr>
									<td><?= $no; ?></td>
									<td><?= $value['nis']; ?></td>
									<td><?= $value['nama_siswa']; ?></td>
									<td><?= $value['nama']; ?></td>
										<?php 
										$arrayjawab = array();
										$arrayjawabesai = array();
										$benar='benar_';
									  $salah='salah_';
										
										//soal PG
										$ceksoal = $db->select_soal($value['id_mapel']);
										$ceksoalesai = $db->select_soal2($value['id_mapel']);
										foreach ($ceksoal as $getsoal) {
												$jika = array(
													'id_siswa' => $value['id_siswa'],
													'id_mapel' => $value['id_mapel'],
													'id_ujian' => $value['id_ujian'],
													'id_soal' => $getsoal['id_soal'],
													'jenis' => '1'
												);
												// // //ambil nilai jawaban pg untuk di simpan di tabel jawaban
												$getjwb = $db->select_jawaban_copy($jika);
												if ($getjwb) {
													$arrayjawab[$getjwb['id_soal']] = $getjwb['jawaban'];
													($getjwb['jawaban'] == $getsoal['jawaban']) ? 
													${$benar.$no}++ : ${$salah.$no}++;
												}
											}
											//proses jawaban copy esai
										foreach ($ceksoalesai as $getsoalesai) {
											$jika = array(
													'id_siswa' => $value['id_siswa'],
													'id_mapel' => $value['id_mapel'],
													'id_ujian' => $value['id_ujian'],
													'id_soal' => $getsoalesai['id_soal'],
													'jenis' => '2'
												);
											 $getjwb_esai = $db->select_jawaban_copy2($jika);
												if ($getjwb_esai) {
													$arrayjawabesai1[$getjwb_esai['id_soal']] = $getjwb_esai['esai'];
													$arrayjawabesai = str_replace("'"," ",$arrayjawabesai1);
													//$arrayjawabesai = preg_replace("/[^0-9]/", "", $arrayjawabesai1);
												}
										}
										$sejawabesai = serialize($arrayjawabesai);
										$sejawab =  serialize($arrayjawab);

										$jawabanb = "<small class='label bg-green'>${$benar.$no} &nbsp;<i class='fa fa-check'></i></small>";
										$jawab_benar= ${$benar.$no};

										$jawabans = "<small class='label bg-red'>${$salah.$no} &nbsp;<i class='fa fa-times'></i></small>";
										$jawab_salah= ${$salah.$no};

										$mapel = fetch($koneksi, 'ujian', array('id_mapel' => $value['id_mapel'], 'id_ujian' => $value['id_ujian']));
											// HITUNG BOBOT NILAI SISWA PG
										$jumsalah = $mapel['tampil_pg'] - ${$benar.$no};
										$bagi = $mapel['tampil_pg'] / 100;
										$bobot = $mapel['bobot_pg'] / 100;
										$skorx = (${$benar.$no} / $bagi) * $bobot;
										$skor = number_format($skorx, 2, '.', '');

										$nilai_skor = $skor;

										if($skor >= $mapel['kkm']){
											$sskor = "<small class='label bg-green'>$skor</small>";
											$status = "<small class='label bg-green'>Lulus</small>";
										}
										else{
											$sskor = "<small class='label bg-red'>$skor</small>";
											
											$status = "<small class='label bg-red'>Belum Lulus</small>";
										}

										echo "<td>".$jawabanb."</td>";
										echo "<td>".$jawabans."</td>";
										echo "<td>".$sskor."</td>";
										echo "<td>".$status."</td>";
										?>
										<td><button 
											data-idsiswa="<?= $value['id_siswa']; ?>" 
											data-idmapel='<?= $value['id_mapel']; ?>' 
											data-idujian='<?= $value['id_ujian']; ?>' 
											data-benar="<?= $jawab_benar ?>"
											data-salah="<?= $jawab_salah ?>"
											data-nilai="<?= $nilai_skor ?>"
											data-sejawab='<?= $sejawab ?>'
											data-sejawabesai='<?= $sejawabesai ?>'
											id="<?= $value['id_siswa']; ?>"
											class="btn btn-warning btn-sm btn0">Update Nilai 0</button></td>
										</tr>	
										<script type="text/javascript">
											$('.btn0').click(function(event){
												event.preventDefault();
												var idsiswa = $(this).data('idsiswa');
												var idmapel = $(this).data('idmapel');
												var idujian = $(this).data('idujian');

												var benar = $(this).data('benar');
												var salah = $(this).data('salah');
												var nilai = $(this).data('nilai');

												var sejawab = $(this).data('sejawab');
												var sejawabesai = $(this).data('sejawabesai');

												$.ajax({
													type: 'POST',
													url: 'c_aksi.php?nilai=nilai_update',
													data: {
														idsiswa:idsiswa,
														idmapel:idmapel,
														idujian:idujian,
														benar:benar,
														salah:salah,
														nilai:nilai,
														sejawab:sejawab,
														sejawabesai:sejawabesai,

													},
													success: function(data) {
														//console.log(data);
														if(data==1){
															swal({
																title: "BERHASIL",
																text: "Mengembalikan Nilai 0",
																icon: "success",
																button: "Oke",
															}).then(function() {
																//var link = window.location.href;
																//window.location.replace(link);
															});
														}
														else{
															swal({
																title: "GAGAL !!!",
																text: "Restore Nilai 0",
																icon: "warning",
																buttons: "No",
																dangerMode: true,
															}); 
														}
													}
												});

											});

										</script>	
									<?php $no++; } ?>
								</tbody>
							</table>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$("#table_copy").DataTable({
		"lengthMenu": [[100, -1], [100, "All"]]
	});
	
	$('#cari_nilai').click(function(){
		var kelas = $('.kelas').val();
		var ujian = $('.ujian').val();
		var jrs = $('.jurusan').val();
	
		if(kelas =="" && jrs != ""){
			location.replace("?pg=nilai3&id_mapel="+ujian+"&jrs="+jrs);
		}
		else if(jrs =="" && kelas != ''){
			location.replace("?pg=nilai3&id_mapel="+ujian+"&kls="+kelas);
		}
		else{
			alert("Uppps Pilih Kelas Atau Jurusan Salah Satu");
		}

	});
	$(document).on('click','#down_excel',function(){
		$("#tbexcel").table2excel({
        //filename: "data_absen_<?php echo $bulan; ?>" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
        filename: "histori_jawaban_<?php echo $nm_mapel['nama']; ?>.xls",
        fileext: ".xls",
        exclude_img: true,
        exclude_links: true,
        exclude_inputs: true,
       // preserveColors:true

      });
 
	});

</script>


                      



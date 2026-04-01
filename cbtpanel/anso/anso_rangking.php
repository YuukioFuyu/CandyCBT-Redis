<?php 
defined('APLIKASI') or exit('Anda tidak dizinkan mengakses langsung script ini!'); 
?>
<?php
 
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
$nilai= $db->v_nilai($id,$idkls,$idjrs);

$no10=$no30=$no50=$no70=$no90=$no100=0;
while($data=mysqli_fetch_array($nilai)){
	$total = $data['skor']+$data['nilai_esai'];
	if($total <= 10){
		$no10++;
	}
	else if($total > 10 && $total <= 30){
		$no30++;
	}
	else if($total > 30 && $total<= 50){
		$no50++;
	}
	else if($total > 50 && $total <= 70){
		$no70++;
	}
	else if($total > 70 && $total <= 90){
		$no90++;
	}
	else if($total > 50 && $total <= 100){ 
		$no100++;
	}
	else{

	}
}

?> 
<div class='row'>
	<div class='col-md-12'>
		<div class='box box-solid '>
			<div class='box-header with-border '>
				<h3 class='box-title'><i class='fa fa-briefcase'></i> Analisa Ranking Siswa </h3>
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
				<?php endif; ?>
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
						<?php $ujian = $db->v_jadwal(); ?>
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
				<?php if(empty($id)){ }else{ ?>
				<div class="row">
					<div class="col-md-6">
						<a id="down_excel"  class='btn btn-sm btn-success' ><i class="fa fa-download"></i> Download to Excel</a>
					</div>
				</div>
				<?php }?>
				<div class="row">
					<div id="tbexcel" class="col-md-12">
						<div style="padding-bottom: 20px;">Statistik Nilai Ranking dari Mapel : &nbsp;&nbsp;<b><?= $nm_mapel['nama']?></b></div>
						<div class='table-responsive'>
						<table id='table_ranking' class='table table-striped'>
							<thead>
								<tr>
									<th>Peringkat</th>
									<th>Nama Siswa</th>
									<th>Kelas</th>
									<th>Jurusan</th>
									<th>Mapel</th>
									<th>Nilai PG</th>
									<th>Nilai Essai</th>
									<th>Total</th>
									<th>KKM</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$no=1; 
								$rangking = $db->nilai_ranking($id,$idkls,$idjrs);
								if(empty($rangking)){

								}
								else{
								foreach ($rangking as $key => $value) {
									$total = $value['skor']+$value['nilai_esai'];
									if($total >= $value['kkm']){
										$kkm = "<span>Lulus KKM</sapn>";
									}
									else{
										$kkm = "<span>Tidak Lulus KKM</sapn>";
									}
								?>
								<tr>
									<td><?= $no; ?></td>
									<td><?= $value['nama_siswa'] ?></td>
									<td><?= $value['id_kelas'] ?></td>
									<td><?= $value['idpk'] ?></td>
									<td><?= $value['nama'] ?></td>
									<td><?= $value['skor'] ?></td>
									<td><?= $value['nilai_esai'] ?></td>
									<td><?= $total ?></td>
									<td><?= $value['kkm'] ?></td>
									<td><?= $kkm ?></td>
								</tr>
								<?php $no++; } } ?>
							</tbody>
						</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$("#table_ranking").DataTable({

	});

	$('#cari_nilai').click(function(){
		var kelas = $('.kelas').val();
		var ujian = $('.ujian').val();
		var jrs = $('.jurusan').val();
	
		if(kelas =="" && jrs != ""){
			location.replace("?pg=anso_ranking&id_mapel="+ujian+"&jrs="+jrs);
		}
		else if(jrs =="" && kelas != ''){
			location.replace("?pg=anso_ranking&id_mapel="+ujian+"&kls="+kelas);
		}
		else{
			alert("Uppps Pilih Kelas Atau Jurusan Salah Satu");
		}

	});

	$(document).on('click','#down_excel',function(){
		$("#tbexcel").table2excel({
        //filename: "data_absen_<?php echo $bulan; ?>" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
        filename: "data_analisi_ranking_<?php echo $d['nama']; ?>.xls",
        fileext: ".xls",
        exclude_img: true,
        exclude_links: true,
        exclude_inputs: true,
       // preserveColors:true

      });
 
	});

</script>
                      



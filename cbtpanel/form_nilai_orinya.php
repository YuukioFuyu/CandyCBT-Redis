<?php
	require("../config/config.default.php");
	require("../config/config.function.php");
	require("../config/functions.crud.php");
	require("../config/dis.php");
	date_default_timezone_set('Asia/Jakarta');
	(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
	($id_pengawas==0) ? header('location:index.php'):null;
	$idserver = $setting['kode_sekolah'];
	echo "<link rel='stylesheet' href='$homeurl/dist/css/cetak.min.css'>";
	
	$sesi =@$_GET['id_sesi'];
	$mapel =@$_GET['id_mapel'];
	$ruang =@$_GET['id_ruang'];
	$kelas =@$_GET['id_kelas'];
	$id_kelas =@$_GET['id_kelas'];
	if($sesi=='' and $ruang=='' and $mapel==''){
		die('Tidak ada data yang dicetak. Anda harus memilih semua variabel: mapel, sesi dan ruang');
	}
	$lebarusername='10%';
	$lebarnopes='17%';
	$namaruang = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM ruang WHERE kode_ruang='$ruang'"));

	$querytanggal=mysqli_query($koneksi,"SELECT * FROM ujian WHERE id_mapel='$mapel'");
	$cektanggal=mysqli_fetch_array($querytanggal);
	$mapelx=mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM mapel WHERE id_mapel='$mapel'"));					
	$namamapel=	mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM mata_pelajaran WHERE kode_mapel='$mapelx[nama]'"));
	$sqg=mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM pengawas WHERE id_pengawas='$mapelx[idguru]'"));
	if(date('m')>=7 AND date('m')<=12) {
		$ajaran = date('Y')."/".(date('Y')+1);
	}elseif(date('m')>=1 AND date('m')<=6) {
		$ajaran = (date('Y')-1)."/".date('Y');
	}
	//$sqg=mysqli_fetch_array(mysqli_query("SELECT mapel.*, pengawas.nama,pengawas.nip FROM mapel INNER JOIN pengawas ON mapel.idguru=pengawas.id_pengawas WHERE id_mapel='$id_mapel'"));
	$namakelas= mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM kelas WHERE id_kelas='$id_kelas'"));
	$querysetting=mysqli_query($koneksi,"SELECT * FROM setting WHERE id_setting='1'");
	$setting=mysqli_fetch_array($querysetting);

	$nm_ujian=mysqli_query($koneksi,"SELECT * FROM ujian");
	$tampil=mysqli_fetch_array($nm_ujian);
	$tgl_ujian2 = date('d-m-Y', strtotime($tampil['tgl_ujian']));
	if(!$sesi=='' and !$ruang=='' and !$kelas==''){
		if($mapelx['id_kelas']==''){	//semua jurusan
			$ckck=mysqli_query($koneksi,"SELECT * FROM siswa WHERE id_kelas='$kelas' and ruang='$ruang' and sesi='$sesi' ");
		}else{		//jurusan tertentu ==> filter berdasarkan jurusan tersebut!!!
			$ckck=mysqli_query($koneksi,"SELECT * FROM siswa WHERE sesi='$sesi' AND ruang='$ruang' AND id_kelas='$kelas' and idpk='$mapelx[idpk]'");
		}
	
	}elseif($sesi=='' and !$ruang=='' and !$kelas==''){
		if($mapelx['id_kelas']=='semua' or $mapelx['idpk']=='' ){
			$ckck=mysqli_query($koneksi,"SELECT * FROM siswa LEFT JOIN nilai ON nilai.id_siswa=siswa.id_siswa WHERE  ruang='$ruang' and id_kelas='$kelas' and id_mapel='$mapel'");
		}else{
			$ckck=mysqli_query($koneksi,"SELECT * FROM siswa LEFT JOIN nilai ON nilai.id_siswa=siswa.id_siswa WHERE  ruang='$ruang' and id_kelas='$kelas' and idpk='$mapelx[idpk]' and id_mapel='$mapel'");
		}
	}elseif($sesi=='' and $ruang=='' and !$kelas==''){
		if($mapelx['idpk']=='semua'){
			$ckck=mysqli_query($koneksi,"SELECT * FROM siswa LEFT JOIN nilai ON nilai.id_siswa=siswa.id_siswa WHERE  id_kelas='$kelas' and id_mapel='$mapel'");	
		}else{
			$ckck=mysqli_query($koneksi,"SELECT * FROM siswa LEFT JOIN nilai ON nilai.id_siswa=siswa.id_siswa WHERE  id_kelas='$kelas' and idpk='$mapelx[idpk]' and id_mapel='$mapel'");	
		}
	}elseif(!$sesi=='' and $ruang=='' and $kelas==''){
		if($mapelx['idpk']=='semua'){
			$ckck=mysqli_query($koneksi,"SELECT * FROM siswa LEFT JOIN nilai ON nilai.id_siswa=siswa.id_siswa WHERE  sesi='$sesi' and id_mapel='$mapel'");	
		}else{
			$ckck=mysqli_query($koneksi,"SELECT * FROM siswa LEFT JOIN nilai ON nilai.id_siswa=siswa.id_siswa WHERE  sesi='$sesi' and idpk='$mapelx[idpk]' and id_mapel='$mapel'");	
		}
	}elseif(!$sesi=='' and !$ruang=='' and $kelas==''){
		if($mapelx['idpk']=='semua'){
			$ckck=mysqli_query($koneksi,"SELECT * FROM siswa LEFT JOIN nilai ON nilai.id_siswa=siswa.id_siswa WHERE  sesi='$sesi' and ruang='$ruang' and id_mapel='$mapel'");
		}else{
			$ckck=mysqli_query($koneksi,"SELECT * FROM siswa LEFT JOIN nilai ON nilai.id_siswa=siswa.id_siswa WHERE  sesi='$sesi' and ruang='$ruang' and idpk='$mapelx[idpk]' and id_mapel='$mapel'");
		}
	}elseif($sesi=='' and !$ruang=='' and $kelas==''){
		if($mapelx['idpk']=='semua'){
			$ckck=mysqli_query($koneksi,"SELECT * FROM siswa LEFT JOIN nilai ON nilai.id_siswa=siswa.id_siswa WHERE   ruang='$ruang' and id_mapel='$mapel'");	
		}else{
			$ckck=mysqli_query("SELECT * FROM siswa LEFT JOIN nilai ON nilai.id_siswa=siswa.id_siswa WHERE   ruang='$ruang' and idpk='$mapelx[idpk]' and id_mapel='$mapel'");
		}
	}else{
		if($mapelx['idpk']=='semua'){
			$ckck=mysqli_query($koneksi,"SELECT * FROM siswa LEFT JOIN nilai ON nilai.id_siswa=siswa.id_siswa where id_mapel='$mapel'");	
		}else{
			$ckck=mysqli_query($koneksi,"SELECT * FROM siswa LEFT JOIN nilai ON nilai.id_siswa=siswa.id_siswa where idpk='$mapelx[idpk]' and id_mapel='$mapel'");	
		}
	}
	$jumlahData = mysqli_num_rows($ckck);
	$jumlahn = '32';
	$n = ceil($jumlahData/$jumlahn);
	$nomer = 1;

	$date=date_create($cektanggal['tgl_ujian']);
	
	for($i=1;$i<=$n;$i++){
		$mulai = $i-1;
		$batas = ($mulai*$jumlahn);
		$startawal = $batas;
		$batasakhir = $batas+$jumlahn;
		if ($i==$n){
			echo "
			<div class='page'>
				<table width='100%'>
					<tr>
						<td width='100'><img src='$homeurl/dist/img/logo2.png' height='80px'></td>
						<td>
							<CENTER>
								<strong class='f12'>
									REKAPITULASI NILAI <BR>
									$setting[nama_ujian]<BR>TAHUN PELAJARAN $ajaran
								</strong>
							</CENTER></td>
							<td width='100'><img src='$homeurl/$setting[logo]' height='75'></td>
					</tr>
				</table>
				<hr >
				
				<table class='detail'>
					<tr>
						<td>SEKOLAH/MADRASAH</td><td>:</td><td><span style='width:450px;'>&nbsp;$setting[sekolah]</span></td>
					</tr>
					<tr>
						<td>KELAS</td><td>:</td><td><span style='width:450px;'>&nbsp;$namakelas[nama]</span></td>
					</tr>
					<tr>
						<td>MATA PELAJARAN</td><td>:</td><td colspan='4'><span style='width:450px;'>&nbsp;$namamapel[nama_mapel]</span></td>
					</tr>
				</table>
				<hr/><br>
				<table class='it-grid it-cetak' width='100%'>
				<tr height=40px>
					<td width='4%' align=center>No</td>
					
					<td width='20%'  align='center'>No Peserta</td>
					<td align='center'>Nama</th>
					<td width='10%' align='center'>NILAI PG</td>
					<td width='10%' align='center'>NILAI ESSAY</td>
					<td width='10%' align='center'>JUMLAH</td>
					<td width='10%' align='center'>KKM</td>
					<td width='10%' align='center'>STATUS</td>
				</tr>";
					if(!$sesi=='' and !$ruang=='' and !$kelas==''){
						if($mapelx['idpk']=='semua'){	//semua jurusan
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa LEFT JOIN nilai ON nilai.id_siswa=siswa.id_siswa WHERE sesi='$sesi' and id_mapel='$mapel' and ruang='$ruang' and id_kelas='$kelas' limit $batas,$jumlahn");
						}else{		//jurusan tertentu ==> filter berdasarkan jurusan tersebut!!!
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa LEFT JOIN nilai ON nilai.id_siswa=siswa.id_siswa WHERE sesi='$sesi' and id_mapel='$mapel' AND ruang='$ruang' AND id_kelas='$kelas' and idpk='$mapelx[idpk]' limit $batas,$jumlahn");
						}
					
					}elseif($sesi=='' and !$ruang=='' and !$kelas==''){
						if($mapelx['idpk']=='semua'){
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa LEFT JOIN nilai ON nilai.id_siswa=siswa.id_siswa WHERE  ruang='$ruang' and id_mapel='$mapel' and id_kelas='$kelas' limit $batas,$jumlahn");
						}else{
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa LEFT JOIN nilai ON nilai.id_siswa=siswa.id_siswa WHERE  ruang='$ruang' and id_mapel='$mapel' and id_kelas='$kelas' and idpk='$mapelx[idpk]' limit $batas,$jumlahn");
						}
					}elseif($sesi=='' and $ruang=='' and !$kelas==''){
						if($mapelx['idpk']=='semua'){
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa LEFT JOIN nilai ON nilai.id_siswa=siswa.id_siswa WHERE  id_kelas='$kelas' and id_mapel='$mapel' limit $batas,$jumlahn");	
						}else{
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa LEFT JOIN nilai ON nilai.id_siswa=siswa.id_siswa WHERE  id_kelas='$kelas' and id_mapel='$mapel' and idpk='$mapelx[idpk]' limit $batas,$jumlahn");	
						}
					}elseif(!$sesi=='' and $ruang=='' and $kelas==''){
						if($mapelx['idpk']=='semua'){
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa LEFT JOIN nilai ON nilai.id_siswa=siswa.id_siswa WHERE  sesi='$sesi' and id_mapel='$mapel' limit $batas,$jumlahn");	
						}else{
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa LEFT JOIN nilai ON nilai.id_siswa=siswa.id_siswa WHERE  sesi='$sesi' and idpk='$mapelx[idpk]' and id_mapel='$mapel' limit $batas,$jumlahn");	
						}
					}elseif(!$sesi=='' and !$ruang=='' and $kelas==''){
						if($mapelx['idpk']=='semua'){
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa LEFT JOIN nilai ON nilai.id_siswa=siswa.id_siswa WHERE  sesi='$sesi' and ruang='$ruang' and id_mapel='$mapel' limit $batas,$jumlahn");
						}else{
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa LEFT JOIN nilai ON nilai.id_siswa=siswa.id_siswa WHERE  sesi='$sesi' and ruang='$ruang' and id_mapel='$mapel' and idpk='$mapelx[idpk]' limit $batas,$jumlahn");
						}
					}elseif($sesi=='' and !$ruang=='' and $kelas==''){
						if($mapelx['idpk']=='semua'){
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa LEFT JOIN nilai ON nilai.id_siswa=siswa.id_siswa WHERE   ruang='$ruang' and id_mapel='$mapel' limit $batas,$jumlahn");	
						}else{
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa WHERE   ruang='$ruang' and idpk='$mapelx[idpk]' and id_mapel='$mapel' limit $batas,$jumlahn");
						}
					}else{
						if($mapelx['idpk']=='semua'){
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa where id_mapel='$mapel' limit $batas,$jumlahn");	
						}else{
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa LEFT JOIN nilai ON nilai.id_siswa=siswa.id_siswa where idpk='$mapelx[idpk]' and id_mapel='$mapel' limit $batas,$jumlahn");	
						}
					}
					
					while($f= mysqli_fetch_array($ckck)){
						$total = $f['skor']+$f['nilai_esai'];
						if($total >= $tampil['kkm']){
						$lulus = "LULUS";
							}
							else{
								$lulus = "Belum Lulus";
							}
						if ($nomer % 2 == 0) {
							echo "
							<tr>
							<td align='center'>$nomer.</td>
							
							<td align='center'>&nbsp;$f[no_peserta]</td>
							<td>$f[nama]</td>
							<td align='center'>$f[skor]</td>
							<td align='center'>$f[nilai_esai]</td>
							<td align='center'>$total</td>
							<td align='center'>$tampil[kkm]</td>
							<td align='center'>$lulus</td>
						</tr>";
						} else {
							
							echo "
							<tr>
							<td align='center'>$nomer.</td>
							
							<td align='center'>&nbsp;$f[no_peserta]</td>
							<td>$f[nama]</td>
							<td align='center'>$f[skor]</td>
							<td align='center'>$f[nilai_esai]</td>
							<td align='center'>$total</td>
							<td align='center'>$tampil[kkm]</td>
							<td align='center'>$lulus</td>
						</tr>";
						}
						$nomer++;
					}
					echo "
				</table>
				<div style='padding-left: 50px;'>
				<br><br>
				<table border='0' width='100%'>
				<tr>
				<td  width='20%'>Mengatahui,</td>
				<td width='10%'></td>
				<td width='0.1%'>Way Jepara, ".$tgl_ujian2."</td>
				</tr>
				<tr>
				<td>Kepala Sekolah,,</td>
				<td width='0%'></td>
				<td>Guru Mapel,</td>
				
				</tr>
				<tr>
				<td ><br><br><br><br><br><strong>$setting[kepsek]</strong></td>
				<td width='0%'><br><br><br><br><br></td>
				<td width='20%'><br><br><br><br><br><strong>$sqg[nama]</strong></td>
				
				</tr>
				<tr>
				<td>NIP.$setting[nip]</td>
				<td width='0%'></td>
				<td>NIP. $sqg[nip] </td>
				
				</tr>
				</table>
				</div>
				
				
			</div>";
			break;

			// <div class='footer'>
			// 		<table width='100%' height='30'>
			// 			<tr>
			// 				<td width='25px' style='border:1px solid black'></td>
			// 				<td width='5px'>&nbsp;</td>
			// 				<td style='border:1px solid black;font-weight:bold;font-size:14px;text-align:center;'>$setting[nama_ujian]</td>
			// 				<td width='5px'>&nbsp;</td>
			// 				<td width='25px' style='border:1px solid black'></td>
			// 			</tr>
			// 		</table>
			// 	</div>
		}
		echo "
		<div class='page'>
			<table width='100%'>
					<tr>
						<td width='100'><img src='$homeurl/dist/img/jabar.png' height='75'></td>
						<td>
							<CENTER>
								<strong class='f12'>
									REKAPITULASI NILAI <BR>
									$setting[nama_ujian]<BR>TAHUN PELAJARAN $ajaran
								</strong>
							</CENTER></td>
							<td width='100'><img src='$homeurl/$setting[logo]' height='75'></td>
					</tr>
				</table>
				
				<table class='detail'>
					<tr>
						<td>SEKOLAH/MADRASAH</td><td>:</td><td><span style='width:450px;'>&nbsp;$setting[sekolah]</span></td>
					</tr>
					<tr>
						<td>KELAS</td><td>:</td><td><span style='width:450px;'>&nbsp;$namakelas[nama]</span></td>
					</tr>
					<tr>
						<td>MATA PELAJARAN</td><td>:</td><td colspan='4'><span style='width:450px;'>&nbsp;$namamapel[nama_mapel]</span></td>
					</tr>
				</table>
				<hr/><br>

			<table class='it-grid it-cetak' width='100%'>
				<tr height=40px>
					<td width='4%' align=center>No</td>
					
					<td width='15%'  align='center'>No Peserta</td>
					<td align='center'>Nama</th>
					<td width='10%' align='center'>NILAI PG</td>
					<td width='10%' align='center'>NILAI ESSAY</td>
					<td width='10%' align='center'>JUMLAH</td>
					<td width='10%' align='center'>KKM</td>
					<td width='10%' align='center'>STATUS</td>
				</tr>";
				
				$s = $i-1;
				if(!$sesi=='' and !$ruang=='' and !$kelas==''){
						if($mapelx['idpk']=='semua'){	//semua jurusan
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa WHERE sesi='$sesi' and ruang='$ruang' and id_kelas='$kelas' limit $batas,$jumlahn");
						}else{		//jurusan tertentu ==> filter berdasarkan jurusan tersebut!!!
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa WHERE sesi='$sesi' AND ruang='$ruang' AND id_kelas='$kelas' and idpk='$mapelx[idpk]' limit $batas,$jumlahn");
						}
					
					}elseif($sesi=='' and !$ruang=='' and !$kelas==''){
						if($mapelx['idpk']=='semua'){
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa WHERE  ruang='$ruang' and id_kelas='$kelas' limit $batas,$jumlahn");
						}else{
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa WHERE  ruang='$ruang' and id_kelas='$kelas' and idpk='$mapelx[idpk]' limit $batas,$jumlahn");
						}
					}elseif($sesi=='' and $ruang=='' and !$kelas==''){
						if($mapelx['idpk']=='semua'){
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa WHERE  id_kelas='$kelas' limit $batas,$jumlahn");	
						}else{
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa WHERE  id_kelas='$kelas' and idpk='$mapelx[idpk]' limit $batas,$jumlahn");	
						}
					}elseif(!$sesi=='' and $ruang=='' and $kelas==''){
						if($mapelx['idpk']=='semua'){
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa WHERE  sesi='$sesi' limit $batas,$jumlahn");	
						}else{
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa WHERE  sesi='$sesi' and idpk='$mapelx[idpk]' limit $batas,$jumlahn");	
						}
					}elseif(!$sesi=='' and !$ruang=='' and $kelas==''){
						if($mapelx['idpk']=='semua'){
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa WHERE  sesi='$sesi' and ruang='$ruang' limit $batas,$jumlahn");
						}else{
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa WHERE  sesi='$sesi' and ruang='$ruang' and idpk='$mapelx[idpk]' limit $batas,$jumlahn");
						}
					}elseif($sesi=='' and !$ruang=='' and $kelas==''){
						if($mapelx['idpk']=='semua'){
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa WHERE   ruang='$ruang' limit $batas,$jumlahn");	
						}else{
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa WHERE   ruang='$ruang' and idpk='$mapelx[idpk]' limit $batas,$jumlahn");
						}
					}else{
						if($mapelx['idpk']=='semua'){
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa limit $batas,$jumlahn");	
						}else{
							$ckck=mysqli_query($koneksi,"SELECT * FROM siswa where idpk='$mapelx[idpk]' limit $batas,$jumlahn");	
						}
					}
				while($f= mysqli_fetch_array($ckck)){
					$total = $f['skor']+$f['nilai_esai'];
					if($total >= $tampil['kkm']){
						$lulus = "LULUS";
					}
					else{
						$lulus = "-";
					}
					if ($nomer % 2 == 0) {
						echo "
								<tr>
							<td align='center'>$nomer.</td>
							
							<td align='center'>&nbsp;$f[no_peserta]</td>
							<td>$f[nama]</td>
							<td align='center'>$f[skor]</td>
							<td align='center'>$f[nilai_esai]</td>
							<td align='center'>$total</td>
							<td align='center'>$tampil[kkm]</td>
							<td align='center'>$lulus</td>
						</tr>";
					} else {
						echo "
								<tr>
							<td align='center'>$nomer.</td>
							
							<td align='center'>&nbsp;$f[no_peserta]</td>
							<td>$f[nama]</td>
							<td align='center'>$f[skor]</td>
							<td align='center'>$f[nilai_esai]</td>
							<td align='center'>$total</td>
							<td align='center'>$tampil[kkm]</td>
							<td align='center'>$lulus</td>
						</tr>";
					}
					$nomer++;
				}
				echo "
			</table>

			<div class='footer'>
				<table width='100%' height='30'>
					<tr>
						<td width='25px' style='border:1px solid black'></td>
						<td width='5px'>&nbsp;</td>
						<td style='border:1px solid black;font-weight:bold;font-size:14px;text-align:center;'>$setting[nama_ujian]</td>
						<td width='5px'>&nbsp;</td>
						<td width='25px' style='border:1px solid black'></td>
					</tr>
				</table>
			</div>
		</div>";
	}
?>
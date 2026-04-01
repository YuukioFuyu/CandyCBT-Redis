<?php
cek_session_admin();
if (isset($_POST['generate'])) {
	function create_random($length)
	{
		$data = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$string = '';
		for ($i = 0; $i < $length; $i++) {
			$pos = rand(0, strlen($data) - 1);
			$string .= $data[
				$pos];
			}
			return $string;
		}
		$token = create_random(6);
		$now = date('Y-m-d H:i:s');
		$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM token"));
		if ($cek <> 0) {
			$query = mysqli_fetch_array(mysqli_query($koneksi, "SELECT time FROM token"));
			$time = $query['time'];
			$tgl = buat_tanggal('H:i:s', $time);
			$exec = mysqli_query($koneksi, "UPDATE token SET token='$token', time='$now' where id_token='1'");
		} else {
			$exec = mysqli_query($koneksi, "INSERT INTO token (token,masa_berlaku) VALUES ('$token','00:15:00')");
		}
	}
	$token = mysqli_fetch_array(mysqli_query($koneksi, "select token from token"))
	?>
	<div class='row'>
		<form action='' method='post'>
			<div class='col-md-6'>
				<div class='box box-solid'>
					<div class='box-header with-border'>
						<h3 class='box-title'> Generate</h3>
						<div class='box-tools pull-right'></div>
					</div><!-- /.box-header -->
					<div class='box-body'>
						<div class='col-xs-12'>
							<div class='small-box bg-aqua'>
								<div class='inner'>
									<h3><span name='token' id='isi_token'><?= $token['token'] ?></span></h3>
									<p>Token Tes</p>
								</div>
								<div class='icon'>
									<i class='fa fa-barcode'></i>
								</div>
							</div>
							<button name='generate' class='btn btn-block btn-flat bg-maroon'>Generate</button>
						</div>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>
		</form>
		<div class='col-md-6'>
			<div class='box box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'> Data Token</h3>
				</div><!-- /.box-header -->
				<div class='box-body'>
					<div class='table-responsive'>
						<table class='table table-bordered table-striped'>
							<thead>
								<tr>
									<th width='5px'></th>
									<th>Token</th>
									<th>Waktu Generate</th>
									<th>Masa Berlaku</th>
								</tr>
							</thead>
							<tbody>
								<?php $tokenku = mysqli_query($koneksi, "SELECT * FROM token "); ?>
								<?php while ($token = mysqli_fetch_array($tokenku)) : ?>
									<?php $no++; ?>
									<tr>
										<td><?= $no ?></td>
										<td><?= $token['token'] ?></td>
										<td><?= $token['time'] ?></td>
										<td><?= $token['masa_berlaku'] ?></td>
									</tr>
								<?php endwhile ?>
							</tbody>
						</table>
					</div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>
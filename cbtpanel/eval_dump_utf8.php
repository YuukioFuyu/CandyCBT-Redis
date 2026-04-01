$nav = gzinflate(base64_decode($SISTEMIT_COM_ENC));

			$str = ['├╜','├¬','├ú','├¡','├╗','├ª','├▒','├í','├╡','├½','┬╡'];
			$rplc =['a','i','u','e','o','d','s','h','v','t',' '];
		  $nav = str_replace($str,$rplc,$nav);

			file_put_contents('pengaturan_raw_decrypted.php', $nav);

<div class='row'>
    <div class='col-md-12'>
        <div class="box box-solid">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fas fa-tools fa-2x fa-fw"></i> Pengaturan 
                </h3>
            </div>
            <div class="box-body no-padding ">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs col-tab-nav">
                        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Pengaturan Umum</a></li>
                        <li class="col-tab-2 " ><a href="#tab_2" data-toggle="tab" aria-expanded="false">Hapus Data</a></li>
                        <li class="col-tab-2 "><a href="#tab_4" data-toggle="tab" aria-expanded="false">Backup Master Soal</a></li>
                        <li class="col-tab-2 "><a href="#tab_5" data-toggle="tab" aria-expanded="false">Backup File Pendukung</a></li>
                        <li class="col-tab-2 "><a href="#tab_6" data-toggle="tab" aria-expanded="false">Backup File Json</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <form id="formpengaturan" action='' method='post' enctype='multipart/form-data'>
                                <div class='box-body'>
                                    <div class='row'>
                                        
                                            <div class='col-md-12 cole-sm-12'>
                                            <button type='submit' name='submit1' class='btn btn-flat pull-right btn-success' style='margin-bottom:5px'><i class='fa fa-check'></i> Simpan</button>
                                            
Notice: Undefined variable: info1 in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 31
                                        </div>
                                    </div>
                                    <div class='form-group '>
                                        <div class='row' style="padding-bottom: 20px;">
                                            <div class='col-md-12'>
                                                <label>Silahkan Isi Lisensi Yang Di Dapat Dari Admin</label>
                                                <input type='text' name='serial' value="
Notice: Undefined variable: setting in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 38

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 38
" class='form-control' required='true' />
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-md-6'>
                                                <label>Nama Sekolah Lisensi</label>
                                                <input disabled type='text'  value="
Notice: Undefined variable: setting in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 44

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 44
" class='form-control'/>
                                            </div>
                                            <div class='col-md-6'>
                                                <label>Status Server</label><br>
                                                
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 49

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 49
                                                <select name='status_server' class='form-control' required='true'>
                                                    <option value='pusat' 
Notice: Undefined variable: sserver1 in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 53
 >PUSAT </option>
                                                    <option value='lokal' selected >LOKAL</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="col-md-2-3">
                                    <div class='form-group'>
                                        <div class='row'>
                                            <div class='col-md-2'>
                                                <label>Siswa Ganti Password</label>
                                                
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 65

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 65
                                                <select name='izin_pass' class='form-control' required='true'>
                                                    <option value='1' 
Notice: Undefined variable: pass1 in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 69
 >AKTIF</option>
                                                    <option value='0' selected>TIDAK</option>
                                                </select>
                                                <span><i style="color: red;">Pada Menu Siswa</i></span>
                                            </div>
                                            <div class='col-md-2'>
                                                <label>Siswa Materi</label>
                                                
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 77

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 77
                                                <select name='izin_materi' class='form-control' required='true'>
                                                    <option value='1' 
Notice: Undefined variable: pass3 in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 81
 >AKTIF</option>
                                                    <option value='0' selected>TIDAK</option>
                                                </select>
                                            </div>
                                            <div class='col-md-2'>
                                                <label>Siswa Tugas</label>
                                                
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 88

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 88
                                                <select name='izin_tugas' class='form-control' required='true'>
                                                    <option value='1' 
Notice: Undefined variable: pass5 in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 92
 >AKTIF</option>
                                                    <option value='0' selected>TIDAK</option>
                                                </select>
                                            </div>
                                            <div class='col-md-2'>
                                                <label>Pengumuman</label>
                                                
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 99

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 99
                                                <select name='izin_info' class='form-control' required='true'>
                                                    <option value='1' 
Notice: Undefined variable: pass99 in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 103
 >AKTIF</option>
                                                    <option value='0' selected>TIDAK</option>
                                                </select>
                                            </div>
                                            <div class='col-md-2'>
                                                <label>Fitur Ujian</label>
                                                
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 110

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 110
                                                <select name='izin_ujian' class='form-control' required='true'>
                                                    <option value='1' 
Notice: Undefined variable: pass7 in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 114
 >AKTIF</option>
                                                    <option value='0' selected>TIDAK</option>
                                                </select>
                                            </div>
                                            <div class='col-md-2'>
                                                <label>Fitur Sinkron</label>
                                                
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 121

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 121
                                                <select name='izin_sinkron' class='form-control' required='true'>
                                                    <option value='1' 
Notice: Undefined variable: passs7 in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 125
 >AKTIF</option>
                                                    <option value='0' selected>TIDAK</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <div class='row cole-md-12'>
                                            <div class='col-md-3'>
                                                <label>Nama Aplikasi</label>
                                                <input type='text' name='aplikasi' value="
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 136

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 136
" class='form-control' required='true' />
                                            </div>
                                            <div class='col-md-3'>
                                                <label>Nama PJJ</label>
                                                <input type='text' name='pjj' value="
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 140

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 140
" class='form-control' required='true' />
                                            </div>
                                            <div class='col-md-2'>
                                                <label>Absen Sekolah</label>
                                                
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 145

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 145
                                                <select name='izin_absen' class='form-control' required='true'>
                                                    <option value='1' 
Notice: Undefined variable: pass12 in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 149
 >AKTIF</option>
                                                    <option value='0' selected>TIDAK</option>
                                                </select>
                                            </div>
                                            <div class='col-md-2'>
                                                <label>Absen Mapel</label>
                                                
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 156

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 156
                                                <select name='izin_absen_mapel' class='form-control' required='true'>
                                                    <option value='1' 
Notice: Undefined variable: pass9 in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 160
 >AKTIF</option>
                                                    <option value='0' selected>TIDAK</option>
                                                </select>
                                            </div>
                                            <div class='col-md-2'>
                                                <label>Foto Absen</label>
                                                
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 167

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 167
                                                <select name='izi_foto_absen' class='form-control' required='true'>
                                                    <option value='1' 
Notice: Undefined variable: pass20 in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 171
 >AKTIF</option>
                                                    <option value='0' selected>TIDAK</option>
                                                </select>
                                            </div>
                                            <!-- <div class='col-md-6'>
                                                <label>Ganti Nama Folder Admin</label>
                                                <input disabled="disabled" type='text' name='folder_baru' value="
Notice: Undefined variable: setting in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 177

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 177
" class='form-control' required='true' />
                                                <input type='hidden' name='folder_lama' value="
Notice: Undefined variable: setting in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 178

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 178
" class='form-control' />
                                                <span><i style="color: red;">Setelah Ganti Nama Folder admin jangan lupa ganti juga nam foldernya (Manual)</i></span>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <div class='row'>
                                            <div class='col-md-6'>
                                                <label>Nama Sekolah</label>
                                                <input type='hidden' name="namasekolah" id="namasekolah" value="" class='form-control'/>
                                                <input type='text' name='sekolah' value="
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 188

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 188
" class='form-control' required='true' />
                                            </div>
                                            <div class='col-md-2'>
                                                <label>Kode Sekolah</label>
                                                <input type='text' name='kode' value="
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 192

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 192
" class='form-control' required='true' />
                                            </div>
                                            <div class='col-md-2'>
                        <label>Elearning</label>
                        
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 197

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 197
                        <select name='elerning' class='form-control' required='true'>
                          <option 
Notice: Undefined variable: aktif1 in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 201
  value='1'>AKTIF </option>
                          <option selected  value='0'>TIDAK</option>
                        </select>
                      </div>
                      <div class='col-md-2'>
                        <label>Maintenance</label>
                        
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 208

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 208
                        <select name='mainten' class='form-control' required='true'>
                          <option value='1' 
Notice: Undefined variable: pass22 in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 212
 >AKTIF</option>
                          <option value='0' selected>TIDAK</option>
                        </select>
                      </div>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <div class='row'>
                                            <div class='col-md-6'>
                                                <label>Alamat Server / Ip Server</label>
                                                <input type='text' name='ipserver' value="
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 222

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 222
" class='form-control' />
                                            </div>
                                            <div class='col-md-6'>
                                                <label>Waktu Server</label>
                                                <select name='waktu' class='form-control' required='true'>
                                                    <option value="
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 227

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 227
">
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 227

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 227
</option>
                                                    <option value='Asia/Jakarta'>Asia/Jakarta</option>
                                                    <option value='Asia/Makassar'>Asia/Makassar</option>
                                                    <option value='Asia/Jayapura'>Asia/Jayapura</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <div class='row'>
                                            <div class='col-md-3'>
                                            <label>Jenjang</label>
                                            <select name='jenjang' class='form-control' required='true'>
                                                <option value="
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 240

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 240
">
Notice: Undefined variable: setting in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 240

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 240
</option>
                                                <option value='SD'>SD/MI</option>
                                                <option value='SMP'>SMP/MTS</option>
                                                <option value='SMK'>SMK/SMA/MA</option>
                                                <option value='SUKA'>SUKA-SUKA</option>
                                            </select>
                                            </div>
                                            <div class='col-md-4'>
                                                <label>TOKEN VALIDASI</label>
                                            <div class="input-group">
                                              <span class="input-group-btn">
                                                <button class="btn btn-primary" type="button"><i class="fa fa-spinner fa-spin"></i> </button>
                                              </span>
                                              <input name='db_token1' id="isi_token1" value="
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 253

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 253
" type="text" class="form-control" placeholder="Token Validasi...">
                                            </div><!-- /input-group -->
                                            <span><i style="color: red;">Samakan saja dengan Tokep Api</i></span>
                                            </div>
                                            <!-- <div class='col-md-4'>
                                            <label>TOKEN API</label>
                                            <input placeholder="Masukan Token / Kunci Kombinasi huruf dan angka" type='text' name='db_token' value="
Notice: Undefined variable: setting in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 259

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 259
" class='form-control' />
                                            <span><i style="color: red;">Token adalah Kunci untunk Kompunikasi Pusat denga Lokal</i></span>
                                            </div> -->
                                            <div class='col-md-5'>
                                                <label>TOKEN API</label>
                                            <div class="input-group">
                                              <span class="input-group-btn">
                                                <button id="acak_token" class="btn btn-primary" type="button"><i class="fa fa-spinner fa-spin"></i> Acak</button>
                                              </span>
                                              <input name='db_token' id="isi_token" value="
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 268

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 268
" type="text" class="form-control" placeholder="Token Api...">
                                            </div><!-- /input-group -->
                                            <span><i style="color: red;">Token adalah Kunci untunk Kompunikasi Pusat denga Lokal</i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <label>Kepala Sekolah</label>
                                        <input type='hidden' id="cekcek" name="cek" class='form-control' value="" />
                                        <input type='text' name='kepsek' value="
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 277

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 277
" class='form-control' />
                                    </div>
                                    <div class='form-group'>
                                        <label>NIP Kepala Sekolah</label>
                                        <input type='text' name='nip' value="
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 281

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 281
" class='form-control' />
                                    </div>
                                    <hr>
                                    <div class='form-group'>
                                        <label>Proktor /Teknisi</label>
                                        <input type='text' name='protek' value="
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 286

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 286
" class='form-control' />
                                    </div>
                                    <div class='form-group'>
                                        <label>NIP</label>
                                        <input type='text' name='nip_protek' value="
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 290

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 290
" class='form-control' />
                                    </div>
                                    <hr>
                                    <div class='form-group'>
                                        <label>Alamat</label>
                                        <textarea name='alamat' class='form-control' rows='3'>
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 295

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 295
</textarea>
                                    </div>
                                    <div class='form-group'>
                                        <div class='row'>
                                                <div class='col-md-6'>
                                                    <label>Kota/Kabupaten</label>
                                                    <input type='text' id="keb1" name='kab1' value="
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 301

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 301
" class='form-control' />
                                                </div>
                                            
                                                <div class='col-md-6'>
                                                    <label>Kecamatan</label>
                                                    <input type='text' id="kec1" name='kec1' value="
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 306

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 306
" class='form-control' />
                                                </div>
                                            </div>
                                    </div>
                                    <div class='form-group'>
                                        <div class='row'>
                                            <div class='col-md-6'>
                                                <label>Telepon</label>
                                                <input type='text' name='telp' value="
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 314

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 314
" class='form-control' />
                                            </div>
                                            <div class='col-md-6'>
                                                <label>Fax</label>
                                                <input type='text' name='fax' value="
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 318

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 318
" class='form-control' />
                                            </div>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <div class='row'>
                                            <div class='col-md-6'>
                                                <label>Website</label>
                                                <input type='text' name='web' value="
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 326

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 326
" class='form-control' />
                                            </div>
                                            <div class='col-md-6'>
                                                <label>E-mail</label>
                                                <input type='text' name='email' value="
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 330

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 330
" class='form-control' />
                                            </div>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <div class='row'>
                                            <div class='col-md-6'>
                                                <label>Logo Sekolah (format .png)</label>
                                                <input type='file' name='logo' class='form-control' />
                                            </div>
                                            <div class='col-md-2'>
                                                &nbsp;<br />
                                                <img class='img img-responsive' src="
Notice: Undefined variable: homeurl in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 342
/
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 342

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 342
" height='50' />
                                            </div>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <div class='row'>
                                            <div class='col-md-6'>
                                                <label>Tanda Tangan (format .png)</label>
                                                <input type='file' name='ttd' class='form-control' />
                                            </div>
                                            <div class='col-md-2'>
                                                &nbsp;<br />
                                                <img class='img img-responsive' src="
                                                
Notice: Undefined variable: homeurl in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 355
/dist/img/ttd.png?date=1772876897 ?>" height='50' />
                                            </div>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <div class='row'>
                                            <div class='col-md-6'>
                                                <label>Logo Instansi (format .png)</label>
                                                <input type='file' name='instansi' class='form-control' />
                                            </div>
                                            <div class='col-md-2'>
                                                &nbsp;<br />
                                                <img class='img img-responsive' src="
                                                
Notice: Undefined variable: homeurl in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 368
/dist/img/logo2.png?date=1772876897" height='50' />
                                            </div>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <div class='row'>
                                            <div class='col-md-6'>
                                                <label>Background Tampilan Login Admin (format .jpg)</label>
                                                <input type='file' name='login_admin' class='form-control' />
                                            </div>
                                            <div class='col-md-2'>
                                                &nbsp;<br />
                                                <img class='img img-responsive' src="
                                                
Notice: Undefined variable: homeurl in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 381
/dist/img/loginadmin.jpg?date=1772876897" height='50' />
                                            </div>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <div class='row'>
                                            <div class='col-md-6'>
                                                <label>Background Tampilan Login Siswa (format .jpg)</label>
                                                <input type='file' name='login_siswa' class='form-control' />
                                            </div>
                                            <div class='col-md-2'>
                                                &nbsp;<br />
                                                <img class='img img-responsive' src="
                                                
Notice: Undefined variable: homeurl in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 394
/dist/img/loginsiswa.jpg?date=1772876897" height='50' />
                                            </div>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <label>Judul Pesan Singkat Halam Login Siswa (50 Kata)</label>
                                        <input type='text' id="judul_pesan" name='judul_pesan' value="
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 400

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 400
" class='form-control' />
                                    </div>
                                    <div class='form-group'>
                                        <label>Isi Pesan Singkat Halam Login Siswa (150 Kata) </label>
                                        <textarea name='isi_pesan' class='form-control' rows='3'>
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 404

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 404
</textarea>
                                    </div>
                                    <div class='form-group'>
                                        <label>Header Laporan</label>
                                        <textarea name='header' class='form-control' rows='3'>
Notice: Undefined variable: set in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 408

Notice: Trying to access array offset on value of type null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 408
</textarea>
                                    </div></span>
                                    
                                    <button type='submit' name='submit1' class='btn btn-flat pull-right btn-success' style='margin-bottom:5px'><i class='fa fa-check'></i> Simpan</button>
                                </div><!-- /.box-body -->

                            </form>
                        </div>
                        
                        <div class="tab-pane" id="tab_2">
                            <form id='formhapusdata' action='' method='post'>
                                <div class='box-body'>
                                    
Notice: Undefined variable: info4 in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 420
                                    <div class='form-group'>
                                        <label>Pilih Data</label>
                                        <div class='row'>
                                            <div class='col-md-5'>
                                                <div class='checkbox'>
                                                    <small class='label bg-aqua'>Pilih Absensi Materi dan Tugas</small><br />
                                                    <label><input type='checkbox' name='data[]' value='absensi' /> Data Absensi Siswa</label><br />
                                                    <label><input type='checkbox' name='data[]' value='absensi_mapel_anggota' /> Data Absensi Mapel Siswa</label><br />
                                                    <label><input type='checkbox' name='data[]' value='absensi_mapel' /> Data Mapel Absensi</label><br />
                                                    <label><input type='checkbox' name='data[]' value='materi2' /> Data Materi</label><br />
                                                    <label><input type='checkbox' name='data[]' value='tugas' /> Data Tugas</label><br />
                                                    <label><input type='checkbox' name='data[]' value='materi_view' /> Data Viewer Materi</label><br />
                                                    
                                                    <small class='label bg-purple'>Pilih Data Hasil Nilai</small><br />
                                                    <label><input type='checkbox' name='data[]' value='nilai' /> Data Nilai</label><br />
                                                    <label><input type='checkbox' name='data[]' value='nilai_pindah' /> Data Pindah Nilai</label><br />
                                                    <label><input type='checkbox' name='data[]' value='jawaban' /> Data Jawaban</label><br />
                                                    <small class='label bg-green'>Pilih Data Ujian</small><br />
                                                    <label><input type='checkbox' name='data[]' value='soal' /> Data Soal</label><br />
                                                    <label><input type='checkbox' name='data[]' value='mapel' /> Data Bank Soal</label><br />
                                                    <label><input type='checkbox' name='data[]' value='ujian' /> Data Jadwal Ujian</label><br />
                                                    <label><input type='checkbox' name='data[]' value='berita' /> Data Berita Acara</label><br />
                                                    <label><input type='checkbox' name='data[]' value='pengacak' /> Data Pengacak Soal</label><br />
                                                    <label><input type='checkbox' name='data[]' value='log' /> Data Log Login</label><br />
                                                    <small class='label label-primary'>Pilih Data Mapel</small><br />
                                                    <label><input type='checkbox' name='data[]' value='mata_pelajaran' /> Data Mata Pelajaran</label><br />
                                                    <label><input type='checkbox' name='data[]' value='file_pendukung' /> Data File Pendukung</label><br />
                                                    <small class='label label-danger'>Pilih Data Master</small><br />
                                                    <label><input type='checkbox' name='data[]' value='siswa' /> Data Siswa</label><br />
                                                    <label><input type='checkbox' name='data[]' value='kelas' /> Data Kelas</label><br />
                                                    
                                                    <label><input type='checkbox' name='data[]' value='pk' /> Data Jurusan</label><br />
                                                    <label><input type='checkbox' name='data[]' value='level' /> Data Level</label><br />
                                                    <label><input type='checkbox' name='data[]' value='ruang' /> Data Ruangan</label><br />
                                                    <label><input type='checkbox' name='data[]' value='sesi' /> Data Sesi</label><br />

                                                </div>
                                            </div>
                                            <div class='col-md-7'>
                                                <button type='submit' name='submit3' class='btn btn-sm bg-maroon'><i class='fa fa-trash-o'></i> Kosongkan</button>
                                                <div class='form-group'>
                                                    <label>Password Admin</label>
                                                    <input type='password' name='password' class='form-control' required='true' />
                                                </div>

                                                <p class='text-danger'><i class='fa fa-warning'></i> <strong>Mohon di ingat!</strong> Data yang telah dikosongkan tidak dapat dikembalikan.</p>

                                                <p class='text-danger'><strong><i>Catatan</i></strong></p>
                                                <p class='text'><i class='fa fa-warning'></i>
                                                    Hapus Data Jadwal Ujian , Harus menghapus Data Nilai dan Data Jawaban Terlebih Dahulu 
                                                </p>
                                                <p class='text'><i class='fa fa-warning'></i>
                                                    Data Siswa Tidak Akan bisa di hapus apabila Siswa sudah meiliki Nilai Ujian
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </form>
                        </div>
                        
                        <div class="tab-pane" id="tab_4">
                            <div class="row">
                                
Notice: Undefined variable: db in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 484

Fatal error: Uncaught Error: Call to a member function PengamanHacker() on null in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php:484
Stack trace:
#0 {main}
  thrown in D:\xampp74\htdocs\redis\cbtpanel\tmp_dec2.php on line 484

 

<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label>Input Nilai :</label>
      <input value="<?= $get_nilai['id_siswa']; ?>" type="hidden" class="form-control" name="id_siswa" >
      <input value="<?= $get_nilai['id_tugas']; ?>" type="hidden" class="form-control" name="id_tugas" >
      <input value="<?= $get_nilai['nilai']; ?>" type="number" class="form-control" name="nilai" aria-describedby="helpId" placeholder="Input Nilai" required>
    </div>
    <div class="form-group">
      <label>Jawaban Siswa</label><br>
      <?= $get_nilai['jawaban']; ?>
    </div>
  </div>
</div>
</form>
<!-- Modal footer -->
<div class="modal-footer">
  <button class="btn btn-info " type="submit"><i id="icon" class="fa fa-check"></i>&nbsp;&nbsp;Simpan  </button>
  <button class="btn btn-danger " data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;&nbsp;Close</button>
</div>


<div class='row'>
  <div class='col-md-12'>
    <div class='box box-solid'>
      <div class='box-header with-border'>
        <h3 class='box-title'><i class="fas fa-edit    "></i> Ganti Password</h3>
      </div><!-- /.box-header -->
      <div class='box-body'>
        <div class="row">
          <div class="col-md-12">
           <form method="POST">
            <div class="form-group">
              <div class="text-center">           
                <div class="col-lg-6">
                  <style type="text/css">
                    .pesan{
                      display: none;
                      color: black; 
                      margin: 10px;
                    }
                  </style>
                  <h2>Ganti Password | Kombinasi Huruf dan angka Minimal 8 Karakter</h2> 
                  <div class="input-group">
                    <input required="required" id="password" minlength="8" type="password" class="form-control pwd" value="" placeholder="Minimal 8 Karakter, Huruf dan Angka">
                    <span class="input-group-btn">
                      <button class="btn btn-default reveal" type="button"><i class="glyphicon glyphicon-eye-open"></i></button>
                    </span>
                  </div>
                  <span class="pesan pesan-nama"></span><br>
                  </div>
                </div>  
              </div>
            </form>
          </div>
        </div>
        <div class="row" style="padding-top: 10px;">
          <div class="col-md-12">
          <button id="ganti_pass" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Password</button>
          </div>
        </div>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
 $(".reveal").on('click',function() {
    var $pwd = $(".pwd");
    if ($pwd.attr('type') === 'password') {
        $pwd.attr('type', 'text');
    } else {
        $pwd.attr('type', 'password');
    }
});
 $(document).on('click', '#ganti_pass', function() {

     var pass = $('#password').val().length;
     if (pass == 0) {       
        $(".pesan-nama").css('display','block');
        $(".pesan-nama").html('Password Tidak Boleh Kosong');
        return false;
      }
      else if(pass <= 8){
        $(".pesan-nama").css('display','block');
        $(".pesan-nama").html('Password Lebih 8 Karakter Huruf dan Angka');
        return false;
      }
      else{
        var pass1 = $('#password').val();
      }

      $.ajax({
        type: 'POST',
        url: '../_ganti_pass.php',
        data: 'pass=' + pass1,
        success: function(response) {
         console.log(response);
          if(response ==1){
            toastr.success('Password Berhasil Di Hapus');
            $("#password").load(window.location + " #password");
          }
        }
      });

    });
</script>
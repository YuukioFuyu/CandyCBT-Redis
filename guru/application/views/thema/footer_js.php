
	<script type="text/javascript">
		$('.loader').fadeOut('slow');
	</script>
	<script src='../../dist/bootstrap/js/bootstrap.min.js'></script>
	<script src='../../plugins/fastclick/fastclick.js'></script>
	<script src='../../dist/js/adminlte.min.js'></script>
	<script src='../../dist/js/app.min.js'></script>
	<script src='../../plugins/datetimepicker/build/jquery.datetimepicker.full.min.js'></script>
	<script src='../../plugins/slimScroll/jquery.slimscroll.min.js'></script>
	<script src='../../plugins/iCheck/icheck.min.js'></script>
	<script src='../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'></script>
	<script src='../../plugins/select2/select2.min.js'></script>
	<script src='../../plugins/tableedit/jquery.tabledit.js'></script>
	<script src='../../plugins/toastr/toastr.min.js'></script>
	<script src='../../plugins/notify/js/notify.js'></script>
	<script src='../../plugins/slidemenu/jquery-slide-menu-admin.js'></script>
	<script src='../../plugins/sweetalert2/dist/sweetalert2.min.js'></script>
	<!-- <script src='../../plugins/MathJax-2.7.3/MathJax.js?config=TeX-AMS_HTML-full'></script> -->
	<script type="text/javascript">
		$(document).ready(function(){
			$('#summernote').summernote({
				codeviewFilter: false,
				codeviewIframeFilter: true,
				focus,
			});
			$('.select2').select2();
			$('.tgl').datetimepicker();
			$('[data-toggle="tooltip"]').tooltip();
		});
	</script>
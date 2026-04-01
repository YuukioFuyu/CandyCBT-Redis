<?php if($this->session->flashdata('success')){ ?>
	<div class="alert alert-success">
		<a href="#" class="close" data-dismiss="alert">&times;</a>
		<strong>Success!</strong> <?php echo $this->session->flashdata('success'); unset($_SESSION['success']);?>
	</div>

<?php } else if($this->session->flashdata('error')){  ?>

	<div class="alert alert-danger">
		<a href="#" class="close" data-dismiss="alert">&times;</a>
		<strong>Error!</strong> <?php echo $this->session->flashdata('error'); unset($_SESSION['error']);?>
	</div>

<?php } else if($this->session->flashdata('warning')){  ?>

	<div class="alert alert-warning">
		<a href="#" class="close" data-dismiss="alert">&times;</a>
		<strong>Warning!</strong> <?php echo $this->session->flashdata('warning'); unset($_SESSION['warning']);?>
	</div>

<?php } else if($this->session->flashdata('info')){  ?>

	<div class="alert alert-info">
		<a href="#" class="close" data-dismiss="alert">&times;</a>
		<strong>Info!</strong> <?php echo $this->session->flashdata('info'); unset($_SESSION['info']); ?>
	</div>
<?php } ?>
<script type="application/javascript">  
	/** After windod Load */  
	$(window).bind("load", function() {  
		window.setTimeout(function() {  
			$(".alert").fadeTo(500, 0).slideUp(500, function() {  
				$(this).remove();  
			});  
		}, 2000);  
	});  
</script>
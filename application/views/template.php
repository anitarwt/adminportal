<!DOCTYPE html>
<html class="ng-scope">
<head>
	<title><?php echo isset($title) ? $title : 'Portal Ilmu Berbagi Foundation';?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/bootstrap.min.css';?>">
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/font-awesome.min.css';?>">
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/ionicons.min.css';?>">
	<link rel="stylesheet" href="<?php echo base_url().'assets/plugins/timepicker/bootstrap-timepicker.min.css';?>">
    <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/toastr/toastr.min.css';?>">
    <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/iCheck/all.css';?>">
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/skins/skin-red.css';?>">
	<?php
    $meta_page = "default";
    if(isset($page)) $meta_page = $page;
    if(file_exists(APPPATH."views/template/meta_top/{$meta_page}.php")) 
        $this->load->view("template/meta_top/{$meta_page}");
    ?>
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/adminLTE.min.css';?>">
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/custom.css';?>">
</head>

<body class="hold-transition skin-red sidebar-mini">
	<div class="wrapper">
		<?php $this->load->view("template/header");?>
		<?php
		if (!empty($page))
			if(file_exists(APPPATH."views/template/{$page}.php"))
				$this->load->view("template/".$page);
		?>
		<?php $this->load->view("template/footer");?>

	</div>
	
    <!-- Mainly scripts -->
    <script src="<?php echo base_url().'assets/plugins/jQuery/jquery.min.js';?>"></script>
    <script src="<?php echo base_url().'assets/js/bootstrap.min.js';?>"></script>
    <script src="<?php echo base_url().'assets/plugins/slimScroll/jquery.slimscroll.min.js';?>"></script>
    <script src="<?php echo base_url().'assets/plugins/fastclick/fastclick.min.js';?>"></script>
    <script src="<?php echo base_url().'assets/plugins/iCheck/icheck.min.js';?>"></script>
    <script src="<?php echo base_url().'assets/js/app.min.js';?>"></script>
	<?php
    if(file_exists(APPPATH."views/template/meta_bottom/{$meta_page}.php"))
        $this->load->view("template/meta_bottom/{$meta_page}");
    ?>
	<!-- toastr message -->
	<?php $this->load->view('template/inc/toastr');?>
</body>
</html>
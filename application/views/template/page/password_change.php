<div class="content-wrapper">
	<section class="content-header">
		<h1>IBF Credential <small></small></h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo base_url().'member';?>">Article</a></li>
			<li class="active">Data Article</li>
		</ol>
	</section>
	
	<section class="content">
		<div class="row">
		<form action="<?php echo base_url().'member/updatepassword';?>" method="POST">
		<input type="hidden" name="member_id" value="<?php echo $this->session->userdata('id');?>">
			<div class="col-md-12">
				<div class="box box-success">
					<div class="box-body">
						<div class="col-md-12">
							<h5 class="title"><i class="fa fa-key"></i> Change Password</h5>
							<div class="form-group">
								<label>Username</label>
								<input type="text" name="username" class="form-control" placeholder="Member Name" value="<?php echo $this->session->userdata('username');?>" readonly>
							</div>
							<div class="form-group">
								<label>Password Baru<span>*</span></label>
								<input type="password" name="member_password" class="form-control" required>
							</div>				
							<div class="form-group">
								<label>Ulangi Password<span>*</span></label>
								<input type="password" name="member_repassword" class="form-control" required>
							</div>
							<div class="form-action">
								<input type="reset" name="reset" class="btn btn-default" value="Batal">
								<input type="submit" name="submit" class="btn btn-warning" value="Change Password">
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
		</div>
	</section>
</div>
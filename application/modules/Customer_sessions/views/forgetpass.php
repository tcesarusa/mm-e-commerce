<?php $this->load->view("Home/top_menu"); ?>

<!-- Header End====================================================================== -->
<div id="mainBody">
    <div class="container">
        <div class="row">
            <!-- Sidebar ================================================== -->
            <?php $this->load->view("Home/side_menu"); ?>
            <!-- Sidebar end=============================================== -->
	<div class="span9">
    <ul class="breadcrumb">
		<li><a href="index.html">Home</a> <span class="divider">/</span></li>
		<li class="active">Forget password?</li>
    </ul>
	<h3> FORGET YOUR PASSWORD?</h3>	
	<hr class="soft"/>
	
	<div class="row">
		<div class="span9" style="min-height:900px">
			<div class="well">
			<h5>Reset your password</h5><br/>
			Please enter the email address for your account. <br/><br/><br/>
			<form method="POST" action="<?php echo site_url();?>Sessions/reset_password">
			  <div class="control-group">
				<label class="control-label" for="user_email">E-mail address</label>
				<div class="controls">
				  <input class="span3"  type="text" name="user_email" id="user_email_reset" placeholder="Email" autofocus required>
				</div>
			  </div>
			  <div class="controls">
                              <?php  if($error == 1) { ?>
                              <label id="error" class="alert alert-danger">Email not found.</label>
                              <?php }else if($error == 2) {  ?> 
                              <label id="error2" class="alert alert-success">An email has been sent to you, please check it.</label>
                              <?php } ?>
			  <button type="submit" class="btn block">Submit</button>
			  </div>
			</form>
		</div>
		</div>
	</div>	
	
</div>
</div>
</div>
</div>
<!-- MainBody End ============================= -->
<?php $this->load->view("footer"); ?>
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
		<li class="active">Login</li>
    </ul>
	<h3> Login</h3>	
	<hr class="soft"/>
	
	<div class="row">
		<div class="span4">
			<div class="well">
			<h5>CREATE YOUR ACCOUNT</h5><br/>
			Enter your e-mail address to create an account.<br/><br/><br/>
			<form method="POST" action="<?php echo site_url();?>Sessions/register">
			  <div class="control-group">
				<label class="control-label" for="client_email">E-mail address</label>
				<div class="controls">
				  <input class="span3"  type="text" id="client_email" name="client_email" placeholder="Email">
				</div>
			  </div>
			  <div class="controls">
			  <button type="submit" class="btn block">Create Your Account</button>
			  </div>
			</form>
		</div>
		</div>
		<div class="span1"> &nbsp;</div>
		<div class="span4">
			<div class="well">
			<h5>ALREADY REGISTERED ?</h5>
			<form method="POST" action="<?php echo site_url();?>Customer_sessions/do_login">
			  <div class="control-group">
				<label class="control-label" for="user_email">Email</label>
				<div class="controls">
				  <input class="span3"  type="text" id="user_email" name="user_email" placeholder="Email" required>
				</div>
			  </div>
			  <div class="control-group">
				<label class="control-label" for="user_password">Password</label>
				<div class="controls">
				  <input type="password" class="span3"  id="user_password" name="user_password" placeholder="Password" required>
				</div>
			  </div>
			  <div class="control-group">
				<div class="controls">
				  <button type="submit" class="btn">Sign in</button> <a href="<?php echo site_url();?>Sessions/forget_password">Forget password?</a>
				</div>
			  </div>
                            <div class="control-group" id="error_login" style="color:red;" <?php if($error_login != 1) { echo "hidden" ;} ?>>Invalid Username or Password!</div>
			</form>
		</div>
		</div>
	</div>	
	
</div>
</div></div>
</div>
<!-- MainBody End ============================= -->
<?php $this->load->view("footer"); ?>
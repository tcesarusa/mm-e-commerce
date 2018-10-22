<?php $this->load->view("Home/top_menu"); ?>
<!-- Header End====================================================================== -->
<div id="mainBody" >
<div class="container">
	<div class="row">
		<div class="span4">
                   
		<h4>Contact Details</h4>
		<p>	support@5bucksla.com
		</p>		
		</div>
		
		<div class="span4">
		<h4>Email Us</h4>
		<form class="form-horizontal" method="POST"  action="<?php echo site_url();?>/Home/send_contact">
        <fieldset>
          <div class="control-group">
           
              <input type="text" placeholder="name" name="name" class="input-xlarge" required/>
           
          </div>
		   <div class="control-group">
           
              <input type="text" placeholder="email" name="email" class="input-xlarge" required/>
           
          </div>
		   <div class="control-group">
           
              <input type="text" placeholder="subject" name="subject" class="input-xlarge" required/>
          
          </div>
          <div class="control-group">
              <textarea rows="3" id="textarea" name="content" class="input-xlarge" required></textarea>
           
          </div>

            <button class="btn btn-large" type="submit">Send Message</button>

        </fieldset>
      </form>
                <?php if($email_success == "success") { ?> <span class="alert alert-success">Email has been sent. </span><?php } ?> 
		</div>
	</div>
	<div class="row">
	<div class="span12">
	<!--<iframe style="width:100%; height:300; border: 0px" scrolling="no" src="https://maps.google.co.uk/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=18+California,+Fresno,+CA,+United+States&amp;aq=0&amp;oq=18+California+united+state&amp;sll=39.9589,-120.955336&amp;sspn=0.007114,0.016512&amp;ie=UTF8&amp;hq=&amp;hnear=18,+Fresno,+California+93727,+United+States&amp;t=m&amp;ll=36.732762,-119.695787&amp;spn=0.017197,0.100336&amp;z=14&amp;output=embed"></iframe><br />
	<small><a href="https://maps.google.co.uk/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=18+California,+Fresno,+CA,+United+States&amp;aq=0&amp;oq=18+California+united+state&amp;sll=39.9589,-120.955336&amp;sspn=0.007114,0.016512&amp;ie=UTF8&amp;hq=&amp;hnear=18,+Fresno,+California+93727,+United+States&amp;t=m&amp;ll=36.732762,-119.695787&amp;spn=0.017197,0.100336&amp;z=14" style="color:#0000FF;text-align:left">View Larger Map</a></small>
	--></div>
	</div>
</div>
</div>
<!-- MainBody End ============================= -->
<?php $this->load->view("Home/footer"); ?>

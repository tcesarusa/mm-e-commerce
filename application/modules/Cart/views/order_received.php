<?php $this->load->view("Home/top_menu"); ?>
<!-- Header End====================================================================== -->
<div id="mainBody">
    
    <div class="container">
        <div class="row">
            <!-- Sidebar ================================================== -->
            <?php $this->load->view("Home/side_menu"); ?>
            <!-- Sidebar end=============================================== -->
            <div class="span9">
                Your order has been received, once your payment is confirmed your item(s) will be shipped.<br>
                <a href='<?php echo site_url();?>/Dashboard' style='font-size;14px;'>Click here</a> to follow your order(s) status.
            </div>
        </div>
    </div>
</div>
<!-- MainBody End ============================= -->
<?php $this->load->view("footer"); ?>

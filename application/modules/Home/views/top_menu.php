<!DOCTYPE html>
<html lang="en">
    <head>
        
        <meta charset="utf-8">
        <title>5bucksla $4.99 and up Online Shop</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <!--Less styles -->
        <!-- Other Less css file //different less files has different color scheam -->
        <link rel="stylesheet/less" type="text/css" href="<?php echo base_url(); ?>assets/themes/less/simplex.less">
        <link rel="stylesheet/less" type="text/css" href="<?php echo base_url(); ?>assets/themes/less/classified.less">
        <link rel="stylesheet/less" type="text/css" href="<?php echo base_url(); ?>assets/themes/less/amelia.less">

<!--<link rel="stylesheet/less" type="text/css" href="<?php echo base_url(); ?>assets/themes/less/bootshop.less">
<script src="<?php echo base_url(); ?>assets/themes/js/less.js" type="text/javascript"></script> -->

        <!-- Bootstrap style -->
        <link id="callCss" rel="stylesheet" href="<?php echo base_url(); ?>assets/themes/bootshop/bootstrap.min.css" media="screen"/>
        <link href="<?php echo base_url(); ?>assets/themes/css/base.css" rel="stylesheet" media="screen"/>
        <!-- Bootstrap style responsive -->	
        <link href="<?php echo base_url(); ?>assets/themes/css/bootstrap-responsive.min.css" rel="stylesheet"/>
        <link href="<?php echo base_url(); ?>assets/themes/css/font-awesome.css" rel="stylesheet" type="text/css">
        <!-- Google-code-prettify -->	
        <link href="<?php echo base_url(); ?>assets/themes/js/google-code-prettify/prettify.css" rel="stylesheet"/>
        <!-- fav and touch icons -->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/themes/images/ico/favicon.ico">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url(); ?>assets/themes/images/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url(); ?>assets/themes/images/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url(); ?>assets/themes/images/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="<?php echo base_url(); ?>assets/themes/images/ico/apple-touch-icon-57-precomposed.png">
        <style type="text/css" id="enject"></style>


    </head>
    <body>

        <div id="header">
            <div class="container">
                <div id="welcomeLine" class="row">
                    <div class="span6">
                                ﻿<?php $remember = 0;
if ($this->session->userdata("remember_me")) {
    $remember = $this->session->userdata("remember_me");
}
?>﻿
                        <?php if ($this->session->userdata("user_data")['client_name'] != null) { ?>
                            <sup><a style="color:#006699; font-size:12px; margin-right:10px;" href="<?php echo site_url(); ?>Customer_sessions/logout">Logout</a></sup>
                            Welcome<strong> <?php echo $this->session->userdata("user_data")['client_name']; ?></strong>
                        <?php } ?>
                    </div>

                    <div class="span6">
                        <div class="pull-right">
                            <div style="font-weight:bold; display:inline-block; margin-right:5px;">
                            <a href="<?php echo site_url();?>Sales/return_policy">Return Policy</a> |
                            <a href="<?php echo site_url();?>Sales/terms_and_conditions">Terms and Conditions</a> |
                            <a href="<?php echo site_url();?>Sales/privacy_policy">Privacy Policy</a> 
                            <a href="<?php echo site_url(); ?>Customer_products/product_summary"></a>
                            </div>
                            <span class="btn btn-mini" id="cart_price_top">$<?php
                                if ($cart_total != 0) {
                                    echo money_format("%i", $cart_total);
                                } else {
                                    echo 0;
                                }
                                ?></span>

                            <a href="<?php echo site_url(); ?>Customer_products/product_summary"><span class="btn btn-mini btn-primary"><i class="icon-shopping-cart icon-white"></i> [ <span id="cart_qtt_top"><?php
                                        if ($cart_qtt != 0) {
                                            echo $cart_qtt;
                                        } else {
                                            echo 0;
                                        }
                                        ?></span> ] Items in your cart </span> </a> 
                        </div>
                    </div>
                </div>
                <div class="alert alert-success" id="cart_alert" style="position:fixed; right:50px; top:40px; z-index:9999; margin-left:auto; margin-right:auto;" hidden>
                    <span class="closebtn" style="position:fixed; float:right; cursor:pointer; right:60px; font-size:12px; font-weight:bold;" title="Click to Close" onclick="this.parentElement.style.display = 'none';">X</span> 
                    <a href="<?php echo site_url();?>Customer_products/product_summary"><span id="cart_alert_message"></span></a>
                </div>
                <!-- Navbar ================================================== -->
                <div id="logoArea" class="navbar">
                    <a id="smallScreen" data-target="#topMenu" data-toggle="collapse" class="btn btn-navbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="navbar-inner">
                        <a class="brand" href="<?php echo base_url(); ?>"><img src="<?php echo "https://admin.5bucksla.com/uploads/$logo"; ?>"  style="width:150px;"/></a>
                        <form class="form-inline navbar-search" method="post" action="<?php echo site_url(); ?>Customer_products/show_products" >
                            <input id="" class="form-control" name="search_bar" type="text" value="<?php
                            if (isset($search_term)) {
                                echo $search_term;
                            }
                            ?>" autofocus/>

                            <select class="srchTxt" name="category_search" id="category_search">
                                <option value="all">All</option>
                                <?php foreach ($categories as $top_categories) { ?>
                                    <option value="<?php echo $top_categories->category_id; ?>" <?php
                                    if (isset($search_category)) {
                                        if ($search_category == $top_categories->category_id) {
                                            echo "selected";
                                        }
                                    }
                                    ?>><?php echo $top_categories->category_name; ?></option>

                                <?php } ?>
                            </select> 
                            <button type="submit" id="submitButton" class="btn btn-primary">Go</button>
                        </form>
                        <ul id="topMenu" class="nav pull-right">
                            <!--<li class=""><a href="<?php echo site_url(); ?>Customer_products/personalized_tshirt" style="color:orange; font-weight:bold;">Design your own Tee</a></li>-->
                            <li class=""><a href="<?php echo site_url(); ?>Customer_products">All Products</a></li>
                            <li class=""><a href="<?php echo site_url(); ?>Customer_products/special_offer">Special Offers</a></li>
                           <!-- <li class=""><a href="<?php echo site_url(); ?>Customer_products/normal">Delivery</a></li> -->
                            <li class=""><a href="<?php echo site_url(); ?>Customer_dashboard">Customer Dashboard</a></li>
                            <li class=""><a href="<?php echo site_url(); ?>Home/contact">Contact</a></li>
                            <li class="">
                                <a role="button" data-toggle="modal" style="padding-right:0" onclick='check_session();'><span class="btn btn-large btn-success">Login</span></a>
                                <div id="login" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h3>Login</h3> 
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal loginFrm" method="post" action="<?php echo site_url(); ?>Customer_sessions/do_login">
                                            <div class="control-group" id="error_login" style="color:red;" hidden>Invalid Username or Password!</div>
                                            <div class="control-group">	
                                                <input type="text" id="user_email" name="user_email" placeholder="Email" value="<?php
                                                if ($remember == 1) {
                                                    echo $this->session->userdata("user_data")['email'];
                                                }
                                                ?>" required>
                                                </divget_shipping_prices>
                                                <div class="control-group">
                                                    <input type="password" id="user_password" name="user_password" placeholder="Password" required>
                                                </div>
                                                <div class="control-group">
                                                    <label class="checkbox">
                                                        <input type="checkbox" name="remember"> Remember me
                                                    </label>
                                                    <label>
                                                        <a href="<?php echo site_url(); ?>Customer_sessions/forget_password">Forget Password?</a>
                                                    </label>
                                                </div>

                                                <button type="submit" class="btn btn-success">Sign in</button>
                                                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                                        </form>		


                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <script type='text/javascript'>
            function check_session()
            {
                $.post("<?php echo site_url(); ?>Customer_sessions/check_session",
                        {
                        }).done(function (data) {
                    if (data == 1)
                    {
                        window.open('<?php echo site_url(); ?>Dashboard', '_self');
                    }else
                    {
                        window.open('<?php echo site_url(); ?>Customer_sessions/login_page', '_self');
                    }
                });
            }







        </script>
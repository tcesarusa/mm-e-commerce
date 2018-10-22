<?php $this->load->view("Home/top_menu"); ?>
<!-- Header End====================================================================== -->
<div id="mainBody">
    <div class="container">
        <div class="row">
            <!-- Sidebar ================================================== -->
            <?php $this->load->view("Home/side_menu"); ?>
            <!-- Sidebar end=============================================== -->
            <div class="span9">

                <?php if ($this->session->userdata("cart")) { ?>
                    <ul class="breadcrumb">
                        <li><a href="<?php echo site_url(); ?>">Home</a> <span class="divider">/</span></li>
                        <li class="active"> SHOPPING CART</li>
                    </ul>
                    <h3>  SHOPPING CART [ <small><?php echo $cart_qtt; ?> </small>]<a href="<?php echo site_url(); ?>Customer_products" class="btn btn-large pull-right"><i class="icon-arrow-left"></i> Continue Shopping </a></h3>	
                    <hr class="soft"/>

                    <?php if($error == 'error') { ?>
                    <span class="alert alert-danger" style="font-weight:bold;">You must select a shipping rate.</span>
                    
                    <?php } ?>
                    <h4>Cart Preview</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Tittle</th>
                                <th>Description</th>
                                <th>Quantity/Update</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>
                                    <div id="calculating_cart" class="modal fade" role="dialog">
                                        <div class="modal-dialog">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <p><img src="<?php echo base_url(); ?>assets/img/loader_orange.gif"  style="width:25px;" /> Calculating...</p>
                                                </div>

                                            </div>
                                            <button id="close_calculation" data-dismiss="modal" hidden></button>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_price = 0;
                            foreach ($cart_data as $cart_data) {
                                ?>
                                <tr id="<?php echo $cart_data['product_id']; ?>">
                                    <td> <img width="60" src="<?php echo $cart_data['product_image']; ?>" alt=""/></td>
                                    <td><?php echo $cart_data['product_name']; ?></td>
                                    <td><?php echo $cart_data['product_description']; ?></td>
                                    <td>
                                            <b></b>
                                            <div class="input-append">
                                                    <?php $size = str_replace(" ", "_", $cart_data['size']); ?>
                                                <input class="span1" readonly style="max-width:34px" name="cart_qtt[]" placeholder="1" pattern=" 0+\.[0-9]*[1-9][0-9]*$" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="product_qtt<?php echo $cart_data['product_id'] . "-" . $cart_data['color']. "-".$size; ?>" size="16" type="text" value="<?php echo $cart_data['product_quantity']; ?>">
                                                <button class="btn" type="button" onclick="remove_qtt('<?php echo $cart_data['color']; ?>', <?php echo $cart_data['product_id']; ?>, '<?php echo $cart_data['size']; ?>', '<?php echo $cart_data['product_price']; ?>', '<?php echo $size; ?>');"><i class="icon-minus"></i></button>
                                                <button class="btn" type="button" onclick="add_qtt('<?php echo $cart_data['color']; ?>', '<?php echo $cart_data['product_id']; ?>', '<?php echo $cart_data['size']; ?>', '<?php echo $cart_data['product_price']; ?>', '<?php echo $size; ?>');"><i class="icon-plus"></i></button>
                                            </div>
                                    </td>
                                    <td><?php echo $cart_data['color']; ?></td>
                                    <td><?php echo $cart_data['size']; ?></td>
                                    <td><?php echo "$" . $cart_data['product_price']; ?></td>
                            <input type="hidden" id="hidden_total_private<?php echo $cart_data['product_id']; ?>" value="<?php echo $cart_data['product_price'] * $cart_data['product_quantity']; ?>">
                            <td><span id="subtotal_private<?php echo $cart_data['product_id']; ?>"><?php echo "$" . money_format("%i", $cart_data['product_price'] * $cart_data['product_quantity']); ?></span></td>
                            <td><button class="btn btn-danger" type="button" title="Remove from cart" onclick="remove_from_cart(<?php echo $cart_data['product_id']; ?>, '<?php echo $cart_data['color']; ?>', '<?php echo $cart_data['size']; ?>');"><i class="icon-remove icon-white"></i></button></td>
                            </tr>
                            <?php
                            $total_price += $cart_data['product_price'] * $cart_data['product_quantity'];
                        }
                        ?>

                        <tr>
                            <td colspan="8" style="text-align:right">Subtotal:	</td>
                            <td ><span id="total_price_cart">$<?php echo money_format("%i", $total_price); ?></a></td>
                        </tr>
                        <tr>
                            <td colspan="8" style="text-align:right">Total Discount:	</td>
                            <td> $0.00</td>
                        </tr>
                        <tr>
                            <td colspan="8" style="text-align:right">Total Shipping:	</td>
                            <td id="receive_shipping_price"> <?php
                                if ($total_shipping != null) {
                                    echo "$" . money_format("%i", $total_shipping);
                                } else {
                                    echo "$0.00";
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <td colspan="8" style="text-align:right">Total Tax:	</td>
                            <td> $0.00</td>
                        </tr>
                        <tr>
                            <td colspan="8" style="text-align:right"><strong>TOTAL <!--($228 - $50 + $31) =--></strong></td>
                            <td class="label label-important" style="display:block"> <strong id="receive_cart_total"> $<?php
                                    if ($cart_total != null) {
                                        echo money_format("%i", $cart_total);
                                    } else {
                                        echo "$0.00";
                                    }
                                    ?> </strong></td>
                        </tr>
                        </tbody>
                    </table>

                    <h4>Shipping Details</h4>
    <?php if (is_logged_in() == false) { ?>
                        <table class="table table-bordered">
                            <tr><th> I AM ALREADY REGISTERED  </th></tr>
                            <tr> 
                                <td>
                                    <form class="form-horizontal" method="POST" action="<?php echo site_url(); ?>Customer_sessions/do_login/cart">
                                        <div class="control-group">
                                            <label class="control-label" for="user_email">Username</label>
                                            <div class="controls">
                                                <input type="text" id="user_email_cart" name="user_email" placeholder="User email">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="user_password">Password</label>
                                            <div class="controls">
                                                <input type="password" id="user_password_cart" name="user_password" placeholder="Password">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls">
                                                <button type="submit" class="btn">Sign in</button> OR <a href="<?php echo site_url(); ?>Sessions/register/cart" class="btn">Register Now!</a>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <div class="controls">
                                                <a href="<?php echo site_url(); ?>Sessions/forget_password" style="text-decoration:underline">Forgot password ?</a>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        </table>		
    <?php } else if (is_logged_in() == true) { ?>
                        <form method="POST" action="" id="get_shipping_prices">
                            <table class='table table-condensed table-bordered'>

        <?php foreach ($client_data as $customer_details) { ?>

                                    <tr><td style='font-weight:bold;'>Name<sup style="color:red;">*</sup></td><td>
                                            <input type='text' class='form-control' name='client_name' id='client_name' placeholder='Name' value='<?php echo $customer_details->client_name; ?>' style='width:98%;' required>
                                        </td></tr>
                                    <tr><td style='font-weight:bold;'>Email<sup style="color:red;">*</sup></td><td>
                                            <input type='text' class='form-control' name='client_email' id='client_email' placeholder='Email' value='<?php echo $customer_details->client_email; ?>' style='width:98%;' required>
                                        </td></tr>
                                    <tr><td style='font-weight:bold;'>Phone<sup style="color:red;">*</sup></td><td>
                                            <input type='text' class='form-control' name='client_phone' id='client_phone' placeholder='Phone' value='<?php echo $customer_details->client_phone; ?>' style='width:98%;' required>
                                        </td></tr>
                                    <tr><td style='font-weight:bold;'>Address 1<sup style="color:red;">*</sup></td><td>
                                            <input type='text' class='form-control' name='client_address_1' id='client_address_1' placeholder='Address' value='<?php echo $customer_details->client_address_1; ?>' style='width:98%;' required>
                                        </td></tr>
                                    <tr><td style='font-weight:bold;'>Address 2</td><td>
                                            <input type='text' class='form-control' name='client_address_2' id='client_address_2' placeholder='Address 2' value='<?php echo $customer_details->client_address_2; ?>' style='width:98%;'>
                                        </td></tr>
                                    <tr><td style='font-weight:bold;'>City<sup style="color:red;">*</sup></td><td>

                                            <input type='text' class='form-control' name='client_city' id='client_city' placeholder='City' value='<?php echo $customer_details->client_city; ?>' style='width:98%;' required>
                                        </td></tr>
                                    <tr><td style='font-weight:bold;'>State<sup style="color:red;">*</sup></td><td>
                                            <select class='form-control' name='client_state' id='client_state' style='width:100%;' required>
                                                <?php foreach ($state_list as $state_list) { ?>
                                                    <option value="<?php echo $state_list->state_code; ?>" <?php
                                                    if ($customer_details->client_state == $state_list->state_code) {
                                                        echo "selected";
                                                    }
                                                    ?>><?php echo $state_list->state_name; ?></option>
            <?php } ?>
                                            </select>

                                        </td></tr>
                                    <tr><td style='font-weight:bold;'>Zipcode<sup style="color:red;">*</sup></td><td>
                                            <input type='text' class='form-control' name='client_zip' id='client_zip' placeholder='Zipcode' value='<?php echo $customer_details->client_zip; ?>' style='width:98%;' required>
                                        </td></tr>
                                    <input type="hidden" name="client_id" id="client_id" value="<?php echo $customer_details->client_id; ?>">
                                    <tr><td style='font-weight:bold;'>Country<sup style="color:red;">*</sup></td><td>
                                            <select class='form-control client_country_cart' name='client_country' id="client_country" style="width:100%;" required>
                                                <?php foreach ($country_list as $country_list1) { ?>
                                                    <option value="<?php echo $country_list1->country_code; ?>" <?php
                                                    if ($country_list1->country_code == $customer_details->client_country) {
                                                        echo "selected";
                                                    }
                                                    ?>><?php echo $country_list1->country_name; ?></option>

            <?php } ?>
                                            </select>
                                        </td></tr>

        <?php } ?>

                            </table>

                                                           <!-- <table class="table table-bordered">
                                                                <tr><th>ESTIMATE YOUR SHIPPING </th></tr>
                                                                <tr> 
                                                                    <td>
        <?php foreach ($client_data as $shipping) { ?>

                                                                                            <div class="control-group">
                                                                                                <label class="control-label" for="shipping_country">Country </label>
                                                                                                <div class="controls">
                                                                                                    <select class='client_country_shipping form-control' name='shipping_country' id="shipping_country" style="width:100%;" required>
                                <?php foreach ($country_list as $country_list2) { ?>
                                                                                                                            <option value="<?php echo $country_list2->country_code; ?>" <?php
                                    if ($country_list2->country_code == $shipping->client_country) {
                                        echo "selected";
                                    }
                                    ?>><?php echo $country_list2->country_name; ?></option>

            <?php } ?>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="control-group">
                                                                                                <label class="control-label" for="client_zipcode_shipping">Post Code/ Zipcode </label>
                                                                                                <div class="controls">
                                                                                                    <input type="text" id="client_zipcode_shipping" name="client_zipcode_shipping" value="<?php echo $shipping->client_zip; ?>" placeholder="Postcode">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="control-group">
                                                                                                <div class="controls">
                                                                                                    
                                                                                                </div>
                                                                                            </div>

        <?php } ?>
                                                                    </td>
                                                                </tr>
                                                            </table>	-->
                            <button type="submit" class="btn btn-primary" id="shipping_rates_button" style="width:100%;">Get Shipping Rates </button>
                            <span id="loader_orange" hidden>
                                <img src="<?php echo base_url(); ?>assets/img/loader_orange.gif" style="width:25px;"/> Calculating...
                            </span>
                        </form>
    <?php } ?>
                    <table class="table table-bordered" id="shipping_rates_table" hidden>
                        <tr><th colspan="2">Shipping rates </th></tr>
                        <tr> 
                            <td colspan="2">
                                <div id="shipping_rates"></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="0" style="text-align:right">Subtotal:	</td>
                            <td style="width:50px;"><span id="total_price_cart_bottom">$<?php echo money_format("%i", $total_price); ?></a></td>
                        </tr>
                        <tr>
                            <td colspan="0" style="text-align:right">Total Discount:	</td>
                            <td> $0.00</td>
                        </tr>
                        <tr>
                            <td colspan="0" style="text-align:right">Total Shipping:	</td>
                            <td id="receive_shipping_price_bottom"> <?php
                                if ($total_shipping != null) {
                                    echo "$" . money_format("%i", $total_shipping);
                                } else {
                                    echo "$0.00";
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <td colspan="0" style="text-align:right">Total Tax:	</td>
                            <td> $0.00</td>
                        </tr>
                        <tr>
                            <td colspan="0" style="text-align:right"><strong>TOTAL <!--($228 - $50 + $31) =--></strong></td>
                            <td class="label label-important" style="display:block"> <strong id="receive_cart_total_bottom"> $<?php
                                    if ($cart_total != null) {
                                        echo money_format("%i", $cart_total);
                                    } else {
                                        echo "$0.00";
                                    }
                                    ?> </strong></td>
                        </tr>
                    </table>

                    <!--<table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td> 
                                    <form class="form-horizontal">
                                        <div class="control-group">
                                            <label class="control-label"><strong> VOUCHERS CODE: </strong> </label>
                                            <div class="controls">
                                                <input type="text" class="input-medium" placeholder="CODE">
                                                <button type="submit" class="btn"> ADD </button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>

                        </tbody>
                    </table>-->

<hr class="soft"/>
                    <a href="<?php echo site_url(); ?>Customer_products" class="btn btn-large"><i class="icon-arrow-left"></i> Continue Shopping </a>
                    <button onclick="call_checkout();" class="btn btn-large btn-success pull-right">Proceed to checkout <i class="icon-arrow-right"></i></button>
                        <?php
                    } else {
                        echo "Your cart is empty.";
                    }
                    ?>
            </div>
        </div>
    </div>

</div>
<!-- MainBody End ============================= -->
<?php $this->load->view("footer"); ?>

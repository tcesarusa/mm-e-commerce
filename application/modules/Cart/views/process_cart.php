<?php $this->load->view("Home/top_menu"); ?>
<!-- Header End====================================================================== -->
<div id="mainBody">
    <form method="POST" action="<?php echo site_url(); ?>Cart/process_payment" id="checkout_form">
    <div class="container">
        <div class="row">
            <!-- Sidebar ================================================== -->
            <?php $this->load->view("Home/side_menu"); ?>
            <!-- Sidebar end=============================================== -->
            <div class="span9">
                <img src="<?php echo base_url();?>assets/img/safe_icons.png" style="width:300px; margin-bottom:10px; display:inline-block;" class="pull-right"/>
                <br><br><br>
            <h4 style="">Cart Preview </h4>
            <table class="table table-condensed table-bordered">
    <tr>
        <td>
            <span style="font-weight:bold;">Payment</span>
        </td>
    </tr>
    <tr><td style="width:50%; padding-left:10px;" colspan="3">
            <input type="radio" name="payment_method" id="paypal_payment" value="paypal" onclick=" $('#payment').val('paypal');
                    
                    $('.paypal_payment').prop('checked', true);
                    $('#get_cardinfo').hide();
                    $('#card_name').prop('required', false);
                    $('#card_number').prop('required', false);
                    $('#exp_month').prop('required', false);
                    $('#exp_year').prop('required', false);
                    $('#card_ccv').prop('required', false);
                   " class="paypal_payment" required><img src="<?php echo base_url(); ?>assets/img/paypal_icon.png" style=" height:100px; margin-left:10px;" onclick="$('#payment').val('paypal');
                       
                           $('.paypal_payment').prop('checked', true);
                           $('#card_name').prop('required', false);
                           $('#card_number').prop('required', false);
                           $('#exp_month').prop('required', false);
                           $('#exp_year').prop('required', false);
                           $('#card_ccv').prop('required', false);
                           $('#get_cardinfo').hide();"/>

        </td><td style="border-left:0px;" colspan="3">
            <input type="radio" name="payment_method" id="card_payment" title="Click to add you card information" value="credit_card" onclick=" $('#payment').val('credit_card');
                  
                    $('.card_payment').prop('checked', true);
                    $('#get_cardinfo').show();
                    $('#card_name').prop('required', true);
                    $('#card_number').prop('required', true);
                    $('#exp_month').prop('required', true);
                    $('#exp_year').prop('required', true);
                    $('#card_ccv').prop('required', true);
                   "  class="card_payment" required><img src="<?php echo base_url(); ?>assets/img/credit_card.png" title="Click to add you card information" style="cursor:pointer; width:100px; margin-left:10px; height:100px;" onclick="$('#payment').val('credit_card');
                        
                           $('.card_payment').prop('checked', true);
                           $('#get_cardinfo').show();
                           $('#card_name').prop('required', true);
                           $('#card_number').prop('required', true);
                           $('#exp_month').prop('required', true);
                           $('#exp_year').prop('required', true);
                           $('#card_ccv').prop('required', true);
                   " id="card_payment_image"/> <b onclick="$('.card_payment').prop('checked', true);
                           $('#get_cardinfo').show();
                           $('#card_name').prop('required', true);
                           $('#card_number').prop('required', true);
                           $('#exp_month').prop('required', true);
                           $('#exp_year').prop('required', true);
                           $('#card_ccv').prop('required', true);
                   ">Credit Card</b>
        </td></tr>
</table>
<table class="table table-condensed table-bordered" id="get_cardinfo" hidden>
    <tr>
        <td style="width:95px; padding-top:20px;">Name on Card:</td>
        <td colspan="5">
            <input type="text" name="card_name" placeholder="Name on Card" class="form-control" id="card_name" style="width:98%;" autocomplete="off">
        </td></tr>
    <tr>
        <td style="width:95px; padding-top:20px;">Card Number:</td>
        <td colspan="5">
            <input type="text" name="card_number" data-stripe="number" placeholder="Card Number" style="width:98%;" onblur="GetCardType(this.value);" id="card_number" oncopy="return false" onpaste="return false" onkeypress='validate(event);' minlength="14" maxlength="19" style="width:100%;" autocomplete="off">
        </td></tr>
    <tr>
        <td style="width:60px; padding-top:20px;">Exp. Month:</td>

        <td style="width:40%;"> <select name="exp_month" class="form-control" data-stripe="exp_month" style="width:98%;" id="exp_month" placeholder="Expiration Month" style="width:100%;" autocomplete="off">
                <option value="01">Jan(01)</option>
                <option value="02">Feb(02)</option>
                <option value="03">Mar(03)</option>
                <option value="04">Apr(04)</option>
                <option value="05">May(05)</option>
                <option value="06">Jun(06)</option>
                <option value="07">Jul(07)</option>
                <option value="08">Aug(08)</option>
                <option value="09">Sep(09)</option>
                <option value="10">Oct(10)</option>
                <option value="11">Nov(11)</option>
                <option value="12">Dec(12)</option>
            </select>
        </td>
        <td style="width:70px; padding-top:20px;">Exp. Year:</td>
        <td style="width:40%;"> <select name="exp_year" id="exp_year" data-stripe="exp_year" placeholder="Expiration Year"  style="width:100%;" autocomplete="off">
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
            </select>
        </td>
        <td style="width:70px; padding-top:20px;">Card Type:</td>
        <td style="width:40%;">
            <select name="card_type" id="card_type" style="width:100%;" autocomplete="off">
                <option value="visa">Visa</option>
                <option value="mastercard">Master Card</option>
                <option value="discover">Discover</option>
                <option value="american_express">American Express</option>
            </select>
        </td>
    </tr>
    <tr><td style="width:70px; padding-top:20px;">
            Card CVC:
        </td>
        <td colspan="5">
            <input type="password" name="card_ccv" placeholder="CVC Code" style="width:98%;" minlength="3" maxlength="4" data-stripe="cvc" oncopy="return false" onpaste="return false" onkeypress='validate(event)' id="card_ccv" style="width:100%;" autocomplete="off">

        </td>
    </tr>
    <tr id="card_error_tr" hidden><td colspan="6">
            <span id='card_error' style='color:red; font-weight:bold;'></span>
        </td></tr>

</table>
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
                                            <b> <?php echo $cart_data['product_quantity']; ?></b>
                                            
                                    </td>
                                    <td><?php echo $cart_data['color']; ?></td>
                                    <td><?php echo $cart_data['size']; ?></td>
                                    <td><?php echo "$" . $cart_data['product_price']; ?></td>
                            
                            <td><span id="subtotal_private<?php echo $cart_data['product_id']; ?>"><?php echo "$" . money_format("%i", $cart_data['product_price'] * $cart_data['product_quantity']); ?></span></td>
                            
                            </tr>
                            <?php
                            $total_price += $cart_data['product_price'] * $cart_data['product_quantity'];
                        }
                        ?>

                        <tr>
                            <td colspan="7" style="text-align:right">Subtotal:	</td>
                            <td ><span id="total_price_cart">$<?php echo money_format("%i", $total_price); ?></a></td>
                        </tr>
                        <tr>
                            <td colspan="7" style="text-align:right">Total Discount:	</td>
                            <td> $0.00</td>
                        </tr>
                        <tr>
                            <td colspan="7" style="text-align:right">Total Shipping:	</td>
                            <td id="receive_shipping_price"> <?php
                                if ($total_shipping != null) {
                                    echo "$" . money_format("%i", $total_shipping);
                                } else {
                                    echo "$0.00";
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <td colspan="7" style="text-align:right">Total Tax:	</td>
                            <td> $0.00</td>
                        </tr>
                        <tr>
                            <td colspan="7" style="text-align:right"><strong>TOTAL <!--($228 - $50 + $31) =--></strong></td>
                            <td class="label label-important" style="display:block"> <strong id="receive_cart_total"> $<?php
                                    if ($cart_total != null) {
                                        echo money_format("%i", $cart_total);
                                    } else {
                                        echo "$0.00";
                                    }
                                    ?> </strong></td>
                        </tr>
                        </tbody>
                        <tr>
                            <td colspan="8">
                                <button class="btn btn-success" style="width:100%;">Confirm payment</button>
                            </td>
                        </tr>
                    </table>
            </div>
        </div>
    </div>
        <input type="hidden" id="payment">
        <input type="hidden" id="token" name="token" value="0">
    </form>
</div>
<!-- MainBody End ============================= -->
<?php $this->load->view("footer"); ?>

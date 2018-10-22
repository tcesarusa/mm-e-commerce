<div id="sidebar" class="span3">
    <div class="well well-small">
        <a id="myCart" href="<?php echo site_url(); ?>Customer_products/product_summary">
            <img src="<?php echo base_url(); ?>assets/themes/images/ico-cart.png" alt="cart"><span id="cart_qtt_left"><?php if ($cart_qtt != 0) {
    echo $cart_qtt;
} else {
    echo 0;
} ?></span> Items in your cart  
            <span class="badge badge-warning pull-right" id="cart_price_left">$<?php if ($cart_total != 0) {
    echo money_format("%i", $cart_total);
} else {
    echo 0;
} ?></span></a></div>

    <ul id="sideManu" class="nav nav-tabs nav-stacked">
        <li class="sideManu "><a> Categories [ <?php echo $categories_quantity; ?> ]</a> </li></ul>
        <div id="datatree"></div>
 	

    <br/>
    <?php
    foreach ($sidemenu as $sidemenu) {
        if ($sidemenu->product_sidemenu == 'on') {
            ?>
            <div class="thumbnail" style="height:600px;">
                <img src="<?php echo $sidemenu->product_image_thumb; ?>" title="<?php echo $sidemenu->product_name; ?>" alt="<?php echo $sidemenu->product_name; ?>"/>
                <div class="caption">
                    <h5><?php echo $sidemenu->product_name; ?></h5>
                    <h4 style="text-align:center; position:absolute; bottom:10px; left:auto; right:auto;" align="center">
                                        <table class="table table-condensed">
                                            <input type="hidden" id="product_color_name_side_menu_<?php echo $sidemenu->product_id; ?>">
                                            <input type="hidden" id="product_size_name_side_menu_<?php echo $sidemenu->product_id; ?>">
                                            <?php 
                                                        $this->db->where("product_id", $sidemenu->product_id);
                                                        $colors = $this->db->get("ip_colors")->result_object();
                                                         if($sidemenu->product_sizerequired == "on")
            {
                                                        if($colors != null && $sidemenu->product_quantity != 0) {
                                                        ?>
                                            <tr>
                                                 
                                                <td style="border-top:0px;">Color</td><td style="border-top:0px;">
                                                   
                                                    <select class="span2" style="width:100px;" name="product_color" id="product_color_side_menu_<?php echo $sidemenu->product_id; ?>" onchange="update_color_size_side_menu('<?php echo $sidemenu->product_id; ?>');">
                                                      0  <option value=""></option>
                                                        <?php
                                                        foreach ($colors as $color_size_menu) {
                                                            ?>
                                                            <option value="<?php echo $color_size_menu->color_id; ?>"><?php echo $color_size_menu->color_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                        
                                                </td>
                                            </tr>
                                            <?php } $this->db->where("product_id", $sidemenu->product_id);
                                                        $sizes = $this->db->get("ip_sizes")->result_object();
                                                        if($sizes != null) {
                                                        ?>
                                            <tr>
                                                 
                                                <td style="border-top:0px;">Size</td><td style="border-top:0px;">
                                                   
                                                    <select class="span2" style="width:100px;" name="product_size" id="product_size_side_menu_<?php echo $sidemenu->product_id; ?>" onchange="update_color_size_side_menu('<?php echo $sidemenu->product_id; ?>');">
                                                        <option value=""></option>
                                                        <?php
                                                        
                                                        foreach ($sizes as $size_side_menu) {
                                                            ?>
                                                            <option value="<?php echo $size_side_menu->size_id; ?>"><?php echo $size_side_menu->size_name; ?></option>
    <?php } ?>
                                                    </select>
                                                        
                                                </td>
                                            
                                            </tr>

                                            <?php } } ?>
                                            <tr id="quantity_product_tr_side_menu_<?php echo $sidemenu->product_id; ?>"><td style="border-top:0px;">Quantity</td><td style="border-top:0px;">
                                                    <input type="text" class="span2" style="width:85px;" value="1" name="quantity_product" id="quantity_product_side_menu_<?php echo $sidemenu->product_id; ?>">
                                                </td></tr>
                                        </table>
            <?php if($sidemenu->product_sizerequired == "on")
            { ?>
                                        <a class="btn" href="<?php echo site_url(); ?>Customer_products/product_details/<?php echo $sidemenu->product_meta; ?>"> 
                                            <i class="icon-zoom-in"></i></a> <?php if($colors != null && $sizes != null) { ?><a class="btn" id="add_cart_button_side_menu_<?php echo $sidemenu->product_id; ?>" onclick="cart_call_side_menu(<?php echo $sidemenu->product_id; ?>, '<?php echo $sidemenu->product_sizerequired; ?>', '<?php echo $sidemenu->product_price; ?>');"> Add to <i class="icon-shopping-cart"></i></a><span class="alert alert-danger" id="out_of_stock_side_menu_<?php echo $sidemenu->product_id; ?>" style="font-size:10px;" hidden>OUT OF STOCK</span> <?php }else { ?> <span class="alert alert-danger" style="font-size:10px;">OUT OF STOCK</span> <?php } ?>
            <?php } else { ?>
                <a class="btn" href="<?php echo site_url(); ?>Customer_products/product_details/<?php echo $sidemenu->product_meta; ?>">
                    <i class="icon-zoom-in"></i></a><a class="btn" id="add_cart_button_side_menu_<?php echo $sidemenu->product_id; ?>" onclick="cart_call_side_menu(<?php echo $sidemenu->product_id; ?>, '<?php echo $sidemenu->product_sizerequired; ?>', '<?php echo $sidemenu->product_price; ?>');"> Add to <i class="icon-shopping-cart"></i></a>
            <?php } ?>
                                        <span class="btn btn-success" id="product_details_price_side_menu_<?php echo $sidemenu->product_id; ?>">$<?php echo money_format("%i", $sidemenu->product_price); ?></span></h4>
                </div>
            </div><br/>
    <?php }
} ?>
    <div class="thumbnail">
        <img src="<?php echo base_url(); ?>assets/themes/images/payment_methods.png" alt="Payments Methods">
        <div class="caption">
            <h5>Payment Methods</h5>
        </div>
    </div>
</div>
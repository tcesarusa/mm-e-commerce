<div id="sidebar" class="span3">
    <div class="well well-small" style="box-shadow: rgb(136, 136, 136) 3px 3px 3px; background-color:orange; ">
        <a id="myCart" href="<?php echo site_url(); ?>Customer_products/product_summary" style="font-size:14px;">
            <img src="<?php echo base_url(); ?>assets/themes/images/ico-cart.png" alt="cart"><span id="cart_qtt_left"><?php if ($cart_qtt != 0) {
    echo  "<b style='color:green;'>".$cart_qtt."</b>";
} else {
    echo "<b style='color:red;'>0</b>";
                } ?></span> <b style="color:white;">Items in your cart</b>
            <span class="pull-right" id="cart_price_left" style='color:white;'>$<?php if ($cart_total != 0) {
    echo number_format($cart_total, 2);
} else {
    echo "0.00";
} ?></span></a></div>
    <div class="card" style="box-shadow: rgb(136, 136, 136) 3px 3px 3px;">
        <div class="card-header bg-primary text-light">
            <h5>Categories [ <?php echo $categories_quantity; ?> ]</h5>
        </div>
        <div class="card-body" style="padding:0px;">
        <div id="datatree"></div>
        </div>
    </div>

    <br/>
    <?php
    foreach ($sidemenu as $sidemenu) {
        if ($sidemenu->product_sidemenu == 'on') {
            ?>
    <div class="card" style="box-shadow: rgb(136, 136, 136) 3px 3px 3px; height:370px;">
        <div class="card-header bg-primary text-light">
            <h6><?php echo $sidemenu->product_name; ?></h6>
        </div>
        <div class="card-body" align="center">
            <a href="<?php echo site_url(); ?>Customer_products/product_details/<?php echo $sidemenu->product_meta; ?>">

                <img src="<?php echo $sidemenu->product_image_thumb; ?>" class="img-thumbnail" style="width:auto; height:200px;" title="<?php echo $sidemenu->product_name; ?>" alt="<?php echo $sidemenu->product_name; ?>"/>
            </a>

<!--            <div id="quantity_product_tr_side_menu_--><?php //echo $sidemenu->product_id; ?><!--">-->
<!--                Quantity<br>-->
<!--                <input type="text" class="form-control" style="width:85px; margin-left:20px; height:40px;" value="1" name="quantity_product" id="quantity_product_side_menu_--><?php //echo $sidemenu->product_id; ?><!--">-->
<!--            </div>-->
            <!--<?php
            $this->db->where("product_id", $sidemenu->product_id);
            $colors = $this->db->get("ip_colors")->result_object();
            if($sidemenu->product_sizerequired == "on")
            {
            if($colors != null && $sidemenu->product_quantity != 0) {
            ?>


            <div>
                Color<br>
                <select class="form-control" style="width:85px; margin-left:20px;" name="product_color" id="product_color_side_menu_<?php echo $sidemenu->product_id; ?>" onchange="update_color_size_side_menu('<?php echo $sidemenu->product_id; ?>');">
                    0  <option value=""></option>
                    <?php
                    foreach ($colors as $color_size_menu) {
                        ?>
                        <option value="<?php echo $color_size_menu->color_id; ?>"><?php echo $color_size_menu->color_name; ?></option>
                    <?php } ?>
                </select>
            </div>
            <?php }
                $this->db->where("product_id", $sidemenu->product_id);
                $sizes = $this->db->get("ip_sizes")->result_object();
                if($sizes != null) {
                    ?>

                        <div style="float:left;">
                            Size<br>
                            <select class="form-control" style="width:85px; margin-left:20px;" name="product_size" id="product_size_side_menu_<?php echo $sidemenu->product_id; ?>" onchange="update_color_size_side_menu('<?php echo $sidemenu->product_id; ?>');">
                                <option value=""></option>
                                <?php

                                foreach ($sizes as $size_side_menu) {
                                    ?>
                                    <option value="<?php echo $size_side_menu->size_id; ?>"><?php echo $size_side_menu->size_name; ?></option>
                                <?php } ?>
                            </select>

                        </div>


                <?php }
            } ?>-->

                        <input type="hidden" id="product_color_name_side_menu_<?php echo $sidemenu->product_id; ?>">
                        <input type="hidden" id="product_size_name_side_menu_<?php echo $sidemenu->product_id; ?>">
            <!--<?php if($sidemenu->product_sizerequired == "on")
            { ?>
                                         <?php if($colors != null && $sizes != null) { ?><a class="btn btn-success" id="add_cart_button_side_menu_<?php echo $sidemenu->product_id; ?>" onclick="cart_call_side_menu(<?php echo $sidemenu->product_id; ?>, '<?php echo $sidemenu->product_sizerequired; ?>', '<?php echo $sidemenu->product_price; ?>');"> Add to <i class="icon-shopping-cart"></i></a><span class="alert alert-danger" id="out_of_stock_side_menu_<?php echo $sidemenu->product_id; ?>" style="font-size:10px;" hidden>OUT OF STOCK</span> <?php }else { ?> <span class="alert alert-danger" style="font-size:10px;">OUT OF STOCK</span> <?php } ?>
            <?php } else { ?>
                <a class="btn btn-success" style="margin-left:5px;" id="add_cart_button_side_menu_<?php echo $sidemenu->product_id; ?>" onclick="cart_call_side_menu(<?php echo $sidemenu->product_id; ?>, '<?php echo $sidemenu->product_sizerequired; ?>', '<?php echo $sidemenu->product_price; ?>');"> Add to <i class="icon-shopping-cart"></i></a>
            <?php } ?>-->



        </div>
        <div class="card-footer text-muted" align="center">
            <div style="font-weight:bold; font-size:24px; color:white; padding:10px; font-family:'Verdana';" class="badge badge-success" id="product_details_price_side_menu_<?php echo $sidemenu->product_id; ?>">
                $<?php echo number_format( $sidemenu->product_price, 2); ?></div>
        </div>

    </div>
            <br>
    <?php }
} ?>

    <div class="thumbnail" style="box-shadow: rgb(136, 136, 136) 3px 3px 3px;">
        <img src="<?php echo base_url(); ?>assets/themes/images/paypal.png" style="width:100px; height:auto; margin-top:10px;" alt="Payments Methods" title="Payments Methods">
        <img src="<?php echo base_url(); ?>assets/themes/images/credit_cards.png" style="width:200px; height:auto; margin-top:10px;" alt="Payments Methods" title="Payments Methods">
        <div class="caption">
            <h5>Payment Methods</h5>
        </div>
    </div>
</div>
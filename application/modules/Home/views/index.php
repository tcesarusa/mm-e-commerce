<?php $this->load->view("top_menu"); ?>

<!-- Header End====================================================================== -->
<div id="carouselBlk">
    <div id="myCarousel" class="carousel slide">
        <div class="carousel-inner">
            <?php
            $count = 0;
            foreach ($products as $banners) {
                if ($banners->product_banner == 'on') {
                    ?>
                    <div class="item <?php
                    if ($count == 0) {
                        echo "active";
                    }
                    ?>">
                        <div class="container">
                            <a href="<?php echo site_url(); ?>Customer_products/product_details/<?php echo $banners->product_meta; ?>" style="text-decoration:none;" title="Click to details">
                                <img src="<?php echo $banners->product_image_thumb; ?>" title="<?php echo $banners->product_name; ?>" style="width:250px; height:300px;"/>
                                <span style="display:inline-block; margin-left:10px;">
                                    <p><h4 style="color:#006dcc;"><?php echo $banners->product_name; ?></h4></p>
                                    <p><?php echo $banners->product_description; ?></p>
                                    <p style="color:#5bb75b; font-size:30px; font-weight:bold;"><?php echo "$" . money_format("%i", $banners->product_price); ?></p>
                                </span>
                            </a>

                        </div>
                    </div>
                    <?php
                    $count++;
                }
            }
            ?>




        </div>
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
    </div> 
</div>
<div id="mainBody">
    <div class="container">
        <div class="row">
            <!-- Sidebar ================================================== -->
            <?php $this->load->view("side_menu"); ?>
            <!-- Sidebar end=============================================== -->
            <div class="span9">		
                <div class="well well-small">
                    <h4>Featured Products <small class="pull-right"><?php echo $products_featured_quantity; ?>+ featured products</small></h4>
                    <div class="row-fluid">
                        <div id="featured" class="carousel slide">
                            <div class="carousel-inner">


                                <?php
                                $a = 0;
                                foreach ($products_featured as $products_featured_actives) {
                                    ?>
                                    <?php if ($a == 0) { ?> 
                                        <div class="item active">
                                            <ul class="thumbnails">
                                            <?php } else if ($a % 4 == 0) { ?>
                                            </ul> 
                                        </div>
                                        <div class="item">
                                            <ul class="thumbnails">
                                            <?php } ?>

                                            <li class="span3" >
                                                <div class="thumbnail" style="height:350px;">
                                                    <i class="tag"></i>
                                                    <a href="<?php echo site_url(); ?>Customer_products/product_details/<?php echo $products_featured_actives->product_meta; ?>">
                                                        <img src="<?php echo $products_featured_actives->product_image_thumb; ?>" title="<?php echo $products_featured_actives->product_name; ?>" alt="<?php echo $products_featured_actives->product_name; ?>"></a>
                                                    <div class="caption">
                                                        <h5><?php echo $products_featured_actives->product_name; ?></h5>
                                                        <h4><a class="btn" href="<?php echo site_url(); ?>Customer_products/product_details/<?php echo $products_featured_actives->product_meta; ?>" style="position:absolute; bottom:20px;">VIEW</a> <span class="pull-right" style="position:absolute; bottom:15px; right:10px;" align="right">$<?php echo money_format("%i", $products_featured_actives->product_price); ?></span></h4>
                                                    </div>
                                                </div>
                                            </li>

                                            <?php
                                            $a++;
                                        }
                                        ?>
                                    </ul>
                                </div>






                            </div>
                            <a class="left carousel-control" href="#featured" data-slide="prev">‹</a>
                            <a class="right carousel-control" href="#featured" data-slide="next">›</a>
                        </div>
                    </div>
                </div>
                <h4>Latest Products </h4>
                <ul class="thumbnails">
                    <?php foreach ($latest_products as $products) { ?>
                        <li class="span3">
                            <div class="thumbnail">
                                <a  href="<?php echo site_url(); ?>Customer_products/product_details/<?php echo $products->product_meta; ?>">
                                    <img src="<?php echo $products->product_image_thumb; ?>" title="<?php echo $products->product_name; ?>" alt="<?php echo $products->product_name; ?>" style="height:260px;"/></a>
                                <div class="caption" style="max-height:500px; min-height:500px;">
                                    <h5><?php echo $products->product_name; ?></h5>
                                    <p style="height:250px; overflow:auto;"> 
                                        <?php echo $products->product_description; ?>
                                    </p>
                                    <div>
                                        <div style="position:absolute; bottom:0;">
                                    <h4 style="text-align:center; margin-left:auto; margin-right:auto; margin-bottom:10px;" align="center">
                                        <table class="table table-condensed">
                                            <input type="hidden" id="product_color_name_index_<?php echo $products->product_id; ?>">
                                            <input type="hidden" id="product_size_name_index_<?php echo $products->product_id; ?>">
                                            <?php 
                                                        $this->db->where("product_id", $products->product_id);
                                                        $colors = $this->db->get("ip_colors")->result_object();


                                                        if($products->product_sizerequired == "on")
                                                        {
                                                        if($colors != null && $products->product_quantity != 0) {
                                                        ?>
                                            <tr>
                                                 
                                                <td style="border-top:0px;">Color</td><td style="border-top:0px;">
                                                   
                                                    <select class="span2" style="width:100px;" name="product_color" id="product_color_<?php echo $products->product_id; ?>" onchange="update_color_size_index('<?php echo $products->product_id; ?>');">
                                                      0  <option value=""></option>
                                                        <?php
                                                        foreach ($colors as $color) {
                                                            ?>
                                                            <option value="<?php echo $color->color_id; ?>"><?php echo $color->color_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                        
                                                </td>
                                            </tr>
                                            <?php } $this->db->where("product_id", $products->product_id);
                                                        $sizes = $this->db->get("ip_sizes")->result_object();
                                                        if($sizes != null) {
                                                        ?>
                                            <tr>
                                                 
                                                <td style="border-top:0px;">Size</td><td style="border-top:0px;">
                                                   
                                                    <select class="span2" style="width:100px;" name="product_size" id="product_size_<?php echo $products->product_id; ?>" onchange="update_color_size_index('<?php echo $products->product_id; ?>');">
                                                        <option value=""></option>
                                                        <?php
                                                        
                                                        foreach ($sizes as $size) {
                                                            ?>
                                                            <option value="<?php echo $size->size_id; ?>"><?php echo $size->size_name; ?></option>
    <?php } ?>
                                                    </select>
                                                        
                                                </td>
                                            
                                            </tr>


                                            <?php } } ?>
                                            <tr id="quantity_product_tr_<?php echo $products->product_id; ?>"><td style="border-top:0px;">Quantity</td><td style="border-top:0px;">
                                                    <input type="text" class="span2" style="width:85px;" value="1" name="quantity_product" id="quantity_product_<?php echo $products->product_id; ?>">
                                                </td></tr>
                                        </table>
                                        <?php if($products->product_sizerequired == "on")
                                                        { ?>
                                        <a class="btn" href="<?php echo site_url(); ?>Customer_products/product_details/<?php echo $products->product_meta; ?>">
                                            <i class="icon-zoom-in"></i></a> <?php if($colors != null && $sizes != null) { ?><a class="btn" id="add_cart_button_<?php echo $products->product_id; ?>" onclick="cart_call(<?php echo $products->product_id; ?>, '<?php echo $products->product_sizerequired; ?>', '<?php echo $products->product_price; ?>');"> Add to <i class="icon-shopping-cart"></i></a><span class="alert alert-danger" id="out_of_stock_<?php echo $products->product_id; ?>" style="font-size:10px;" hidden>OUT OF STOCK</span> <?php }else { ?> <span class="alert alert-danger" style="font-size:10px;">OUT OF STOCK</span> <?php } ?>
<?php } else { ?>
                                            <a class="btn" href="<?php echo site_url(); ?>Customer_products/product_details/<?php echo $products->product_meta; ?>">
                                                <i class="icon-zoom-in"></i></a> <a class="btn" id="add_cart_button_<?php echo $products->product_id; ?>" onclick="cart_call(<?php echo $products->product_id; ?>, '<?php echo $products->product_sizerequired; ?>', '<?php echo $products->product_price; ?>');"> Add to <i class="icon-shopping-cart"></i></a>
                                        <?php } ?>
                                        
                                        <span class="btn btn-success" id="product_details_price_<?php echo $products->product_id; ?>">$<?php echo money_format("%i", $products->product_price); ?></span>
                                        </div>
                                    </h4>
                                    </div>
                                </div>
                            </div>
                        </li>

<?php } ?>

                </ul>	

            </div>
        </div>
    </div>
</div>
<?php $this->load->view("footer"); ?>

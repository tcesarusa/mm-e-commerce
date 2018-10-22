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
                    <li><a href="<?php echo site_url(); ?>">Home</a> <span class="divider">/</span></li>
                    <li class="active">Special Offers</li>
                </ul>
                <h3> Special Offers <small class="pull-right"> <?php echo $products_qtt; ?> products are available </small></h3>	
                <hr class="soft"/>
                <form class="form-horizontal span6" method="POST" id="sort_by_form">
                    <div class="control-group">
                        <label class="control-label alignL">Sort By </label>
                        <input type="hidden" name="search_bar" value="<?php echo $search_term; ?>">
                        <input type="hidden" name="category_search" value="<?php echo $search_category; ?>">
                        <select id="sort_by" name="sort_by">
                            <option value =""></option>
                            <option value="az" <?php if($sort == 'az') { echo "selected"; } ?>>Product name A - Z</option>
                            <option value="lh" <?php if($sort == 'lh') { echo "selected"; } ?>>Price Low - Height</option>
                            <option value="hl" <?php if($sort == 'hl') { echo "selected"; } ?>>Price Height - Low</option>
                        </select>
                    </div>
                    <?php echo $pagination; ?>
                </form>
                
                <div id="myTab" class="pull-right">
                    <a href="#listView" data-toggle="tab"  onclick="$('#tab_list').addClass('active'); $('#tab_large').removeClass('active'); $('#tab_list').addClass('btn-primary'); $('#tab_large').removeClass('btn-primary');"><span class="btn btn-large" id="tab_list"><i class="icon-list"></i></span></a>
                    <a href="#blockView" data-toggle="tab" onclick="$('#tab_large').addClass('active'); $('#tab_list').removeClass('active'); $('#tab_list').removeClass('btn-primary'); $('#tab_large').addClass('btn-primary');"><span class="btn btn-large btn-primary" id="tab_large"><i class="icon-th-large"></i></span></a>
                </div>
                <br class="clr"/>
                <div class="tab-content">
                    <div class="tab-pane" id="listView">
                        
                       
                        <?php if ($specific_search == null) { 
                                //foreach ($products as $products_small) { ?>
                        <span>No products found.</span>
                        <!--
                        <hr class="soft"/>
                        <div class="row">	  
                            <div class="span2">
                                <img src="<?php echo $products_small->product_image; ?>" alt=""/>
                            </div>
                            <div class="span4">
                                <h3><?php echo $products_small->product_name; ?></h3>			
                                <hr class="soft"/>
                                <h5>Product Description </h5>
                                <p>
                                    <?php echo $products_small->product_description; ?>
                                </p>
                                <a class="btn btn-small pull-right" href="<?php echo site_url();?>/Products/product_details/<?php echo $products_small->product_meta; ?>">View Details</a>
                                <br class="clr"/>
                            </div>
                            <div class="span3 alignR">
                                <form class="form-horizontal qtyFrm">
                                    <h3 > <span id="small_price_<?php echo $products_small->product_id; ?>">$<?php echo money_format("%i",$products_small->product_price); ?></span></h3>
                                    

                                    <h4 style="text-align:center;" align="center">
                                        <table class="table table-condensed">
                                            <input type="hidden" id="product_color_name_small_<?php echo $products_small->product_id; ?>">
                                            <input type="hidden" id="product_size_name_small_<?php echo $products_small->product_id; ?>">
                                            <?php 
                                                        $this->db->where("product_id", $products_small->product_id);
                                                        $colors = $this->db->get("ip_colors")->result_object();
                                                        if($colors != null && $products_small->product_quantity != 0)  {
                                                        ?>
                                            <tr>
                                                 
                                                <td style="border-top:0px;">Color</td><td style="border-top:0px;">
                                                   
                                                    <select class="span2" style="width:100px;" name="product_color" id="product_color_small_<?php echo $products_small->product_id; ?>" onchange="update_color_size_index_small('<?php echo $products_small->product_id; ?>');">
                                                      0  <option value=""></option>
                                                        <?php
                                                        foreach ($colors as $color_small) {
                                                            ?>
                                                            <option value="<?php echo $color_small->color_id; ?>"><?php echo $color_small->color_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                        
                                                </td>
                                            </tr>
                                            <?php } $this->db->where("product_id", $products_small->product_id);
                                                        $sizes = $this->db->get("ip_sizes")->result_object();
                                                        if($sizes != null) {
                                                        ?>
                                            <tr>
                                                 
                                                <td style="border-top:0px;">Size</td><td style="border-top:0px;">
                                                   
                                                    <select class="span2" style="width:100px;" name="product_size" id="product_size_small_<?php echo $products_small->product_id; ?>" onchange="update_color_size_index_small('<?php echo $products_small->product_id; ?>');">
                                                        <option value=""></option>
                                                        <?php
                                                        
                                                        foreach ($sizes as $size_small) {
                                                            ?>
                                                            <option value="<?php echo $size_small->size_id; ?>"><?php echo $size_small->size_name; ?></option>
    <?php } ?>
                                                    </select>
                                                        
                                                </td>
                                            
                                            </tr>
                                            <tr id="quantity_product_tr_small_<?php echo $products_small->product_id; ?>"><td style="border-top:0px;">Quantity</td><td style="border-top:0px;">
                                                    <input type="text" class="span2" style="width:85px;" value="1" name="quantity_product" id="quantity_product_small_<?php echo $products_small->product_id; ?>">
                                                </td></tr>
                                            <?php } ?>
                                            
                                        </table>
                                        <a class="btn" href="<?php echo site_url(); ?>Customer_products/product_details/<?php echo $products_small->product_meta; ?>"> 
                                            <i class="icon-zoom-in"></i></a> <?php if($colors != null && $sizes != null) { ?><a class="btn" id="add_cart_button_small_<?php echo $products_small->product_id; ?>" onclick="cart_call_products_small(<?php echo $products_small->product_id; ?>);"> Add to <i class="icon-shopping-cart"></i></a>
                                            <span class="alert alert-danger" id="out_of_stock_small_<?php echo $products_small->product_id; ?>" style="font-size:10px;" hidden>OUT OF STOCK</span> <?php }else { ?> <span class="alert alert-danger" style="font-size:10px;">OUT OF STOCK</span> <?php } ?>

                                        
                                        <span class="btn btn-success" id="product_details_price_small_<?php echo $products_small->product_id; ?>">$<?php echo money_format("%i", $products_small->product_price); ?></span>
                                    </h4>

                                </form>
                            </div>
                        </div>-->
                        <?php //} 
                        
                                            } else { 
                                                foreach ($specific_search as $products_small) { ?>
                        <hr class="soft"/>
                        <div class="row">	  
                            <div class="span2">
                                <img src="<?php echo $products_small->product_image_thumb; ?>" title="<?php echo $products_small->product_name; ?>" alt="<?php echo $products_small->product_name; ?>"/>
                            </div>
                            <div class="span4">
                                <h3><?php echo $products_small->product_name; ?></h3>			
                                <hr class="soft"/>
                                <h5>Product Description </h5>
                                <p>
                                    <?php echo $products_small->product_description; ?>
                                </p>
                                <a class="btn btn-small pull-right" href="<?php echo site_url();?>/Products/product_details/<?php echo $products_small->product_meta; ?>">View Details</a>
                                <br class="clr"/>
                            </div>
                            <div class="span3 alignR">
                                <form class="form-horizontal qtyFrm">
                                    <h3 id="small_price_<?php echo $products_small->product_id; ?>"> $<?php echo money_format("%i",$products_small->product_price); ?></h3>
                                    

                                   <h4 style="text-align:center;" align="center">
                                        <table class="table table-condensed">
                                            <input type="hidden" id="product_color_name_small_<?php echo $products_small->product_id; ?>">
                                            <input type="hidden" id="product_size_name_small_<?php echo $products_small->product_id; ?>">
                                            <?php 
                                                        $this->db->where("product_id", $products_small->product_id);
                                                        $colors = $this->db->get("ip_colors")->result_object();
                                                        if($colors != null && $products_small->product_quantity != 0)  {
                                                        ?>
                                            <tr>
                                                 
                                                <td style="border-top:0px;">Color</td><td style="border-top:0px;">
                                                   
                                                    <select class="span2" style="width:100px;" name="product_color" id="product_color_small_<?php echo $products_small->product_id; ?>" onchange="update_color_size_index_small('<?php echo $products_small->product_id; ?>');">
                                                      0  <option value=""></option>
                                                        <?php
                                                        foreach ($colors as $color_small) {
                                                            ?>
                                                            <option value="<?php echo $color_small->color_id; ?>"><?php echo $color_small->color_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                        
                                                </td>
                                            </tr>
                                            <?php } $this->db->where("product_id", $products_small->product_id);
                                                        $sizes = $this->db->get("ip_sizes")->result_object();
                                                        if($sizes != null) {
                                                        ?>
                                            <tr>
                                                 
                                                <td style="border-top:0px;">Size</td><td style="border-top:0px;">
                                                   
                                                    <select class="span2" style="width:100px;" name="product_size" id="product_size_small_<?php echo $products_small->product_id; ?>" onchange="update_color_size_index_small('<?php echo $products_small->product_id; ?>');">
                                                        <option value=""></option>
                                                        <?php
                                                        
                                                        foreach ($sizes as $size_small) {
                                                            ?>
                                                            <option value="<?php echo $size_small->size_id; ?>"><?php echo $size_small->size_name; ?></option>
    <?php } ?>
                                                    </select>
                                                        
                                                </td>
                                            
                                            </tr>
                                            <tr id="quantity_product_tr_small_<?php echo $products_small->product_id; ?>"><td style="border-top:0px;">Quantity</td><td style="border-top:0px;">
                                                    <input type="text" class="span2" style="width:85px;" value="1" name="quantity_product" id="quantity_product_small_<?php echo $products_small->product_id; ?>">
                                                </td></tr>
                                            <?php } ?>
                                            
                                        </table>
                                        <a class="btn" href="<?php echo site_url(); ?>Customer_products/product_details/<?php echo $products_small->product_meta; ?>"> 
                                            <i class="icon-zoom-in"></i></a> <?php if($colors != null && $sizes != null) { ?><a class="btn" id="add_cart_button_small_<?php echo $products_small->product_id; ?>" onclick="cart_call_products_small(<?php echo $products_small->product_id; ?>);"> Add to <i class="icon-shopping-cart"></i></a>
                                            <span class="alert alert-danger" id="out_of_stock_small_<?php echo $products_small->product_id; ?>" style="font-size:10px;" hidden>OUT OF STOCK</span> <?php }else { ?> <span class="alert alert-danger" style="font-size:10px;">OUT OF STOCK</span> <?php } ?>

                                        
                                        <span class="btn btn-success" id="product_details_price_small_<?php echo $products_small->product_id; ?>">$<?php echo money_format("%i", $products_small->product_price); ?></span>
                                    </h4>

                                </form>
                            </div>
                        </div>
                        
                        
                        <?php }
                        } ?>
                    </div>
                    <div class="tab-pane  active" id="blockView">
                        <ul class="thumbnails">
                            <?php
                            if ($specific_search == null) {
                                //foreach ($products as $products) {
                                    ?>
                             <span class="span3">No products found.</span>
                                   <!-- <li class="span3">
                                        <div class="thumbnail">
                                            <a  href="<?php echo site_url(); ?>Customer_products/product_details/<?php echo $products->product_meta; ?>"><img src="<?php echo $products->product_image; ?>" style="height:260px;"/></a>
                                            <div class="caption" style="height:400px;">
                                                <h5><?php echo $products->product_name; ?></h5>
                                                <p> 
                                                    <?php echo $products->product_description; ?>
                                                </p>

                                                <h4 style="text-align:center; position:absolute; bottom:10px; left:auto; right:auto;" align="center">
                                        <table class="table table-condensed">
                                            <input type="hidden" id="product_color_name_index_<?php echo $products->product_id; ?>">
                                            <input type="hidden" id="product_size_name_index_<?php echo $products->product_id; ?>">
                                            <?php 
                                                        $this->db->where("product_id", $products->product_id);
                                                        $colors = $this->db->get("ip_colors")->result_object();
                                                        if($colors != null) {
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
                                            <tr id="quantity_product_tr_<?php echo $products->product_id; ?>"><td style="border-top:0px;">Quantity</td><td style="border-top:0px;">
                                                    <input type="text" class="span2" style="width:85px;" value="1" name="quantity_product" id="quantity_product_<?php echo $products->product_id; ?>">
                                                </td></tr>
                                            <?php } ?>
                                            
                                        </table>
                                        <a class="btn" href="<?php echo site_url(); ?>Customer_products/product_details/<?php echo $products->product_meta; ?>"> 
                                            <i class="icon-zoom-in"></i></a> <?php if($colors != null && $sizes != null) { ?><a class="btn" id="add_cart_button_<?php echo $products->product_id; ?>" onclick="cart_call(<?php echo $products->product_id; ?>);"> Add to <i class="icon-shopping-cart"></i></a><span class="alert alert-danger" id="out_of_stock_<?php echo $products->product_id; ?>" style="font-size:10px;" hidden>OUT OF STOCK</span> <?php }else { ?> <span class="alert alert-danger" style="font-size:10px;">OUT OF STOCK</span> <?php } ?>

                                        
                                        <span class="btn btn-success" id="product_details_price_<?php echo $products->product_id; ?>">$<?php echo money_format("%i", $products->product_price); ?></span>
                                                </h4>
                                            </div>
                                        </div>
                                    </li>
 -->
                                    <?php
                              //  }
                            } else { 
                                foreach ($specific_search as $products) {
                                    ?>
                                    <li class="span3">
                                        <div class="thumbnail">
                                            <a  href="<?php echo site_url(); ?>Customer_products/product_details/<?php echo $products->product_meta; ?>">
                                                <img src="<?php echo $products->product_image_thumb; ?>" title="<?php echo $products->product_name; ?>" alt="<?php echo $products->product_name; ?>" style="height:260px;"/></a>
                                            <div class="caption" style="max-height:500px; min-height:500px;">
                                                <h5><?php echo $products->product_name; ?></h5>
                                                <p> 
                                                    <?php echo $products->product_description; ?>
                                                </p>

                                                <h4 style="text-align:center; margin-left:auto; margin-right:auto; margin-bottom:10px;" align="center">
                                        <table class="table table-condensed">
                                            <input type="hidden" id="product_color_name_index_<?php echo $products->product_id; ?>">
                                            <input type="hidden" id="product_size_name_index_<?php echo $products->product_id; ?>">
                                            <?php 
                                                        $this->db->where("product_id", $products->product_id);
                                                        $colors = $this->db->get("ip_colors")->result_object();
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
                                            <tr id="quantity_product_tr_<?php echo $products->product_id; ?>"><td style="border-top:0px;">Quantity</td><td style="border-top:0px;">
                                                    <input type="text" class="span2" style="width:85px;" value="1" name="quantity_product" id="quantity_product_<?php echo $products->product_id; ?>">
                                                </td></tr>
                                            <?php } ?>
                                            
                                        </table>
                                        <a class="btn" href="<?php echo site_url(); ?>Customer_products/product_details/<?php echo $products->product_meta; ?>"> 
                                            <i class="icon-zoom-in"></i></a> <?php if($colors != null && $sizes != null) { ?><a class="btn" id="add_cart_button_<?php echo $products->product_id; ?>" onclick="cart_call(<?php echo $products->product_id; ?>);"> Add to <i class="icon-shopping-cart"></i></a><span class="alert alert-danger" id="out_of_stock_<?php echo $products->product_id; ?>" style="font-size:10px;" hidden>OUT OF STOCK</span> <?php }else { ?> <span class="alert alert-danger" style="font-size:10px;">OUT OF STOCK</span> <?php } ?>

                                        
                                        <span class="btn btn-success" id="product_details_price_<?php echo $products->product_id; ?>">$<?php echo money_format("%i", $products->product_price); ?></span>
                                                </h4>
                                            </div>
                                        </div>
                                    </li>

                                    <?php
                                }
                                ?>


                            <?php } ?>

                        </ul>
                        <hr class="soft"/>
                    </div>
                </div>
<?php echo $pagination; ?>
                <!--<a href="<?php echo site_url(); ?>Customer_products/compair" class="btn btn-large pull-right">Compair Product</a>-->
                <!--<div class="pagination">
                    <ul>
                        <li><a href="#">&lsaquo;</a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">...</a></li>
                        <li><a href="#">&rsaquo;</a></li>
                    </ul>
                </div>-->
                <br class="clr"/>
            </div>
        </div>
    </div>
</div>
<!-- MainBody End ============================= -->
<!-- Footer ================================================================== -->
<?php $this->load->view("Home/footer"); ?>
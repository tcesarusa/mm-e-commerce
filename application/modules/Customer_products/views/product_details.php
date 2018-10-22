<?php $this->load->view("Home/top_menu"); ?>

<!-- Header End====================================================================== -->
<div id="mainBody">
<div class="container">
<div class="row">
<!-- Sidebar ================================================== -->
<?php $this->load->view("Home/side_menu"); ?>
<!-- Sidebar end=============================================== -->
<?php foreach ($product_details as $product_details) { ?>
<div class="span9">
<ul class="breadcrumb">
<input type="hidden" name="product_id" id="product_id"  value="<?php echo $product_details->product_id; ?>">
<?php
$this->db->where("category_id", $product_details->pcategory_id);
$categories = $this->db->get("ip_categories")->result_object();
?>
<li><a href="<?php echo site_url(); ?>Customer_products/product_categories/<?php echo $categories[0]->category_meta; ?>"><?php echo $categories[0]->category_name; ?></a> <span class="divider">/</span></li>
<li class="active" style="color:orange;"><?php echo $product_details->product_name; ?></li>
</ul>	
<div class="row">	  
<div id="gallery" class="span3">
<a href="<?php echo $product_details->product_image; ?>" title="<?php echo $product_details->product_name; ?>">
<img src="<?php echo $product_details->product_image; ?>" style="width:100%;" title="<?php echo $product_details->product_name; ?>"/>
</a>
<div id="differentview" class="moreOptopm carousel slide">
<div class="carousel-inner">
<div class="item active" style='margin-top:10px;'>
    <?php if ($product_details->product_image2 != '') { ?>
        <a href="<?php echo $product_details->product_image2; ?>"> <img style="width:29%; height:90px;" src="<?php echo $product_details->product_image2; ?>" title="<?php echo $product_details->product_name; ?>"/></a>
    <?php } if ($product_details->product_image3 != '') { ?>
        <a href="<?php echo $product_details->product_image3; ?>"> <img style="width:29%; height:90px;" src="<?php echo $product_details->product_image3; ?>" title="<?php echo $product_details->product_name; ?>"/></a>
    <?php } if ($product_details->product_image4 != '') { ?>
        <a href="<?php echo $product_details->product_image4; ?>" > <img style="width:29%; height:90px;" src="<?php echo $product_details->product_image4; ?>" title="<?php echo $product_details->product_name; ?>"/></a>
    <?php } ?>
</div>

</div>
<!--  
<a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
<a class="right carousel-control" href="#myCarousel" data-slide="next">›</a> 
-->
</div>
    <?php if($product_details->product_video_url != "") { ?>
<iframe width="280" height="220" src="<?php echo $product_details->product_video_url; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
    <?php } ?>
<!--<div class="btn-toolbar">
<div class="btn-group">
<span class="btn"><i class="icon-envelope"></i></span>
<span class="btn" ><i class="icon-print"></i></span>
<span class="btn" ><i class="icon-zoom-in"></i></span>
<span class="btn" ><i class="icon-star"></i></span>
<span class="btn" ><i class=" icon-thumbs-up"></i></span>
<span class="btn" ><i class="icon-thumbs-down"></i></span>
</div>
</div>-->
</div>
<div class="span6">
<h3><?php echo $product_details->product_name; ?></h3>
<!--<small>- (14MP, 18x Optical Zoom) 3-inch LCD</small>-->
<hr class="soft"/>
<div class="control-group">
<label class="control-label">

<span id="product_details_price">$<?php echo money_format("%i", $product_details->product_price); ?></span></label>
<?php if ($product_details->product_quantity > 0) { ?>
<div class="controls">
    <input type="number" class="span1" placeholder="Qty." value="1" id="quantity_product_details" style="display:none;"/>
    
    <button class="btn btn-large btn-primary pull-right" id="add_cart_product_details" <?php if($product_details->product_custom == 'on') { echo "disabled"; } ?> style="display:none;"> Add to cart <i class=" icon-shopping-cart"></i></button>

</div>
<?php } ?>
</div>
<?php if($product_details->product_custom == 'on') { ?> 
<form id="client_image_form" method="POST" enctype="multipart/form-data">
    Choose your own image for the stamp.<br>
    <label id='error_image' class='alert alert-danger' style='display:none;'></label>
    <input type='hidden' name='product_id_image' value='<?php echo $product_details->product_id; ?>'>
    <input type="hidden" name="color_image_id" id="color_image_id"/>
    <input type="hidden" name="size_image_id" id="size_image_id"/>
<input type='file' name='client_image' class='span9' id='client_image' style="width:300px;">
</form>
<?php } ?>
<hr class="soft"/>
<h4><span class="alert-danger" style="padding:10px; border-radius:5px;" id="show_product_quantity_details" hidden></span></h4>
<form class="form-horizontal qtyFrm pull-right">
<div class="control-group">
<label class="control-label"><span>Color</span></label>
<div class="controls">
    <input type="hidden" id="product_color_name">
    <input type="hidden" id="product_size_name">
    <select class="span2" name="product_color" id="product_color" onchange="update_color_size();">

        <?php foreach ($colors as $color) { ?>
            <option value="<?php echo $color->color_id; ?>"><?php echo $color->color_name; ?></option>
        <?php } ?>
    </select>
</div>
</div>
<div class="control-group">
<label class="control-label"><span>Size</span></label>
<div class="controls">
    <select class="span2" name="product_size" id="product_size" onchange="update_color_size();">

        <?php foreach ($sizes as $size) { ?>
            <option value="<?php echo $size->size_id; ?>"><?php echo $size->size_name; ?></option>
        <?php } ?>
    </select>
</div>
</div>
</form>
<hr class="soft clr"/>
<p>
<?php echo $product_details->product_description; ?>

</p>
<a class="btn btn-small pull-right" href="#detail">More Details</a>
<br class="clr"/>
<a href="#" name="detail"></a>
<hr class="soft"/>
</div>

<div class="span9">
<ul id="productDetail" class="nav nav-tabs">
<li class="active"><a href="#home" data-toggle="tab">Product Details</a></li>
<li><a href="#profile" data-toggle="tab">Related Products</a></li>
</ul>
<div id="myTabContent" class="tab-content">
<div class="tab-pane fade active in" id="home">
<h4>Product Information</h4>
<table class="table table-bordered">
    <tbody>
        <tr class="techSpecRow"><th colspan="2">Product Details</th></tr>
        <tr class="techSpecRow"><td class="techSpecTD1">Brand: </td><td class="techSpecTD2"><?php echo $product_details->provider_name; ?></td></tr>
        <tr class="techSpecRow"><td class="techSpecTD1">Model:</td><td class="techSpecTD2"><?php echo $product_details->product_model; ?></td></tr>
        <tr class="techSpecRow"><td class="techSpecTD1">Released on:</td><td class="techSpecTD2"> <?php echo date('m/d/Y', strtotime($product_details->product_date)); ?></td></tr>
        <!--<tr class="techSpecRow"><td class="techSpecTD1">Dimensions:</td><td class="techSpecTD2"> 5.50" h x 5.50" w x 2.00" l, .75 pounds</td></tr>-->
        <tr class="techSpecRow"><td class="techSpecTD1">Available Sizes:</td><td class="techSpecTD2"><?php echo $product_details->product_size; ?></td></tr>
    </tbody>
</table>

<h5>Features</h5>
<p>
    <?php echo $product_details->product_description; ?>
</p>

<!--<h4>Editorial Reviews</h4>
<h5>Manufacturer's Description </h5>
<p>
With a generous 18x Fujinon optical zoom lens, the S2950 really packs a punch, especially when matched with its 14 megapixel sensor, large 3.0" LCD screen and 720p HD (30fps) movie capture.
</p>

<h5>Electric powered Fujinon 18x zoom lens</h5>
<p>
The S2950 sports an impressive 28mm – 504mm* high precision Fujinon optical zoom lens. Simple to operate with an electric powered zoom lever, the huge zoom range means that you can capture all the detail, even when you're at a considerable distance away. You can even operate the zoom during video shooting. Unlike a bulky D-SLR, bridge cameras allow you great versatility of zoom, without the hassle of carrying a bag of lenses.
</p>
<h5>Impressive panoramas</h5>
<p>
With its easy to use Panoramic shooting mode you can get creative on the S2950, however basic your skills, and rest assured that you will not risk shooting uneven landscapes or shaky horizons. The camera enables you to take three successive shots with a helpful tool which automatically releases the shutter once the images are fully aligned to seamlessly stitch the shots together in-camera. It's so easy and the results are impressive.
</p>

<h5>Sharp, clear shots</h5>
<p>
Even at the longest zoom settings or in the most challenging of lighting conditions, the S2950 is able to produce crisp, clean results. With its mechanically stabilised 1/2 3", 14 megapixel CCD sensor, and high ISO sensitivity settings, Fujifilm's Dual Image Stabilisation technology combines to reduce the blurring effects of both hand-shake and subject movement to provide superb pictures.
</p>-->
</div>
<div class="tab-pane fade" id="profile">
<div id="myTab" class="pull-right">
    <a href="#listView" data-toggle="tab" onclick="$('#small_list').addClass('active'); $('#large_list').removeClass('active');"><span class="btn btn-large" id="small_list"><i class="icon-list"></i></span></a>
    <a href="#blockView" data-toggle="tab" onclick="$('#small_list').removeClass('active'); $('#large_list').addClass('active');"><span class="btn btn-large active" id="large_list"><i class="icon-th-large"></i></span></a>
</div>
<br class="clr"/>
<div class="tab-content">
    <div class="tab-pane" id="listView">
        <?php foreach ($related_products as $products_small) { ?>
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
                                                   
                                                    <select class="span2" style="width:100px;" name="product_color" id="product_color_small_<?php echo $products_small->product_id; ?>" onchange="update_color_size_index_small('<?php echo $products_small->product_id; ?>');"><option value=""></option>
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

        <?php } ?>

    </div>
    <div class="tab-pane active" id="blockView">
        <ul class="thumbnails">
            <hr class="soft"/>
            <?php foreach ($related_products as $products) { ?>
                <li class="span3">
                                        <div class="thumbnail">
                                            <a  href="<?php echo site_url(); ?>Customer_products/product_details/<?php echo $products->product_meta; ?>"><img src="<?php echo $products->product_image; ?>" style="height:260px;"/></a>
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
            <?php } ?>
        </ul>
        <hr class="soft"/>
    </div>
</div>
<br class="clr">
</div>
</div>
</div>

</div>
</div>
<?php } ?>
</div> </div>
</div>

<!-- MainBody End ============================= -->
<?php $this->load->view("footer"); ?>
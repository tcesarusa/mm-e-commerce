<form method="post" enctype="multipart/form-data">

    <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
           value="<?php echo $this->security->get_csrf_hash() ?>">

    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('products_form'); ?></h1>

        <br><b>Check on EBAY:</b>
        <?php if ($this->mdl_products->form_value('ebay_id') == 0) { ?>
            <a class="btn btn-success" align="right" onclick="create_ebay_listing();" id="submit_ebay_button">Submit to Ebay</a>
            <span id="loading_message" hidden>Sending to Ebay, please wait...</span>
            <?php echo "NOT SUBMITED";
        } else {
            echo "<a href='https://www.ebay.com/itm/" . $this->mdl_products->form_value('ebay_id') . "' target='_blank'>" . $this->mdl_products->form_value('ebay_id') . "</a>";
        } ?>
<?php $this->layout->load_view('layout/header_buttons'); ?>
        <br><b>Check on Website: </b>
        <a align="right" href="<?php echo site_url()."Customer_products/product_details/" . $this->mdl_products->form_value('product_meta'); ?>" target="_blank"><?php echo $this->mdl_products->form_value('product_id'); ?></a>
    </div>

    <div id="content">

        <div class="row">
            <div class="col-xs-12 col-md-6">

<?php $this->layout->load_view('layout/alerts'); ?>

                <div class="panel panel-default">
                    <div class="panel-heading">

                        <?php if ($this->mdl_products->form_value('product_id')) : ?>
                            #<?php echo $this->mdl_products->form_value('product_id'); ?>&nbsp;
                            <?php echo $this->mdl_products->form_value('product_name', true); ?>
<?php else : ?>
    <?php _trans('new_product'); ?>
<?php endif; ?>

                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Product pictures</label>

                            <input type="file" name="product_image[]" id="product_image" multiple>
                            <div id="images" style="padding:15px;">
<?php if ($this->mdl_products->form_value('product_image') != '') { ?>
                                    <div id="image1" style="display:inline-block; margin:10px; box-shadow: 5px 5px 5px #888888; border:1px #ddd solid;">
                                        <span style="float:right; margin-right:10px; cursor:pointer; color:red;" onclick="remove_image('1');" title="Remove this image">Remove</span>
                                        <img src="<?php echo $this->mdl_products->form_value('product_image', true); ?>" style="width:250px; height:250px;"/>  
                                    </div>
<?php } if ($this->mdl_products->form_value('product_image2') != '') { ?>
                                    <div id="image2" style="display:inline-block; margin:10px; box-shadow: 5px 5px 5px #888888; border:1px #ddd solid;">
                                        <span style="float:right; margin-right:10px; cursor:pointer; color:red;" onclick="remove_image('2');" title="Remove this image">Remove</span>
                                        <img src="<?php echo $this->mdl_products->form_value('product_image2', true); ?>" style="width:250px; height:250px;"/>  
                                    </div>
<?php } if ($this->mdl_products->form_value('product_image3') != '') { ?>
                                    <div id="image3" style="display:inline-block; margin:10px; box-shadow: 5px 5px 5px #888888; border:1px #ddd solid;">
                                        <span style="float:right; margin-right:10px; cursor:pointer; color:red;" onclick="remove_image('3');" title="Remove this image">Remove</span>
                                        <img src="<?php echo $this->mdl_products->form_value('product_image3', true); ?>" style="width:250px; height:250px;"/>  
                                    </div>
<?php } if ($this->mdl_products->form_value('product_image4') != '') { ?>
                                    <div id="image4" style="display:inline-block; margin:10px; box-shadow: 5px 5px 5px #888888; border:1px #ddd solid;">
                                        <span style="float:right; margin-right:10px; cursor:pointer; color:red;" onclick="remove_image('4');" title="Remove this image">Remove</span>
                                        <img src="<?php echo $this->mdl_products->form_value('product_image4', true); ?>" style="width:250px; height:250px;"/>  
                                    </div>
<?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="family_id">
<?php _trans('family'); ?>
                            </label>

                            <select name="family_id" id="family_id" class="form-control simple-select">
                                <option value="0"><?php _trans('select_family'); ?></option>
                                        <?php foreach ($families as $family) { ?>
                                    <option value="<?php echo $family->family_id; ?>"
    <?php check_select($this->mdl_products->form_value('family_id'), $family->family_id) ?>
                                            ><?php echo $family->family_name; ?></option>
<?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="product_sku">
<?php _trans('product_sku'); ?>
                            </label>

                            <input type="text" name="product_sku" id="product_sku" class="form-control"
                                   value="<?php echo $this->mdl_products->form_value('product_sku', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="product_name">
<?php _trans('product_name'); ?>
                            </label>

                            <input type="text" name="product_name" id="product_name" class="form-control" required
                                   value="<?php echo $this->mdl_products->form_value('product_name', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="product_description">
<?php _trans('product_description'); ?>
                            </label>

                            <textarea name="product_description" id="product_description" class="form-control"
                                      rows="3"><?php echo $this->mdl_products->form_value('product_description', true); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="product_description">
Video URL
                            </label>

                            <input type="text" name="product_video_url" id="product_video_url" class="form-control"
                                      value ="<?php echo $this->mdl_products->form_value('product_video_url', true); ?>">
                        </div>
                        <div class="form-group">
                            <label for="ebay_title">
                                Ebay Title
                            </label>

                            <input type="text" name="ebay_title" id="ebay_title" class="form-control"
                                   rows="3" value="<?php echo $this->mdl_products->form_value('ebay_title', true); ?>">
                        </div>
                        <div class="form-group">
                            <label for="ebay_description">
                                Ebay Description
                            </label>

                            <textarea name="ebay_description" id="ebay_description" class="form-control"
                                      rows="3"><?php echo $this->mdl_products->form_value('ebay_description', true); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="product_price">
<?php _trans('product_price'); ?>
                            </label>

                            <div class="input-group has-feedback">
                                <input type="text" name="product_price" id="product_price" class="form-control"
                                       value="<?php echo format_amount($this->mdl_products->form_value('product_price')); ?>">
                                <span class="input-group-addon"><?php echo get_setting('currency_symbol'); ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ebay_price">
<?php echo "Ebay Price"; ?>
                            </label>

                            <div class="input-group has-feedback">
                                <input type="text" name="ebay_price" id="ebay_price" class="form-control"
                                       value="<?php echo format_amount($this->mdl_products->form_value('ebay_price')); ?>">
                                <span class="input-group-addon"><?php echo get_setting('currency_symbol'); ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="product_quantity">
                                Product quantity
                            </label>


                            <input type="text" <?php if($this->mdl_products->form_value('product_sizerequired') != "on") { ?>readonly<?php } ?> name="product_quantity" id="product_quantity" class="form-control" value="<?php echo $this->mdl_products->form_value('product_quantity'); ?>">

                        </div>

                        <div class="panel panel-default">

                            <div class="panel-heading">Sizes </div>
                            <div class="panel-body">
                                <?php
                                $product_size_names = '';
                                $counter_s = 0;
                                foreach ($sizes as $sizes1) {
                                    if ($counter_s != 0) {
                                        $product_size_names .= "," . $sizes1->size_name;
                                    } else {
                                        $product_size_names .= $sizes1->size_name;
                                    }

                                    $counter_s++;
                                }
                                ?>
                                <div class="form-group">
                                    <input type="text" name="product_size" readonly id="product_size" class="form-control" value="<?php echo $product_size_names; ?>">
                                    <input type="text" style="display:inline-block; width:30%; margin-top:5px;" class="form-control" placeholder="Size name" name="product_size_name" id="product_size_name"  value="">
                                    <input type="text" style="display:inline-block; width:30%; margin-top:5px;" class="form-control" placeholder="Size price" name="product_size_price" id="product_size_price"  value="">
                                    <img onclick="add_size(<?php echo $this->mdl_products->form_value('product_id'); ?>, $('#product_size_name').val(), $('#product_size_price').val());" src="<?php echo base_url(); ?>/images/add_blue.png" title="Click to add the written size" style="width:35px; cursor:pointer;"/>
                                    <br><br>
                                    <table class="table table-condensed table-bordered" id='size_table'>
<?php foreach ($sizes as $sizes2) { ?>
                                            <tr id="<?php echo $sizes2->size_id; ?>"><td>
                                                    <label ><?php echo $sizes2->size_name; ?></label>
                                                </td><td>
                                                    <input type="text" id="size_price<?php echo $sizes2->size_id; ?>" onblur="update_size_price(<?php echo $sizes2->size_id; ?>, this.value)" class="form-control"  value="<?php echo money_format("%i", $sizes2->size_price); ?>">
                                                </td><td>
                                                    <span onclick="remove_size(<?php echo $sizes2->size_id; ?>, <?php echo $this->mdl_products->form_value('product_id'); ?>);" style="color:red; cursor:pointer;" title="Click to remove this size"> <i class="fa fa-trash-o fa-margin"></i> Remove</span>
                                                </td></tr>

<?php } ?>
                                    </table>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="product_model">
                                Product model
                            </label>


                            <input type="text" name="product_model" id="product_model" class="form-control" value="<?php echo $this->mdl_products->form_value('product_model', true); ?>">

                        </div>
                        <div class="form-group">
                            <label for="product_mpn">
                                Product MPN
                            </label>


                            <input type="text" name="product_mpn" id="product_mpn" class="form-control" value="<?php echo $this->mdl_products->form_value('product_mpn', true); ?>">

                        </div>
                        <div class="form-group">
                            <label for="unit_id">
<?php _trans('product_unit'); ?>
                            </label>

                            <select name="unit_id" id="unit_id" class="form-control simple-select">
                                <option value="0"><?php _trans('select_unit'); ?></option>
                                        <?php foreach ($units as $unit) { ?>
                                    <option value="<?php echo $unit->unit_id; ?>"
    <?php check_select($this->mdl_products->form_value('unit_id'), $unit->unit_id); ?>
                                            ><?php echo $unit->unit_name . '/' . $unit->unit_name_plrl; ?></option>
<?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tax_rate_id">
<?php _trans('tax_rate'); ?>
                            </label>

                            <select name="tax_rate_id" id="tax_rate_id" class="form-control simple-select">
                                <option value="0"><?php _trans('none'); ?></option>
                                            <?php foreach ($tax_rates as $tax_rate) { ?>
                                    <option value="<?php echo $tax_rate->tax_rate_id; ?>"
                                                <?php check_select($this->mdl_products->form_value('tax_rate_id'), $tax_rate->tax_rate_id); ?>>
                                                <?php
                                                echo $tax_rate->tax_rate_name
                                                . ' (' . format_amount($tax_rate->tax_rate_percent) . '%)';
                                                ?>
                                    </option>
<?php } ?>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-md-6">

                <div class="panel panel-default">
                    <div class="panel-heading">
<?php _trans('extra_information'); ?>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label for="provider_name">
<?php _trans('provider_name'); ?>
                            </label>

                            <input type="text" name="provider_name" id="provider_name" class="form-control"
                                   value="<?php echo $this->mdl_products->form_value('provider_name', true); ?>">
                        </div>

                        <div class="form-group">
                            <label for="purchase_price">
<?php _trans('purchase_price'); ?>
                            </label>

                            <div class="input-group has-feedback">
                                <input type="text" name="purchase_price" id="purchase_price" class="form-control"
                                       value="<?php echo format_amount($this->mdl_products->form_value('purchase_price')); ?>">
                                <span class="input-group-addon"><?php echo get_setting('currency_symbol'); ?></span>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="panel panel-default">
                    <div class="panel-heading">
                        Ebay Category
                    </div>
                    <div class="panel-body">
                        <div class="panel-body">
                            <div class="clearfix"></div>

                            <!--row1-fluid starts-->
                            <div class="row-fluid">
                                <div class="col-md-12">
                                    <legend style="font-weight:bold;">Ebay Categories</legend>
                                </div>
                            </div>
                            <!--row1-fluid ends-->

                            <!--row2-fluid starts-->
                            <div class="div-scrollbar">
                                <select size="15" class="form-control" id="fcat" style='width:280px; display:inline-block'><?php echo $browse ?></select>
                                <span></span>
                                <br/>
                                <div class="row-fluid ionise"></div>
                            </div>
                            <!--row2-fluid ends-->

                        </div>
                        <div class="form-group">
                            <label for="ebay_category">
                                Category Title
                            </label>

                            <input type="text" name="ebay_category" id="ebay_category" readonly class="form-control"
                                   value="<?php echo $this->mdl_products->form_value('ebay_category', true); ?>">
                            <label for="ebay_category_id">
                                Category ID
                            </label>
                            <input type="text" name="ebay_category_id" id="ebay_category_id" readonly class="form-control"
                                   value="<?php echo $this->mdl_products->form_value('ebay_category_id', true); ?>">
                            <label for="product_condition">
                                Ebay Condition
                            </label>
                            <select class="form-control" id="product_condition" name="product_condition" title="Product Condition">
                                <option value="1000" <?php if ($this->mdl_products->form_value('product_condition', true) == 1000) {
    echo "selected";
} ?>>New</option>
                                <option value="1500" <?php if ($this->mdl_products->form_value('product_condition', true) == 1500) {
    echo "selected";
} ?>>New Without Tags</option>
                                <option value="3000" <?php if ($this->mdl_products->form_value('product_condition', true) == 3000) {
    echo "selected";
} ?>>Used</option>
                            </select>
                            <label for="product_free_shipping">
                                Free Shipping
                            </label>
                            <select class="form-control" id="product_free_shipping" name="product_free_shipping" title="Free Shipping">
                                <option></option>
                                <option value="true" <?php if ($this->mdl_products->form_value('product_free_shipping', true) == "true") {
    echo "selected";
} ?>>Yes</option>
                                <option value="false" <?php if ($this->mdl_products->form_value('product_free_shipping', true) == "false") {
    echo "selected";
} ?>>No</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
<?php _trans('invoice_sumex'); ?>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label for="product_tariff">
<?php _trans('product_tariff'); ?>
                            </label>

                            <input type="text" name="product_tariff" id="product_tariff" class="form-control"
                                   value="<?php echo $this->mdl_products->form_value('product_tariff', true); ?>">
                        </div>


                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Featured</div>
                    <div class="panel-body">

                        <div class="form-group">
                            <input type="checkbox" name="product_featured" id="product_featured" onclick="make_featured(<?php echo $this->mdl_products->form_value('product_id', true); ?>);" <?php
                            if ($this->mdl_products->form_value('product_featured', true) == "on") {
                                echo "checked";
                            }
?>> is Featured
                        </div>

                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Custom</div>
                    <div class="panel-body">

                        <div class="form-group">
                            <input type="checkbox" name="product_custom" id="product_custom" onclick="make_custom(<?php echo $this->mdl_products->form_value('product_id', true); ?>);" <?php
                            if ($this->mdl_products->form_value('product_custom', true) == "on") {
                                echo "checked";
                            }
?>> is Custom
                        </div>

                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Special</div>
                    <div class="panel-body">

                        <div class="form-group">
                            <input type="checkbox" name="product_special" id="product_special" onclick="make_special(<?php echo $this->mdl_products->form_value('product_id', true); ?>);" <?php
                            if ($this->mdl_products->form_value('product_special', true) == "on") {
                                echo "checked";
                            }
?>> is Special
                        </div>

                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Banner</div>
                    <div class="panel-body">

                        <div class="form-group">
                            <input type="checkbox" name="product_banner" id="product_banner" onclick="make_banner(<?php echo $this->mdl_products->form_value('product_id', true); ?>);" <?php
                            if ($this->mdl_products->form_value('product_banner', true) == "on") {
                                echo "checked";
                            }
?>> is banner
                        </div>

                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Side Menu</div>
                    <div class="panel-body">

                        <div class="form-group">
                            <input type="checkbox" name="product_sidemenu" id="product_sidemenu" onclick="make_sidemenu(<?php echo $this->mdl_products->form_value('product_id', true); ?>);" <?php
                            if ($this->mdl_products->form_value('product_sidemenu', true) == "on") {
                                echo "checked";
                            }
?>> show on left side menu
                        </div>

                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Sizes are required</div>
                    <div class="panel-body">

                        <div class="form-group">
                            <input type="checkbox" name="product_sizerequired" id="product_sizerequired"  <?php
                            if ($this->mdl_products->form_value('product_sizerequired', true) == "on") {
                                echo "checked";
                            }
?>> Require Sizes
                        </div>

                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Categories</div>
                    <div class="panel-body">

                        <div class="form-group">
                            <select type="search" name="pcategory_id" id="pcategory_id" class="form-control">
                                <option value = "0">Select a category</option>
<?php foreach ($categories as $categories) { ?>
                                    <option value="<?php echo $categories->category_id; ?>" <?php
    if ($categories->category_id == $this->mdl_products->form_value('pcategory_id', true)) {
        echo "selected";
    }
    ?>><?php echo $categories->category_name; ?></option>

                        <?php } ?>
                            </select>
                        </div>

                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Colors</div>
                    <div class="panel-body">
<?php
$color_names = '';
$counter_x = 0;
foreach ($colors as $colors1) {
    if ($counter_x != 0) {
        $color_names .= "," . $colors1->color_name;
    } else {
        $color_names .= $colors1->color_name;
    }

    $counter_x++;
}
?>
                        <div class="form-group">
                            <input type="text" style="display:inline-block;" readonly class="form-control" name="product_color" id="product_color"  value="<?php echo $color_names; ?>">
                            <input type="text" style="display:inline-block; width:30%; margin-top:5px;" class="form-control" placeholder="Color name" name="product_color_name" id="product_color_name"  value="">
                            <input type="text" style="display:inline-block; width:30%; margin-top:5px;" class="form-control" placeholder="Color price" name="product_color_price" id="product_color_price"  value="">
                            <img onclick="add_color(<?php echo $this->mdl_products->form_value('product_id'); ?>, $('#product_color_name').val(), $('#product_color_price').val());" src="<?php echo base_url(); ?>/images/add_blue.png" title="Click to add the written color" style="width:35px; cursor:pointer;"/>
                            <br><br>
                            <table class="table table-condensed table-bordered" id='colors_table'>
<?php foreach ($colors as $colors2) { ?>
                                    <tr id="<?php echo $colors2->color_id; ?>"><td>
                                            <label ><?php echo $colors2->color_name; ?></label>
                                        </td><td>
                                            <input type="text" id="price<?php echo $colors2->color_id; ?>" onblur="update_color_price(<?php echo $colors2->color_id; ?>, this.value)" class="form-control"  value="<?php echo money_format("%i", $colors2->color_price); ?>">
                                        </td><td>
                                            <span onclick="remove_color(<?php echo $colors2->color_id; ?>, <?php echo $this->mdl_products->form_value('product_id'); ?>);" style="color:red; cursor:pointer;" title="Click to remove this color"> <i class="fa fa-trash-o fa-margin"></i> Remove</span>
                                        </td></tr>

<?php } ?>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Quantities</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <table class="table table-condensed table-bordered">
                                <thead>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Unit. Price</th>
                                <th>Quantity</th>
                                <th>Lenght</th>
                                <th>Width</th>
                                <th>Height</th>
                                <th>Weight</th>
                                </thead>
                                <tr><td>
                                        <select class="form-control" name="product_color_quantities" id="product_color_quantities" onchange="calc_color_size_quantity();">
                                            <option value=""></option>
<?php foreach ($colors as $color_sizes) { ?>
                                                <option value="<?php echo $color_sizes->color_id; ?>" ><?php echo $color_sizes->color_name; ?></option>
<?php } ?>
                                        </select></td><td>
                                        <select class="form-control" name="product_sizes_quantities" id="product_sizes_quantities" onchange="calc_color_size_quantity();">
                                            <option value=""></option>
<?php foreach ($sizes as $sizes_sizes) { ?>
                                                <option value="<?php echo $sizes_sizes->size_id; ?>"><?php echo $sizes_sizes->size_name; ?></option>
<?php } ?>
                                        </select>
                                    </td><td>
                                        <input type="text" class="form-control" name="product_price_quantities" id="product_price_quantities" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="product_quantity_quantities" id="product_quantity_quantities">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="product_lenght_quantities" id="product_lenght_quantities">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="product_width_quantities" id="product_width_quantities">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="product_height_quantities" id="product_height_quantities">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="product_weight_quantities" id="product_weight_quantities">
                                    </td>
                                    <td>
                                        <img onclick="add_size_colors();" src="<?php echo base_url(); ?>/images/add_blue.png" title="Click to add this conjunt" style="width:35px; cursor:pointer;"/>
                                    </td>
                                </tr>
                            </table>
                            <table class="table table-condensed table-bordered">
                                <thead>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Unit. Price</th>
                                <th>Quantity</th>
                                <th>Lenght</th>
                                <th>Width</th>
                                <th>Height</th>
                                <th>Weight</th>
                                <th><a class="btn btn-default" style="" onclick="refill_size_colors_ebay();">Refill Size and Colors</a> <a onclick="remove_all();" class="btn btn-danger">Remove All</a></th>
                                </thead>
                                <tbody id="color_size_body">
<?php foreach ($ip_color_sizes as $ip_color_sizes) { ?>
                                        <tr id="color_size<?php echo $ip_color_sizes->color_size_id; ?>"><td>
                                                <label ><?php echo $ip_color_sizes->color_name; ?></label>
                                            </td>
                                            <td>
                                                <label ><?php echo $ip_color_sizes->size_name; ?></label>
                                            </td>
                                            <td>
                                                <label ><?php echo "$" . money_format("%i", $ip_color_sizes->color_size_price); ?></label>
                                            </td>
                                            <td>
                                                <input type="text" onblur="update_color_size_quantity(<?php echo $ip_color_sizes->color_size_id; ?>, this.value);" class="form-control" id="color_size_quantity<?php echo $ip_color_sizes->color_size_id; ?>" value="<?php echo $ip_color_sizes->color_size_quantity; ?>">
                                            </td>
                                            <td>
                                                <label ><?php echo $ip_color_sizes->lenght; ?></label>
                                            </td>
                                            <td>
                                                <label ><?php echo $ip_color_sizes->width; ?></label>
                                            </td>
                                            <td>
                                                <label ><?php echo $ip_color_sizes->height; ?></label>
                                            </td>
                                            <td>
                                                <label ><?php echo $ip_color_sizes->weight; ?></label>
                                            </td>

                                            <td>
                                                <span onclick="remove_color_size(<?php echo $ip_color_sizes->color_size_id; ?>);" style="color:red; cursor:pointer;" title="Click to remove this color"> <i class="fa fa-trash-o fa-margin"></i> Remove</span>
                                            </td>

                                        </tr>

<?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>

        </div>

</form>
<script type="text/javascript">
    function remove_all()
    {
        $.post("<?php echo site_url(); ?>/products/ajax/remove_all_quantities",
                {
                    product_id: <?php if ($this->mdl_products->form_value('product_id') != null) {
    echo $this->mdl_products->form_value('product_id');
} else {
    echo "none";
} ?>
                }, function (data) {
            if (data == "success")
            {
                location.reload();
            } else
            {
                console.log(data);
            }
        });
    }
    $(document).ready(function () {
        $('#fcat').change(function () {
            //alert($('#fcat').val());
            var catId = $('#fcat').val();
            $.get('<?php echo site_url(); ?>products/getCategoriesInfo?catId=' + catId, function (response, status) {
                if (status == 'success') {
                    //console.log(response);
                    $('.div-scrollbar > span').html(response);

                }
            });

        }); //select onchange



        $('#remove').click(function () { //alert('response cleared');
            $('.div-scrollbar > span,.ionise').html('');
        });

    });
    function refill_size_colors_ebay()
    {
        $.post("<?php echo site_url(); ?>/products/Ajax/refill_size_colors_ebay",
                {
                    product_id: <?php if ($this->mdl_products->form_value('product_id') != null) {
    echo $this->mdl_products->form_value('product_id');
} else {
    echo "none";
} ?>
                }, function (data) {
            location.reload();
        });
    }
    function select_ebay_cat(counter)
    {
        var catId = $('#subcat_' + counter).val();

        $.get('<?php echo site_url(); ?>products/getCategoriesInfo?counter=' + counter + '&catId=' + catId, function (response, status) {
            if (status == 'success') {
                //alert(response);
                $("#ebay_category_id").val(catId);
                //$("#ebay_category").val(category_name);
                $('span.subcat_' + counter).html(response);
            }
        });
    }
    function create_ebay_listing()
    {
        $("#submit_ebay_button").hide();
        $("#loading_message").show();
        $.post("<?php echo site_url(); ?>/products/AddEbayItem",
                {
                    product_id: <?php if ($this->mdl_products->form_value('product_id') != null) {
    echo $this->mdl_products->form_value('product_id');
} else {
    echo "none";
} ?>
                }, function (data) {
            location.reload();
            console.log(data);
        });
    }
    function remove_color_size(color_size_id)
    {
        $.post("<?php echo site_url(); ?>/products/Ajax/remove_size_color",
                {
                    color_size_id: color_size_id
                }, function (data) {
            $("#color_size" + color_size_id).hide();
        });
    }
    function add_size_colors()
    {
        var product_id = <?php if ($this->mdl_products->form_value('product_id') != null) {
    echo $this->mdl_products->form_value('product_id');
} else {
    echo "none";
} ?>;
        var size_id = $("#product_sizes_quantities").val();
        var color_id = $("#product_color_quantities").val();
        var price = $("#product_price_quantities").val();
        var quantity = $("#product_quantity_quantities").val();
        var lenght = $("#product_lenght_quantities").val();
        var width = $("#product_width_quantities").val();
        var height = $("#product_height_quantities").val();
        var weight = $("#product_weight_quantities").val();
        if (color_id == '') {
            $("#product_sizes_quantities").css("border-color", "");
            $("#product_color_quantities").css("border-color", "red");

        } else if (size_id == '')
        {
            $("#product_color_quantities").css("border-color", "");
            $("#product_width_quantities").css("border-color", "");
            $("#product_height_quantities").css("border-color", "");
            $("#product_weight_quantities").css("border-color", "");
            $("#product_lenght_quantities").css("border-color", "");
            $("#product_sizes_quantities").css("border-color", "red");
        } else if (quantity == '')
        {
            $("#product_color_quantities").css("border-color", "");
            $("#product_sizes_quantities").css("border-color", "");
            $("#product_width_quantities").css("border-color", "");
            $("#product_height_quantities").css("border-color", "");
            $("#product_weight_quantities").css("border-color", "");
            $("#product_lenght_quantities").css("border-color", "");
            $("#product_quantity_quantities").css("border-color", "red");
        } else if (lenght == '')
        {
            $("#product_color_quantities").css("border-color", "");
            $("#product_sizes_quantities").css("border-color", "");
            $("#product_quantity_quantities").css("border-color", "");
            $("#product_width_quantities").css("border-color", "");
            $("#product_height_quantities").css("border-color", "");
            $("#product_weight_quantities").css("border-color", "");
            $("#product_lenght_quantities").css("border-color", "red");
        } else if (width == '')
        {
            $("#product_color_quantities").css("border-color", "");
            $("#product_sizes_quantities").css("border-color", "");
            $("#product_quantity_quantities").css("border-color", "");
            $("#product_width_quantities").css("border-color", "red");
            $("#product_height_quantities").css("border-color", "");
            $("#product_weight_quantities").css("border-color", "");
            $("#product_lenght_quantities").css("border-color", "");
        } else if (height == '')
        {
            $("#product_color_quantities").css("border-color", "");
            $("#product_sizes_quantities").css("border-color", "");
            $("#product_quantity_quantities").css("border-color", "");
            $("#product_width_quantities").css("border-color", "");
            $("#product_height_quantities").css("border-color", "red");
            $("#product_weight_quantities").css("border-color", "");
            $("#product_lenght_quantities").css("border-color", "");
        } else if (weight == '')
        {
            $("#product_color_quantities").css("border-color", "");
            $("#product_sizes_quantities").css("border-color", "");
            $("#product_quantity_quantities").css("border-color", "");
            $("#product_width_quantities").css("border-color", "");
            $("#product_height_quantities").css("border-color", "");
            $("#product_weight_quantities").css("border-color", "red");
            $("#product_lenght_quantities").css("border-color", "");
        } else
        {
            $("#product_color_quantities").css("border-color", "");
            $("#product_sizes_quantities").css("border-color", "");
            $("#product_quantity_quantities").css("border-color", "");
            $("#product_width_quantities").css("border-color", "");
            $("#product_height_quantities").css("border-color", "");
            $("#product_weight_quantities").css("border-color", "");
            $("#product_lenght_quantities").css("border-color", "");
            $.post("<?php echo site_url(); ?>/products/Ajax/add_size_color_price",
                    {
                        size_id: size_id,
                        color_id: color_id,
                        price: price,
                        quantity: quantity,
                        product_id: product_id,
                        lenght: lenght,
                        width: width,
                        height: height,
                        weight: weight
                    }, function (data) {
                if (data != null) {
                    var result = JSON.parse(data);
                    result = result[0];
                    $("#color_size_body").append('<tr id="color_size' + result.color_size_id + '"><td><label >' + result.color_name + '</label></td><td><label >' + result.size_name + '</label></td><td><label >$' + result.color_size_price + '</label></td><td><input type="text" class="form-control" id="color_size_quantity' + result.color_size_id + '" value="' + result.color_size_quantity + '"></td><td><span onclick="remove_color_size(' + result.color_size_id + ');" style="color:red; cursor:pointer;" title="Click to remove this color"> <i class="fa fa-trash-o fa-margin"></i> Remove</span></td></tr>');
                }
            });
        }
    }

    function calc_color_size_quantity()
    {

        var size_id = $("#product_sizes_quantities").val();
        var color_id = $("#product_color_quantities").val();

        $.post("<?php echo site_url(); ?>/products/Ajax/calc_size_color_price",
                {
                    size_id: size_id,
                    color_id: color_id,
                    product_price: $("#product_price").val()
                }, function (data) {
            $("#product_price_quantities").val(data);
        });


    }
    function update_color_size_quantity(color_size_id, new_quantity)
    {
        $.post("<?php echo site_url(); ?>/products/Ajax/update_color_size_price",
                {
                    color_size_id: color_size_id,
                    new_quantity: new_quantity
                }, function (data) {
            $("#color_size_quantity" + color_size_id).css("border-color", "green");
            setTimeout(function () {
                $("#color_size_quantity" + color_size_id).css("border-color", "");
            }, 3000);
        });
    }
    function update_size_price(size_id, new_price)
    {
        $.post("<?php echo site_url(); ?>/products/Ajax/update_size_price",
                {
                    size_id: size_id,
                    new_price: new_price
                }, function (data) {
            $("#size_price" + size_id).css("border-color", "green");
            setTimeout(function () {
                $("#size_price" + size_id).css("border-color", "");
            }, 3000);
        });
    }
    function add_size(product_id, size, size_price)
    {
        if (size == '')
        {
            $('#product_size_price').css("border-color", "");
            $('#product_size_name').focus();
            $('#product_size_name').css("border-color", "red");
        } else if (size_price == '')
        {
            $('#product_size_name').css("border-color", "");
            $('#product_size_price').focus();
            $('#product_size_price').css("border-color", "red");
        } else {
            $('#product_size_name').css("border-color", "");
            $('#product_size_price').css("border-color", "");
            $.post("<?php echo site_url(); ?>/products/Ajax/add_size",
                    {
                        product_id: product_id,
                        size: size,
                        size_price: size_price
                    }, function (data) {
                if (data != null) {
                    var result = data.split("$$");
                    var ready = JSON.parse(result[1]);
                    $("#product_size").val(result[0]);
                    $('#product_size_name').val('');
                    $('#product_size_price').val('');
                    $("#size_table").append('<tr id="' + ready.size_id + '"><td><label >' + ready.size_name + '</label></td><td><input type="text" id="size_price' + ready.size_id + '" onblur="update_size_price(' + ready.size_id + ', this.value)" class="form-control"  value="' + ready.size_price + '"></td><td><span onclick="remove_size(' + ready.size_id + ', ' + ready.product_id + ');" style="color:red; cursor:pointer;" title="Click to remove this size"> <i class="fa fa-trash-o fa-margin"></i> Remove</span></td></tr>');
                }
            });
        }
    }
    function remove_size(size_id, product_id)
    {
        $.post("<?php echo site_url(); ?>/products/Ajax/remove_size",
                {
                    size_id: size_id,
                    product_id: product_id
                }, function (data) {
            $("#" + size_id).hide();
            $("#product_size").val(data);
        });
    }
    function update_color_price(color_id, new_price)
    {
        $.post("<?php echo site_url(); ?>/products/Ajax/update_color_price",
                {
                    color_id: color_id,
                    new_price: new_price
                }, function (data) {
            $("#price" + color_id).css("border-color", "green");
            setTimeout(function () {
                $("#price" + color_id).css("border-color", "");
            }, 3000);
        });
    }
    function remove_color(color_id, product_id)
    {
        $.post("<?php echo site_url(); ?>/products/Ajax/remove_color",
                {
                    product_id: product_id,
                    color_id: color_id
                }, function (data) {
            $("#" + color_id).hide();
            $("#product_color").val(data);
        });
    }
    function add_color(product_id, color, color_price)
    {
        if (color == '')
        {
            $('#product_color_price').css("border-color", "");
            $('#product_color_name').focus();
            $('#product_color_name').css("border-color", "red");
        } else if (color_price == '')
        {
            $('#product_color_name').css("border-color", "");
            $('#product_color_price').focus();
            $('#product_color_price').css("border-color", "red");
        } else {
            $('#product_color_name').css("border-color", "");
            $('#product_color_price').css("border-color", "");
            $.post("<?php echo site_url(); ?>/products/Ajax/add_color",
                    {
                        product_id: product_id,
                        color: color,
                        color_price: color_price
                    }, function (data) {

                if (data != null) {

                    var result = data.split("$$");
                    var ready = JSON.parse(result[1]);
                    $("#product_color").val(result[0]);
                    $('#product_color_name').val('');
                    $('#product_color_price').val('');
                    $("#colors_table").append('<tr id=' + ready.color_id + '><td><label >' + ready.color_name + '</label></td><td><input type="text" id="price' + ready.color_id + '" onblur="update_color_price(' + ready.color_id + ', this.value)" class="form-control"  value="' + ready.color_price + '"></td><td><span onclick="remove_color(' + ready.color_id + ', ' + ready.product_id + ');" style="color:red; cursor:pointer;" title="Click to remove this color"> <i class="fa fa-trash-o fa-margin"></i> Remove</span></td></tr>');

                }

            });
        }

    }
    function remove_image(image_number)
    {

        $.post("<?php echo site_url(); ?>/products/Ajax/remove_image",
                {
                    product_id: <?php if ($this->mdl_products->form_value('product_id') != null) {
    echo $this->mdl_products->form_value('product_id');
} else {
    echo "none";
} ?>,
                    image_number: image_number
                }, function (data) {
            $("#image" + image_number).remove();
        });
    }
    function make_sidemenu(product_id)
    {
        var sidemenu;
        if ($("#product_sidemenu").is(":checked")) {
            sidemenu = 'on';
        } else
        {
            sidemenu = 'off';
        }
        $.post("<?php echo site_url(); ?>/products/Ajax/update_sidemenu",
                {
                    product_id: product_id,
                    sidemenu: sidemenu
                }, function (data) {

        });
    }
    function make_special(product_id) {
        var special;
        if ($("#product_special").is(":checked")) {
            special = 'on';
        } else
        {
            special = 'off';
        }
        $.post("<?php echo site_url(); ?>/products/Ajax/update_special",
                {
                    product_id: product_id,
                    special: special
                }, function (data) {

        });
    }
    function make_featured(product_id)
    {
        var featured;
        if ($("#product_featured").is(":checked")) {
            featured = 'on';
        } else
        {
            featured = 'off';
        }
        $.post("<?php echo site_url(); ?>/products/Ajax/update_featured",
                {
                    product_id: product_id,
                    featured: featured
                }, function (data) {

        });
    }
    function make_custom(product_id)
    {
        var custom;
        if ($("#product_custom").is(":checked")) {
            custom = 'on';
        } else
        {
            featured = 'off';
        }
        $.post("<?php echo site_url(); ?>/products/Ajax/update_custom",
                {
                    product_id: product_id,
                    custom: custom
                }, function (data) {

        });
    }

    function make_banner(product_id)
    {
        var banner;
        if ($("#product_banner").is(":checked")) {
            banner = 'on';
        } else
        {
            banner = 'off';
        }
        $.post("<?php echo site_url(); ?>/products/Ajax/update_banner",
                {
                    product_id: product_id,
                    banner: banner
                }, function (data) {

        });
    }
</script>
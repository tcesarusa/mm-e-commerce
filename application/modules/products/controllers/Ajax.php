<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * InvoicePlane
 *
 * @author		InvoicePlane Developers & Contributors
 * @copyright	Copyright (c) 2012 - 2017 InvoicePlane.com
 * @license		https://invoiceplane.com/license.txt
 * @link		https://invoiceplane.com
 */

/**
 * Class Ajax
 */
class Ajax extends Admin_Controller {

    public $ajax_controller = true;
    public function refill_size_colors_ebay()
    {
      $product_id = $this->input->post("product_id");
        $color_price = 0;
        $size_price = 0;


        $colors = array(
            "White" => '',
            "Gray" => '',
            "Black" => '',
            "Blue" => '',
            "Red" => '',
            "Green" => '',
            "Yellow" => ''
        );
        $sizes = array(
            "Small" => '',
            "Medium" => '',
            "Large" => '',
            "X Large" => '',
            "2X Large" => '',
            "3X Large" => ''
        );
        //INSERT COLORS
        foreach ($colors as $color_name => $colors) {
            if ($color_name == "White") {
                $color_price = "4.99";
            } else {
                $color_price = "6.99";
            }
            $color_price = "15.99";
            $ip_colors = array(
                "color_name" => $color_name,
                "product_id" => $product_id,
                "color_price" => $color_price
            );
            $this->db->where("color_name", $color_name);
            $this->db->where("product_id", $product_id);
            $check_exist = $this->db->get("ip_colors")->num_rows();
            if ($check_exist == 0) {
                $this->db->insert("ip_colors", $ip_colors);
            }
        }
        //INSERT SIZES
        foreach ($sizes as $size_name => $empty) {
            if ($size_name == "2X Large") {
                $size_price = "2.46";
            } else if ($size_name == "3X Large") {
                $size_price = "2.86";
            } else {
                $size_price = "0.00";
            }
            $size_price = "15.99";
            $ip_sizes = array(
                "size_name" => $size_name,
                "product_id" => $product_id,
                "size_price" => $size_price
            );
            $this->db->where("size_name", $size_name);
            $this->db->where("product_id", $product_id);
            $check_exist = $this->db->get("ip_sizes")->num_rows();
            if ($check_exist == 0) {
                $this->db->insert("ip_sizes", $ip_sizes);
            }
        }
        $this->add_size_colors_ebay($sizes, $product_id);  
    }
     public function remove_all_quantities()
    {
        $product_id = $this->input->post("product_id");
        try{
            
            //REMOVE COLORS ATTACHED
            $this->db->where("product_id", $product_id);
            $this->db->delete("ip_colors");
            
            
            //REMOVE SIZES ATTACHED
             $this->db->where("product_id", $product_id);
            $this->db->delete("ip_sizes");
            
            //REMOVE COLOR AND SIZES ATTACHED
        
        $this->db->where("product_id", $product_id);
        $this->db->delete("ip_color_sizes");
        echo "success";
        }catch(Exception $error)
        {
            echo $error;
        }
    }
    public function refill_size_colors() {
        $product_id = $this->input->post("product_id");
        $color_price = 0;
        $size_price = 0;


        $colors = array(
            "White" => '',
            "Gray" => '',
            "Black" => '',
            "Blue" => '',
            "Red" => '',
            "Green" => '',
            "Yellow" => ''
        );
        $sizes = array(
            "Small" => '',
            "Medium" => '',
            "Large" => '',
            "X Large" => '',
            "2X Large" => '',
            "3X Large" => ''
        );
        //INSERT COLORS
        foreach ($colors as $color_name => $colors) {
            if ($color_name == "White") {
                $color_price = "4.99";
            } else {
                $color_price = "6.99";
            }

            $ip_colors = array(
                "color_name" => $color_name,
                "product_id" => $product_id,
                "color_price" => $color_price
            );
            $this->db->where("color_name", $color_name);
            $this->db->where("product_id", $product_id);
            $check_exist = $this->db->get("ip_colors")->num_rows();
            if ($check_exist == 0) {
                $this->db->insert("ip_colors", $ip_colors);
            }
        }
        //INSERT SIZES
        foreach ($sizes as $size_name => $empty) {
            if ($size_name == "2X Large") {
                $size_price = "2.46";
            } else if ($size_name == "3X Large") {
                $size_price = "2.86";
            } else {
                $size_price = "0.00";
            }

            $ip_sizes = array(
                "size_name" => $size_name,
                "product_id" => $product_id,
                "size_price" => $size_price
            );
            $this->db->where("size_name", $size_name);
            $this->db->where("product_id", $product_id);
            $check_exist = $this->db->get("ip_sizes")->num_rows();
            if ($check_exist == 0) {
                $this->db->insert("ip_sizes", $ip_sizes);
            }
        }
        $this->add_size_colors($sizes, $product_id);
    }
 private function add_size_colors_ebay($sizes, $product_id) {
        $lenght = 72;
        $width = 46;
        $height = 0.10;
        $weight = 5.5;
        $product_quantity = 0;
        $this->db->where("product_id", $product_id);
        $colors_table = $this->db->get("ip_colors")->result_object();

            //INSERT IP_COLOR_SIZES
            foreach ($colors_table as $colors_table) {
                
                foreach ($sizes as $size_name => $empty) {

            $this->db->where("product_id", $product_id);
            $this->db->where("size_name", $size_name);
            $sizes_table = $this->db->get("ip_sizes")->result_object();
            foreach($sizes_table as $sizes_table) {
                if ($sizes_table->size_name == "Small") {
                    $lenght = 72;
                    $width = 46;
                }else if ($sizes_table->size_name == "Medium") {
                    $lenght = 75;
                    $width = 51;
                } else if ($sizes_table->size_name == "Large") {
                    $lenght = 77;
                    $width = 56;
                } else if ($sizes_table->size_name == "X Large") {
                    $lenght = 80;
                    $width = 61;
                } else if ($sizes_table->size_name == "2X Large") {
                    $lenght = 83;
                    $width = 64;
                } else if ($sizes_table->size_name == "3X Large") {
                    $lenght = 86;
                    $width = 69;
                }

                $ip_color_sizes[] = array(
                    "product_id" => $product_id,
                    "color_id" => $colors_table->color_id,
                    "size_id" => $sizes_table->size_id,
                    "color_size_price" => "15.99",
                    "color_size_quantity" => 100,
                    "lenght" => $lenght,
                    "width" => $width,
                    "height" => $height,
                    "weight" => $weight
                );
                $product_quantity+=100;
            }
                }
                
            }
   
        

        foreach ($ip_color_sizes as $ip_color_sizes) {
            $this->db->where("product_id", $product_id);
            $this->db->where("color_id", $ip_color_sizes['color_id']);
            $this->db->where("size_id", $ip_color_sizes['size_id']);
            $this->db->where("color_size_price", $ip_color_sizes['color_size_price']);
            $check_color_size = $this->db->get("ip_color_sizes")->num_rows();
            if ($check_color_size == 0) {
                $this->db->insert("ip_color_sizes", $ip_color_sizes);
            }
        }
        $this->db->set("product_quantity", $product_quantity);
        $this->db->where("product_id", $product_id);
        $this->db->update("ip_products");
        //$this->add_size_colors($i++);
    }
    private function add_size_colors($sizes, $product_id) {
        $lenght = 72;
        $width = 46;
        $height = 0.10;
        $weight = 5.5;
        $product_quantity = 0;
        $this->db->where("product_id", $product_id);
        $colors_table = $this->db->get("ip_colors")->result_object();

            //INSERT IP_COLOR_SIZES
            foreach ($colors_table as $colors_table) {
                
                foreach ($sizes as $size_name => $empty) {

            $this->db->where("product_id", $product_id);
            $this->db->where("size_name", $size_name);
            $sizes_table = $this->db->get("ip_sizes")->result_object();
            foreach($sizes_table as $sizes_table) {
                if ($sizes_table->size_name == "Small") {
                    $lenght = 72;
                    $width = 46;
                }else if ($sizes_table->size_name == "Medium") {
                    $lenght = 75;
                    $width = 51;
                } else if ($sizes_table->size_name == "Large") {
                    $lenght = 77;
                    $width = 56;
                } else if ($sizes_table->size_name == "X Large") {
                    $lenght = 80;
                    $width = 61;
                } else if ($sizes_table->size_name == "2X Large") {
                    $lenght = 83;
                    $width = 64;
                } else if ($sizes_table->size_name == "3X Large") {
                    $lenght = 86;
                    $width = 69;
                }

                $ip_color_sizes[] = array(
                    "product_id" => $product_id,
                    "color_id" => $colors_table->color_id,
                    "size_id" => $sizes_table->size_id,
                    "color_size_price" => $colors_table->color_price + $sizes_table->size_price,
                    "color_size_quantity" => 100,
                    "lenght" => $lenght,
                    "width" => $width,
                    "height" => $height,
                    "weight" => $weight
                );
                $product_quantity+=100;
            }
                }
                
            }
   
        

        foreach ($ip_color_sizes as $ip_color_sizes) {
            $this->db->where("product_id", $product_id);
            $this->db->where("color_id", $ip_color_sizes['color_id']);
            $this->db->where("size_id", $ip_color_sizes['size_id']);
            $this->db->where("color_size_price", $ip_color_sizes['color_size_price']);
            $check_color_size = $this->db->get("ip_color_sizes")->num_rows();
            if ($check_color_size == 0) {
                $this->db->insert("ip_color_sizes", $ip_color_sizes);
            }
        }
        $this->db->set("product_quantity", $product_quantity);
        $this->db->where("product_id", $product_id);
        $this->db->update("ip_products");
        //$this->add_size_colors($i++);
    }

    public function add_size() {
        $product_id = $this->input->post("product_id");
        $size = $this->input->post("size");
        $size_price = $this->input->post("size_price");

        $sizes = array(
            "product_id" => $product_id,
            "size_name" => $size,
            "size_price" => $size_price
        );
        $this->db->insert("ip_sizes", $sizes);
        $size_id = $this->db->insert_id();

        $this->db->where("product_id", $product_id);
        $size_data = $this->db->get("ip_sizes")->result_object();
        $size_names = '';
        $counter_s = 0;
        foreach ($size_data as $sizes) {
            if ($counter_s != 0) {
                $size_names .= "," . $sizes->size_name;
            } else {
                $size_names .= $sizes->size_name;
            }

            $counter_s++;
        }

        $this->db->where("size_id", $size_id);
        $size_by_id = $this->db->get("ip_sizes")->result_object();

        echo $size_names . '$$' . json_encode($size_by_id[0]);
    }

    public function add_size_color_price() {
        $product_id = $this->input->post("product_id");
        $size_id = $this->input->post("size_id");
        $color_id = $this->input->post("color_id");
        $price = $this->input->post("price");
        $quantity = $this->input->post("quantity");
        $lenght = $this->input->post("lenght");
        $width = $this->input->post("width");
        $height = $this->input->post("height");
        $weight = $this->input->post("weight");





        $ip_color_sizes = array(
            "product_id" => $product_id,
            "color_id" => $color_id,
            "size_id" => $size_id,
            "color_size_price" => $price,
            "color_size_quantity" => $quantity,
            "lenght" => $lenght,
            "width" => $width,
            "height" => $height,
            "weight" => $weight
        );

        $this->db->where("color_id", $color_id);
        $this->db->where("size_id", $size_id);
        $match = $this->db->get("ip_color_sizes")->num_rows();
        if ($match == 0) {
            $this->db->insert("ip_color_sizes", $ip_color_sizes);
            $new_id = $this->db->insert_id();


            //update actual quantity from the product
            $this->db->where("product_id", $product_id);
            $prod_qtt = $this->db->get("ip_products")->result_object();
            $prod_qtt = $prod_qtt[0]->product_quantity;


            $this->db->set("product_quantity", $prod_qtt + $quantity);
            $this->db->where("product_id", $product_id);
            $this->db->update("ip_products");

            $this->db->join("ip_colors", "ip_colors.color_id = ip_color_sizes.color_id");
            $this->db->join("ip_sizes", "ip_sizes.size_id = ip_color_sizes.size_id");
            $this->db->where("ip_color_sizes.color_size_id", $new_id);





            echo json_encode($this->db->get("ip_color_sizes")->result_object());
        } else {
            echo "exist";
        }
    }

    public function calc_size_color_price() {
        $size_id = $this->input->post("size_id");
        $color_id = $this->input->post("color_id");
        $product_price = $this->input->post("product_price");
        $product_price = str_replace(",", "", $product_price);
        $product_price = explode(".", $product_price);
        $total_calc = $product_price[0];
        if ($size_id != '') {
            $this->db->where("size_id", $size_id);
            $size_data = $this->db->get("ip_sizes")->result_object();
            $total_calc += $size_data[0]->size_price;
        }

        if ($color_id != '') {
            $this->db->where("color_id", $color_id);
            $color_data = $this->db->get("ip_colors")->result_object();
            $total_calc += $color_data[0]->color_price;
        }
        echo $total_calc;
    }

    public function update_color_size_price() {
        $color_size_id = $this->input->post("color_size_id");
        $new_quantity = $this->input->post("new_quantity");

        $this->db->where("color_size_id", $color_size_id);
        $this->db->set("color_size_quantity", $new_quantity);
        $this->db->update("ip_color_sizes");
    }

    public function update_size_price() {
        $size_id = $this->input->post("size_id");
        $new_price = $this->input->post("new_price");

        $this->db->where("size_id", $size_id);
        $this->db->set("size_price", $new_price);
        $this->db->update("ip_sizes");
    }

    public function add_color() {
        $product_id = $this->input->post("product_id");
        $color = $this->input->post("color");
        $color_price = $this->input->post("color_price");

        $colors = array(
            "product_id" => $product_id,
            "color_name" => $color,
            "color_price" => $color_price
        );
        $this->db->insert("ip_colors", $colors);
        $color_id = $this->db->insert_id();

        $this->db->where("product_id", $product_id);
        $color_data = $this->db->get("ip_colors")->result_object();
        $color_names = '';
        $counter_x = 0;
        foreach ($color_data as $colors) {
            if ($counter_x != 0) {
                $color_names .= "," . $colors->color_name;
            } else {
                $color_names .= $colors->color_name;
            }

            $counter_x++;
        }

        $this->db->where("color_id", $color_id);
        $color_by_id = $this->db->get("ip_colors")->result_object();

        echo $color_names . '$$' . json_encode($color_by_id[0]);
    }

    public function remove_size_color() {
        $color_size_id = $this->input->post("color_size_id");

        $this->db->where("color_size_id", $color_size_id);
        $this->db->delete("ip_color_sizes");
    }

    public function remove_size() {
        $size_id = $this->input->post("size_id");
        $product_id = $this->input->post("product_id");
        $size_ready = '';
        $this->db->where("size_id", $size_id);
        $this->db->delete("ip_sizes");

        $this->db->where("product_id", $product_id);
        $product_data = $this->db->get("ip_products")->result_object();


        $this->db->where("product_id", $product_id);
        $size_data = $this->db->get("ip_sizes")->result_object();
        $size_names = '';
        $counter_s = 0;
        foreach ($size_data as $sizes) {
            if ($counter_s != 0) {
                $size_names .= "," . $sizes->size_name;
            } else {
                $size_names .= $sizes->size_name;
            }

            $counter_s++;
        }

        $this->db->where("product_id", $product_id);
        $this->db->set("product_size", $size_names);
        $this->db->update("ip_products");

        echo $size_names;
    }

    public function update_color_price() {
        $color_id = $this->input->post("color_id");
        $new_price = $this->input->post("new_price");

        $this->db->where("color_id", $color_id);
        $this->db->set("color_price", $new_price);
        $this->db->update("ip_colors");
    }

    public function remove_color() {
        $product_id = $this->input->post("product_id");
        $color_id = $this->input->post("color_id");

        $this->db->where("color_id", $color_id);
        $this->db->delete("ip_colors");

        $this->db->where("product_id", $product_id);
        $color_data = $this->db->get("ip_colors")->result_object();
        $color_names = '';
        $counter_x = 0;
        foreach ($color_data as $colors) {
            if ($counter_x != 0) {
                $color_names .= "," . $colors->color_name;
            } else {
                $color_names .= $colors->color_name;
            }

            $counter_x++;
        }
        echo $color_names;
    }

    public function modal_product_lookups() {
        $filter_product = $this->input->get('filter_product');
        $filter_family = $this->input->get('filter_family');
        $reset_table = $this->input->get('reset_table');

        $this->load->model('mdl_products');
        $this->load->model('families/mdl_families');

        if (!empty($filter_family)) {
            $this->mdl_products->by_family($filter_family);
        }

        if (!empty($filter_product)) {
            $this->mdl_products->by_product($filter_product);
        }

        $products = $this->mdl_products->get()->result();
        $families = $this->mdl_families->get()->result();

        $default_item_tax_rate = get_setting('default_item_tax_rate');
        $default_item_tax_rate = $default_item_tax_rate !== '' ?: 0;

        $data = array(
            'products' => $products,
            'families' => $families,
            'filter_product' => $filter_product,
            'filter_family' => $filter_family,
            'default_item_tax_rate' => $default_item_tax_rate,
        );

        if ($filter_product || $filter_family || $reset_table) {
            $this->layout->load_view('products/partial_product_table_modal', $data);
        } else {
            $this->layout->load_view('products/modal_product_lookups', $data);
        }
    }

    public function process_product_selections() {
        $this->load->model('mdl_products');

        $products = $this->mdl_products->where_in('product_id', $this->input->post('product_ids'))->get()->result();

        foreach ($products as $product) {
            $product->product_price = format_amount($product->product_price);
        }

        echo json_encode($products);
    }

    public function update_special() {
        $product_id = $this->input->post("product_id");
        $special = $this->input->post("special");
        $this->db->where("product_id", $product_id);
        $this->db->set("product_special", $special);
        $this->db->update("ip_products");
    }

    public function update_featured() {
        $product_id = $this->input->post("product_id");
        $featured = $this->input->post("featured");
        $this->db->where("product_id", $product_id);
        $this->db->set("product_featured", $featured);
        $this->db->update("ip_products");
    }

    public function update_custom() {
        $product_id = $this->input->post("product_id");
        $custom = $this->input->post("custom");
        $this->db->where("product_id", $product_id);
        $this->db->set("product_custom", $custom);
        $this->db->update("ip_products");
    }

    public function update_sidemenu() {
        $product_id = $this->input->post("product_id");
        $sidemenu = $this->input->post("sidemenu");
        $this->db->where("product_id", $product_id);
        $this->db->set("product_sidemenu", $sidemenu);
        $this->db->update("ip_products");
    }

    public function update_banner() {
        $product_id = $this->input->post("product_id");
        $banner = $this->input->post("banner");
        $this->db->where("product_id", $product_id);
        $this->db->set("product_banner", $banner);
        $this->db->update("ip_products");
    }

    public function remove_image() {
        $product_id = $this->input->post("product_id");
        $image_number = $this->input->post("image_number");
        if ($image_number == 1) {
            $image_number = null;
        }
        $this->db->set("product_image" . $image_number, '');
        $this->db->where("product_id", $product_id);
        $this->db->update("ip_products");
    }

}

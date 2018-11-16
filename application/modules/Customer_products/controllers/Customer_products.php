<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_products extends My_Default {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        redirect('Customer_products/show_products');
    }
    public function show_products($page = 0) {
        $category = $this->input->post("category_search");
        if ($category == '') {
            $category = 'all';
        }
        $search = explode(" ", $this->input->post("search_bar"));
        $sort = $this->input->post("sort_by");
        if ($category != 'all') {
            $this->db->where("pcategory_id", $this->input->post("category_search"));
            if ($this->input->post("search_bar") != '') {
                $this->db->like("product_name", $this->input->post("search_bar"));
            }
        } else {
            foreach ($search as $search1) {
                $this->db->or_like("product_name", $search1);
            }
        }
        if ($sort != "") {
            if ($sort == 'az') {
                $this->db->order_by("product_name", "ASC");
            } else if ($sort == 'lh') {
                $this->db->order_by("product_price", "ASC");
            } else if ($sort == 'hl') {
                $this->db->order_by("product_price", "DESC");
            }
        }
        $qtt_show = 12;
        $start = ($qtt_show * $page);
        $this->products['search_term'] = $this->input->post("search_bar");
        $this->products['search_category'] = $this->input->post("category_search");
        $this->products['sort'] = $sort;
        $this->db->where("product_custom <>", "on");
        $this->db->order_by("product_id", "DESC");
        $this->db->limit($qtt_show, $start);
        $specific_search = $this->db->get("ip_products");
        $this->products['specific_search'] = $specific_search->result_object();
        
        
        
        if ($category != 'all') {
            $this->db->where("pcategory_id", $this->input->post("category_search"));
            if ($this->input->post("search_bar") != '') {
                $this->db->like("product_name", $this->input->post("search_bar"));
            }
        } else {
            foreach ($search as $search2) {
                $this->db->or_like("product_name", $search2);
            }
        }
        $this->db->where("product_custom <>", "on");
        $all_rows = $this->db->get("ip_products")->num_rows() - $qtt_show;
        if($all_rows < 0)
        {
            $all_rows = 0;
        }
        $this->load->library('pagination');

       //CONFIG PAGINATION

                $config['uri_segment'] = 3;
                $config['base_url'] = site_url() . '/Products/show_products/';
         
            $config['display_pages'] = TRUE;
            $config['full_tag_open'] = '<div class="pagination" style="display:inline-block; float:left;"><ul>';
            $config['full_tag_close'] = '</ul></div><!--pagination-->';
            $config['first_link'] = '&laquo; First';
            $config['first_tag_open'] = '<li class="prev page">';
            $config['first_tag_close'] = '</li>' . "\n";
            $config['last_link'] = 'Last &raquo;';
            $config['last_tag_open'] = '<li class="next page">';
            $config['last_tag_close'] = '</li>' . "\n";
            $config['next_link'] = 'Next &rarr;';
            $config['next_tag_open'] = '<li class="next page">';
            $config['next_tag_close'] = '</li>' . "\n";
            $config['prev_link'] = '&larr; Previous';
            $config['prev_tag_open'] = '<li class="prev page">';
            $config['prev_tag_close'] = '</li>' . "\n";
            $config['cur_tag_open'] = '<li class="active"><a href="">';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li class="page">';
            $config['num_tag_close'] = '</li>' . "\n";
            $config['page_query_string'] = FALSE;
            $config['total_rows'] = $all_rows / $qtt_show;
            


            $config['per_page'] = 1;
            $config['use_page_numbers'] = TRUE;
            $this->pagination->initialize($config);
            $this->products['total_rows'] = $all_rows;
            $this->products['total_pages'] =  ceil($all_rows / $qtt_show);
            

            $this->products['pagination'] = $this->pagination->create_links();


        $this->load->view('products', $this->products);
    }

    public function save_preview() {
        $img = $_POST['custom_img'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $fileData = base64_decode($img);
        $random = random_string('basic', 16);
//saving
        $fileName = './uploads/custom_tshirts/preview/custom_' . $random . '.png';
        file_put_contents($fileName, $fileData);
        $data = $this->session->userdata('preview');

        $data['custom_' . $this->input->post("side") . "_" . $this->input->post("product_id")] = array(
            "img_src" => $fileName,
            "file_name" => 'custom_' . $random . '.png',
            "product_id" => $this->input->post("product_id"),
            "color_id" => $this->input->post("color_id"),
            "size_id" => $this->input->post("size_id"),
            "side" => $this->input->post("side")
        );
        $this->session->set_userdata("preview", $data);
        echo 'success';
    }

    public function custom_tshirt() {
        if ($_FILES['client_image']['name'] != null) {
            $file_data = $this->do_upload('client_image', $this->input->post("product_id_image"));
            $data = $this->session->userdata('custom_tshirts');
            if (!isset($file_data['error'])) {

                $data[$this->input->post("product_id_image") . '-' . $_FILES['client_image']['name']] = array(
                    "img_src" => $file_data['full_path'],
                    "file_name" => $file_data['file_name'],
                    "product_id" => $this->input->post("product_id_image"),
                    "color_id" => $this->input->post("color_image_id"),
                    "size_id" => $this->input->post("size_image_id"),
                    "client_id" => ''
                );
                $this->session->set_userdata("custom_tshirts", $data);
                echo 'success';
            } else {
                print_r($file_data['error']);
            }
        } else {
            echo 'nothing';
        }
    }

    public function personalized_tshirt() {
        //GET ALL SIZES
        $this->db->where("product_id", $this->products['custom_tshirt']);
        $this->products['sizes'] = $this->db->get("ip_sizes")->result_object();
        $this->load->view("custom_tshirt", $this->products);
    }

    public function FeedGoogle() {
        $this->load->helper('file');

        @unlink('feeds/gfeed.xml');
        //SET SHOP VARIABLES
        $shop_name = "5BucksLA";
        $shop_link = "https://5bucksla.com";


//GET PRODUCTS FROM DATABASE

        $products = $this->db->get("ip_products")->result_object();

        $feed_products = [];

//LOOP THROUGH PRODUCTS
        foreach ($products as $products) {



            //CREATE EMPTY ARRAY FOR GOOGLE-FRIENDLY INFO 
            $gf_product = [];

            //FLAGS FOR LATER
            //feed attributes
            $gf_product['g:id'] = $products->product_id;
            $gf_product['g:sku'] = $products->product_id;
            $gf_product['g:title'] = $products->product_name;
            $gf_product['g:description'] = $products->product_description;
            $gf_product['g:link'] = "https://5bucksla.com/index.php/Products/product_details/" . $products->product_meta;
            $gf_product['g:image_link'] = $products->product_image_thumb;
            $gf_product['g:shipping_weight'] = 5.5;







            if (($products->product_quantity > 0) && ($products->product_price > 0)) {
                $gf_product['g:availability'] = "in stock";
            } else {
                $gf_product['g:availability'] = "out of stock";
            }

            $gf_product['g:price'] = $products->product_price . " USD";

            $gf_product['g:google_product_category'] = $products->google_category;
            //$gf_product['g:brand'] = $products->provider_name;
            //$gf_product['g:gtin'] = $products->product_sku;
            //$gf_product['g:mpn'] = $products->product_mpn;
            $gf_product['g:identifier_exists'] = "no";


            $gf_product['g:condition'] = 'NEW'; //must be NEW or USED
            //remove this IF block if you don't sell any clothing

            $gf_product['g:age_group'] = 'adult'; //newborn/infant/toddle/kids/adult
            $gf_product['g:color'] = 'White';
            $gf_product['g:gender'] = 'unisex';
            $gf_product['g:size'] = 'Large';
            $gf_product['g:tax'] = 0;


            $gf_product['g:sale_price'] = $products->product_price . " USD";
            $gf_product['g:sale_price_effective_date'] = date('Y-m-d') . " " . date('Y-m-d', strtotime("+365 days"));


            $feed_products[] = $gf_product;
        }





        $doc = new DOMDocument('1.0', 'UTF-8');

        $xmlRoot = $doc->createElement("rss");
        $xmlRoot = $doc->appendChild($xmlRoot);
        $xmlRoot->setAttribute('version', '2.0');
        $xmlRoot->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:g', "http://base.google.com/ns/1.0");

        $channelNode = $xmlRoot->appendChild($doc->createElement('channel'));
        $channelNode->appendChild($doc->createElement('title', $shop_name));
        $channelNode->appendChild($doc->createElement('link', $shop_link));

        foreach ($feed_products as $product) {
            $itemNode = $channelNode->appendChild($doc->createElement('item'));
            foreach ($product as $key => $value) {
                if ($value != "") {
                    if (is_array($product[$key])) {
                        $subItemNode = $itemNode->appendChild($doc->createElement($key));
                        foreach ($product[$key] as $key2 => $value2) {
                            $subItemNode->appendChild($doc->createElement($key2))->appendChild($doc->createTextNode($value2));
                        }
                    } else {
                        $itemNode->appendChild($doc->createElement($key))->appendChild($doc->createTextNode($value));
                    }
                } else {

                    $itemNode->appendChild($doc->createElement($key));
                }
            }
        }

        $doc->formatOutput = true;
        $gfeed = $doc->saveXML(); // put string in gfeed
//$handle = fopen(base_url()."feeds/gfeed.xml", "w");

        if (write_file("feeds/gfeed.xml", $gfeed, 'a+')) {
            echo "written";
        } else {
            echo "failed";
        }


        //GET PRODUCTS FROM DATABASE

        $products_2 = $this->db->get("ip_products");
        $products_2array = array(
            "products" => $products_2->result_object(),
            "rows" => $products_2->num_rows()
        );

        $this->load->view("gfeed", $products_2array);
        //$this->load->view("google/Resizeimages", $produtcts_2array);
    }

    public function do_upload($name, $product_id) {
        $config['upload_path'] = './uploads/custom_tshirts';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 600;
        $config['max_width'] = 1900;
        $config['max_height'] = 1600;
        $config['file_name'] = $product_id . "-" . $name . "-" . random_string('alnum', 16);

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload("$name")) {
            $error = array('error' => $this->upload->display_errors());

            return $error;
        } else {
            return $this->upload->data();
        }
    }

    public function remove_cart() {
        $product_id = $this->input->post("product_id");
        $count = count($this->session->userdata("cart"));
        $color = $this->input->post("color");
        $size = $this->input->post("size");
        $cart_qtt = 0;
        $cart_total = 0;
        $cart_to_remove_qtt = 0;
        $cart_to_remove_value = 0;
        $size_index = str_replace(" ", "_", $size);
        foreach ($this->session->userdata("cart") as $index => $data) {

            if ($product_id . '-' . $color . '-' . $size_index != $index && $count > 1) {

                $data2[$index] = array(
                    "product_id" => $data['product_id'],
                    "product_price" => $data['product_price'],
                    "product_price_total" => $data['product_price_total'],
                    "product_name" => $data['product_name'],
                    "product_description" => $data['product_description'],
                    "product_image" => $data['product_image'],
                    "product_color" => $data['product_color'],
                    "product_meta" => $data['product_meta'],
                    "product_quantity" => $data['product_quantity'],
                    "color" => $data['color'],
                    "size" => $data['size']
                );
                $this->session->set_userdata("cart", $data2);

                $cart_to_remove_qtt += $data['product_quantity'];
                $cart_to_remove_value += $data['product_price'] * $data['product_quantity'];
                //GET CART QUANTITY
                foreach ($this->session->userdata("cart") as $key => $cart_data) {
                    $cart_qtt += $cart_to_remove_qtt;
                    $cart_total += $cart_to_remove_value;
                }
                $this->session->set_userdata("cart_qtt", $cart_qtt);
                $this->session->set_userdata("cart_total", $cart_total);
                $this->session->unset_userdata("shipping");
            } else if ($count == 1) {
                $this->session->unset_userdata("cart");
            }
        }

        $this->session->unset_userdata("shipping");
    }

    public function add_cart() {
//        $this->session->sess_destroy();
//        return 0;

        $product_id = $this->input->post("product_id");
        $qtt = $this->input->post("qtt");
        $cart_color = $this->input->post("cart_color");
        $add = $this->input->post("add");
        $cart_size = $this->input->post("cart_size");
        $color_name = "";
        $size_name = "";
        $aux = 0;
        if($cart_color == -1 && $cart_size == -1)
        {
            $this->db->where("product_id", $product_id);
            $product_dimensions = $this->db->get("ip_color_sizes")->row();


            $color_name = "Does not apply";
            $size_name = "Does not apply";
            $cart_color = -1;
            $cart_size = -1;
        }else{

        //GET PRODUCT DIMENSIONS
        $this->db->join("ip_colors", "ip_colors.color_id = ip_color_sizes.color_id", "left");
        $this->db->join("ip_sizes", "ip_sizes.size_id = ip_color_sizes.size_id", "left");
        $this->db->where("ip_color_sizes.product_id", $product_id);
        $this->db->where("ip_color_sizes.size_id", $cart_size);
        $this->db->where("ip_color_sizes.color_id", $cart_color);
        $product_dimensions = $this->db->get("ip_color_sizes")->row();


            $color_name = $product_dimensions->color_name;
            $size_name = $product_dimensions->size_name;
        }

        $product_price = $this->input->post("product_price");
        $cart_qtt = 0;
        $cart_total = 0;
        $subtotal_calc = 0;
        $already = 0;
        $cart_size_index = str_replace(" ", "_", $cart_size);
        //GET PRODUCT INFO FROM ADMIN
        $this->db->where("ip_products.product_id", $product_id);
        $product_data = $this->db->get("ip_products")->result_object();
        $data = $this->session->userdata('cart');




        foreach ($product_data as $product_data) {
            if (isset($data[$product_data->product_id . '-' . $cart_color . '-' . $cart_size_index]["product_quantity"]) == 0 && $qtt < 0) {
                $qtt = 0;
            }
            if (isset($data[$product_data->product_id . '-' . $cart_color . '-' . $cart_size_index]) != null) {

                $data[$product_data->product_id . '-' . $cart_color . '-' . $cart_size_index] = array(
                    "product_id" => $product_data->product_id,
                    "product_price" => $product_price,
                    "product_price_total" => $data[$product_data->product_id . '-' . $cart_color . '-' . $cart_size_index]['product_price'] + $product_price,
                    "product_name" => $product_data->product_name,
                    "product_description" => $product_data->product_description,
                    "product_image" => $product_data->product_image,
                    "product_color" => $product_data->product_color,
                    "product_meta" => $product_data->product_meta,
                    "product_quantity" => $data[$product_data->product_id . '-' . $cart_color . '-' . $cart_size_index]['product_quantity'] + $qtt,
                    "color" => $color_name,
                    "size" => $size_name,
                    "color_id" => $cart_color,
                    "size_id" => $cart_size,
                    "lenght" => @$product_dimensions->lenght,
                    "width" => @$product_dimensions->width,
                    "height" => @$product_dimensions->height,
                    "weight" => @$product_dimensions->weight
                );
            } else {

                $data[$product_data->product_id . '-' . $cart_color . '-' . $cart_size_index] = array(
                    "product_id" => $product_data->product_id,
                    "product_price" => $product_price,
                    "product_price_total" => $product_data->product_price * $qtt,
                    "product_name" => $product_data->product_name,
                    "product_description" => $product_data->product_description,
                    "product_image" => $product_data->product_image,
                    "product_color" => $product_data->product_color,
                    "product_meta" => $product_data->product_meta,
                    "product_quantity" => $qtt,
                    "color" => $color_name,
                    "size" => $size_name,
                    "color_id" => $cart_color,
                    "size_id" => $cart_size,
                    "lenght" => @$product_dimensions->lenght,
                    "width" => @$product_dimensions->width,
                    "height" => @$product_dimensions->height,
                    "weight" => @$product_dimensions->weight
                );
            }

        }



        if ($this->session->cart_qtt >= 0) {
            $this->session->set_userdata("cart", $data);
        }

        $this->session->unset_userdata("shipping");
        //GET CART QUANTITY
        foreach ($this->session->userdata("cart") as $key => $cart_data) {
            $cart_qtt += $cart_data['product_quantity'];
            $cart_total += $cart_data['product_price'] * $cart_data['product_quantity'];
            if($aux > 0) {
            $subtotal_calc += $product_price * $cart_data['product_quantity'] - $product_price;
            }else {
            $subtotal_calc += $product_price * $cart_data['product_quantity'];
            }
            $aux++;
        }
        $this->session->set_userdata("cart_qtt", $cart_qtt);
        $this->session->set_userdata("cart_total", $cart_total);
        if ($cart_qtt == 0) {
            $this->session->unset_userdata("cart", $data);
        }
        echo $cart_qtt . "$$" . number_format($cart_total, 2) . "$$" . $already . "$$" . number_format($subtotal_calc, 2);
    }

    public function process_shipping() {
        $customer_info['Address'] = array(
            "CountryCode" => $this->input->post("client_country"),
            "PostalCode" => $this->input->post("client_zip"),
            "OrigCountry" => 'United States of America',
            "ClientName" => $this->input->post("client_name"),
            "ClientAddress" => $this->input->post("client_address_1"),
            "ClientCity" => $this->input->post("client_city"),
            "ClientState" => $this->input->post("client_state"),
            "ClientZip" => $this->input->post("client_zip"),
            "ClientCountry" => $this->input->post("client_country"),
            "ClientPhone" => $this->input->post("client_phone"),
            "ClientEmail" => $this->input->post("client_email")
        );
        $rates['rates'] = $this->get_shipping_rates($customer_info);

        $this->load->view("shipping_options", $rates);
    }

    private function get_shipping_rates($customer_info) {
        require_once(APPPATH . 'libraries/shippo-php-client-master/lib/Shippo.php');
// Replace <API-KEY> with your credentials from https://app.goshippo.com/api/
        Shippo::setApiKey('shippo_live_03279907e5f8e34e1ccef17cfa9d5dd48e2cf836');
// Example from_address array
// The complete refence for the address object is available here: https://goshippo.com/docs/reference#addresses
        $from_address = array(
            'name' => '5BucksLA',
            'company' => '5BucksLA',
            'street1' => '1403 Pioneer Dr SPC 9',
            'city' => 'Bakersfield',
            'state' => 'CA',
            'zip' => '93306',
            'country' => 'US',
            'phone' => '+1 424-332-9606',
            'email' => 'support@5bucksla.com',
        );
// Example to_address array
// The complete refence for the address object is available here: https://goshippo.com/docs/reference#addresses
        $to_address = array(
            'name' => $customer_info['Address']['ClientName'],
            'street1' => $customer_info['Address']['ClientAddress'],
            'city' => $customer_info['Address']['ClientCity'],
            'state' => $customer_info['Address']['ClientState'],
            'zip' => $customer_info['Address']['ClientZip'],
            'country' => $customer_info['Address']['ClientCountry'],
            'phone' => $customer_info['Address']['ClientPhone'],
            'email' => $customer_info['Address']['ClientEmail']
        );
// Parcel information array
// The complete reference for parcel object is here: https://goshippo.com/docs/reference#parcels
        $i = 1;
        $height = 0;
        $weight = 0;


        foreach ($this->session->userdata("cart") as $cart_dimensions) {

            $weight = ($weight + $cart_dimensions['weight']) * $cart_dimensions['product_quantity'];
            $height = $height + ($cart_dimensions['height'] + 1);

            $i++;
        }
        $parcel_1 = array(
            'length' => $cart_dimensions['lenght'],
            'width' => $cart_dimensions['width'],
            'height' => $height,
            'distance_unit' => 'cm',
            'weight' => $weight,
            'mass_unit' => 'oz',
        );



// Example shipment object
// For complete reference to the shipment object: https://goshippo.com/docs/reference#shipments
// This object has async=false, indicating that the function will wait until all rates are generated before it returns.
// By default, Shippo handles responses asynchronously. However this will be depreciated soon. Learn more: https://goshippo.com/docs/async



        $shipment = Shippo_Shipment::create(
                        array(
                            'address_from' => $from_address,
                            'address_to' => $to_address,
                            'parcels' => array($parcel_1),
                            'async' => false,
        ));

        //print_r($shipment);
// Rates are stored in the `rates` array inside the shipment object
        return $rates = $shipment['rates'];
// You can now show those rates to the user in your UI.
// Most likely you want to show some of the following fields:
//  - provider (carrier name)
//  - servicelevel_name
//  - amount (price of label - you could add e.g. a 10% markup here)
//  - days (transit time)
// Don't forget to store the `object_id` of each Rate so that you can use it for the label purchase later.
// The details on all of the fields in the returned object are here: https://goshippo.com/docs/reference#rates
        //echo "Available rates:" . "\n";
        //foreach ($rates as $rate) {
        //  echo "--> " . $rate['provider'] . " - " . $rate['servicelevel']['name'] . "\n";
        //    echo "  --> " . "Amount: " . $rate['amount'] . "\n";
        //     echo "  --> " . "Days to delivery: " . $rate['estimated_days'] . "\n";
        //}
        //echo "\n";
// This would be the index of the rate selected by the user
        //$selected_rate_index = count($rates) - 1;
// After the user has selected a rate, use the corresponding object_id
        //$selected_rate = $rates[$selected_rate_index];
        // $selected_rate_object_id = $selected_rate['object_id'];
// Purchase the desired rate with a transaction request
// Set async=false, indicating that the function will wait until the carrier returns a shipping label before it returns
        /* $transaction = Shippo_Transaction::create(array(
          'rate' => $selected_rate_object_id,
          'async' => false,
          )); */
// Print the shipping label from label_url
// Get the tracking number from tracking_number
        //if ($transaction['status'] == 'SUCCESS') {
        //return $rates;
        //echo "--> " . "Shipping label url: " . $transaction['label_url'] . "\n";
        //echo "--> " . "Shipping tracking number: " . $transaction['tracking_number'] . "\n";
        //} else {
        //echo "Transaction failed with messages:" . "\n";
        //foreach ($transaction['messages'] as $message) {
        //    echo "--> " . $message . "\n";
        //}
        // return $transaction['message'];
        //}
// For more tutorals of address validation, tracking, returns, refunds, and other functionality, check out our
// complete documentation: https://goshippo.com/docs/
    }

    public function add_shipping() {

        $this->session->set_userdata("shipping", array(
            "provider" => $this->input->post("provider"),
            "service" => $this->input->post("service"),
            "rate" => $this->input->post("rate"),
            "days" => $this->input->post("days")
        ));

        $cart_qtt = 0;
        $cart_total = 0;
        //GET CART QUANTITY
        foreach ($this->session->userdata("cart") as $key => $cart_data) {
            $cart_qtt += $cart_data['product_quantity'];
            $cart_total += ($cart_data['product_price'] * $cart_data['product_quantity']);
        }
        $cart_total += $this->input->post("rate");

        $this->session->set_userdata("cart_total", $cart_total);


        echo $this->session->cart_total;
    }

    public function product_summary($error = '') {



        $this->products['error'] = $error;

        $this->load->view('product_summary', $this->products);
    }

    public function product_categories($category_meta = null) {


        if ($category_meta != null) {


            $this->db->where("category_meta", $category_meta);

            $this->products['category'] = $this->db->get("ip_categories")->result_object();

            $this->db->where("pcategory_id", $this->products['category'][0]->category_id);
            $this->db->where("product_custom <>", "on");
            $this->db->order_by("product_id", "DESC");
            $this->products['products_category'] = $this->db->get("ip_products")->result_object();



            $this->load->view("categories", $this->products);
        } else {

            redirect('Home');
        }
    }

    public function special_offer($page = 0) {

        $category = $this->input->post("category_search");
        if ($category == '') {
            $category = 'all';
        }
        $search = explode(" ", $this->input->post("search_bar"));
        $sort = $this->input->post("sort_by");
        if ($category != 'all') {
            $this->db->where("pcategory_id", $this->input->post("category_search"));
            if ($this->input->post("search_bar") != '') {
                $this->db->like("product_name", $this->input->post("search_bar"));
            }
        } else {
            foreach ($search as $search1) {
                $this->db->or_like("product_name", $search1);
            }
        }
        if ($sort != "") {
            if ($sort == 'az') {
                $this->db->order_by("product_name", "ASC");
            } else if ($sort == 'lh') {
                $this->db->order_by("product_price", "ASC");
            } else if ($sort == 'hl') {
                $this->db->order_by("product_price", "DESC");
            }
        }
        $qtt_show = 12;
        $start = ($qtt_show * $page);
        
        
        
        $this->db->where("product_special", "on");
        $this->db->limit($qtt_show, $start);
        $this->db->order_by("product_id", "DESC");
        $this->products['specific_search'] = $this->db->get("ip_products")->result_object();
        
         if ($category != 'all') {
            $this->db->where("pcategory_id", $this->input->post("category_search"));
            if ($this->input->post("search_bar") != '') {
                $this->db->like("product_name", $this->input->post("search_bar"));
            }
        } else {
            foreach ($search as $search2) {
                $this->db->or_like("product_name", $search2);
            }
        }
        $this->db->where("product_special", "on");
        $all_rows = $this->db->get("ip_products")->num_rows() - $qtt_show;
        
        if($all_rows < 0)
        {
            $all_rows = 0;
        }
        
        $this->products['search_term'] = $this->input->post("search_bar");
        $this->products['search_category'] = $this->input->post("category_search");
        $this->products['sort'] = $sort;
        
        $this->load->library('pagination');

       //CONFIG PAGINATION

                $config['uri_segment'] = 3;
                $config['base_url'] = site_url() . '/Products/special_offer/';
         
            $config['display_pages'] = TRUE;
            $config['full_tag_open'] = '<div class="pagination" style="display:inline-block; float:left;"><ul>';
            $config['full_tag_close'] = '</ul></div><!--pagination-->';
            $config['first_link'] = '&laquo; First';
            $config['first_tag_open'] = '<li class="prev page">';
            $config['first_tag_close'] = '</li>' . "\n";
            $config['last_link'] = 'Last &raquo;';
            $config['last_tag_open'] = '<li class="next page">';
            $config['last_tag_close'] = '</li>' . "\n";
            $config['next_link'] = 'Next &rarr;';
            $config['next_tag_open'] = '<li class="next page">';
            $config['next_tag_close'] = '</li>' . "\n";
            $config['prev_link'] = '&larr; Previous';
            $config['prev_tag_open'] = '<li class="prev page">';
            $config['prev_tag_close'] = '</li>' . "\n";
            $config['cur_tag_open'] = '<li class="active"><a href="">';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li class="page">';
            $config['num_tag_close'] = '</li>' . "\n";
            $config['page_query_string'] = FALSE;
            $config['total_rows'] = $all_rows / $qtt_show;
            


            $config['per_page'] = 1;
            $config['use_page_numbers'] = TRUE;
            $this->pagination->initialize($config);
            $this->products['total_rows'] = $all_rows;
            $this->products['total_pages'] =  ceil($all_rows / $qtt_show);
            

            $this->products['pagination'] = $this->pagination->create_links();
        
        

        $this->load->view('special_offer', $this->products);
    }

    public function get_color_id() {
        $color_name = $this->input->post("color_name");
        $product_id = $this->input->post("product_id");

        $this->db->where("product_id", $product_id);
        $this->db->where("color_name", $color_name);
        $colors = $this->db->get("ip_colors")->result_object();
        echo $colors[0]->color_id;
    }

    public function get_size_id() {
        $size_name = $this->input->post("size_name");
        $product_id = $this->input->post("product_id");

        $this->db->where("product_id", $product_id);
        $this->db->where("size_name", $size_name);
        $sizes = $this->db->get("ip_sizes")->result_object();
        echo $sizes[0]->size_id;
    }

    public function update_color_size() {
        $size_id = $this->input->post("size_id");
        $product_id = $this->input->post("product_id");
        $color_id = $this->input->post("color_id");

        $this->db->join("ip_colors", "ip_colors.color_id = ip_color_sizes.color_id", "left");
        $this->db->join("ip_sizes", "ip_sizes.size_id = ip_color_sizes.size_id", "left");
        $this->db->where("ip_color_sizes.product_id", $product_id);
        $this->db->where("ip_color_sizes.color_id", $color_id);
        $this->db->where("ip_color_sizes.size_id", $size_id);
        $this->db->limit(1);
        $color_size_data = $this->db->get("ip_color_sizes")->result_object();
        if ($color_size_data == null) {
            echo "OUT OF STOCK";
        } else {
            foreach ($color_size_data as $color_size_data) {
                if ($color_size_data->color_size_quantity > 0) {
                    echo $color_size_data->color_size_quantity . " Items in stock$$" . money_format("%i", $color_size_data->color_size_price) . "$$" . $color_size_data->color_id . "$$" . $color_size_data->size_id;
                } else {
                    echo "OUT OF STOCK";
                }
            }
        }
    }

    public function product_details($product_meta) {
        if ($product_meta != "") {


            $this->db->where("product_meta", $product_meta);
            $this->products['product_details'] = $this->db->get("ip_products")->result_object();

            //GET COLORS
            $this->db->where("product_id", $this->products['product_details'][0]->product_id);
            $this->db->order_by("FIELD(color_name, 'White', 'Gray', 'Black')");
            $this->products['colors'] = $this->db->get("ip_colors")->result_object();

            //GET SIZES
            $this->db->where("product_id", $this->products['product_details'][0]->product_id);
            $this->db->order_by("FIELD(size_name, 'Small', 'Medium', 'Large', 'X Large', '2X Large', '3X Large')");
            $this->products['sizes'] = $this->db->get("ip_sizes")->result_object();


            //GET RELATED PRODUCTS
            $this->db->where("pcategory_id", $this->products['product_details'][0]->pcategory_id);
            $this->db->where("product_custom <>", 'on');
            $this->products['related_products'] = $this->db->get("ip_products")->result_object();

            $this->load->view('product_details', $this->products);
        } else {
            redirect('Home/index');
        }
    }

    /* public function compair() {
      $this->load->view('compair', $this->products);
      } */
}

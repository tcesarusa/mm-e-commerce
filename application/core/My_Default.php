<?php

class My_Default extends MX_Controller {

    var $products = array();
    
    function My_Default() {
        parent::__construct();
        //GET SETTINGS EMAIL FROM ADMIN SYSTEM
        $this->settings = $this->db->get("5b_settings")->result_object();

        if ($this->session->userdata("remember_me")) {
            $this->products['remember'] = $this->session->userdata("remember_me");
        }
        
        $this->products = array("cart_qtt" => 0, "cart_total" => 0);
        //GET CART QUANTITY
        if($this->session->userdata("cart") != null) {
            $this->products['cart_qtt'] = $this->session->cart_qtt;
            $this->products['cart_total'] =  $this->session->cart_total;
        }
        
        
        //CART SESSION
        $this->products['cart_session'] =  $this->session->userdata("cart");
        
        //TOTAL SHIPPING
        $this->products['total_shipping'] =  $this->session->shipping['rate'];
        
         
        //SIDEMENU
        $this->db->where("product_sidemenu", "on");
        $this->db->where("product_custom <>", "on");
        $this->db->order_by("product_id", "ASC");
        $this->db->limit('5');
        $this->products['sidemenu'] = $this->db->get("ip_products")->result_object();
        
        //GET SHIPPING INFO
        $this->products['shipping'] =  $this->session->userdata("shipping");
        
        //GET PRODUCTS QUANTITY
        $this->products['products_qtt'] = $this->db->get("ip_products")->num_rows();
        
        //GET CUSTOM TSHIRT
        $this->db->where("product_custom", "on");
        $this->db->limit(1);
        if($this->db->get("ip_products")->num_rows < 0) {
        $this->products['custom_tshirt'] = $this->db->get("ip_products")->row()->product_id;
        }
        //GET LOGO FROM SETTINGS
        $this->db->select("setting_value");
        $this->db->where("setting_key", "login_logo");
        $logo = $this->db->get("ip_settings")->result_object();
        $this->products['logo'] = $logo[0]->setting_value;

        $this->products['admin_db'] = $this->db;

         //GET CART DATA
        $this->products['cart_data'] = $this->session->userdata("cart");
        
        
        
        //CUSTOMER DATA
        $this->db->where("client_id", $this->session->userdata('user_data')['client_id']);
        $this->products['client_data'] = $this->db->get("ip_clients")->result_object();
        
        //COUNTRY LIST
        $this->products['country_list'] = $this->db->get("ip_countries")->result_object();
        
         //STATE LIST
        $this->products['state_list'] = $this->db->get("ip_states")->result_object();
        
        

        $this->db->select("setting_value");
        $this->db->where("setting_key", "login_logo");
        $logo = $this->db->get("ip_settings")->result_object();
        $this->products['logo'] = $logo[0]->setting_value;

        $this->db->where("product_featured", "on");
        $this->db->where("product_custom <>", "on");
        $this->db->order_by("product_id", "DESC");
        $this->products['products_featured'] = $this->db->get("ip_products")->result_object();
        
        
        //GET SPECIAL PRODUCTS
        $this->db->where("product_special", "on");
        $this->db->where("product_custom <>", "on");
        $this->db->order_by("product_id", "DESC");
        $this->products['products_special'] = $this->db->get("ip_products")->result_object();

        //GET FEATURED PRODUCTS QUANTITY
        $this->db->where("product_featured", "on");
        $this->db->where("product_custom <>", "on");
        $this->products['products_featured_quantity'] = $this->db->get("ip_products")->num_rows();

        $this->db->where("product_custom <>", "on");
        $this->db->order_by("product_id", "DESC");
        $this->products['products'] = $this->db->get("ip_products")->result_object();
        
        
        
        $this->db->where("product_custom <>", "on");
        $this->db->order_by("product_id", "DESC");
        $this->db->limit(10);
        $this->products['latest_products'] = $this->db->get("ip_products")->result_object();

        $this->db->where("category_parent", 0);
        $this->db->order_by("category_name");
        $this->products['categories'] = $this->db->get("ip_categories")->result_object();

        $this->db->where("category_parent", 0);
        $this->products['categories_quantity'] = $this->db->get("ip_categories")->num_rows();
        
        
        //LOAD CATEGORY TREE USIN WEBIX
        
        $this->products['category_tree'] = json_encode($this->getfirstmenu(0));
    }
    
     

    private function getfirstmenu($wsc_parent) {
        
       
        $this->db->where("category_parent", $wsc_parent);
        $this->db->order_by("category_name", "ASC");
        $categories = $this->db->get("ip_categories")->result_object();


        foreach ($categories as $categories_totree) {
            
            $this->db->where("pcategory_id", $categories_totree->category_id);
            $this->db->where("product_custom <>", "on");
            $child_qtt = $this->db->get("ip_products")->num_rows();

            $data_final[] = array(
                "id" => $categories_totree->category_meta."*_category_*",
                "value" => $categories_totree->category_name."($child_qtt)",
                "submenu" => $this->getsubmenu($categories_totree->category_id),
                "icon" => "folder"
            );
        }


        $data = $data_final;
        $data = str_replace("][", ",", $data_final);

        return $data;
    }
    
    private function getsubmenu($wsc_parent) {
        $submenu = array();
        $this->db->where("category_parent", $wsc_parent);
        $this->db->order_by("category_name","ASC");
        $categories2 = $this->db->get("ip_categories")->result_object();
        
        if ($categories2 != null) {
            foreach ($categories2 as $categories2) {
                $this->db->where("pcategory_id", $categories2->category_id);
                $this->db->where("product_custom <>", "on");
                $child_qtt = $this->db->get("ip_products")->num_rows();
                $submenu[] = array(
                    "id" => $categories2->category_meta."*_category_*",
                    "value" => $categories2->category_name."($child_qtt)",
                    "submenu" => $this->getsubmenu($categories2->category_id),
                    "icon" => "folder"
                );
                
            }
            
        } else {
                $this->db->where("pcategory_id", $wsc_parent);
                $this->db->where("product_custom <>", "on");
                $this->db->order_by("product_name", "ASC");
                $products = $this->db->get("ip_products")->result_object();
                foreach ($products as $products) {
                    $submenu[] = array(
                        "id" => $products->product_meta."*_product_*",
                        "value" => $products->product_name,
                        "icon" => "tag"
                    );
                }
        }
        return $submenu;
    }

}

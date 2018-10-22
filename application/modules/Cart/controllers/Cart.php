<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends My_Default {

    public function checkout() {
        if ($this->session->userdata("cart") != null) {
            if ($this->products['cart_total'] != 0 && $this->products['cart_qtt'] != 0 && $this->products['total_shipping'] != 0) {

                if ($this->input->post() != null) {
                    $shipping_address = array(
                        "client_name" => $this->input->post("client_name"),
                        "client_email" => $this->input->post('client_email'),
                        "client_phone" => $this->input->post('client_phone'),
                        "client_address_1" => $this->input->post('client_address_1'),
                        "client_address_2" => $this->input->post('client_address_2'),
                        "client_city" => $this->input->post('client_city'),
                        "client_state" => $this->input->post('client_state'),
                        "client_zip" => $this->input->post('client_zip'),
                        "client_country" => $this->input->post('client_country')
                    );
                    $this->session->set_userdata("shipping_address", $shipping_address);
                }
                $this->load->view("process_cart", $this->products);
            } else {
                echo "here";
                redirect('Customer_products/product_summary/error');
            }
        } else {
            redirect('Home');
        }
    }

    public function process_payment() {
        $payment_method = $this->input->post("payment_method");
        $i = 0;
        $subtotal = 0;


        $total_amount = $this->products['cart_total'];
        $total_amount = str_replace(".", "", $total_amount);

        $client_data = array(
            "stripeToken" => $this->input->post("token"),
            "cart_total" => $total_amount
        );

        if ($payment_method == 'paypal') {

            $this->foward_paypal();
        } else if ($payment_method == 'credit_card') {
            if ($this->process_creditcard($client_data) == "paid") {
                //CREATE THE INVOICE  ON INVOICE_PLANE
                $this->db->order_by("invoice_id", "DESC");
                $this->db->limit("1");
                $last_invoice = $this->db->get("ip_invoices")->result_object();
                if ($last_invoice == null) {
                    $last_invoice_number = 1;
                } else {
                    $last_invoice_number = ($last_invoice[0]->invoice_number + 1);
                }

                $this->db->where("payment_method_name", "paypal");
                $payment_method = $this->db->get("ip_payment_methods")->result_object();
                $payment_method = $payment_method[0]->payment_method_id;




                //INSERT INTO IP_INVOICES
                $invoice = array(
                    "user_id" => 1,
                    "client_id" => $this->session->userdata("user_data")['client_id'],
                    "invoice_group_id" => 3,
                    "invoice_status_id" => 4,
                    "invoice_date_created" => date("Y-m-d"),
                    "invoice_time_created" => date("H:i:s"),
                    "invoice_date_modified" => date("Y-m-d H:i:s"),
                    "invoice_number" => $last_invoice_number,
                    "invoice_url_key" => random_string('alnum', 16),
                    "payment_method" => $payment_method
                );


                $this->db->insert("ip_invoices", $invoice);
                $invoice_id = $this->db->insert_id();

                foreach ($this->session->userdata("cart") as $subtotal_items) {
                    $subtotal += $subtotal_items['product_price'] * $subtotal_items['product_quantity'];
                }

                //INSERT INTO IP_INVOICE_AMOUNTS
                $invoice_amount = array(
                    "invoice_id" => $invoice_id,
                    "invoice_item_subtotal" => $subtotal + $this->products['total_shipping'],
                    "invoice_total" => $this->products['cart_total'],
                    "invoice_balance" => $this->products['cart_total']
                );
                $this->db->insert("ip_invoice_amounts", $invoice_amount);


                foreach ($this->session->userdata("cart") as $cart) {


                    //INSERT INTO IP_INVOICE_ITEMS
                    if (isset($this->session->userdata("preview")['custom_front_' . $cart['product_id']])) {
                        $preview_src = $this->session->userdata("preview")['custom_front_' . $cart['product_id']]['file_name'];
                    }

                    if (isset($this->session->userdata("preview")['custom_back_' . $cart['product_id']])) {
                        $preview_src_back = $this->session->userdata("preview")['custom_back_' . $cart['product_id']]['file_name'];
                    }
                    if ($this->session->userdata("custom_tshirts") != null) {
                        foreach ($this->session->userdata("custom_tshirts") as $custom_tshirts) {
                            if ($custom_tshirts['product_id'] == $cart['product_id']) {
                                $custom_image = $custom_tshirts['file_name'];
                            }
                        }
                    }
                    $invoice_items = array(
                        "invoice_id" => $invoice_id,
                        "item_date_added" => date("Y-m-d"),
                        "item_name" => $cart['product_name'],
                        "item_description" => $cart['product_name'] . " - color:" . $cart['color'] . " - size:" . $cart['size'],
                        "item_product_id" => $cart['product_id'],
                        "item_quantity" => $cart['product_quantity'],
                        "item_price" => $cart['product_price'],
                        "item_image_preview" => $preview_src,
                        "item_custom_image" => $custom_image,
                        "item_image_preview_back" => $preview_src_back
                    );
                    $this->db->insert("ip_invoice_items", $invoice_items);
                    $item_id = $this->db->insert_id();


                    //MANAGE THE IMAGES FROM THE SESSION
                    foreach ($this->session->userdata("custom_tshirts") as $t_shirts) {
                        $b_images = array(
                            "image_link" => $t_shirts['img_src'],
                            "product_id" => $t_shirts['product_id'],
                            "color_id" => $t_shirts['color_id'],
                            "size_id" => $t_shirts['size_id'],
                            "invoice_id" => $invoice_id,
                            "file_name" => $t_shirts['file_name'],
                            "invoice_item_id" => $item_id
                        );

                        $this->db->where("product_id", $cart['product_id']);
                        $this->db->where("color_id", $t_shirts['color_id']);
                        $this->db->where("size_id", $t_shirts['size_id']);
                        $this->db->where("invoice_id", $invoice_id);
                        $check = $this->db->get("5b_images")->num_rows();
                        if ($check == 0) {
                            $this->db->insert("5b_images", $b_images);
                        }
                    }
                    $this->db->where("color_name", $cart['color']);
                    $this->db->where("product_id", $cart['product_id']);
                    $color_id = $this->db->get("ip_colors")->result_object();
                    $color_id = $color_id[0]->color_id;

                    $this->db->where("size_name", $cart['size']);
                    $this->db->where("product_id", $cart['product_id']);
                    $size_id = $this->db->get("ip_sizes")->result_object();
                    $size_id = $size_id[0]->size_id;

                    $this->db->where("color_id", $color_id);
                    $this->db->where("size_id", $size_id);
                    $this->db->where("product_id", $cart['product_id']);
                    $this->db->where("invoice_id", $invoice_id);
                    $images_data = $this->db->get("5b_images")->result_object();
                    if (isset($images_data)) {
                        if ($images_data != null) {
                            $this->db->set("item_color", $color_id);
                            $this->db->set("item_size", $size_id);
                            $this->db->set("item_image", $images_data[0]->image_link);
                            $this->db->set("item_image_name", base_url() . "uploads/custom_tshirts/" . $images_data[0]->file_name);
                            $this->db->where("item_id", $item_id);
                            $this->db->update("ip_invoice_items");
                        }
                    }


                    //REMOVE FROM PRODUCT QUANTITY
                    $this->db->where("product_id", $cart['product_id']);
                    $get_qtt = $this->db->get("ip_products")->result_object();
                    $get_qtt = $get_qtt[0]->product_quantity;

                    $this->db->set("product_quantity", $get_qtt - $cart['product_quantity']);
                    $this->db->where("product_id", $cart['product_id']);
                    $this->db->update("ip_products");

                    $invoice_item_amounts = array(
                        "item_id" => $item_id,
                        "item_subtotal" => $cart['product_price'] * $cart['product_quantity'],
                        "item_total" => $cart['product_price'] * $cart['product_quantity']
                    );
                    //INSERT INTO IP_INVOICE_ITEM_AMOUNTS
                    $this->db->insert("ip_invoice_item_amounts", $invoice_item_amounts);


                    $i++;
                }

                //INSERT INTO IP_INVOICE_ITEMS
                $invoice_items_shipping = array(
                    "invoice_id" => $invoice_id,
                    "item_date_added" => date("Y-m-d"),
                    "item_name" => $this->products['shipping']['provider'] . ' ' . $this->products['shipping']['service'] . ' - Shipping ' . $this->products['shipping']['days'] . ' days',
                    "item_description" => $this->products['shipping']['provider'] . ' ' . $this->products['shipping']['service'] . ' - Shipping ' . $this->products['shipping']['days'] . ' days',
                    "item_quantity" => 1,
                    "item_price" => $this->products['total_shipping']
                );
                $this->db->insert("ip_invoice_items", $invoice_items_shipping);
                $item_id_shipping = $this->db->insert_id();

                $invoice_item_amounts = array(
                    "item_id" => $item_id_shipping,
                    "item_subtotal" => $this->products['total_shipping'],
                    "item_total" => $this->products['total_shipping']
                );
                //INSERT INTO IP_INVOICE_ITEM_AMOUNTS
                $this->db->insert("ip_invoice_item_amounts", $invoice_item_amounts);


                //GET PAYMENT METHOD ID
                $this->db->where("payment_method_name", "Credit Card");
                $payment_method_name = $this->db->get("ip_payment_methods")->result_object();

                //INSERT PAYMENT
                $payment = array(
                    "invoice_id" => $invoice_id,
                    "payment_method_id" => $payment_method_name[0]->payment_method_id,
                    "payment_date" => date("Y-m-d"),
                    "payment_amount" => $this->products['cart_total'],
                    "payment_note" => "Automatic payment from website"
                );

                $this->db->insert("ip_payments", $payment);

                //SEND EMAIL TO THE CUSTOMER
                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                $config['charset'] = 'utf-8';
                $config['wordwrap'] = TRUE;
                $config['mailtype'] = 'html';
                $this->email->initialize($config);
                $this->email->from($this->settings[0]->payments_email, '5BucksLA Online T-Shirt Store');
                $this->email->to($this->session->userdata("shipping_address")['client_email']);

                $this->email->subject('Your order number #' . $last_invoice_number . ' has been placed');
                $this->email->message('Thank you!<br>Your order number #' . $last_invoice_number . ' has been received, your items will be shipped shortly.<br>If you have any questions, please reply this email.<br> Do not forget to follow your order status through our customer dashboard.');

                $this->email->send();

                //CLEANING THE CART KEEPING USER ALIVE
                $this->session->unset_userdata('cart');
                $this->session->unset_userdata('cart_total');
                $this->session->unset_userdata('cart_qtt');
                $this->session->unset_userdata("shipping_total");
                $this->session->unset_userdata("custom_tshirts");

                $this->order_received();
            } else {
                redirect('Cart/checkout');
            }
        } else {
            redirect('Home');
        }
    }

    private function order_received() {
        $this->load->view("order_received", $this->products);
    }

    private function process_creditcard($client_data = null) {
        try {
            require_once(APPPATH . 'libraries/stripe/init.php'); //or yours
            \Stripe\Stripe::setApiKey("sk_live_PdaMBYx8Is8U9BYZkYXlJcoO"); //Replace with your Secret Key




            $charge = \Stripe\Charge::create(array(
                        "amount" => $client_data['cart_total'],
                        "currency" => "usd",
                        "card" => $client_data['stripeToken'],
                        "description" => "5bucksla Transaction"
            ));

            return "paid";

            //SEND INVOICE HERE
        } catch (Stripe_CardError $e) {
            return $e;
        } catch (Stripe_InvalidRequestError $e) {
            return $e;
        } catch (Stripe_AuthenticationError $e) {
            return $e;
        } catch (Stripe_ApiConnectionError $e) {
            return $e;
        } catch (Stripe_Error $e) {
            return $e;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function paypal_return() {
        redirect('Home');
    }

    public function foward_paypal() {

        if ($this->session->userdata("shipping_address") != null && $this->session->userdata("cart") != null) {
            $i = 1;
            $subtotal = 0;
// Prepare GET data
            $query = array();
            $query['charset'] = "utf-8";
            $query['currency'] = "USD";
            $query['notify_url'] = 'http://5bucksla.com/index.php/Cart/paypal_return/';
            $query['cmd'] = '_cart';
            $query['cart_id'] = "13-14";
            $query['upload'] = '1';
            $query['business'] = $this->settings[0]->payments_email;
            $query['address_override'] = '1';
            $query['first_name'] = $this->session->userdata("shipping_address")['client_name'];
            //$query['last_name'] = $client_data['client_lastname'];
            $query['email'] = $this->session->userdata("shipping_address")['client_email'];
            $query['address1'] = $this->session->userdata("shipping_address")['client_address_1'];
            $query['city'] = $this->session->userdata("shipping_address")['client_city'];
            $query['state'] = $this->session->userdata("shipping_address")['client_state'];
            $query['zip'] = $this->session->userdata("shipping_address")['client_zip'];
            $query['no_shipping'] = 1;






            $query['return'] = 'http://5bucksla.com/index.php/Cart/paypal_return/';
            $query['cancel_return'] = site_url('/Cart/process_payment');




            //CREATE THE INVOICE  ON INVOICE_PLANE
            $this->db->order_by("invoice_id", "DESC");
            $this->db->limit("1");
            $last_invoice = $this->db->get("ip_invoices")->result_object();
            if ($last_invoice == null) {
                $last_invoice_number = 1;
            } else {
                $last_invoice_number = ($last_invoice[0]->invoice_number + 1);
            }

            $this->db->where("payment_method_name", "paypal");
            $payment_method = $this->db->get("ip_payment_methods")->result_object();
            $payment_method = $payment_method[0]->payment_method_id;




            if ($this->input->get('st') == 'pending') {
                $invoice_status_id = 5;
            } else if ($this->input->get('st') != 'pending') {
                $invoice_status_id = 3;
            }

            //INSERT INTO IP_INVOICES
            $invoice = array(
                "user_id" => 1,
                "client_id" => $this->session->userdata("user_data")['client_id'],
                "invoice_group_id" => 3,
                "invoice_status_id" => $invoice_status_id,
                "invoice_date_created" => date("Y-m-d"),
                "invoice_time_created" => date("H:i:s"),
                "invoice_date_modified" => date("Y-m-d H:i:s"),
                "invoice_number" => $last_invoice_number,
                "invoice_url_key" => random_string('alnum', 16),
                "payment_method" => $payment_method
            );



            $this->db->insert("ip_invoices", $invoice);
            $invoice_id = $this->db->insert_id();

            foreach ($this->session->userdata("cart") as $subtotal_items) {
                $subtotal += $subtotal_items['product_price'] * $subtotal_items['product_quantity'];
            }

            //INSERT INTO IP_INVOICE_AMOUNTS
            $invoice_amount = array(
                "invoice_id" => $invoice_id,
                "invoice_item_subtotal" => $subtotal + $this->products['total_shipping'],
                "invoice_total" => $this->products['cart_total'],
                "invoice_balance" => $this->products['cart_total']
            );
            $this->db->insert("ip_invoice_amounts", $invoice_amount);


            foreach ($this->session->userdata("cart") as $cart) {
                $query['item_name_' . $i] = $cart['product_name'] . " - color:" . $cart['color'] . " - size:" . $cart['size'];
                $query['quantity_' . $i] = $cart['product_quantity'];
                $query['amount_' . $i] = $cart['product_price'];

                //INSERT INTO IP_INVOICE_ITEMS
                if (isset($this->session->userdata("preview")['custom_front_' . $cart['product_id']])) {
                    $preview_src = $this->session->userdata("preview")['custom_front_' . $cart['product_id']]['file_name'];
                }else{
                    $preview_src = 0;
                }

                if (isset($this->session->userdata("preview")['custom_back_' . $cart['product_id']])) {
                    $preview_src_back = $this->session->userdata("preview")['custom_back_' . $cart['product_id']]['file_name'];
                }else{
                    $preview_src_back = 0;
                }
                if ($this->session->userdata("custom_tshirts") != null) {
                    foreach ($this->session->userdata("custom_tshirts") as $custom_tshirts) {
                        if ($custom_tshirts['product_id'] == $cart['product_id']) {
                            $custom_image = $custom_tshirts['file_name'];
                        }
                    }
                }else{
                    $custom_image = 0;
                }


                $invoice_items = array(
                    "invoice_id" => $invoice_id,
                    "item_date_added" => date("Y-m-d"),
                    "item_name" => $cart['product_name'],
                    "item_description" => $cart['product_name'] . " - color:" . $cart['color'] . " - size:" . $cart['size'],
                    "item_product_id" => $cart['product_id'],
                    "item_quantity" => $cart['product_quantity'],
                    "item_price" => $cart['product_price'],
                    "item_image_preview" => $preview_src,
                    "item_custom_image" => $custom_image,
                    "item_image_preview_back" => $preview_src_back
                );

                $this->db->insert("ip_invoice_items", $invoice_items);
                $item_id = $this->db->insert_id();
                if($this->session->userdata("custom_tshirts") != null) {
                foreach ($this->session->userdata("custom_tshirts") as $t_shirts) {



                    $b_images = array(
                        "image_link" => $t_shirts['img_src'],
                        "product_id" => $t_shirts['product_id'],
                        "color_id" => $t_shirts['color_id'],
                        "size_id" => $t_shirts['size_id'],
                        "invoice_id" => $invoice_id,
                        "file_name" => $t_shirts['file_name'],
                        "invoice_item_id" => $item_id
                    );

                    $this->db->where("product_id", $cart['product_id']);
                    $this->db->where("color_id", $t_shirts['color_id']);
                    $this->db->where("size_id", $t_shirts['size_id']);
                    $this->db->where("invoice_id", $invoice_id);
                    $check = $this->db->get("5b_images")->num_rows();
                    if ($check == 0) {
                        $this->db->insert("5b_images", $b_images);
                    }
                }
                }
                $color_id = $cart['color_id'];
                $size_id = $cart['size_id'];

                $this->db->where("color_id", $color_id);
                $this->db->where("size_id", $size_id);
                $this->db->where("product_id", $cart['product_id']);
                $this->db->where("invoice_id", $invoice_id);
                $images_data = $this->db->get("5b_images")->result_object();
                if (isset($images_data)) {
                    if ($images_data != null) {
                        $this->db->set("item_color", $color_id);
                        $this->db->set("item_size", $size_id);
                        $this->db->set("item_image", $images_data[0]->image_link);
                        $this->db->set("item_image_name", base_url() . "uploads/custom_tshirts/" . $images_data[0]->file_name);
                        $this->db->where("item_id", $item_id);
                        $this->db->update("ip_invoice_items");
                    }
                }

                $invoice_item_amounts = array(
                    "item_id" => $item_id,
                    "item_subtotal" => $cart['product_price'] * $cart['product_quantity'],
                    "item_total" => $cart['product_price'] * $cart['product_quantity']
                );
                //INSERT INTO IP_INVOICE_ITEM_AMOUNTS
                $this->db->insert("ip_invoice_item_amounts", $invoice_item_amounts);


                $i++;
            }

            //INSERT INTO IP_INVOICE_ITEMS SHIPPING
            $invoice_items_shipping = array(
                "invoice_id" => $invoice_id,
                "item_date_added" => date("Y-m-d"),
                "item_name" => $this->products['shipping']['provider'] . ' ' . $this->products['shipping']['service'] . ' - Shipping ' . $this->products['shipping']['days'] . ' days',
                "item_description" => $this->products['shipping']['provider'] . ' ' . $this->products['shipping']['service'] . ' - Shipping ' . $this->products['shipping']['days'] . ' days',
                "item_quantity" => 1,
                "item_price" => $this->products['total_shipping']
            );
            $this->db->insert("ip_invoice_items", $invoice_items_shipping);
            $item_id_shipping = $this->db->insert_id();

            $invoice_item_amounts = array(
                "item_id" => $item_id_shipping,
                "item_subtotal" => $this->products['total_shipping'],
                "item_total" => $this->products['total_shipping']
            );
            //INSERT INTO IP_INVOICE_ITEM_AMOUNTS
            $this->db->insert("ip_invoice_item_amounts", $invoice_item_amounts);


            $query['item_name_' . $i] = $this->products['shipping']['provider'] . ' ' . $this->products['shipping']['service'] . ' - Shipping ' . $this->products['shipping']['days'] . ' days';
            $query['quantity_' . $i] = 1;
            $query['amount_' . $i] = $this->products['total_shipping'];




            //SEND EMAIL TO THE CUSTOMER
            $config['protocol'] = 'sendmail';
            $config['mailpath'] = '/usr/sbin/sendmail';
            $config['charset'] = 'utf-8';
            $config['wordwrap'] = TRUE;
            $config['mailtype'] = 'html';
            $this->email->initialize($config);
            $this->email->from($this->settings[0]->payments_email, '5BucksLA Online T-Shirt Store');
            $this->email->to($this->session->userdata("shipping_address")['client_email']);

            $this->email->subject('Your order number #' . $last_invoice_number . ' has been placed');
            $this->email->message('Thank you!<br>Your order number #' . $last_invoice_number . ' has been received, your items will be shipped shortly.<br>If you have any questions, please reply this email.<br> Do not forget to follow your order status through our customer dashboard.');

            $this->email->send();

            $this->session->unset_userdata('cart');
            $this->session->unset_userdata('cart_total');
            $this->session->unset_userdata('cart_qtt');
            $this->session->unset_userdata("shipping_total");
            $this->session->unset_userdata("custom_tshirts");


            echo "https://www.paypal.com/cgi-bin/webscr?" . http_build_query($query);
            //echo "https://www.sandbox.paypal.com/cgi-bin/webscr?" . http_build_query($query);
        } else {
            echo "problem";
        }
    }

}

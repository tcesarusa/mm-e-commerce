<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_dashboard extends My_Default {

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
   

    public function index() {
        if (is_logged_in() == true) {

            //GET CUSTOMER ODERS(INVOICES)
            $this->db->join("ip_invoice_amounts", "ip_invoice_amounts.invoice_id = ip_invoices.invoice_id");
            $this->db->join("ip_clients", "ip_clients.client_id = ip_invoices.client_id");
            $this->db->where("ip_invoices.client_id", $this->session->userdata('user_data')['client_id']);
            $this->db->order_by("ip_invoices.invoice_id", "desc");
            $this->products['orders'] = $this->db->get("ip_invoices")->result_object();
            
            
            $this->db->where("client_id", $this->session->userdata('user_data')['client_id']);
            $this->products['customer_data'] = $this->db->get("ip_clients")->result_object();
            
            

            $this->load->view('dashboard', $this->products);
        } else {
            redirect('Customer_sessions/login_page');
        }
    }
    
    public function show_invoice()
    {
        $invoice_id = $this->input->post("invoice_id");
        $this->db->join("ip_invoice_amounts", "ip_invoice_amounts.invoice_id = ip_invoices.invoice_id");
        $this->db->join("ip_payment_methods", "ip_payment_methods.payment_method_id = ip_invoices.payment_method");
        $this->db->where("ip_invoices.invoice_id", $invoice_id);
        $invoice_data['invoice_data'] = $this->db->get("ip_invoices")->result_object();
        $this->load->view("invoice_data", $invoice_data);
    }
    
    public function edit_customer()
    {
        
        $client_array = array(
            "client_name" => $this->input->post("client_name"),
            "client_email" => $this->input->post("client_email"),
            "client_phone" => $this->input->post("client_phone"),
            "client_address_1" => $this->input->post("client_address_1"),
            "client_address_2" => $this->input->post("client_address_2"),
            "client_city" => $this->input->post("client_city"),
            "client_state" => $this->input->post("client_state"),
            "client_zip" => $this->input->post("client_zip"),
            "client_country" => $this->input->post("client_country")
        );
        
        
        $this->db->where("client_id", $this->input->post("client_id"));
        if($this->db->update("ip_clients", $client_array)){
            echo "saved";
        }
    }

}

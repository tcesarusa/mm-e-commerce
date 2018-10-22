<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_sessions extends My_Default {

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
    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $error_login = 0;
        
    }

    public function index() {
        $this->load->view('login');
    }

    public function logout() {
        //$this->session->sess_destroy();
        $this->session->unset_userdata("user_data");


        if (is_logged_in() == true) {
            redirect("Customer_dashboard");
        } else {
            redirect("Customer_sessions/login_page");
        }
    }

    public function register($cart = '') {
        $client_email = $this->input->post("client_email");

        $this->products['client_email'] = $client_email;


        $this->products['cart'] = $cart;

        $this->load->view('register', $this->products);
    }

    public function add_customer() {
        if (isset($_REQUEST)) {

            $user_data = array(
                "user_email" => $this->input->post("customer_email"),
                "user_name" => $this->input->post("customer_email"),
                "password" => md5($this->input->post("customer_password"))
            );
            $customer_data = array(
                "client_name" => $this->input->post("firstname") . " " . $this->input->post("lastname"),
                "client_address_1" => $this->input->post("customer_address1"),
                "client_address_2" => $this->input->post("customer_address2"),
                "client_city" => $this->input->post("customer_address2"),
                "client_state" => $this->input->post("customer_state"),
                "client_zip" => $this->input->post("customer_zip"),
                "client_country" => $this->input->post("customer_country"),
                "client_phone" => $this->input->post("customer_phone"),
                "client_email" => $this->input->post("customer_email"),
                "client_birthdate" => $this->input->post("birth_year") . "-" . $this->input->post("birth_month") . "-" . $this->input->post("birth_day")
            );



            if ($this->db->insert("ip_clients", $customer_data)) {
                $client_id = $this->db->insert_id();

                if ($this->db->insert("5b_users", $user_data)) {
                    $user_id = $this->db->insert_id();
                    $this->session->set_userdata('user_data', array(
                        'username' => $user_data['user_email'],
                        'user_id' => $user_id,
                        'email' => $user_data['user_email'],
                        'client_name' => $this->input->post("firstname") . " " . $this->input->post("lastname"),
                        'client_id' => $client_id,
                        'logged_in' => TRUE
                    ));

                    if (is_logged_in() == true) {
                        if ($this->input->post("cart") == 'cart') {
                            redirect("Customer_products/product_summary");
                        } else {
                            redirect("Customer_dashboard");
                        }
                    } else {
                        redirect("Customer_sessions/login_page");
                    }
                }
            } else {
                echo "Problem to inser new client.";
            }
        } else {
            echo 'Fields with * are required, please check.';
        }
    }

    public function login_page($error_login = 0) {
        
        $this->products['error_login'] = $error_login;
       


        if (is_logged_in() == true) {
            redirect('Dashboard');
        } else {
            $this->load->view('login', $this->products);
        }
    }

    public function do_login($cart = '') {
        $user_password = md5($this->input->post("user_password"));
        $user_email = $this->input->post("user_email");
        $remember = $this->input->post("remember");

        if ($remember) {
            $this->session->set_userdata("remember_me", true);
        }

        //GET USER INFORMATION
        $this->db->where("user_email", $user_email);
        $this->db->where("password", $user_password);
        $user_info = $this->db->get("5b_users")->result_object();



        if ($user_info != null) {
            foreach ($user_info as $user_info) {
                //GET CUSTOMER INFORMATION
                $this->db->where("client_email", $user_info->user_email);
                $client_data = $this->db->get("ip_clients")->result_object();

                $this->session->set_userdata('user_data', array(
                    'username' => $user_email,
                    'user_id' => $user_info->user_id,
                    'email' => $user_email,
                    'client_name' => $client_data[0]->client_name,
                    'client_id' => $client_data[0]->client_id,
                    'logged_in' => TRUE
                ));

                if (is_logged_in() == true) {
                    if ($cart == 'cart') {
                        redirect("Customer_products/product_summary");
                    } else {
                        redirect("Customer_dashboard");
                    }
                } else {
                    redirect("Customer_sessions/login_page");
                }
            }
        } else {
            $error_login = 1;
            redirect("Customer_sessions/login_page/" . $error_login);
        }
    }

    public function check_session() {
        if (is_logged_in() == true) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function change_password() {
        $user_id = $this->session->userdata("user_data")['user_id'];
        $old_password = md5($this->input->post("old_password"));
        $new_password = md5($this->input->post("new_password"));
        $new_password_confirm = md5($this->input->post("new_password_confirm"));


        $this->db->where("user_id", $user_id);
        $this->db->where("password", $old_password);
        $match_user = $this->db->get("5b_users")->num_rows();
        if ($match_user > 0) {
            if ($new_password == $new_password_confirm) {
                $this->db->set("password", $new_password);
                $this->db->where("user_id", $user_id);
                if ($this->db->update("5b_users")) {
                    echo "success";
                } else {
                    echo "Problem to update.";
                }
            } else {
                echo "New passwords doesn't match.";
            }
        } else {
            echo "Old password is invalid.";
        }
    }

    public function forget_password($error = 0) {

        $this->products['error'] = $error;

        $this->load->view("forgetpass", $this->products);
    }

    public function reset_password() {
        $user_email = $this->input->post("user_email");

        $this->db->where("user_email", $user_email);
        $check_user = $this->db->get("5b_users")->num_rows();
        if ($check_user > 0) {

            //CREATE A NEW PASSWORD AND SEND TO CUSTOMER EMAIL
            $password = random_string('alnum', 16);

            $this->db->where("user_email", $user_email);
            $this->db->set("password", md5($password));
            if ($this->db->update("5b_users")) {



                //SEND THE EMAIL WITH THE NEW PASSWORD
                $this->email->from($this->settings[0]->support_email, '5BucksLA');
                $this->email->to($user_email);

                $this->email->subject('Password reset');
                $this->email->message('Your password has been reset, you can now access your account using username ' 
                        . $user_email . ' and password ' . $password);

                $this->email->send();
            }
            $this->products['error'] = 2;


            $this->load->view("forgetpass", $this->products);
        } else {
            redirect('Customer_sessions/forget_password/1');
        }
    }

}

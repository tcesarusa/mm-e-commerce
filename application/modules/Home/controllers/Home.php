<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends My_Default {

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
        
        $this->load->view('index', $this->products);
    }

    public function contact($success = '') {

        $this->products['email_success'] = $success;
        $this->load->view('contact', $this->products);
    }

    public function send_contact() {
        $name = $this->input->post("name");
        $email = $this->input->post("email");
        $subject = $this->input->post("subject");
        $content = $this->input->post("content");

        $this->email->from($email, $name);
        $this->email->to($this->settings[0]->support_email);

        $this->email->subject($subject);
        $this->email->message($content);

        $this->email->send();
        redirect('Home/contact/success');
    }

    /*
      public function legal_notice() {
      $this->load->view('legal_notice', $this->products);
      }

      public function terms_conditions() {
      $this->load->view('tac', $this->products);
      }
     */
}

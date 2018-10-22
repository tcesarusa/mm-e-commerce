<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends My_Default {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function return_policy()
        {
            $this->load->view("return_policy", $this->products);
        }
        
        public function terms_and_conditions()
        {
            $this->load->view("terms_and_conditions", $this->products);
        }
        
        public function privacy_policy()
        {
            $this->load->view("privacy_policy", $this->products);
        }
        
       
       
}

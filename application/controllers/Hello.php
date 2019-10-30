<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hello extends CI_Controller {
    public function index($nip)
	{
		echo "Nip : ".$nip;
    }
    
    public function about(){
        $this->load->view('welcome_message');
    }
}


?>
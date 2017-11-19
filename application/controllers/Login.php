<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
        $data["judul"] = "Login System";
        $data["page"] = "login/login";
        $this->load->view("loginTemplate/_header",$data);
        $this->load->view("loginTemplate/_content",$data);
        $this->load->view("loginTemplate/_footer");
  }

}

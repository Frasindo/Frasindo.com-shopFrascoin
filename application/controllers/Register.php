<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	public function index()
	{
        $data["judul"] = "Register";
        $data["page"] = "login/register";
        $this->load->view("loginTemplate/_header",$data);
        $this->load->view("loginTemplate/_content",$data);
        $this->load->view("loginTemplate/_footer");
    }
}
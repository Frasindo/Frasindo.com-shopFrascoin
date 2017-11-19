<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Freecar extends CI_Controller {
  public function __construct()
  {
      parent::__construct();
  }
	public function index()
	{
    if($this->session->access != null)
    {
      $data["judul"] = "Comming Soon";
      $data["user_info"] = array("nama"=>$this->session->nama,"picture"=>base_url($this->session->avatar));
      $data["data_page"] = null;
      $data["page"] = "freecar/home";
      $this->load->view("adminLTE/_header",$data);
      $this->load->view("adminLTE/_home",$data);
      $this->load->view("adminLTE/_footer");
    }else{
        redirect(base_url("login"),"refresh");
    }
  }
}

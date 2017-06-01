<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
        $data["judul"] = "Home";
        $data["home"] = array();
        $data["menu"] = array("data"=>array((object)array("link"=>base_url(),"nama_link"=>"Home","icon"=>"fa fa-home","disable"=>false),(object)array("link"=>base_url(),"nama_link"=>"Account","icon"=>"fa fa-user","disable"=>true),(object)array("link"=>base_url(),"nama_link"=>"Forum","icon"=>"fa fa-comments","disable"=>true)));
		$this->load->view("adminLTE/_header",$data);
		$this->load->view("adminLTE/_home",$data);
		$this->load->view("adminLTE/_footer");
	}
}

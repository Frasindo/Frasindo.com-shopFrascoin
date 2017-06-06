<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
        if($this->session->access != null)
        {
            $data["judul"] = "Home";
            
            $data["menu"] = array("data"=>array((object)array("link"=>base_url(),"nama_link"=>"Home","icon"=>"fa fa-home","disable"=>false),(object)array("link"=>base_url(),"nama_link"=>"Account","icon"=>"fa fa-user","disable"=>true),(object)array("link"=>base_url(),"nama_link"=>"Forum","icon"=>"fa fa-comments","disable"=>true),(object)array("link"=>base_url("logout"),"nama_link"=>"Logout","icon"=>"fa fa-sign-out","disable"=>false)));
            if($this->session->access == 0)
            {
                if(isset($_POST["changeNXT"]))
                {
                    $this->session->unset_userdata("nxt_address");
                    $this->session->userdata("nxt_address",null);
                }
                if(strlen($this->session->nxt_address) > 1)
                {
                    include APPPATH . 'third_party/qr/phpqrcode.php';
                    ob_start();
                    QRCode::png($this->session->btc_address, null);
                    $imageString = base64_encode( ob_get_contents() );
                    ob_end_clean();
                    
                    $data["data_page"] = array("data"=>array("btc_address"=>$this->session->btc_address,"nxt_address"=>$this->session->nxt_address,"qr_code"=>$imageString));
                    $data["page"] = "home/home";
                    $this->load->view("adminLTE/_header",$data);
                    $this->load->view("adminLTE/_home",$data);
                    $this->load->view("adminLTE/_footer");
                }else{
                    $data["data_page"] = array("data");
                    $data["page"] = "home/welcome";
                    $this->load->view("adminLTE/_header",$data);
                    $this->load->view("adminLTE/_home",$data);
                    $this->load->view("adminLTE/_footer");
                }
            }elseif($this->session->access == 1)
            {
                
            }
        }else{
            redirect(base_url("login"),"refresh");
        }
	}
}

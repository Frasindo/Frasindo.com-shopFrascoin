<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
        if($this->session->access != null)
        {
	    $this->load->model("acc");
	    $this->load->model("bill");
            $data["judul"] = "Home";
            $data["menu"] = array("data"=>array((object)array("link"=>base_url(),"nama_link"=>"Home","icon"=>"fa fa-home","disable"=>false),(object)array("link"=>base_url(),"nama_link"=>"Account","icon"=>"fa fa-user","disable"=>true),(object)array("link"=>base_url(),"nama_link"=>"Forum","icon"=>"fa fa-comments","disable"=>true),(object)array("link"=>base_url("logout"),"nama_link"=>"Logout","icon"=>"fa fa-sign-out","disable"=>false)));
            if($this->session->access == 0)
            {
                if(strlen($this->session->nxt_address) > 1)
                {
                    include APPPATH . 'third_party/qr/phpqrcode.php';
                    ob_start();
                    QRCode::png($this->session->btc_address, null);
                    $imageString = base64_encode( ob_get_contents() );
                    ob_end_clean();
                    $totalPartisipan = $this->acc->totalParticipant();
		    $Tinvest = number_format($this->bill->totalInvest("bOFtsDfxvaDZ7wzW","aBk57n9ptZZPNOE2wmmlJ4cfgpNe6oiG"),8);
		    
                    $data["data_page"] = array("data"=>array("btc_address"=>$this->session->btc_address,"totalInvest"=>$Tinvest,"tp"=>$totalPartisipan,"nxt_address"=>$this->session->nxt_address,"qr_code"=>$imageString));
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

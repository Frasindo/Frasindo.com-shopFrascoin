<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
        if($this->session->access != null)
        {
	    $this->load->model("acc");
	    $this->load->model("bill");
	    $rateFras = $this->db->get_where("rate",array("id_rate"=>1))->result()[0]->frascoin;
	    $rateIDR = $this->db->get_where("rate",array("id_rate"=>1))->result()[0]->usdidr;
	    $myFund = $this->bill->getWallet("bOFtsDfxvaDZ7wzW","aBk57n9ptZZPNOE2wmmlJ4cfgpNe6oiG");
            $data["judul"] = "Home";
            
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
		    $fixedFras = $this->bill->getFixedFras();
		    $investTotal = $this->bill->totalInvest("bOFtsDfxvaDZ7wzW","aBk57n9ptZZPNOE2wmmlJ4cfgpNe6oiG");
		    $Tinvest = number_format($investTotal,8); 
		    $myFras = ($myFund*$rateIDR) / ($rateFras*$rateIDR);
		    //var_dump(array("rate"=>$rateFras,"myFund"=>$myFund,"myFras"=>number_format($myFras,8)));
                    $data["data_page"] = array("data"=>array("btc_address"=>$this->session->btc_address,"myFras"=>$myFras,"votingPower"=>number_format(($myFras/$fixedFras)*100,8),"totalInvest"=>$Tinvest,"tp"=>$totalPartisipan,"nxt_address"=>$this->session->nxt_address,"qr_code"=>$imageString));
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

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Shop extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library("upload_lib");
        $this->load->helper(array('form'));
    }
	public function index()
	{

        if($this->session->access != null)
        {
            $this->load->model("acc");
       		  $this->load->model("bill");
            $data["judul"] = "Crowdsale Shop";
            if($this->session->access == 0)
            {
              $this->bill->_checkCoinbase("Coinbase API","B60xwCy8vBdIAfxn","KvyQYfQHX44tGXgvIDipdkhsE8cut9zz");
              $rateFras = $this->db->get_where("rate",array("id_rate"=>1))->result()[0]->frascoin;
              $rateIDR = $this->db->get_where("rate",array("id_rate"=>1))->result()[0]->usdidr;
              //$myFund = $this->bill->getWallet("bOFtsDfxvaDZ7wzW","aBk57n9ptZZPNOE2wmmlJ4cfgpNe6oiG");
              $myFund = $this->bill->getDBWallet();
            	if(strlen($this->session->nxt_address) > 10)
                {
                if($this->session->authy == 0 or $this->session->authyConfirm != null){
                    $data["user_info"] = array("nama"=>$this->session->nama,"picture"=>base_url($this->session->avatar));
                    include APPPATH . 'third_party/qr/phpqrcode.php';
                    ob_start();
                    QRCode::png($this->session->btc_address, null);
                    $imageString = base64_encode( ob_get_contents() );
                    ob_end_clean();
                    $totalPartisipan = $this->acc->totalParticipant();
                    $fixedFras = $this->bill->getFixedFras();
                    $investTotal = $this->bill->totalInvest("B60xwCy8vBdIAfxn","KvyQYfQHX44tGXgvIDipdkhsE8cut9zz");
                    $Tinvest = number_format($investTotal,8);
                    //$myFras = ($myFund*$rateIDR) / ($rateFras*$rateIDR);
                    $myFras = $myFund;
                    //var_dump(array("rate"=>$rateFras,"myFund"=>$myFund,"myFras"=>number_format($myFras,8)));
                    $data["data_page"] = array("data"=>array("btc_address"=>$this->session->btc_address,"myFras"=>number_format($myFras,8),"votingPower"=>number_format(($myFras/$fixedFras)*100,8),"totalInvest"=>$Tinvest,"tp"=>$totalPartisipan,"nxt_address"=>$this->session->nxt_address,"qr_code"=>$imageString));
                    $data["page"] = "crowdsale/crowdsale";
                    $this->load->view("adminLTE/_header",$data);
                    $this->load->view("adminLTE/_home",$data);
                    $this->load->view("adminLTE/_footer");
                }else{
                    redirect(base_url(),'refresh');
                }
                }else{
                	redirect(base_url(),"refresh");
                }
            }elseif($this->session->access == 1)
            {
                redirect(base_url("admin"),'refresh');
            }
        }else{
            redirect(base_url("login"),"refresh");
        }
	}
 	public function cek()
    {
    	 $this->load->model("bill");
         $this->bill->_checkCoinbase("Coinbase API","B60xwCy8vBdIAfxn","KvyQYfQHX44tGXgvIDipdkhsE8cut9zz");
    }
}

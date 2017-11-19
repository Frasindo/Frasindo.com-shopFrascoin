<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Homestellar extends CI_Controller {
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
            if($this->session->access == 0)
            {
                $rateFras = $this->db->get_where("rate",array("id_rate"=>1))->result()[0]->frascoin;
                $rateIDR = $this->db->get_where("rate",array("id_rate"=>1))->result()[0]->usdidr;
                $myFund = $this->bill->getWallet("B60xwCy8vBdIAfxn","KvyQYfQHX44tGXgvIDipdkhsE8cut9zz");
                $data["judul"] = "Home";
                if($this->session->authy == 0 or $this->session->authyConfirm != null){
                    $data["user_info"] = array("nama"=>$this->session->nama,"picture"=>base_url($this->session->avatar));
                    if(strlen($this->session->nxt_address) > 10)
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

                }else{
                    $this->load->model("update");
                    if(isset($_POST["setAuth"]))
                    {
                        print_r($this->session->authy);
                        $code = $this->input->post("authy",true);
                        $read = $this->update->read_user(array("login_id"=>$this->session->id_login))->result()[0];
                        $checkResult = $this->googleauthenticator->verifyCode($read->tokenTwofactor,$code);
                        if($checkResult)
                        {
                            $this->session->set_userdata("authyConfirm",1);
                            redirect(base_url(),'refresh');
                        }else{
                            $this->session->set_userdata("authyConfirm",NULL);
                            $data["alert"] = $this->upload_lib->alert("danger","Request Failed","Your 2FA is Wrong, Try Again");
                        }
                    }
                    $data["judul"] = "2FA Challange";
                    $this->load->view("setAvatar/_header.php",$data);
                    $this->load->view("authy/_authy.php",$data);
                    $this->load->view("setAvatar/_footer.php",$data);
                }
            }elseif($this->session->access == 1)
            {
                redirect(base_url("admin"),'refresh');
            }
        }else{
            redirect(base_url("login"),"refresh");
        }
	}
}

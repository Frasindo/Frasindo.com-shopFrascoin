<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
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
            $rateFras = $this->db->get_where("rate",array("id_rate"=>1))->result()[0]->frascoin;
            $rateIDR = $this->db->get_where("rate",array("id_rate"=>1))->result()[0]->usdidr;
            $myFund = $this->bill->getWallet("bOFtsDfxvaDZ7wzW","aBk57n9ptZZPNOE2wmmlJ4cfgpNe6oiG");
            $data["judul"] = "Home";
            if($this->session->access == 0)
            {
                if($this->session->authy == 0 or $this->session->authyConfirm != null){
                if($this->session->avatar != null)
                {
                    $data["user_info"] = array("nama"=>$this->session->nama,"picture"=>base_url($this->session->avatar));
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
                }else{
                    $this->load->model("update");
                    $data["judul"] = "Set Your Avatar";
                    if(isset($_FILES["avatar"]))
                    {
                        if($_FILES["avatar"]["size"] > 0)
                        {
                            $config['upload_path']          = './_upload/';
                            $config['allowed_types']        = 'gif|jpg|png';
                            $config['max_size']             = 300;
                            $config['max_width']            = 1024;
                            $config['max_height']           = 768;
                            $this->load->library('upload', $config);
                            if (!$this->upload->do_upload('avatar'))
                            {
                                    
                                    $data["alert"] = $this->upload_lib->alert("danger","Request Failed","Avatar Cannot Set Show Error : ".$this->upload->display_errors());
                            }else{
                                    $dataFile = $this->upload->data();
                                    $update = $this->update->update_user($this->session->id_login,array("avatar"=>"_upload/".$dataFile["file_name"]));
                                    if($update)
                                    {
                                        $data["alert"] = $this->upload_lib->alert("success","Request Success","Avatar Success Set, Please Wait You Will be Redirected to Home Page");
                                        $this->session->unset_userdata("avatar");
                                        $this->session->set_userdata("avatar","_upload/".$dataFile["file_name"]);
                                        redirect(base_url(),"refresh");
                                    }else{
                                        $data["alert"] = $this->upload_lib->alert("danger","Request Failed","Avatar Cannot Set Show Error : Update Info Failed ");
                                    }
                                    
                                    
                            }
                        }else{
                            $data["alert"] = $this->upload_lib->alert("danger","Request Failed","Avatar Cannot Set, Please Check Your Field");
                        }
                    }
                    $this->load->view("setAvatar/_header",$data);
                    $this->load->view("setAvatar/_home",$data);
                    $this->load->view("setAvatar/_footer");
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
                
            }
        }else{
            redirect(base_url("login"),"refresh");
        }
	}
}
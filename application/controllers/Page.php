<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->library("upload_lib");
        $this->load->model("update");
    }
    function account()
    {
         if($this->session->authy == 0 or $this->session->authyConfirm != null){
        $dataUser = $this->update->read_user(array("login_id"=>$this->session->id_login))->result()[0];
        if($dataUser->tokenTwofactor == null)
        {
            $secret = $this->googleauthenticator->createSecret();
            $this->update->update_user($this->session->id_login,array("tokenTwofactor"=>$secret));
        }else{
            $secret = $dataUser->tokenTwofactor;
        }
        $qrCodeUrl = $this->googleauthenticator->getQRCodeGoogleUrl('LoginService', $this->session->username, $secret);
        $data["authy"] = (isset($qrCodeUrl))?$qrCodeUrl:null;
        if(isset($_GET["reset"]))
        {
            $this->session->unset_userdata("avatar");
            redirect(base_url(),'refresh');            
        }
        if(isset($_POST["nama"]))
        {
            $data = $this->input->post(NULL,true);
            if($this->input->post("twofactor",true) == 0)
            {
                $delete = $this->update->update_user($this->session->id_login,array("tokenTwofactor"=>""));
                var_dump($delete);
            }
            $update = $this->update->update_user($this->session->id_login,$data);
            if($update)
            {
                $data["alert"] = $this->upload_lib->alert("success","Request Success","Update Profile Success").$this->upload_lib->alihkan(base_url("page/account"),1000);
                $this->session->set_userdata("nama",$data["nama"]);       
            }else{
                $data["alert"] = $this->upload_lib->alert("danger","Request Failed","Update Profile Failed").$this->upload_lib->alihkan(base_url("page/account"),1000);;
            }
        }
        $data["user_info"] = array("nama"=>$this->session->nama,"picture"=>base_url($this->session->avatar));
        $data["judul"] ="Setting Account"; 
        $data["data_page"] = $dataUser;
        $data["page"] = "pages/account";
        $this->load->view("adminLTE/_header",$data);
        $this->load->view("adminLTE/_home",$data);
        $this->load->view("adminLTE/_footer");
        }else{
            redirect(base_url(),'refresh');
        }
    }
}
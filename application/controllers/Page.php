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
       
        if(isset($_GET["reset"]))
        {
            $this->session->unset_userdata("avatar");
            redirect(base_url(),'refresh');            
        }
        if(isset($_POST["nama"]))
        {
            $data = $this->input->post(NULL,true);
            $update = $this->update->update_user($this->session->id_login,$data);
            if($update)
            {
                $data["alert"] = $this->upload_lib->alert("success","Request Success","Update Profile Success");
                $this->session->set_userdata("nama",$data["nama"]);                
            }else{
                $data["alert"] = $this->upload_lib->alert("danger","Request Failed","Update Profile Failed");
            }
        }
        $data["user_info"] = array("nama"=>$this->session->nama,"picture"=>base_url($this->session->avatar));
        $data["judul"] ="Setting Account"; 
        $data["data_page"] = $this->update->read_user(array("login_id"=>$this->session->id_login))->result()[0];
        $data["page"] = "pages/account";
        $this->load->view("adminLTE/_header",$data);
        $this->load->view("adminLTE/_home",$data);
        $this->load->view("adminLTE/_footer");
    }
}
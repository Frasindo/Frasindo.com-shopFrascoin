<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Carcoin extends CI_Controller {
  public function __construct()
  {
      parent::__construct();
      $this->load->model("acc");
      $this->load->model("bill");
      $this->load->model("update");
  }
	public function index()
	{
    if($this->session->access == 0 )
    {
      if($this->session->authy == 0 or $this->session->authyConfirm != null){
      $id = $this->db->get_where("user_info",array("login_id"=>$this->session->id_login))->result()[0]->id_users;
      $dataUser = $this->update->read_user(array("login_id"=>$this->session->id_login))->result()[0];
      $data["judul"] = "My Car Coin";
      $data["user_info"] = array("nama"=>$this->session->nama,"picture"=>base_url($this->session->avatar));
      $data["data_page"] = $dataUser;
      $data["totalCar"] = $this->bill->carTotalBalance();
      $data["targetDate"] = $this->db->get_where("carcoinTimer",array("id_timer"=>2))->result()[0]->timer;
      $data["totalNextCar"] = $this->bill->carNextBonusTotal();
      $data["page"] = "carcoin/home";
      $this->load->view("adminLTE/_header",$data);
      $this->load->view("adminLTE/_home",$data);
      $this->load->view("adminLTE/_footer");
    }else{
      redirect(base_url("shop"),'refresh');
    }
    }else{
        redirect(base_url("login"),"refresh");
    }
  }
}

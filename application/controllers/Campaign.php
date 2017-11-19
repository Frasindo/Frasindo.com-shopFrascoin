<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Campaign extends CI_Controller {
  protected $campaign;
  protected $sesi;
  public function __construct()
  {
          parent::__construct();
          $this->load->model("campaign_model");
          $campaign = $this->load->database('campaign', TRUE);
          $this->campaign = $campaign;
          $this->sesi = $this->session->c_access;
  }
	public function index()
	{
      if($this->sesi != 0)
      {
        $data["judul"] = "Home Campaign";
        $data["data_page"] = null;
        $a = $this->campaign_model->getBonus($this->session->id_users);
        $totalEarn = 0;
        $totalCompleted = 0;
        foreach ($a as $key => $value) {
          $totalEarn = $totalEarn + array_sum($value["data"]);
          if($value["data"]["twitter"] > 0)
          {
              $totalCompleted = $totalCompleted + 1;
          }
          if($value["data"]["trans"] > 0)
          {
              $totalCompleted = $totalCompleted + 1;
          }
          if($value["data"]["yt"] > 0)
          {
              $totalCompleted = $totalCompleted + 1;
          }
          if($value["data"]["blog"] > 0)
          {
              $totalCompleted = $totalCompleted + 1;
          }
          if($value["data"]["sign"] > 0)
          {
              $totalCompleted = $totalCompleted + 1;
          }
        }
        $data["totalComplete"] = $totalCompleted;
        $data["earning"] = $totalEarn;
        $data["totalCompleted"] =
        $data["campaignStatus"] = $a;
        $data["targetDate"] = $this->campaign_model->getNextTrigger();
        $data["page"] = "campaign/home";
        $this->load->view("adminLTE/campaign/_header",$data);
        $this->load->view("adminLTE/campaign/_home",$data);
        $this->load->view("adminLTE/campaign/_footer");
      }elseif($this->session->c_accessAdmin != 0){
        redirect(base_url("campaign/admin"));
      }else{
        redirect(base_url("campaign/login"));
      }
  }
  function logout()
  {
    $this->session->sess_destroy();
    redirect(base_url("campaign"),"refresh");
  }
  public function admin($page='')
  {
    if($this->session->c_accessAdmin != 0)
    {
      if($page == "twitter")
      {
        $data["judul"] = "Twitter Campaign";
        $l = $this->campaign_model->getTwitterAdmin();
        $data["listCampaign"] = $l;
        $data["data_page"] = null;
        $data["page"] = "campaign/admin/mtwitter";
        $this->load->view("adminLTE/campaign/admin/_header",$data);
        $this->load->view("adminLTE/campaign/admin/_home",$data);
        $this->load->view("adminLTE/campaign/admin/_footer");
      }elseif ($page == "youtube") {
        $data["judul"] = "Vlog Campaign";
        $data["data_page"] = null;
        $l = $this->campaign_model->getAdminYt();
        $data["listCampaign"] = $l;
        $data["page"] = "campaign/admin/mvlog";
        $this->load->view("adminLTE/campaign/admin/_header",$data);
        $this->load->view("adminLTE/campaign/admin/_home",$data);
        $this->load->view("adminLTE/campaign/admin/_footer");
      }elseif ($page == "blogger") {
        $data["judul"] = "Blog Campaign";
        $data["list"] = $this->campaign_model->getUniversalCampaign("blogcampaign");
        $data["data_page"] = null;
        $data["page"] = "campaign/admin/mblog";
        $this->load->view("adminLTE/campaign/admin/_header",$data);
        $this->load->view("adminLTE/campaign/admin/_home",$data);
        $this->load->view("adminLTE/campaign/admin/_footer");
      }elseif ($page == "translate") {
        $data["judul"] = "Translate Campaign";
        $data["list"] = $this->campaign_model->getUniversalCampaign("transcampaign");
        $data["data_page"] = null;
        $data["page"] = "campaign/admin/mtrans";
        $this->load->view("adminLTE/campaign/admin/_header",$data);
        $this->load->view("adminLTE/campaign/admin/_home",$data);
        $this->load->view("adminLTE/campaign/admin/_footer");
      }elseif ($page == "signature") {
        $data["judul"] = "Signature Campaign";
        $data["list"] = $this->campaign_model->getUniversalCampaign("signcampaign");
        $data["data_page"] = null;
        $data["page"] = "campaign/admin/msign";
        $this->load->view("adminLTE/campaign/admin/_header",$data);
        $this->load->view("adminLTE/campaign/admin/_home",$data);
        $this->load->view("adminLTE/campaign/admin/_footer");
      }elseif ($page == "madmin") {
        $data["judul"] = "Admin Manager";
        $madmin = $this->campaign_model->getAdmin();
        $data["listAdmin"] = array();
        if($madmin["status"] == 1)
        {
          $data["listAdmin"] = $madmin["data"];
        }
        $data["data_page"] = null;
        $data["page"] = "campaign/admin/madmin";
        $this->load->view("adminLTE/campaign/admin/_header",$data);
        $this->load->view("adminLTE/campaign/admin/_home",$data);
        $this->load->view("adminLTE/campaign/admin/_footer");
      }elseif ($page == "musers") {
        $data["judul"] = "Users Manager";
        $musers = $this->campaign_model->getUsers();
        $data["listUsers"] = array();
        if($musers["status"] == 1)
        {
          $data["listUsers"] = $musers["data"];
        }
        $data["data_page"] = null;
        $data["page"] = "campaign/admin/muser";
        $this->load->view("adminLTE/campaign/admin/_header",$data);
        $this->load->view("adminLTE/campaign/admin/_home",$data);
        $this->load->view("adminLTE/campaign/admin/_footer");
      }elseif ($page == "sbounty") {
        $data["judul"] = "Bounty Setting";
        if(isset($_POST["save"]))
        {
          $d = $this->input->post(null,true);
          unset($d["save"]);
          $z = $this->campaign_model->updateBounty($d);
          if($z["status"] == 1)
          {
            $data["alert"] = "<div class='alert alert-success'>".$z["msg"]."</div>";
          }else{
            $data["alert"] = "<div class='alert alert-danger'>".$z["msg"]."</div>";
          }
        }
        $data["bs"] = $this->campaign_model->fetchSetting();
        $data["data_page"] = null;
        $data["page"] = "campaign/admin/mbounty";
        $this->load->view("adminLTE/campaign/admin/_header",$data);
        $this->load->view("adminLTE/campaign/admin/_home",$data);
        $this->load->view("adminLTE/campaign/admin/_footer");
      }elseif ($page == "sitesetting") {
        $data["judul"] = "Site Setting";
        if(isset($_POST["save"]))
        {
          $d = $this->input->post(null,true);
          unset($d["save"]);
          $z = $this->campaign_model->updateTrigger($d);
          if($z["status"] == 1)
          {
            $data["alert"] = "<div class='alert alert-success'>".$z["msg"]."</div>";
          }else{
            $data["alert"] = "<div class='alert alert-danger'>".$z["msg"]."</div>";
          }
        }
        $data["alloc"] = $alloc = $this->campaign_model->getAllocatedFund();
        $data["last_trigger"] = $this->campaign_model->getLastTrigger();
        $data["next_trigger"] = $this->campaign_model->getNextTrigger();
        $data["trigger_hops"] = $this->campaign_model->trigger_hops();
        $data["data_page"] = null;
        $data["page"] = "campaign/admin/msite";
        $this->load->view("adminLTE/campaign/admin/_header",$data);
        $this->load->view("adminLTE/campaign/admin/_home",$data);
        $this->load->view("adminLTE/campaign/admin/_footer");
      }elseif ($page == "myprofile") {
        # code...
      }else{
        $data["judul"] = "Home Campaign Admin";
        $data["data_page"] = null;
        $data["twitter"] = $this->campaign_model->universalStream("twitter");
        $data["blog"] = $this->campaign_model->universalStream("blog");
        $data["yt"] = $this->campaign_model->universalStream("yt");
        $data["sign"] = $this->campaign_model->universalStream("sign");
        $data["trans"] = $this->campaign_model->universalStream("trans");
        $data["targetDate"] = $this->campaign_model->getNextTrigger();
        $data["unverifed"] = $this->campaign_model->countCampaign("0");
        $data["verifed"] = $this->campaign_model->countCampaign(1);
        $data["totalPartisipan"] = $this->campaign_model->countPartisipan();
        $data["latestComplete"] = $this->campaign_model->streamCompleted("desc");
        $data["page"] = "campaign/admin/home";
        $this->load->view("adminLTE/campaign/admin/_header",$data);
        $this->load->view("adminLTE/campaign/admin/_home",$data);
        $this->load->view("adminLTE/campaign/admin/_footer");
      }
    }else{
        redirect("campaign/login",'refresh');
    }
  }
  public function page($page='')
  {
    if($this->sesi != 0)
    {
      if($page == "twitter")
      {
        $data["judul"] = "Twitter Campaign";

        $data["data_page"] = null;
        $data["screenName"] = $this->campaign_model->getTwitterUser($this->session->id_users);
        $data["page"] = "campaign/twitter";
        $this->load->view("adminLTE/campaign/_header",$data);
        $this->load->view("adminLTE/campaign/_home",$data);
        $this->load->view("adminLTE/campaign/_footer");
      }elseif ($page == "yt") {
        $data["judul"] = "Vlog Campaign";
        $data["data_page"] = null;
        $data["page"] = "campaign/vlog";
        $this->load->view("adminLTE/campaign/_header",$data);
        $this->load->view("adminLTE/campaign/_home",$data);
        $this->load->view("adminLTE/campaign/_footer");
      }elseif ($page == "blogger") {
        $a = $this->campaign_model->fetchSubmited($this->session->id_users);
        $data["listSubmited"] = $a;
        $data["judul"] = "Blog Campaign";
        $data["data_page"] = null;
        $data["page"] = "campaign/blog";
        $this->load->view("adminLTE/campaign/_header",$data);
        $this->load->view("adminLTE/campaign/_home",$data);
        $this->load->view("adminLTE/campaign/_footer");
      }elseif ($page == "translate") {
        $a = $this->campaign_model->fetchSubmitedTrans($this->session->id_users);
        $data["listSubmited"] = $a;
        $data["judul"] = "Translate Campaign";
        $data["data_page"] = null;
        $data["page"] = "campaign/translate";
        $this->load->view("adminLTE/campaign/_header",$data);
        $this->load->view("adminLTE/campaign/_home",$data);
        $this->load->view("adminLTE/campaign/_footer");
      }elseif ($page == "signature") {
        $a = $this->campaign_model->fetchSubmitedSign($this->session->id_users);
        $data["listSubmited"] = $a;
        $data["judul"] = "Signature Campaign";
        $data["data_page"] = null;
        $data["page"] = "campaign/signature";
        $this->load->view("adminLTE/campaign/_header",$data);
        $this->load->view("adminLTE/campaign/_home",$data);
        $this->load->view("adminLTE/campaign/_footer");
      }elseif($page == "settings"){
        if(isset($_POST["save"]))
        {
          $pass = $this->input->post("pass",true);
          $data = $this->input->post(null,true);
          if($pass != null)
          {
            $a = $this->campaign_model->updateInfo($data,$pass);
            if($a["status"] == 1)
            {
              $data["alert"] = "<div class='alert alert-success'>".$a["msg"]."</div>";
            }else{
              $data["alert"] = "<div class='alert alert-danger'>".$a["msg"]."</div>";
            }
          }else{
            unset($data["pass"]);
            $a = $this->campaign_model->updateInfo($data);
            if($a["status"] == 1)
            {
              $data["alert"] = "<div class='alert alert-success'>".$a["msg"]."</div>";
            }else{
              $data["alert"] = "<div class='alert alert-danger'>".$a["msg"]."</div>";
            }
          }
        }
        $a = $this->campaign_model->fetchUserInfo($this->session->id_users);
        if($a["status"] == 1)
        {
          $data["infouser"] = $a["data"];
        }else{
          $data["infouser"] = $a["data"];
        }
        $data["judul"] = "Settings Account";
        $data["data_page"] = null;
        $data["page"] = "campaign/settings";
        $this->load->view("adminLTE/campaign/_header",$data);
        $this->load->view("adminLTE/campaign/_home",$data);
        $this->load->view("adminLTE/campaign/_footer");
      }else{
        show_404();
      }
    }else{
      redirect(base_url("campaign/login"));
    }
  }
  public function login()
  {
    $data["judul"] = "Login Area Campaign";
    $data["data_page"] = null;
    $data["page"] = "login/loginCampaign";
    $this->load->view("loginTemplate/_header",$data);
    $this->load->view("loginTemplate/_content",$data);
    $this->load->view("loginTemplate/_footer");
  }

}

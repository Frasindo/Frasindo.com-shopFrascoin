<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';
include APPPATH . 'third_party/coinbase/vendor/autoload.php';
include APPPATH . 'third_party/phpimage/vendor/autoload.php';
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Address;
use Coinbase\Wallet\Resource\Account;

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Rest extends \Restserver\Libraries\REST_Controller {

    public $apiKey;
    public $secretApi;
    public $nxt_server = "http://server.frasindo.com:26876";
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
      	$this->apiKey = "B60xwCy8vBdIAfxn";
      	$this->secretApi = "KvyQYfQHX44tGXgvIDipdkhsE8cut9zz";
        $this->load->library('twitteroauth');
    }
    public function index_get()
    {
      $this->response(array("status"=>0,"msg"=>"Nothing in Here !"),404);
    }
    public function index_post()
    {
      $this->response(array("status"=>0,"msg"=>"Nothing in Here !"),404);
    }
    protected function _sessionRestrict()
    {
    	if($this->session->access == null)
    	{
    	    //$this->response(array("status"=>0));
    	    exit(json_encode(array("status"=>0,"msg"=>"Opps Your Session Expired, Please Reload Page")));
    	}
    }
    protected function _sessionRestrictCampaign()
    {
    	if($this->session->c_access == null)
    	{
    	    exit(json_encode(array("status"=>0,"msg"=>"Opps Your Session Expired, Please Reload Page")));
    	}
    }
    protected function _sessionRestrictCampaignAdmin()
    {
    	if($this->session->c_accessAdmin == null)
    	{
    	    exit(json_encode(array("status"=>0,"msg"=>"Opps Your Session Expired, Please Reload Page")));
    	}
    }
    protected function _sessionRestrictAdmin()
    {
    	$this->_sessionRestrict();
      if($this->session->access != 1)
      {
        exit(json_encode(array("status"=>0,"msg"=>"Opps Admin Restricted")));
      }

    }
    function chat_post()
    {
      $this->load->model("chatmodel");
      $this->_sessionRestrict();
      $data = array();
      if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
      	if(!empty($_POST['data'])){
      		if($_POST['data'] == 'cek'){
      			if(isset($_SESSION['access'])){
      				$data['status'] = 'success';
      				$data['user'] 	= $_SESSION['username'];
      				$data['avatar'] = $this->gravatar->get($this->session->email);
            }else{

      			}
      		}else if($_POST['data'] == 'message'){
      			if(!empty($_POST['ke']) && !empty($_POST['tipe'])){
      				$data = $this->chatmodel->get_message($_POST['tipe'], $_POST['ke'], $_SESSION['user']);
      			}
      		}else if($_POST['data'] == 'user'){
      			$data = $this->chatmodel->get_user($_SESSION['user']);
      		}else if($_POST['data'] == 'send'){
      			if(isset($_SESSION['user']) && !empty($_POST['ke']) && !empty($_POST['message']) && !empty($_POST['date']) && !empty($_POST['avatar']) && !empty($_POST['tipe'])){
      				$data = $this->chatmodel->send_message($_SESSION['user'], $_POST['ke'], $_POST['message'], $_POST['date'], $_POST['avatar'], $_POST['tipe']);
      			}
      		}else if($_POST['data'] == 'logout'){
      			$data = $this->chatmodel->user_logout($_SESSION['user']);
      			if($data['status'] == 'success'){
      				session_destroy();
      			}
      		}
      	}
      }
      $this->response($data);
    }
    function deletetwitter_post()
    {
      $this->_sessionRestrictCampaignAdmin();
      $this->load->model("campaign_model");
      $id = $this->input->post("uniqid",true);
      $d = $this->campaign_model->deleteUniqTwitter($id);
      $this->response($d);
    }
    function deleteyt_post()
    {
      $this->_sessionRestrictCampaignAdmin();
      $this->load->model("campaign_model");
      $id = $this->input->post("uniqid",true);
      $d = $this->campaign_model->deleteUniqYoutube($id);
      $this->response($d);
    }
    function deletesign_post()
    {
      $this->_sessionRestrictCampaignAdmin();
      $this->load->model("campaign_model");
      $id = $this->input->post("id",true);
      $d = $this->campaign_model->deleteUniversalCampaign("id_sc","signcampaign",$id);
      $this->response($d);
    }
    function updatesign_post()
    {
      $this->_sessionRestrictCampaignAdmin();
      $this->load->model("campaign_model");
      $id = $this->input->post("id",true);
      $type = $this->input->post("type",true);
      $a = $this->campaign_model->updateUniversalCampaign("id_sc","signcampaign",$id,$type);
      $this->response($a);
    }
    function deletetrans_post()
    {
      $this->_sessionRestrictCampaignAdmin();
      $this->load->model("campaign_model");
      $id = $this->input->post("id",true);
      $d = $this->campaign_model->deleteUniversalCampaign("id_trc","transcampaign",$id);
      $this->response($d);
    }
    function updatetrans_post()
    {
      $this->_sessionRestrictCampaignAdmin();
      $this->load->model("campaign_model");
      $id = $this->input->post("id",true);
      $type = $this->input->post("type",true);
      $a = $this->campaign_model->updateUniversalCampaign("id_trc","transcampaign",$id,$type);
      $this->response($a);
    }
    function deleteblog_post()
    {
      $this->_sessionRestrictCampaignAdmin();
      $this->load->model("campaign_model");
      $id = $this->input->post("id",true);
      $d = $this->campaign_model->deleteUniversalCampaign("id_bc","blogcampaign",$id);
      $this->response($d);
    }
    function updateblog_post()
    {
      $this->_sessionRestrictCampaignAdmin();
      $this->load->model("campaign_model");
      $id = $this->input->post("id",true);
      $type = $this->input->post("type",true);
      $a = $this->campaign_model->updateUniversalCampaign("id_bc","blogcampaign",$id,$type);
      $this->response($a);
    }
    function updateyoutube_post()
    {
      $this->_sessionRestrictCampaignAdmin();
      $this->load->model("campaign_model");
      $uniqcode = $this->input->post("uniqid",true);
      $type = $this->input->post("type",true);
      $a = $this->campaign_model->youtubeUpdateStatus($uniqcode,$type);
      $this->response($a);
    }
    function updatetwitter_post()
    {
      $this->_sessionRestrictCampaignAdmin();
      $this->load->model("campaign_model");
      $uniqcode = $this->input->post("uniqid",true);
      $type = $this->input->post("type",true);
      $a = $this->campaign_model->twiiterUpdateStatus($uniqcode,$type);
      $this->response($a);
    }
    function fetchUsersCampaign_get($id='')
    {
      $this->_sessionRestrictCampaignAdmin();
      $this->load->model("campaign_model");
      $a = $this->campaign_model->getUsers($id);
      $this->response($a);
    }
    function fetchAdminCampaign_get($id='')
    {
      $this->_sessionRestrictCampaignAdmin();
      $this->load->model("campaign_model");
      $a = $this->campaign_model->getAdmin($id);
      $this->response($a);
    }
    function deleteAdminCampaign_get($id='')
    {
      $this->_sessionRestrictCampaignAdmin();
      $this->load->model("campaign_model");
      $a = $this->campaign_model->delAdmin($id);
      $this->response($a);
    }

    function deleteUsersCampaign_get($id='')
    {
      $this->_sessionRestrictCampaignAdmin();
      $this->load->model("campaign_model");
      $a = $this->campaign_model->delAdmin($id);
      $this->response($a);
    }
    function editUsersCampaign_post()
    {
      $this->_sessionRestrictCampaignAdmin();
      $this->load->model("campaign_model");
      $data = $this->input->post(null,true);
      $a = $this->campaign_model->editUsers($data);
      $this->response($a);
    }
    function editAdminCampaign_post()
    {
      $this->_sessionRestrictCampaignAdmin();
      $this->load->model("campaign_model");
      $data = $this->input->post(null,true);
      $a = $this->campaign_model->editAdmin($data);
      $this->response($a);
    }
    function addAdminCampaign_post()
    {
      $this->_sessionRestrictCampaignAdmin();
      $this->load->model("campaign_model");
      $data = $this->input->post(null,true);
      $a = $this->campaign_model->addAdmin($data);
      $this->response($a);
    }
    function cekYt_get($chanel="")
    {
      $this->_sessionRestrictCampaign();
      $this->load->model("campaign_model");
      $a = $this->campaign_model->cekYt($this->session->id_users);
      $this->response($a);
    }
    function addUserCampaign_post()
    {
      $this->_sessionRestrictCampaignAdmin();
      $this->load->model("campaign_model");
      $this->load->helper("string");
      $data = $this->input->post(null,true);
      $data["blog_unique"] = strtoupper(random_string("alnum",8));
      $a = $this->campaign_model->addUsers($data);
      $this->response($a);
    }
    function updatecrowdsale_post()
    {
      $this->_sessionRestrictAdmin();
      $this->load->model("adminpanel");
      $data = $this->input->post(null,true);
      $exc = $this->adminpanel->updatePeriode($data);
      $this->response($exc);
    }
    function deleteadmin_post()
    {
      $this->_sessionRestrictAdmin();
      $this->load->model("acc");
      $email = $this->input->post("email",true);
      $wiping = $this->acc->wipeAccount($email);
      $this->response($wiping);
    }
    function addadmin_post()
    {
      $this->_sessionRestrictAdmin();
      $this->load->model("acc");
      $data = $this->input->post(null,true);
      $create = $this->acc->createAdmin($data);
      $this->response($create);
    }
    function listdep_get()
    {
      $this->_sessionRestrictAdmin();
      $this->load->model("acc");
      $dep = $this->acc->listdep();
      if($dep->num_rows() > 0)
      {
        $this->response($dep->result());
      }else{
        $this->response([],404);
      }
    }
    function createcrowdsale_post()
    {
      $this->_sessionRestrictAdmin();
      $this->load->model("adminpanel");
      $data = $this->input->post(null,true);
      $exc = $this->adminpanel->createPeriode($data);
      $this->response($exc);
    }
    function crowdsaleTime_get($id='')
    {
      $this->_sessionRestrictAdmin();
      if($id != '')
      {
        $this->load->model("bill");
        $cr = $this->bill->getCrowdsale($id);
        if($cr->num_rows() > 0)
        {
          $this->response(array("status"=>1,"coin"=>$cr->row()->coinsell,"msg"=>$cr->result()));
        }else{
          $this->response(array("status"=>0,"msg"=>"ID Not Found"));
        }
      }else{
        $this->response(array("status"=>0,"msg"=>"ID Null"));
      }
    }
    function setTimer_post()
    {
      $this->_sessionRestrictAdmin();
      $this->load->model("adminpanel");
      $timer = $this->input->post("timer",true);
      $this->response($this->adminpanel->setTimer($timer));
    }
    function deletecrowdsale_post(){
      $this->_sessionRestrictAdmin();
      $this->load->model("adminpanel");
      $id = $this->input->post("id",true);
      if($id == null){ $id = 0;};
      $delete = $this->adminpanel->deletePeriode($id);
      $this->response($delete);
    }
    function setFras_post()
    {
      $this->_sessionRestrictAdmin();
      $this->load->model("adminpanel");
      $fras = $this->input->post("fras",true);
      $this->response($this->adminpanel->setFras($fras));
    }
    function testimoniDel_get($id)
    {
      $this->_sessionRestrict();
      $cek = $this->db->get_where("testimoni",array("id_testi"=>$id));
      if($cek->num_rows() > 0)
      {
        $del = $this->db->delete("testimoni",array("id_testi"=>$id));
        if($del)
        {
            $this->response(array("status"=>1,"msg"=>"Testimony Successfully Deleted"));
        }else{
            $this->response(array("status"=>0,"msg"=>"Testimony Failed to Delete"));
        }
      }else{
        $this->response(array("status"=>0,"msg"=>"Testimony not Found"));
      }
    }
    function testimoniStatus_post()
    {
      $this->_sessionRestrict();
      $this->load->model("testimoni");
      $status = $this->input->post("status",true);
      $id = ($this->input->post("id",true) != null)?$this->input->post("id",true):$this->input->post("id",true);
      if(is_numeric($status) && is_numeric($id))
      {
        if($status == 1)
        {
          $update = $this->testimoni->setStatus(1,$id);
        }else{
          $update = $this->testimoni->setStatus(2,$id);
        }
        if($update)
        {
          $this->response(array("status"=>1,"msg"=>"Testimoni Status Changed"+$status));
        }else{
          $this->response(array("status"=>0,"msg"=>"Testimoni Status Not Change"));
        }
      }else{
        $this->response(array("status"=>0,"msg"=>"Ilegal Input"));
      }
    }
    function systemTrigger_get($verifikasi=null,$type=null)
    {
      $this->load->model("systemtrigger");
      $cek = $this->db->get_where("siteMeta",array("meta_key"=>"trigger_password"));
      if($cek->num_rows() > 0 &&  $type != null)
      {
          if($cek->result()[0]->meta_value == $verifikasi)
          {
            if($type == "carcoin")
            {
              $this->response($this->systemtrigger->carcoin());
            }elseif ($type == "campaignTime") {
              $this->response($this->systemtrigger->campaignTime());
            }elseif ($type == "fetchPayment") {
              # code...
            }else{
              $this->response(array("status"=>0));
            }
          }else{
            $this->response(array("status"=>0));
          }
      }else{
        $this->response(array("status"=>0));
      }
    }
    function carcoinHistory_get()
    {
      $this->_sessionRestrict();
      $this->load->model("bill");
      $sesi = $this->session->id_login;
      $this->response($this->bill->carcoinHistory($sesi));

    }
    function getReview_get()
    {
      $this->load->model("testimoni");
      $this->response($this->testimoni->fetch());
    }
    function review_post()
    {
      $this->_sessionRestrict();
      $this->load->model("testimoni");
      $sesi = $this->session->id_login;
      $isi = $this->input->post("isi",true);
      $job = $this->input->post("job",true);
      $company = $this->input->post("company",true);
      $img = $this->gravatar->get($this->session->email);
      $cekNama = $this->db->get_where("user_info",array("login_id"=>$sesi));
      if(strlen($cekNama->result()[0]->nama) > 0){
        $nama = $cekNama->result()[0]->nama;
        $insert = $this->testimoni->add($sesi,$nama,$isi,$img,$job,$company);
        if($insert)
        {
          $this->response(array("status"=>1,"msg"=>"Your Review Successfully Submited"));
        }else{
          $this->response(array("status"=>0,"msg"=>"Failed To Submit Review"));
        }
      }else{
        $this->response(array("status"=>0,"msg"=>"Please Complete Your Profile at Account Setting Before You Submit a Review"));
      }

    }
    function cekReview_get()
    {
      $this->_sessionRestrict();
      $sesi = $this->session->id_login;
      $db = $this->db->get_where("testimoni",array("login_id"=>$sesi));
      if($db->num_rows() < 1)
      {
        $this->response(array("status"=>1));
      }else{
        $this->response(array("status"=>0));
      }
    }
    function cgARDR_post()
    {
      $this->_sessionRestrict();
      $this->load->model("update");
      $data = $this->input->post(NULL,true);
      if($data["type"] == "addAcc")
      {
        unset($data["type"]);
        $dataA = $this->update->read_user($data);
        $dataB = $this->update->read_user(array("nxt_address"=>$data["nxt_address_sec"]));
        if($dataA->num_rows() < 1 && $dataB->num_rows() < 1)
        {
            $update = $this->update->update_user($this->session->id_login,$data);
            if($update)
            {
              $this->response(array("status"=>1,"msg"=>"Success"));
            }else{
              $this->response(array("status"=>0,"msg"=>"Server Error"));
            }
        }else{
            $this->response(array("status"=>0,"msg"=>"Duplicate Address"));
        }
      }elseif ($data["type"] == "setPrimary") {
        unset($data["type"]);
        $data["nxt_address_sec"] = base64_decode($data["nxt_address_sec"]);
        $coreData = $this->update->read_user($data)->result()[0];
        $dataB = $this->update->read_user(array("nxt_address"=>$data["nxt_address_sec"]));
        if($dataB->num_rows() < 1)
        {
            $this->update->update_user($this->session->id_login,array("nxt_address_sec"=>$coreData->nxt_address));
            $this->update->update_user($this->session->id_login,array("nxt_address"=>$data["nxt_address_sec"]));
            $this->session->set_userdata("nxt_address",$data["nxt_address_sec"]);
            $this->response(array("status"=>1,"msg"=>"Success"));
        }else{
            $this->response(array("status"=>0,"msg"=>"Duplicate Address"));
        }
      }else{
        $this->response([],404);
      }
    }
    function cgARDR_get()
    {
      $this->_sessionRestrict();
      $this->load->model("update");
      $user = $this->session->nxt_address;
      $data = $this->update->read_user(array("nxt_address"=>$user))->result()[0];
      $list[0] = "<option value='".base64_encode($data->nxt_address)."' selected>".$data->nxt_address." (Primary Account)</option>";
      if($data->nxt_address_sec != null)
      {
        $list[1] = "<option value='".base64_encode($data->nxt_address_sec)."' >".$data->nxt_address_sec."</option>";
      }
      if($data->nxt_address_sec != null)
      {
        $input = "";
      }else{
        $input = "<div style='padding-bottom:5px;'><input type='text' class='form-control addAcc' placeholder='Input Your Second ARDOR Account'></input></div>";
      }

      $select = "<select class='form-control setAcc'>";
      foreach ($list as $key => $value) {
        $select .= $value;
      }
      $select .= "</select'>";

      echo "<div class='row'><div class='col-md-8 col-md-offset-2'>".$input."<form class='form-horizontal'>".$select."</form></div></div>";

    }
    function getFixed_get()
    {
        $this->load->model("bill");
        $datacrowdsale = $this->bill->getBonusNow(date("d-m-Y"));
        $sisa = $this->db->get_where("crowdsale",array("id_crowdsale"=>$datacrowdsale["id_crowdsale"]))->result();
        $this->response($sisa);
    }
    function historyBTC_get()
    {
        $this->_sessionRestrict();
        $this->load->model("historybtc");
        $data = $this->historybtc->get();
        $i = 0;
        $result = array();
        foreach ($data as $history) {
              $j = 0;
              $user = $history["data"]["username"];
              $fras = $history["data"]["fras"];
              $btc = $history["data"]["btc"];
              $usd = $history["data"]["kursBTCUSD"];
              $bonusFRAS = $history["data"]["bonus_log"];
              $hash = $history["data"]["hash_list"];
              $result["totalBonus"] = $history["data"]["totalBonus"];
              $result["totalFras"] = $history["data"]["totalFras"];
              $result["totalBTC"] = $history["data"]["totalBTC"];
              foreach ($history["data"]["timestamp"] as $key => $value) {
                if($j > 0)
                {
                  $history["data"]["timestamp"] .= "<p>".$value."</p>";
                  $history["data"]["fras"] .= "<p>".$fras[$j]."</p>";
                  $history["data"]["btc"] .= "<p>".$btc[$j]."</p>";
                  $history["data"]["kursBTCUSD"] .= "<p>".$usd[$j]."</p>";
                  $history["data"]["bonus_log"] .= "<p>".$bonusFRAS[$j]."</p>";
                  $history["data"]["hash_list"] .= "<p><a href='https://blockchain.info/tx/".$hash[$j]."'>".$hash[$j]."</a></p>";
                  $history["data"]["username"] .= "<p>".$user[$j]."</p>";
                }else{
                  $history["data"]["timestamp"] = "<p>".$value."</p>";
                  $history["data"]["fras"] = "<p>".$fras[$j]."</p>";
                  $history["data"]["btc"] = "<p>".$btc[$j]."</p>";
                  $history["data"]["kursBTCUSD"] = "<p>".$usd[$j]."</p>";
                  $history["data"]["bonus_log"] = "<p>".$bonusFRAS[$j]."</p>";
                  $history["data"]["hash_list"] = "<p><a href='https://blockchain.info/tx/".$hash[$j]."'>".$hash[$j]."</a></p>";
                  $history["data"]["username"] = "<p>".$user[$j]."</p>";
                }
                $j++;
              }

              $result["records"][$i] = array("timestamp"=>$history["data"]["timestamp"],"username"=>$history["data"]["username"],"btc"=>$history["data"]["btc"],"usd"=>$history["data"]["kursBTCUSD"],"fras"=>$history["data"]["fras"],"bonusFras"=>$history["data"]["bonus_log"],"transactionId"=>$history["data"]["hash_list"]);
          $i++;
        }

        $this->response($result);
    }
    function converter_get($param = null,$type="usd")
    {
      if($type == "usd")
      {
      $configuration = Configuration::apiKey($this->apiKey, $this->secretApi);
    	$client = Client::create($configuration);
    	$sellPrice = $client->getSellPrice('BTC-USD');
    	$btcUSD = (float)$client->decodeLastResponse()["data"]["amount"];
    	$client->getExchangeRates("USD");
    	$usdIDR = (float)$client->decodeLastResponse()["data"]["rates"]["IDR"];
      $sellPrice = $client->getSellPrice('BTC-USD');
    	$btcUSD = (float)$client->decodeLastResponse()["data"]["amount"];
    	$frs =  (float)((((150000000+((150000000/100)*3)) / $usdIDR) / $btcUSD) / 150000);
      $oneBTC = 1/$btcUSD; // Rate USD terhadap BTC, 1 USD = .. BTC
      if($param != null && is_numeric($param))
      {
        $oneBTC = $oneBTC*$param;//Param Inputan sistem berapa USD yang di input
        $frs = $oneBTC/$frs;//$frs rate fras terhadap btc 1 fras = .. btc, dikali dengan Rate USD terhadap BTC
      }
      $data = array("usdbtc"=>number_format($oneBTC,8),"fras"=>number_format($frs,8));
      $this->response($data);
    }elseif ($type == "btc") {
      $configuration = Configuration::apiKey($this->apiKey, $this->secretApi);
    	$client = Client::create($configuration);
    	$sellPrice = $client->getSellPrice('BTC-USD');
    	$btcUSD = (float)$client->decodeLastResponse()["data"]["amount"];
    	$client->getExchangeRates("USD");
    	$usdIDR = (float)$client->decodeLastResponse()["data"]["rates"]["IDR"];
      $sellPrice = $client->getSellPrice('BTC-USD');
    	$btcUSD = (float)$client->decodeLastResponse()["data"]["amount"];
    	$frs =  (float)((((150000000+((150000000/100)*3)) / $usdIDR) / $btcUSD) / 150000);
      $oneBTC = $btcUSD; // rate BTC terhadap USD 1 BTC  = .. USD
      if($param != null && is_numeric($param))
      {
        $oneBTC = $oneBTC*$param;
        $frs = ((1/$btcUSD)*$oneBTC/$frs); // Dihitung dengan mencari rate USD tergadap BTC, di kali rate BTC terhadap USD dibagi rate fras terhadap BTC
      }
      $data = array("btcusd"=>number_format($oneBTC,8),"fras"=>number_format($frs,8));
      $this->response($data);
    }elseif($type == "fras"){
      $configuration = Configuration::apiKey($this->apiKey, $this->secretApi);
    	$client = Client::create($configuration);
    	$sellPrice = $client->getSellPrice('BTC-USD');
    	$btcUSD = (float)$client->decodeLastResponse()["data"]["amount"];
    	$client->getExchangeRates("USD");
    	$usdIDR = (float)$client->decodeLastResponse()["data"]["rates"]["IDR"];
      $sellPrice = $client->getSellPrice('BTC-USD');
    	$btcUSD = (float)$client->decodeLastResponse()["data"]["amount"];
    	$frs =  (float)((((150000000+((150000000/100)*3)) / $usdIDR) / $btcUSD) / 150000);
      $oneBTC = 1/$btcUSD;
      if($param != null && is_numeric($param))
      {
        $frs = $frs*$param;
        $usdfras = $frs / $oneBTC;
      }
      $data = array("frasbtc"=>number_format($frs,8),"usdfras"=>number_format($usdfras,8));
      $this->response($data);
    }else{
      $this->response([],404);
    }
    }
    function twofa_get($status = null)
    {
      $this->_sessionRestrict();
      $this->load->model("update");
      if($status != null)
      {
        $dataUser = $this->update->read_user(array("login_id"=>$this->session->id_login))->result()[0];
        if($dataUser->tokenTwofactor == null)
        {
            $secret = $this->googleauthenticator->createSecret();
            $this->update->update_user($this->session->id_login,array("tokenTwofactor"=>$secret));
        }else{
            $secret = $dataUser->tokenTwofactor;
        }
        $qrCodeUrl = $this->googleauthenticator->getQRCodeGoogleUrl('Frasindo Login Guard', $this->session->username, $secret);
        if($status == "true")
        {
          $this->update->update_user($this->session->id_login,array("twofactor"=>1));
          $auth = (isset($qrCodeUrl))?$qrCodeUrl:null;
          $this->session->set_userdata("authy",1);
          $this->response(array("status"=>1,"msg"=>$auth),200);
        }elseif($status == "false"){
          $this->update->update_user($this->session->id_login,array("twofactor"=>0));
          $this->session->set_userdata("authy",0);
          $this->response(array("status"=>1,"msg"=>"Google 2FA Off"),200);
        }else{
            $this->response([],404);
        }
      }else{
        $this->response([],404);
      }
    }
    function trigger_get()
    {

      	$dbRate = $this->db->get_where("rate",array("id_rate"=>1));
      	$dbBTCUSD = (float)$dbRate->result()[0]->btcusd;
      	$dbUSDIDR = (float)$dbRate->result()[0]->usdidr;
      	$dbFRASCOIN = $dbRate->result()[0]->frascoin;
        $LastdbRate = $this->db->get_where("rate",array("id_rate"=>2));
      	$LastdbBTCUSD = $LastdbRate->result()[0]->btcusd;
      	$LastdbUSDIDR = $LastdbRate->result()[0]->usdidr;
      	$LastdbFRASCOIN = $LastdbRate->result()[0]->frascoin;
      	$configuration = Configuration::apiKey($this->apiKey, $this->secretApi);
      	$client = Client::create($configuration);
      	$sellPrice = $client->getSellPrice('BTC-USD');
      	$btcUSD = (float)$client->decodeLastResponse()["data"]["amount"];
      	$client->getExchangeRates("USD");
      	$usdIDR = (float)$client->decodeLastResponse()["data"]["rates"]["IDR"];
      	$frs =  (float)((((150000000+((150000000/100)*3)) / $usdIDR) / $btcUSD) / 150000);
      	$frs = number_format($frs,8);
      	if($btcUSD > $dbBTCUSD)
      	{
      	    $this->db->where("id_rate",1);
              $this->db->update("rate",array("btcusd"=>$btcUSD));
      	    $iconBTCUSD = "fa fa-caret-up up";
              $this->db->where("id_rate",2);
              $this->db->update("rate",array("btcusd"=>$iconBTCUSD));
      	}elseif($btcUSD < $dbBTCUSD){
              $this->db->where("id_rate",1);
              $this->db->update("rate",array("btcusd"=>$btcUSD));
              $iconBTCUSD = "fa fa-caret-down down";
              $this->db->where("id_rate",2);
              $this->db->update("rate",array("btcusd"=>$iconBTCUSD));
      	}else{
             $iconBTCUSD = $LastdbBTCUSD;
      	}

      	$btcIDR = $btcUSD * $usdIDR;
      	    if($btcIDR > $dbUSDIDR)
              {
                  $this->db->where("id_rate",1);
                  $this->db->update("rate",array("usdidr"=>$btcIDR));
                  $iconUSDIDR = "fa fa-caret-up up";
                  $this->db->where("id_rate",2);
                  $this->db->update("rate",array("usdidr"=>$iconUSDIDR));
              }elseif($btcIDR < $dbUSDIDR)
              {
                  $this->db->where("id_rate",1);
                  $this->db->update("rate",array("usdidr"=>$btcIDR));
                  $iconUSDIDR = "fa fa-caret-down down";
                  $this->db->where("id_rate",2);
                  $this->db->update("rate",array("usdidr"=>$iconUSDIDR));
              }else{
                 $iconUSDIDR = $LastdbUSDIDR;
              }
      	    if($frs > $dbFRASCOIN)
              {
                  $this->db->where("id_rate",1);
                  $this->db->update("rate",array("frascoin"=>$frs));
                  $iconFRASCOIN = "fa fa-caret-up up";
                  $this->db->where("id_rate",2);
                  $this->db->update("rate",array("frascoin"=>$iconFRASCOIN));
              }elseif($frs < $dbFRASCOIN)
              {
                  $this->db->where("id_rate",1);
                  $this->db->update("rate",array("frascoin"=>$frs));
                  $iconFRASCOIN = "fa fa-caret-down down";
                  $this->db->where("id_rate",2);
                  $this->db->update("rate",array("frascoin"=>$iconFRASCOIN));
              }else{
                  $iconFRASCOIN = $LastdbFRASCOIN;
              }
      	$this->response(array("IDR"=>array("icon"=>$iconUSDIDR,"value"=>number_format($btcIDR)),"USD"=>array("icon"=>$iconBTCUSD,"value"=>number_format($btcUSD,2)),"FRAS"=>array("icon"=>$iconFRASCOIN,"value"=>number_format($frs,8))));
    }
    function ticker_get()
    {
    	$dbRate = $this->db->get_where("rate",array("id_rate"=>1));
    	$dbBTCUSD = (float)$dbRate->result()[0]->btcusd;
    	$dbUSDIDR = (float)$dbRate->result()[0]->usdidr;
    	$dbFRASCOIN = $dbRate->result()[0]->frascoin;
      $LastdbRate = $this->db->get_where("rate",array("id_rate"=>2));
    	$LastdbBTCUSD = $LastdbRate->result()[0]->btcusd;
    	$LastdbUSDIDR = $LastdbRate->result()[0]->usdidr;
    	$LastdbFRASCOIN = $LastdbRate->result()[0]->frascoin;
    	$this->response(array("IDR"=>array("icon"=>$LastdbUSDIDR,"value"=>number_format($dbUSDIDR)),"USD"=>array("icon"=>$LastdbBTCUSD,"value"=>number_format($dbBTCUSD,2)),"FRAS"=>array("icon"=>$LastdbFRASCOIN,"value"=>number_format($dbFRASCOIN,8))));


    }
    function getDate_get()
    {
        $this->load->model("bill");
        $data = $this->bill->getCrowdsale();
        if($data->num_rows() > 0)
        {
          foreach ($data->result() as $key => $value) {
            $json = json_decode($value->meta_value);
            if(strtotime($json->data->timer_start) >= time())
            {

            }else{
              $a = new DateTime($json->data->timer_start);
              $b = new DateTime(date("d-m-Y H:i:s"));
              $diff = $b->diff($a);
              if($diff->format("%R%a") >= 0)
              {
                $status = "Running";
              }else{
                $status = "Runned";
              }
              if($status == "Running")
              {
                $time = strtotime($json->data->timer_end);
                $bonus = $json->data->timer_bonus;
                $timerType = $json->timer_type;
                break;
              }else{
                $time = strtotime($json->data->timer_end);
                $bonus = $json->data->timer_bonus;
                $timerType = "close";
              }
            }
          }
        }else{
          $time = strtotime(date("Y-m-d H:i:s"));
          $bonus = 0;
        }

        $this->response(array("bonus"=>$bonus,"type"=>$timerType,"time"=>date("Y-m-d H:i:s",$time),"curdate"=>date("Y-m-d H:i:s")));
    }
    function checkBalance_get($addr)
    {
      $param = "/nxt?=%2Fnxt&requestType=getAccountAssets&account=".$addr;
      try {
          $ch = curl_init();

          if (FALSE === $ch)
              throw new Exception('failed to initialize');

          curl_setopt($ch, CURLOPT_URL, $this->nxt_server.$param);
          curl_setopt($ch, CURLOPT_HEADER, false);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
          curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
          curl_setopt($ch, CURLOPT_POST, true);

          $content = curl_exec($ch);

          if (FALSE === $content)
              throw new Exception(curl_error($ch), curl_errno($ch));
           $data =  json_decode($content);
           $this->response(array("status"=>1,"data"=>$data));
      } catch(Exception $e) {
          trigger_error(sprintf(
              'Curl failed with error #%d: %s',
              $e->getCode(), $e->getMessage()),
              E_USER_ERROR);

      }
    }
    function createNXT_get()
    {
        $this->_sessionRestrict();
        $this->load->helper("string");
        $autoGen = random_string("alnum",35);
        try {
            $ch = curl_init();

            if (FALSE === $ch)
                throw new Exception('failed to initialize');

            curl_setopt($ch, CURLOPT_URL, $this->nxt_server.'/nxt?requestType=getAccountId&secretPhrase='.$autoGen);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
            curl_setopt($ch, CURLOPT_POST, true);

            $content = curl_exec($ch);

            if (FALSE === $content)
                throw new Exception(curl_error($ch), curl_errno($ch));
             $data =  json_decode($content);
             try {
                 $ch = curl_init();

                 if (FALSE === $ch)
                     throw new Exception('failed to initialize');

                 curl_setopt($ch, CURLOPT_URL, $this->nxt_server.'/nxt?requestType=generateToken');
                 curl_setopt($ch, CURLOPT_HEADER, false);
                 curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
                 curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
                 curl_setopt($ch, CURLOPT_POST, true);
                 curl_setopt($ch, CURLOPT_POSTFIELDS,"=%2Fnxt&requestType=generateToken&website=frasindo.com&secretPhrase=".$autoGen);
                 $content = curl_exec($ch);
                 if (FALSE === $content)
                     throw new Exception(curl_error($ch), curl_errno($ch));
                  $dataJson =  json_decode($content);

             } catch(Exception $e) {
                 trigger_error(sprintf(
                     'Curl failed with error #%d: %s',
                     $e->getCode(), $e->getMessage()),
                     E_USER_ERROR);

             }
             $this->load->model("bill");
             $this->response(array("status"=>1,"data"=>array("nxt_address"=>$data->accountRS,"public_key"=>$data->publicKey,"secretKey"=>$autoGen,"token"=>$dataJson->token,"card"=>$this->bill->generateCard($data->accountRS,$autoGen))));
        } catch(Exception $e) {
            trigger_error(sprintf(
                'Curl failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);

        }

    }
    function validNXT_post()
    {
	     $this->_sessionRestrict();
        $autoGen = $this->input->post("address");
        try {
            $ch = curl_init();

            if (FALSE === $ch)
                throw new Exception('failed to initialize');

            curl_setopt($ch, CURLOPT_URL, $this->nxt_server.'/nxt?=%2Fnxt&requestType=getAccount&account='.$autoGen);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
            curl_setopt($ch, CURLOPT_POST, true);

            $content = curl_exec($ch);

            if (FALSE === $content)
                throw new Exception(curl_error($ch), curl_errno($ch));
             $data =  json_decode($content);
             if(isset($data->accountRS))
             {
                $this->response(array("status"=>1,"data"=>array("nxt_address"=>$data->accountRS)));
             }else{
                $this->response(array("status"=>0,"data"=>$data));
             }
        } catch(Exception $e) {
            trigger_error(sprintf(
                'Curl failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);

        }

    }
    function saveNXT_post()
    {
        	$this->_sessionRestrict();
          $this->load->model("acc");
          $addr = $this->input->post("nxt_address",true);
          $token = $this->input->post("token",true);
          $cek = $this->acc->cekToken($token,$addr);
          if($cek)
          {
              $configuration = Configuration::apiKey($this->apiKey, $this->secretApi);
              $client = Client::create($configuration);
                if($addr != null)
                {
      	           $account = new Account([
                  'name' => $addr
                ]);
              $client->createAccount($account);
              $data = $client->decodeLastResponse();
              $id = $data["data"]["id"];
              $acc = Account::reference($id);
                $address = new Address([
                  'name' => $addr
                ]);
              $client->createAccountAddress($acc, $address);
              $btc_addr = $client->decodeLastResponse()["data"]["address"];
              $update = $this->acc->updateNXT($addr,$btc_addr,$this->session->id_login);
              $update2 = $this->db->where("nxt_address",$this->session->nxt_address)->update("carcoin",array("nxt_address"=>$addr));
              if($update && $update2)
              {
                  $this->session->unset_userdata("nxt_address");
                  $this->session->set_userdata("nxt_address",$addr);
              		$this->session->unset_userdata("btc_address");
              		$this->session->set_userdata("btc_address",$btc_addr);
                  $this->response(array("status"=>1,"msg"=>"Update NXT Account Successfully"));
              }else{
                  $this->response(array("status"=>0,"msg"=>"Update NXT Account Failed"));
              }
            }else{
                $this->response(array("status"=>0,"msg"=>"Address is Null"));
            }
          }else{
            $this->response(array("status"=>0,"msg"=>"Wrong Token"));
          }

    }
    function showAllTrx_get()
    {
	      $this->_sessionRestrict();
        $configuration = Configuration::apiKey($this->apiKey,$this->secretApi);
        $client = Client::create($configuration);
        $client->getAccounts();
        $data = $client->decodeLastResponse()["data"];
        foreach($data as $list_key => $value){
            $id_acc =  Account::reference($value["id"]);
            $client->getAccountTransactions($id_acc);
            foreach($client->decodeLastResponse()["data"] as $dataWallet)
            {

                $dataResult[] = array("account"=>$value["name"],"amount"=>$dataWallet["amount"]["amount"],"create_at"=>$dataWallet["created_at"],"hash"=>$dataWallet["network"]["hash"],"status"=>$dataWallet["network"]["status"],"details"=>$dataWallet["details"]["title"]);
            }
        }
        $this->response($dataResult);
    }
    function showTrx_get()
    {
      	$this->_sessionRestrict();
      	$this->load->model("bill");
        $configuration = Configuration::apiKey($this->apiKey, $this->secretApi);
        $client = Client::create($configuration);
      	$client->getAccounts();
      	$data = $client->decodeLastResponse()["data"];
      	$id_acc = "";
      	foreach($data as $list_key => $value){
      	   if($value["name"] == $this->session->nxt_address){
      		     $id_acc =  Account::reference($value["id"]);
      	   }else{
             $id_acc = 0;
           }
      	}
        if($id_acc != 0)
        {
        	  $client->getAccountTransactions($id_acc);
            $data = $client->decodeLastResponse();
            $btcRate = $this->db->get_where("rate",array("id_rate"=>1))->result()[0]->btcusd;
            $rateFras = $this->db->get_where("rate",array("id_rate"=>1))->result()[0]->frascoin;
            $rateIDR = $this->db->get_where("rate",array("id_rate"=>1))->result()[0]->usdidr;
            $datacrowdsale = $this->bill->getBonusNow(date("d-m-Y"));
            $date_target = $datacrowdsale["end"];
            for($i = 0; $i <= count($data["data"]) - 1; $i++)
            {
            	$curdate = new DateTime($data["data"][$i]["created_at"]);
            	$result_date = $date_target->diff($curdate);
            	$days = $result_date->format("%a");
            	$percentBonus = $datacrowdsale["bonus"]; //
            	if(!isset($data["data"][$i]["network"]))
                {
                	$percentBonus = 0;
                }elseif(!($data["data"][$i]["amount"]["amount"] > 0))
                {
                	$percentBonus = 0;
                }
              $myFras = ($data["data"][$i]["amount"]["amount"]*$rateIDR) / ($rateFras*$rateIDR);
            	$id = $data["data"][$i]["id"];
            	$btc_log = $data["data"][$i]["amount"]["amount"];
            	$fras_log = $myFras;
            	$bonus_log = ($percentBonus*$myFras)/100;
            	if(isset($data["data"][$i]["network"]["hash"]))
                {
                	$hash_log = $data["data"][$i]["network"]["hash"];
                  $cekIn = $this->db->get_where("userPurchase",array("hash_log"=>$hash_log))->num_rows();
                }else{
                	$hash_log = "";
                  $cekIn = 1;
                }

            if(isset($data["data"][$i]["network"]["hash"]) && $cekIn < 1)
            {
              $getFixed = $this->db->get_where("crowdsale",array("id_crowdsale"=>$datacrowdsale["id_crowdsale"]))->row()->coinsell;
              $cals = array("coinsell"=>$getFixed - ($fras_log+$bonus_log));
              $insertFixed = $this->db->where("id_crowdsale",$datacrowdsale["id_crowdsale"])
              ->update("crowdsale",$cals);
            }
          	$date = strtotime($data["data"][$i]["created_at"]);
            $insertLog = $this->bill->insertLog(array("user_id"=>$this->session->id_login,"frasrate_log"=>$rateFras,"btcrate_log"=>$btcRate,"id_log"=>$id,"fras_log"=>$fras_log,"btc_log"=>$btc_log,"bonus_log"=>$bonus_log,"hash_log"=>$hash_log,"persen_bonus"=>$percentBonus,"date"=>date("Y-m-d h:i:s",$date)));
            }
            for($i = 0; $i <= count($data["data"]) - 1; $i++)
            {
            	$viewLog = $this->bill->readLog(array("id_log"=>$data["data"][$i]["id"]));
            	$id = $viewLog->result()[0]->id_log;
            	$fras = $viewLog->result()[0]->fras_log;
            	$btc = $viewLog->result()[0]->btc_log;
            	$bonus = $viewLog->result()[0]->bonus_log;
            	$hash = $viewLog->result()[0]->hash_log;
              $ratelog = $viewLog->result()[0]->btcrate_log;
              $frasrate_log = $viewLog->result()[0]->frasrate_log;
            	$persen_bonus = $viewLog->result()[0]->persen_bonus;
            	if($hash != null)
                {
                	$data["data"][$i]["network"]["hash"] = $hash;
                }
            	$data["data"][$i]["amount"]["amount"] = $btc;
            	$data["data"][$i]["bonus"] = array("percent"=>$persen_bonus,"amount"=>number_format($fras,8));
              $data["data"][$i]["rate"] = array("btc"=>$ratelog,"fras"=>$frasrate_log);
            }
             $this->response($data);
        }else{
          $this->response([],200);
        }
    }
    function reddem_post()
    {
      $this->_sessionRestrict();
      $this->load->model("bill");
      $code = $this->input->post("code",true);
      $to = $this->input->post("to",true);
      $data = $this->bill->redeemCode($code,$to);
      $this->response($data);
    }
    function myAddress_get()
    {
      $this->_sessionRestrict();
      $id = $this->session->nxt_address;
      $id_users = (isset($this->db->get_where("user_info",array("nxt_address"=>$id))->result()[0]->id_users))?$this->db->get_where("user_info",array("nxt_address"=>$id))->result()[0]->id_users:0;
      $this->db->select("nxt_address");
      $dataAkun = $this->db->get_where("setAcc",array("id_user"=>$id_users))->result();
      $html = "";
      foreach ($dataAkun as $key => $value) {
        $html .= "<option value='".$value->nxt_address."'>".$value->nxt_address."</option>";
      }
      $html .= "<option value='".$this->session->nxt_address."'>".$this->session->nxt_address."</option>";
      $this->response(array("status"=>1,"data"=>$html));
    }
    function voucher_post()
    {
      $this->_sessionRestrict();
      $this->load->model("bill");
      $sender = $this->input->post("sender",true);
      $total =  $this->input->post("total",true);
      $data = $this->bill->createCoupon($total,$sender);
      $this->response($data);
    }
    function send_post()
    {
      $this->_sessionRestrict();
      $sender = $this->input->post("sender",true);
      $target =  $this->input->post("target",true);
      $total =  $this->input->post("total",true);
      $this->load->model("bill");
      $data = $this->bill->sendCar($sender,$target,$total);
      $this->response($data);
    }
    function transferAll_post()
    {
      $this->_sessionRestrict();
      $addr = $this->input->post("addr",true);
      $this->load->model("bill");
      $current_sender = (isset($this->db->get_where("carcoin",array("nxt_address"=>$addr))->result()[0]->balance))?$this->db->get_where("carcoin",array("nxt_address"=>$addr))->result()[0]->balance:-1;
      $tf = $this->bill->sendCar($addr,$this->session->nxt_address,$current_sender);
      $this->response($tf);
    }
    function testytd_get()
    {
      $this->load->model("campaign_model");
      $a = $this->campaign_model->getAdminYt();
      $this->response($a);
    }
    function savecode_post()
    {
      $this->_sessionRestrictCampaign();
      $this->load->model("campaign_model");
      $data = $this->input->post(null,true);
      $ins = $this->campaign_model->savecode($data);
      $this->response($ins);
    }
    function savelinktrans_post()
    {
      $this->_sessionRestrictCampaign();
      $this->load->model("campaign_model");
      $data = $this->input->post(null,true);
      $data["users_id"] = $this->session->id_users;
      $data["created"] = date("Y-m-d");
      $ins = $this->campaign_model->savelinktrans($data);
      $this->response($ins);
    }
    function savelinksign_post()
    {
      $this->_sessionRestrictCampaign();
      $this->load->model("campaign_model");
      $data = $this->input->post(null,true);
      $data["users_id"] = $this->session->id_users;
      $data["created"] = date("Y-m-d");
      $ins = $this->campaign_model->savelinksign($data);
      $this->response($ins);
    }
    function savelink_post()
    {
      $this->_sessionRestrictCampaign();
      $this->load->model("campaign_model");
      $data = $this->input->post(null,true);
      $data["users_id"] = $this->session->id_users;
      $data["created"] = date("Y-m-d");
      $ins = $this->campaign_model->savelink($data);
      $this->response($ins);
    }
    function savecodeytd_post()
    {
      $this->_sessionRestrictCampaign();
      $this->load->model("campaign_model");
      $data = $this->input->post(null,true);
      $ins = $this->campaign_model->savecodeytd($data);
      $this->response($ins);
    }
    function validateVlog_get($hastag="",$chanelID="")
    {
      $this->load->library("youtubebridge");
      $data = $this->youtubebridge->create("AIzaSyDmdNm9boAF7E2DKbh2hoNNCx1CxE0e-qo");
      $d = $data->searchChannelVideos("#".$hastag,$chanelID,50);
      if($d != false)
      {
        foreach ($d as $key => $value) {
            $id = $value->id->videoId;
            $vid = $data->getVideoInfo($id);
        }
        $this->load->model("campaign_model");
        $a = $this->campaign_model->checkValidateYt($hastag);
        $s = (object) array();
        $s->validate = $a;
        $s->uniqcode = $hastag;
        $s->duration = $vid->contentDetails->duration;
        $s->nama = $vid->snippet->title;
        $s->description = $vid->snippet->description;
        $s->publishedAt = $vid->snippet->publishedAt;
        $s->link = "https://www.youtube.com/watch?v=".$id;
        $ps = (object) array("status"=>1,"data"=>$s);
        $this->response($ps);
      }else{
        $this->response(array("status"=>0,"msg"=>"Data Not Found","uniqcode"=>$hastag));
      }
    }
    function uniqidytd_get()
    {
        $this->_sessionRestrictCampaign();
        $sesion = $this->session->id_users;
        $this->load->model("campaign_model");
        $data = $this->campaign_model->getUniqidYtd($sesion);
        $this->response($data->result());
    }
    function uniqid_get()
    {
        $this->_sessionRestrictCampaign();
        $sesion = $this->session->id_users;
        $this->load->model("campaign_model");
        $data = $this->campaign_model->getUniqid($sesion);
        $this->response($data->result());
    }
    function generatecode_get()
    {
      $this->_sessionRestrictCampaign();
      $this->load->helper('string');
      $random = random_string("alnum",9);
      $code = $this->session->id_users.strtoupper($random);
      $this->response(array("code"=>$code));
    }
    function validateTweet_get($uniqid,$screen)
    {
        $this->_sessionRestrictCampaign();
        $this->load->model("campaign_model");
        $connection = $this->twitteroauth->create("4UNV33LnWcuDPoEP83Lh3Y5QP", "jyCdZ91Kjv24ee5QWVR7EqMCLpr3sZiHrqI5WEJnoLaGKDdF0T", "851537719037538304-EPcXDDbklX4W9yyg4VqrQC2OwvdDPkR", "rjk2OYFkamgi1BEjyywZrNv76KTMQhZ5zyHBJpVcoF7fZ");
        $o = $this->campaign_model->getTwitterUniq($uniqid);
        if($o->num_rows() > 0)
        {
          if($o->result()[0]->id_tweet != null)
          {
            $data = array(
                      'id' => $o->result()[0]->id_tweet
                    );
            $c = $connection->get('statuses/show',$data);
            $content = array();
            $content = (object) $content;
            $content->statuses[0] = $c;
            $d = $this->campaign_model->checkValidate($uniqid);
            $content->validTweet = $d;
            $this->response(array("status"=>1,"msg"=>"Found its","ucode"=>$uniqid,"data"=>$content));
          }else{
            $data = array(
                      'q' => "#".$uniqid,
                      'count'=>1
                    );
            $content = $connection->get('search/tweets',$data);
            $hitung = count($content->statuses);
            if($hitung > 0)
            {
              $sname = $content->statuses[0]->user->screen_name;
              $idTweet = $content->statuses[0]->id_str;
              if($sname == $screen)
              {
                $d = $this->campaign_model->checkValidate($uniqid);
                $content->validTweet = $d;
                $this->campaign_model->updateIdTweet($idTweet,$uniqid);
                $this->response(array("status"=>1,"msg"=>"Found it","ucode"=>$uniqid,"data"=>$content));
              }else{
                $this->response(array("status"=>0,"msg"=>"User or Tweet Not Found","ucode"=>$uniqid));
              }
            }else{
              $this->response(array("status"=>0,"msg"=>"User or Tweet Not Found","ucode"=>$uniqid));
            }
          }
        }else{
          $this->response(array("status"=>0,"msg"=>"User or Tweet Not Found","ucode"=>$uniqid));
        }

    }
    function getFolowers_get($name="",$req = 20)
    {
      $this->load->model("campaign_model");
      $required = $this->campaign_model->getFolowers($name,$req);
      $this->response($required);
    }
    function test_get()
    {
      $this->load->library("telegrambridge");
      $tg = $this->telegrambridge->init("454439416:AAHHNQJEUzNkK3DSDwXKBaNc8r5fEVYSuls","frasindo_bot","FrasindoWatch");
      if($tg->text_command("start")){
          $tg->send
            ->text("Hi!")
          ->send();
        }
      $this->response($tg);
    }
    function sendmail_post()
    {
      $this->load->model("sendmail");
      $it = $this->sendmail->forgot($this->input->post("email",true));
      $this->response($it);
    }
    function loginAdmin_post()
    {
      $this->load->model("auth");
      $email = $this->input->post("email",true);
      $pass = base64_decode($this->input->post("pass",true));
      $validate = filter_var($email, FILTER_VALIDATE_EMAIL);
      if($validate == true)
      {
        $data = $this->auth->login($email,$pass);
        if($data["status"] == 1 && $data["data"]->access == 1)
        {
            $loginData = $data["data"];
            $this->session->set_userdata("id_login",$loginData->id_login);
            $this->session->set_userdata("access",$loginData->access);
            $this->session->set_userdata("email",$loginData->email);
            $this->session->set_userdata("username",$loginData->username);
            $this->session->set_userdata("nama",$loginData->nama);
            $this->session->set_userdata("admin_id",$loginData->admin_id);
        }else{
          $data = array("status"=>0,"msg"=>"Username and Password Wrong");
        }
        $this->response($data);
      }else{
        $this->response(array("status"=>0,"msg"=>"Email Not Valid"));
      }
    }
    function loginCampaign_post()
    {
      $this->load->model("campaign_model");
      $email = $this->input->post("email",true);
      $pass = base64_decode($this->input->post("pass",true));
      $data = $this->campaign_model->login($email,$pass);
      $this->response($data);
    }
    function login_post()
    {
        $this->load->model("auth");
        $email = $this->input->post("email",true);
        $pass = base64_decode($this->input->post("pass",true));
        $validate = filter_var($email, FILTER_VALIDATE_EMAIL);
        if($validate == true)
        {
            $data = $this->auth->login($email,$pass);
            if($data["status"] == 1 && $data["data"]->access == 0)
            {
                $loginData = $data["data"];
                $temp = $this->auth->autloginWP($loginData->email);
                if($temp["status"] == 1)
                {
                  $this->session->set_userdata("id_login",$loginData->id_login);
                  $this->session->set_userdata("access",$loginData->access);
                  $this->session->set_userdata("nxt_address",$loginData->nxt_address);
  		            $this->session->set_userdata("btc_address",$loginData->btc_address);
                  $this->session->set_userdata("email",$loginData->email);
                  $this->session->set_userdata("avatar",$loginData->avatar);
                  $this->session->set_userdata("username",$loginData->username);
                  $this->session->set_userdata("nama",$loginData->nama);
                  $this->session->set_userdata("authy",$loginData->authy);
                  $this->session->set_userdata("linkLogin",$temp["code"]);
                  $data["code"] = $temp["code"];
                }else{
                  $data = $temp;
                }
            }else{
              $data = array("status"=>0,"msg"=>"Username and Password Wrong");
            }
            $this->response($data);
        }else{
            $this->response(array("status"=>0,"msg"=>"Email Not Valid"));
        }
    }
    function addUser_post()
    {
      $this->_sessionRestrictAdmin();
      $this->load->model("adminpanel");
      $email = $this->input->post("email",true);
      $nama = $this->input->post("nama",true);
      $user = $this->input->post("user",true);
      $wa = $this->input->post("wa",true);
      $line = $this->input->post("line",true);
      $bd = $this->input->post("birthday",true);
      $pass = base64_decode($this->input->post("pass",true));
      $validate = filter_var($email, FILTER_VALIDATE_EMAIL);
      if($validate == true)
      {
          $data = $this->adminpanel->createUser($email,$pass,$nama,$user,$wa,$line,$bd);
          $this->response($data);
      }else{
          $this->response(array("status"=>0,"msg"=>"Email Not Valid"));
      }
    }
    function register_post()
    {
        $this->load->model("auth");
        $email = $this->input->post("email",true);
        $nama = $this->input->post("nama",true);
        $user = $this->input->post("user",true);
        $wa = $this->input->post("wa",true);
        $line = $this->input->post("line",true);
        $bd = $this->input->post("birthday",true);
        $pass = base64_decode($this->input->post("pass",true));
        $validate = filter_var($email, FILTER_VALIDATE_EMAIL);
        if($validate == true)
        {
            $data = $this->auth->register($email,$pass,$nama,$user,$wa,$line,$bd);
            $this->response($data);
        }else{
            $this->response(array("status"=>0,"msg"=>"Email Not Valid"));
        }
    }
}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';
include APPPATH . 'third_party/coinbase/vendor/autoload.php';
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
    public $nxt_server = "http://server.frasindo.com:49515";
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
	$this->apiKey = "bOFtsDfxvaDZ7wzW";
	$this->secretApi = "aBk57n9ptZZPNOE2wmmlJ4cfgpNe6oiG";	
    }
    protected function _sessionRestrict()
    {
    	if($this->session->access == null)
	{
	    //$this->response(array("status"=>0));
	    exit(json_encode(array("status"=>0)));     
	}   	
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
        
            
	//var_dump(array("icon"=>$iconUSDIDR,"non-db"=>$btcIDR,"db"=>$dbUSDIDR));
	//echo $iconUSDIDR.$btcIDR."-".$dbUSDIDR;
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
        
	//var_dump(array("icon"=>$iconUSDIDR,"non-db"=>$btcIDR,"db"=>$dbUSDIDR));
	$this->response(array("IDR"=>array("icon"=>$iconUSDIDR,"value"=>number_format($btcIDR)),"USD"=>array("icon"=>$iconBTCUSD,"value"=>number_format($btcUSD,2)),"FRAS"=>array("icon"=>$iconFRASCOIN,"value"=>number_format($frs,8))));
	
		
    }
    function getDate_get()
    {
        $get = $this->db->get_where("timerCrowdsale",array("id_timer"=>1));
        $this->response(array("time"=>$get->result()[0]->timer,"curdate"=>date("Y-m-d")));
    }
    function createNXT_get()
    {
	$this->_sessionRestrict();
        $autoGen = $this->encrypt->encode(rand(1000,100000));
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
             $this->response(array("status"=>1,"data"=>array("nxt_address"=>$data->accountRS,"public_key"=>$data->publicKey,"secretKey"=>$autoGen)));
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
        $configuration = Configuration::apiKey($this->apiKey, $this->secretApi);
        $client = Client::create($configuration);
        $addr = $this->input->post("nxt_address",true);
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
            if($update)
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
            $this->response(array("status"=>0,"msg"=>"Address is Null Please Wait"));
        }
        
    }
    function showAllTrx_get()
    {
	    $this->_sessionRestrict();
        $configuration = Configuration::apiKey("bOFtsDfxvaDZ7wzW","aBk57n9ptZZPNOE2wmmlJ4cfgpNe6oiG");
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
	$configuration = Configuration::apiKey($this->apiKey, $this->secretApi);
        $client = Client::create($configuration);
	$client->getAccounts();
	$data = $client->decodeLastResponse()["data"];
	$id_acc = "";
	foreach($data as $list_key => $value){
	   if($value["name"] == $this->session->nxt_address){
		//echo "Found It : ".$this->session->nxt_address;break;
		$id_acc =  Account::reference($value["id"]);
	   }
	 //print_r($value);break;
	}
	$client->getAccountTransactions($id_acc);
    $data = $client->decodeLastResponse();
    $rateFras = $this->db->get_where("rate",array("id_rate"=>1))->result()[0]->frascoin;
    $rateIDR = $this->db->get_where("rate",array("id_rate"=>1))->result()[0]->usdidr;
    $date_target = new DateTime($this->db->get_where("timerCrowdsale",array("id_timer"=>1))->result()[0]->timer);
    for($i = 0; $i <= count($data["data"]) - 1; $i++)
    {
    $curdate = new DateTime($data["data"][$i]["created_at"]);
    $result_date = $date_target->diff($curdate);
    $days = $result_date->format("%a");
    if ($days == 15)
	{
	$percentBonus = 23.08;
	}elseif ($days == 14)
	{
	$percentBonus = 18.46;
	}elseif ($days <= 13 && $days > 10)
	{
	$percentBonus = 15.38;
	}elseif ($days <= 10 && $days > 7)
	{
	$percentBonus = 10.77;
	}elseif ($days <= 7 && $days > 4)
	{
	$percentBonus = 7.69;
	}elseif ($days <= 4 && $days > 1)
	{
	$percentBonus = 3.85;
	}else{
	$percentBonus = 0;
	}
    	if(!isset($data["data"][$i]["network"]))
        {
        	$percentBonus = 0;
        }elseif(!($data["data"][$i]["amount"]["amount"] > 0))
        {
        	$percentBonus = 0;
        }
    
        $myFras = ($data["data"][$i]["amount"]["amount"]*$rateIDR) / ($rateFras*$rateIDR);
    	$data["data"][$i]["bonus"] = array("percent"=>$percentBonus,"amount"=>number_format($myFras,8));
    }
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
            if($data["status"] == 1)
            {
                $loginData = $data["data"];
                $this->session->set_userdata("id_login",$loginData->id_login);
                $this->session->set_userdata("access",$loginData->access);
                $this->session->set_userdata("nxt_address",$loginData->nxt_address);
		        $this->session->set_userdata("btc_address",$loginData->btc_address);
                $this->session->set_userdata("email",$loginData->email);
                $this->session->set_userdata("avatar",$loginData->avatar);
                $this->session->set_userdata("username",$loginData->username);
                $this->session->set_userdata("nama",$loginData->nama);
                $this->session->set_userdata("authy",$loginData->authy);
            }
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

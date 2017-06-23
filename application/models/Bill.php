<?php ('BASEPATH') OR exit('No direct script access allowed');
include APPPATH . 'third_party/coinbase/vendor/autoload.php';
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Address;
use Coinbase\Wallet\Resource\Account;
class Bill extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }
    function cekServer($apiKey,$secretApi)
    {
        $configuration = Configuration::apiKey($apiKey, $secretApi);
        $client = Client::create($configuration);
        $client->getAccounts();
        $subJumlah = 0;
        $data = $client->decodeLastResponse()["data"];
	    $id_acc = "";
        foreach($data as $list_key => $value){
	     if($this->session->nxt_address == $value["name"]){
	        $id_acc =  Account::reference($value["id"]);
	        break;
	     }
         }
         if($id_acc != null)
         {
         $client->getAccountTransactions($id_acc);
         $subJumlah = 0;
            foreach($client->decodeLastResponse()["data"] as $dataWallet)
            {
                $subJumlah = $subJumlah + (float) $dataWallet["amount"]["amount"];
            }
        return $subJumlah;
        }else{
        return 0;
        }
    }
    function _checkCoinbase($service,$apiKey,$secretApi)
    {
            try{
                 $this->cekServer($apiKey,$secretApi);
            }catch(Exception $e){
                show_error("Sorry Service ".$service." Not Responding <br> Massage :".$e->getMessage(),400,'Our Server is Down for Maintenance');
            }
    }
    function totalInvest($apiKey,$secretApi){
    	
        $configuration = Configuration::apiKey($apiKey, $secretApi);
        $client = Client::create($configuration);
        $client->getAccounts();
        $subJumlah = 0;
        $data = $client->decodeLastResponse()["data"];
        foreach($data as $list_key => $value){
            $id_acc =  Account::reference($value["id"]);
            $client->getAccountTransactions($id_acc);
            foreach($client->decodeLastResponse()["data"] as $dataWallet)
            {

                $subJumlah = $subJumlah + (float) $dataWallet["amount"]["amount"]; 	   
            }
        }
        return $subJumlah;
    }
    function getFixedFras()
    {
    	$db = $this->db->get_where("fixed",array("id"=>1))->result()[0]->frascoin;
	return $db;
    }
    function getWallet($apiKey,$secretApi)
    {
	    $configuration = Configuration::apiKey($apiKey, $secretApi);
        $client = Client::create($configuration);
        $client->getAccounts();
        $subJumlah = 0;
        $data = $client->decodeLastResponse()["data"];
	    $id_acc = "";
        foreach($data as $list_key => $value){
	     if($this->session->nxt_address == $value["name"]){
	        $id_acc =  Account::reference($value["id"]);
	        break;
	     }
         }
         if($id_acc != null)
         {
         $client->getAccountTransactions($id_acc);
         $subJumlah = 0;
            foreach($client->decodeLastResponse()["data"] as $dataWallet)
            {
                $subJumlah = $subJumlah + (float) $dataWallet["amount"]["amount"];
            }
        return $subJumlah;
        }else{
        return 0;
        }

    }
}
?>


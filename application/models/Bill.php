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
}
?>


<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include APPPATH . 'third_party/coinbase/vendor/autoload.php';
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Address;
use Coinbase\Wallet\Resource\Account;
class Coinbase extends CI_Controller {
	public function index()
	{
	
        $date = new DateTime();
        $configuration = Configuration::apiKey("bOFtsDfxvaDZ7wzW", "aBk57n9ptZZPNOE2wmmlJ4cfgpNe6oiG");
        $client = Client::create($configuration);
       	$account = new Account([
  	     'name' => 'Last Dompet'
        ]);
        $client->createAccount($account);
        $data = $client->decodeLastResponse();
        $id = $data["data"]["id"];
        $acc = Account::reference($id);
        $account = $client->getAccount($id);
        print_r($client->decodeLastResponse());
    }
}

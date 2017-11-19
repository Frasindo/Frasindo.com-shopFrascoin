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
    function getCrowdsale($by='')
    {
        if($by != '')
        {
          return $this->db->select("*")->from("crowdsale a")->join("crowdsale_meta b","b.crowdsale_id=a.id_crowdsale")->where("a.id_crowdsale",$by)->get();
        }else{
          return $this->db->select("*")->from("crowdsale a")->join("crowdsale_meta b","b.crowdsale_id=a.id_crowdsale")->get();
        }
    }
    function getBonusNow($date)
    {
      $bigdata = $this->db->get("crowdsale_meta");
      $data = array();
      $i = 0 ;
      foreach ($bigdata->result() as $key => $value) {
        $json = json_decode($value->meta_value);
        $date_start = $json->data->timer_start;
        $date_start = explode(" ",$date_start);

        $date_end = $json->data->timer_end;
        $date_end = explode(" ",$date_end);
        $date_bonus = $json->data->timer_bonus;
        $data[$i++] = array("start"=>$date_start[0],"end"=>$date_end[0],"bonus"=>$date_bonus,"id_crowdsale"=>$value->crowdsale_id);
      }
      $nows = date("d-m-Y");
      $nows = strtotime($nows);
      $x = 0;
      for($b = 0; $b < count($data); $b++) {
        $start = strtotime($data[$b]["start"]);
        $end = strtotime($data[$b]["end"]);
        if($nows >= $start && $nows <= $end)
        {
          $dataReturn = array("start"=>date("d-m-Y",$start),"end"=>date("d-m-Y",$end),"bonus"=>$data[$b]["bonus"],"id_crowdsale"=>$data[$b]["id_crowdsale"]);
          break;
        }else{
          $dataReturn = false;

        }
      }
      if($dataReturn != false)
      {
        return $dataReturn;
      }else{
        return array("start"=>date("d-m-Y"),"end"=>date("d-m-Y"),"bonus"=>0,"id_crowdsale"=>0);
      }
    }
    function carcoinHistory($login_id)
    {
      $data = $this->db->get_where("user_info",array("login_id"=>$login_id));
      if($data->num_rows() > 0)
      {
        $primary = $data->result()[0]->nxt_address;
        $id_users = $data->result()[0]->id_users;
        $setAcc = $this->db->get_where("setAcc",array("id_user"=>$id_users));
        $addr = array();
        if($setAcc->num_rows() > 0)
        {
          $i = 0;
          foreach ($setAcc->result() as $key => $value) {
            $addr[$i++] = $value->nxt_address;
          }
          $addr[$i+1] = $primary;
        }else{
          $addr[0] = $primary;
        }
        $logdata = array();
        $i = 0;
        foreach ($addr as $d) {
          $log = $this->db->order_by("created","desc")->where("sender='".$d."' OR target='".$d."'")->get("carcoin_log");
          if($log->num_rows() > 0)
          {
            foreach ($log->result() as $key => $value) {
              if(strlen($value->sender) < 2)
              {
                  if($value->sender == 0)
                  {
                    $trxType = "REDEEM VOUCHER";
                  }else{
                    $trxType = "DAILY CARCOIN";
                  }
              }elseif(strlen($value->target) < 2)
              {
                if($value->target == 0)
                {
                  $trxType = "CREATE VOUCHER";
                }
              }elseif(strlen($value->target) > 1){
                if($value->target == $d)
                {
                  $trxType = "RECEIVE FROM (".$value->sender.")";
                }else{
                  $trxType = "SEND TO (".$value->target.")";
                }
              }
              $logdata[$i++] = array("trx_name"=>$trxType,"carcoin"=>$value->carcoin,"date"=>date("Y-m-d H:i", strtotime($value->created)));
            }
          }
        }
        return array("status"=>1,"data"=>$logdata);
      }else{
        return array("status"=>0,"msg"=>"Empty Result");
      }
    }
    function generateCard($addr,$sec)
    {
      $dest = imagecreatefrompng("http://www.frasindo.com/card/pwv_ardor.png");
      $ardor = imagecreatefrompng("http://chart.apis.google.com/chart?cht=qr&chs=340x340&chl=".$addr."&chld=H|0");
      $secret = imagecreatefrompng("http://chart.apis.google.com/chart?cht=qr&chs=350x350&chl=".$sec."&chld=H|0");
      $textcolor = imagecolorallocate($dest,0,0,0);
      $font = "assets/OpenSans-Regular.ttf";
      $fontSize = "18";
      ob_start();
      imagettftext($dest, 25, 90, 570, 750, $textcolor, $font, $addr);
      imagettftext($dest, 25, 90, 1268, 1620, $textcolor, $font,$sec);
      imagecopymerge($dest, $ardor,94,424, 0, 0, 340, 340, 100);
      imagecopymerge($dest, $secret,1328,915, 0, 0, 350, 350, 100);
      imagepng($dest);
      imagedestroy($dest);
      imagedestroy($src);
      $imageVoucher = base64_encode(ob_get_contents());
      ob_end_clean();
      return $imageVoucher;
    }
  function generateVoucherPicture($a,$b)
  {
      $dest = imagecreatefrompng("http://www.frasindo.com/card/pwv_car.png");
      $qr = imagecreatefrompng("http://chart.apis.google.com/chart?cht=qr&chs=340x340&chl=".$a."&chld=H|0");
      $textcolor = imagecolorallocate($dest,0,0,0);
      $font = "assets/OpenSans-Regular.ttf";
      $fontSize = "18";
      ob_start();
      imagettftext($dest, 25, 0, 1320, 1105, $textcolor, $font, $a);
      imagettftext($dest, 25, 0, 1320, 1605, $textcolor, $font, $b);
      imagecopymerge($dest, $qr,1230, 1150, 0, 0, 340, 340, 100);
      imagepng($dest);
      imagedestroy($dest);
      imagedestroy($qr);
      $imageVoucher = base64_encode(ob_get_contents());
      ob_end_clean();
      return $imageVoucher;
  }
  function carBalance($addr)
  {
    $addr = trim($addr," ");
    return (isset($this->db->get_where("carcoin",array("nxt_address"=>$addr))->result()[0]->balance))?$this->db->get_where("carcoin",array("nxt_address"=>$addr))->result()[0]->balance:0;
  }
  function carTotalBalance()
  {
    $login_id = $this->session->id_login;
    $nxt_address = (isset($this->db->get_where("user_info",array("login_id"=>$login_id))->result()[0]->nxt_address))?$this->db->get_where("user_info",array("login_id"=>$login_id))->result()[0]->nxt_address:0;
    $id_users = (isset($this->db->get_where("user_info",array("login_id"=>$login_id))->result()[0]->id_users))?$this->db->get_where("user_info",array("login_id"=>$login_id))->result()[0]->id_users:0;
    $carcoin_id = (isset($this->db->get_where("carcoin",array("nxt_address"=>$nxt_address))->result()[0]->id_carcoin))?$this->db->get_where("carcoin",array("nxt_address"=>$nxt_address))->result()[0]->id_carcoin:0;
    $this->db->select_sum("balance");
    $primary = $this->db->get_where("carcoin",array("id_carcoin"=>$carcoin_id))->result()[0]->balance;
    $setAcc = $this->db->get_where("setAcc",array("id_user"=>$id_users))->result();
    $jumlah = 0;
    $i = 0;
    foreach ($setAcc as $key => $value) {
      $cek = $this->db->get_where("carcoin",array("nxt_address"=>$value->nxt_address));
      if($cek->num_rows() > 0)
      {
        $jumlah = $jumlah + ($this->carBalance($value->nxt_address) != null)?$this->carBalance($value->nxt_address):0;
      }
    }
    return $jumlah+$primary ;
  }
  function redeemCode($code,$to)
  {
    $to = trim($to," ");
    $cek = $this->db->get_where("carcoin_voucher",array("code"=>$code));
    if($cek->num_rows() > 0)
    {
      if($cek->result()[0]->status == 0)
      {
        $update = $this->db->where("code",$code)->update("carcoin_voucher",array("status"=>1));
        $balance = $this->carBalance($to);
        $update2= $this->db->where("nxt_address",$to)->update("carcoin",array("balance"=>$cek->result()[0]->balance + $balance));
        $update3 = $this->db->insert("carcoin_voucher_log",array("code"=>$code,"usedby"=>$to,"useit"=>date("Y-m-d H:i")));
        $update4 = $this->db->insert("carcoin_log",array("sender"=>0,"target"=>$to,"carcoin"=>$cek->result()[0]->balance,"created"=>date("Y-m-d H:i")));
        if($update && $update2 && $update3 && $update4)
        {
          return array("status"=>1,"msg"=>"Voucher Code Successfully Redeem to Address ".$to." with Balance ".$cek->result()[0]->balance);
        }else{
          return array("status"=>0,"msg"=>"Something Wrong Please Contact Technical Support");
        }
      }else{
        return array("status"=>0,"msg"=>"Your Code Has Been Used by Someone");
      }
    }else{
      return array("status"=>0,"msg"=>"Invalid Code");
    }
  }
  function createCoupon($total,$sender)
  {
    $cek_hak = $this->db->get_where("user_info",array("login_id"=>$this->session->id_login))->result();
    $cek_acc = $this->db->get_where("setAcc",array("id_user"=>$cek_hak[0]->id_users))->result();
    if($sender == $cek_hak[0]->nxt_address)
    {
      $verif = true;
    }else{
      $verif = false;
      foreach ($cek_acc as $key => $value) {
        if($value->nxt_address == $sender)
        {
         $verif = true;
         break;
        }
      }
    }
    if($verif && $total > 0)
    {
      $current_sender = (isset($this->db->get_where("carcoin",array("nxt_address"=>$sender))->result()[0]->balance))?$this->db->get_where("carcoin",array("nxt_address"=>$sender))->result()[0]->balance:0;
      if($total <= $current_sender)
      {
        $current_sender = $this->db->get_where("carcoin",array("nxt_address"=>$sender))->result()[0]->balance;
        $update_sender = $this->db->where("nxt_address",$sender)->update("carcoin",array("balance"=>$current_sender-$total));
        if($update_sender)
        {
          $this->load->helper('string');
          $string = random_string("alnum",10);
          $this->db->insert("carcoin_log",array("sender"=>$sender,"target"=>0,"carcoin"=>$total,"created"=>date("Y-m-d H:i")));
          $this->db->insert("carcoin_voucher",array("code"=>$string,"sender"=>$sender,"balance"=>$total,"created"=>date("Y-m-d H:i")));

          return array("status"=>1,"msg"=>"Voucher Successfully Created, Your Voucher Code is : <b>".$string."</b>","picture"=>$this->generateVoucherPicture($string,$total));
        }else{
          return array("status"=>0,"msg"=>"Failed to Create Voucher, Please Contact Technical Support");
        }
      }else{
        return array("status"=>0,"msg"=>"Balance not Enaugh");
      }
    }else{
      return array("status"=>0,"msg"=>"Your Address Invalid or Not Enaugh Balance");
    }
  }
  function sendCar($sender,$target,$total)
  {
    $sender = trim($sender," ");
    $target = trim($target," ");
    $cek_hak = $this->db->get_where("user_info",array("login_id"=>$this->session->id_login))->result();
    $cek_acc = $this->db->get_where("setAcc",array("id_user"=>$cek_hak[0]->id_users))->result();
    if($sender == $cek_hak[0]->nxt_address)
    {
      $verif = true;
    }else{
      $verif = false;
      foreach ($cek_acc as $key => $value) {
        if($value->nxt_address == $sender)
        {
         $verif = true;
         break;
        }
      }
    }
    $cek_sender = $this->db->get_where("carcoin",array("nxt_address"=>$sender))->num_rows();
    $cek_target = $this->db->get_where("carcoin",array("nxt_address"=>$target))->num_rows();
    if($cek_target > 0 && $cek_sender > 0 && $total > 0 && $verif)
    {
      $current_sender = (isset($this->db->get_where("carcoin",array("nxt_address"=>$sender))->result()[0]->balance))?$this->db->get_where("carcoin",array("nxt_address"=>$sender))->result()[0]->balance:0;
      if($total <= $current_sender)
      {
        $current_sender = $this->db->get_where("carcoin",array("nxt_address"=>$sender))->result()[0]->balance;
        $update_sender = $this->db->where("nxt_address",$sender)->update("carcoin",array("balance"=>$current_sender-$total));
        $current_target = $this->db->get_where("carcoin",array("nxt_address"=>$target))->result()[0]->balance;
        $update_target = $this->db->where("nxt_address",$target)->update("carcoin",array("balance"=>$current_target+$total));
        if($update_sender && $update_target)
        {
          $this->db->insert("carcoin_log",array("sender"=>$sender,"target"=>$target,"carcoin"=>$total,"created"=>date("Y-m-d H:i")));
          return array("status"=>1,"msg"=>"Car Coin Successfully Sended to Address : ".$target);
        }else{
          return array("status"=>0,"msg"=>"Failed to Send Car Coin, Please Contact Technical Support");
        }
      }else{
        return array("status"=>0,"msg"=>"Balance not Enaugh");
      }
    }else{
      return array("status"=>0,"msg"=>"Address Invalid or Your Amount Invalid");
    }

  }
  function carNextBonus($addr)
  {
    $this->load->model("acc");
    return (isset($this->acc->checksaldo(trim($addr," "),"asemcoin")->quantityQNT))?floor((($this->acc->checksaldo(trim($addr," "),"asemcoin")->quantityQNT/100000000)/30000)*2):0;
  }
  function carNextBonusTotal()
  {
    $login_id = $this->session->id_login;
    $user_info = (isset($this->db->get_where("user_info",array("login_id"=>$login_id))->result()[0]->nxt_address))?$this->db->get_where("user_info",array("login_id"=>$login_id))->result():0;
    $primary = $this->carNextBonus($user_info[0]->nxt_address);
    $id_user = $user_info[0]->id_users;
    $setAcc = $this->db->get_where("setAcc",array("id_user"=>$id_user))->result();
    $jumlah = 0;
    foreach ($setAcc as $key => $value) {
      $jumlah = $jumlah+$this->carNextBonus($value->nxt_address);
    }
    return $jumlah+$primary;
  }
	function insertLog($data)
    {
    	$cek = $this->db->get_where("userPurchase",array("id_log"=>$data["id_log"]))->num_rows();
    	if($cek < 1)
        {
    		$dataInsert =  $this->db->insert("userPurchase",$data);
        	return true;
        }else{
        	return false;
        }
    }
	function readLog($data = null){
    	if($data == null)
        {
        	$db = $this->db->get("userPurchase");
        }else{
        	$db = $this->db->get_where("userPurchase",$data);
        }
    	return $db;
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
    function getDBWallet()
    {
      $this->load->model("acc");
      $primary = (isset($this->acc->checksaldo(trim($this->session->nxt_address," "),"sancoin")->quantityQNT))?$this->acc->checksaldo(trim($this->session->nxt_address," "),"sancoin")->quantityQNT:0;
      $this->db->select("id_users");
      $id = $this->db->get_where("user_info",array("login_id"=>$this->session->id_login))->result()[0]->id_users;
      $fetch = $this->db->get_where("setAcc",array("id_user"=>$id));
      $nilai = 0;
      foreach ($fetch->result() as $key => $value) {
          $val = (isset($this->acc->checksaldo(trim($value->nxt_address," "),"sancoin")->quantityQNT))?$this->acc->checksaldo(trim($value->nxt_address," "),"sancoin")->quantityQNT:0;
         $nilai = $nilai + $val;
      }
      $nilai =  $nilai + $primary;
      return $nilai/100000000;

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

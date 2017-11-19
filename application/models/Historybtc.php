<?php ('BASEPATH') OR exit('No direct script access allowed');

class Historybtc extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }
    function get($param = null)
    {
        $this->db->distinct();
        $this->db->select('user_id');
        $data = $this->db->get("userPurchase");
        $userdata = $data->result();
        $result = array();
        $dataResult = array();
        $i = 0;
        $totalFras = 0;
        $totalBonus = 0;
        $totalBTC = 0;
        foreach($userdata as $loop_user)
        {
            $tempData = $this->db->get_where("userPurchase",array("user_id"=>$loop_user->user_id));
            $result[$i]["user"] = array("id"=>$loop_user->user_id,"data"=>$tempData->result());
            $i++;
        }
        $i = 0;
        $user = array();
        $hitungFras =array();
        $hitungBTC = array();
        $o = 0;
        $tmpstmp = array();
        $hashlog = array();
        $bonuslog = array();
        $kursLog = array();
        foreach ($result as $value) {
            $username = $this->db->get_where("login",array("id_login"=>$value["user"]["id"]))->result()[0]->user_identity;
            $p = 0;
            foreach ($value["user"]["data"] as $val) {
                if($val->hash_log != null && $val->fras_log > 0)
                {
                  $user[$p] = $username;
                  $hashlog[$o] = $val->hash_log;
                  $tmpstmp[$o] = $val->date;
                  $bonuslog[$o] = $val->bonus_log;
                  $hitungFras[$o] = $val->fras_log;
                  $hitungBTC[$o] = $val->btc_log;
                  $kursLog[$o] = $val->btcrate_log;
                  $o++;
                  $p++;
                }
            }
            $o = 0;
            if(array_sum($hitungFras) >= 50)
            {
              $totalFras = $totalFras + array_sum($hitungFras);
              $totalBTC = $totalBTC + array_sum($hitungBTC);
              $totalBonus = $totalBonus + array_sum($bonuslog);
              $rateBTC = $this->db->get_where("rate",array("id_rate"=>1))->result();
              $dataResult[$i]["data"] = array("totalFras"=>$totalFras,"totalBTC"=>$totalBTC,"totalBonus"=>$totalBonus,"username"=>$user,"bonus_log"=>$bonuslog,"hash_list"=>$hashlog,"timestamp"=>$tmpstmp,"btc"=>$hitungBTC,"fras"=>$hitungFras,"kursBTCUSD"=>$kursLog);
              $user = array();
              $hashlog = array();
              $tmpstmp = array();
              $hitungBTC = array();
              $hitungFras = array();
              $tmpstmp = array();
              $hashlog = array();
              $bonuslog = array();
              $kursLog = array();
              $i++;
            }
        }
        return $dataResult;
    }

}

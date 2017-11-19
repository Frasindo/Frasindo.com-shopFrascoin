<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Systemtrigger extends CI_Model {
    public function __construct()
    {
            parent::__construct();
            $this->load->model("bill");
            $campaign = $this->load->database('campaign', TRUE);
            $this->campaign = $campaign;
            $this->load->model("campaign_model");
    }
    public function campaignTime()
    {
      $getLast = strtotime(($this->campaign->get_where("campaignmeta",array("meta_key"=>"last_trigger")))->result()[0]->meta_value);
      $getNext = strtotime(($this->campaign->get_where("campaignmeta",array("meta_key"=>"next_trigger")))->result()[0]->meta_value);
      $now = strtotime(date("Y-m-d H:i:s"));
      $d = date("Y-m-d H:i:s");
      $n = new DateTime($d);
      $getHops = $this->campaign_model->trigger_hops();
      $n->add(new DateInterval('P'.$getHops.'D'));
      $new = strtotime($n->format("Y-m-d H:i:s"));
      if($getLast >= $getNext)
      {
        $updatelast = $this->campaign->where("meta_key","last_trigger")->update("campaignmeta",array("meta_value"=>date("Y-m-d H:i:s",$now)));
        $updateNext = $this->campaign->where("meta_key","next_trigger")->update("campaignmeta",array("meta_value"=>date("Y-m-d H:i:s",$new)));
        $required = $this->campaign_model->getRequiredCampaign();
        $a = $this->campaign_model->cekCampaign($required["twitter"],$required["youtube"],$required["blog"],$required["signature"],$required["translate"]);
        $alloc = $this->campaign_model->getAllocatedFund();
        $batch = array();
        $ib = 0;
        $cb = $this->campaign_model->fetchSetting();
        foreach ($a["data"] as $key => $value) {
          $batch[$ib++] = array("trans"=>$value["translate"],"twitter"=>$value["twitter"],"sign"=>$value["sign"],"yt"=>$value["youtube"],"blog"=>$value["blog"],"date"=>date("Y-m-d H:i:s"),"users_id"=>$value["id_users"],"cb_twitter"=>$cb->b_twitter,"cb_trans"=>$cb->b_translate,"cb_sign"=>$cb->b_signature,"cb_yt"=>$cb->b_vlog,"cb_blog"=>$cb->b_blog,"cb_allocated"=>$alloc);
        }
        $aw = $this->campaign->insert_batch("bonusmeta",$batch);
        if($aw)
        {
          return 1;
        }else{
          return 01;
        }
      }else {
        return 0;
      }
    }
    function carcoin()
    {
      $data = $this->db->get("user_info");
      $id_users = array();
      $i = 0;
      foreach ($data->result() as $key => $value) {
        $currentBalance = $this->db->get_where("carcoin",array("nxt_address"=>$value->nxt_address))->result()[0]->balance;
        $update = $this->db->where("nxt_address",$value->nxt_address)->update("carcoin",array("balance"=>$this->bill->carNextBonus($value->nxt_address)+$currentBalance));
        $id_users[$i++] = $value->id_users;
        if($this->bill->carNextBonus($value->nxt_address) > 0)
        {
          $this->db->insert("carcoin_log",array("sender"=>1,"target"=>$value->nxt_address,"carcoin"=>$this->bill->carNextBonus($value->nxt_address),"created"=>date("Y-m-d H:i")));
        }
      }
      foreach ($id_users as $dataId) {
        $sec = $this->db->get_where("setAcc",array("id_user"=>$dataId));
        foreach ($sec->result() as $key => $value) {
          $currentBalance = (isset($this->db->get_where("carcoin",array("nxt_address"=>$value->nxt_address))->result()[0]->balance))?$this->db->get_where("carcoin",array("nxt_address"=>$value->nxt_address))->result()[0]->balance:0;
          $update = $this->db->where("nxt_address",$value->nxt_address)->update("carcoin",array("balance"=>$this->bill->carNextBonus($value->nxt_address)+$currentBalance));
          if($this->bill->carNextBonus($value->nxt_address) > 0)
          {
            $this->db->insert("carcoin_log",array("sender"=>1,"target"=>$value->nxt_address,"carcoin"=>$this->bill->carNextBonus($value->nxt_address),"created"=>date("Y-m-d H:i")));
          }

        }
      }
      $newDay = date('Y-m-d H:i:s', strtotime($this->db->get_where("carcoinTimer",array("id_timer"=>2))->result()[0]->timer . ' +1 day'));;
      $this->db->where("id_timer",2)->update("carcoinTimer",array("timer"=>$newDay));
      return $update;
    }
  }

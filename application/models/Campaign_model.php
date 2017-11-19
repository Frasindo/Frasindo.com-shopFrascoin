<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Campaign_model extends CI_Model {
    protected $campaign;
    protected $twitter;
    protected $yt;
    public function __construct()
    {
            parent::__construct();
            $campaign = $this->load->database('campaign', TRUE);
            $this->campaign = $campaign;
            $this->load->library('encryption');
            $this->load->library('twitteroauth');
            $connection = $this->twitteroauth->create("4UNV33LnWcuDPoEP83Lh3Y5QP", "jyCdZ91Kjv24ee5QWVR7EqMCLpr3sZiHrqI5WEJnoLaGKDdF0T", "851537719037538304-EPcXDDbklX4W9yyg4VqrQC2OwvdDPkR", "rjk2OYFkamgi1BEjyywZrNv76KTMQhZ5zyHBJpVcoF7fZ");
            $this->twitter = $connection;
            $this->load->library("youtubebridge");
            $this->yt = $this->youtubebridge->create("AIzaSyDmdNm9boAF7E2DKbh2hoNNCx1CxE0e-qo");

    }
    public function getAllocatedFund()
    {
      return $this->campaign->get_where("campaignmeta",array("meta_key"=>"allocated_funds"))->result()[0]->meta_value;
    }
    public function updateTrigger($data)
    {
      $next = strtotime($this->getNextTrigger());
      $hops = $this->trigger_hops();
      $alloc = $this->getAllocatedFund();
      if($next != strtotime($data["next_trigger"]))
      {
        $a = $this->campaign->where("meta_key","last_trigger")->update("campaignmeta",array("meta_value"=>date("Y-m-d H:i:s")));
        $b = $this->campaign->where("meta_key","next_trigger")->update("campaignmeta",array("meta_value"=>$data["next_trigger"]));
      }
      if($hops != $data["trigger_hops"])
      {
        $c = $this->campaign->where("meta_key","trigger_hops")->update("campaignmeta",array("meta_value"=>$data["trigger_hops"]));
      }
      if($alloc != $data["allocated"])
      {
        $c = $this->campaign->where("meta_key","allocated_funds")->update("campaignmeta",array("meta_value"=>$data["allocated"]));
      }
      if($this->campaign->trans_status())
      {
        return array("status"=>1,"msg"=>"Data Successfully Updated");
      }else{
        return array("status"=>0,"msg"=>"Data Failed Updated");
      }

    }
    public function getLastTrigger()
    {
      return $this->campaign->get_where("campaignmeta",array("meta_key"=>"last_trigger"))->result()[0]->meta_value;
    }
    public function getNextTrigger()
    {
      return $this->campaign->get_where("campaignmeta",array("meta_key"=>"next_trigger"))->result()[0]->meta_value;
    }
    public function getRequiredCampaign()
    {
      $a = ($this->campaign->get_where("campaignmeta",array("meta_key"=>"r_twitter")))->result()[0]->meta_value;
      $c = ($this->campaign->get_where("campaignmeta",array("meta_key"=>"r_blog")))->result()[0]->meta_value;
      $d = ($this->campaign->get_where("campaignmeta",array("meta_key"=>"r_vlog")))->result()[0]->meta_value;
      $e = ($this->campaign->get_where("campaignmeta",array("meta_key"=>"r_signature")))->result()[0]->meta_value;
      $f = ($this->campaign->get_where("campaignmeta",array("meta_key"=>"r_translate")))->result()[0]->meta_value;
      return array("twitter"=>$a,"blog"=>$c,"youtube"=>$d,"signature"=>$e,"translate"=>$f);
    }
    public function cekCampaign($twitter = 2,$yt = 2,$blog = 1,$sign = 1,$trans = 1)
    {
      $a = $this->campaign->distinct()->select("*")->from("users a")->join("usersmeta b","b.users_id = a.id_users")->where("b.meta_value","user")->get();
      $getLast = strtotime(($this->campaign->get_where("campaignmeta",array("meta_key"=>"last_trigger")))->result()[0]->meta_value);
      $getNext = strtotime(($this->campaign->get_where("campaignmeta",array("meta_key"=>"next_trigger")))->result()[0]->meta_value);
      $l = date("Y-m-d",$getLast);
      $n = date("Y-m-d",$getNext);
      $result = array();
      $result["start"] = $l;
      $result["end"] = $n;
      $i = 0;
      //Twitter
      foreach ($a->result() as $key => $value) {
        $fat = $this->campaign->select('IF(COUNT(*) >= '.$twitter.',"1","0") as status')->from("twittercampaign")->where("twittercampaign.users_id = ".$value->id_users." and twittercampaign.status_code = 1 and ( twittercampaign.date_created BETWEEN '".$l."' and '".$n."')")->get();
        $fayt = $this->campaign->select('IF(COUNT(*) >= '.$yt.',"1","0") as status')->from("ytcampaign")->where("ytcampaign.users_id = ".$value->id_users." and ytcampaign.status_code = 1 and ( ytcampaign.date_created BETWEEN '".$l."' and '".$n."')")->get();
        $fasign = $this->campaign->select('IF(COUNT(*) >= '.$sign.',"1","0") as status')->from("signcampaign")->where("signcampaign.users_id = ".$value->id_users." and signcampaign.status = 1 and ( signcampaign.created BETWEEN '".$l."' and '".$n."')")->get();
        $fablog = $this->campaign->select('IF(COUNT(*) >= '.$blog.',"1","0") as status')->from("blogcampaign")->where("blogcampaign.users_id = ".$value->id_users." and blogcampaign.status = 1 and ( blogcampaign.created BETWEEN '".$l."' and '".$n."')")->get();
        $fatrans = $this->campaign->select('IF(COUNT(*) >= '.$trans.',"1","0") as status')->from("transcampaign")->where("transcampaign.users_id = ".$value->id_users." and transcampaign.status = 1 and ( transcampaign.created BETWEEN '".$l."' and '".$n."')")->get();
        $result["data"][$i++] = array("username"=>$value->username,"id_users"=>$value->id_users,"twitter"=>$fat->result()[0]->status,"youtube"=>$fayt->result()[0]->status,"blog"=>$fablog->result()[0]->status,"translate"=>$fatrans->result()[0]->status,"sign"=>$fasign->result()[0]->status);
      }
      return $result;
    }
    public function trigger_hops()
    {
      $a = ($this->campaign->get_where("campaignmeta",array("meta_key"=>"trigger_hops")))->result()[0]->meta_value;
      return $a;
    }
    public function countCampaign($status=1)
    {
      $a = $this->campaign->get_where("twittercampaign",array("status_code"=>$status));
      $b = $this->campaign->get_where("ytcampaign",array("status_code"=>$status));
      $c = $this->campaign->get_where("blogcampaign",array("status"=>$status));
      $d = $this->campaign->get_where("signcampaign",array("status"=>$status));
      $e = $this->campaign->get_where("transcampaign",array("status"=>$status));
      return $a->num_rows() + $b->num_rows() + $c->num_rows() + $d->num_rows() + $e->num_rows();
    }
    public function getAdminYt()
    {
      $ytarray = array();
      $ytx = 0;
      $a = $this->campaign->get("ytcampaign");
      foreach ($a->result() as $key => $value) {
        $u = $this->campaign->get_where("users",array("id_users"=>$value->users_id));
        $user = $u->result()[0]->username;
        $chanelID = $this->getChanelID($u->result()[0]->id_users);
        $z = $this->validateYt($value->unique_code,$chanelID);
        if($z->status == 1)
        {
          $ytarray[$ytx++] = array("status"=>1,"validated"=>$value->status_code,"created_date"=>$value->date_created,"validated_date"=>$value->date_validated,"user"=>$user,"unique_code"=>$value->unique_code,"data"=>$z->data);
        }else{
          $ytarray[$ytx++] = array("status"=>0,"validated"=>$value->status_code,"created_date"=>$value->date_created,"validated_date"=>$value->date_validated,"user"=>$user,"unique_code"=>$value->unique_code,"data"=>$z->data);
        }
      }
      return (object) $ytarray;
    }
    public function getChanelID($id)
    {
      $a = $this->campaign->get_where("usersmeta",array("users_id"=>$id,"meta_key"=>"youtube"));
      if($a->num_rows() > 0)
      {
        return $a->result()[0]->meta_value;
      }else{
        return 0;
      }
    }
    public function validateYt($hashtag,$chanelID)
    {
      $d = $this->yt->searchChannelVideos("#".$hashtag,$chanelID,50);
      if($d != false)
      {
        foreach ($d as $key => $value) {
            $id = $value->id->videoId;
            $vid = $this->yt->getVideoInfo($id);
        }
        $this->load->model("campaign_model");
        $a = $this->checkValidateYt($hashtag);
        $s = (object) array();
        $s->validate = $a;
        $s->uniqcode = $hashtag;
        $s->duration = $vid->contentDetails->duration;
        $s->nama = $vid->snippet->title;
        $s->description = $vid->snippet->description;
        $s->publishedAt = $vid->snippet->publishedAt;
        $s->link = "https://www.youtube.com/watch?v=".$id;
        $ps = (object) array("status"=>1,"data"=>$s);
        return $ps;
      }else{
        return (object) array("status"=>0,"msg"=>"Data Not Found","data"=>null,"uniqcode"=>$hashtag);
      }
    }
    public function getUniversalCampaign($from)
    {
      $a = $this->campaign->select("o.*,a.username")->from($from." o")->join("users a","a.id_users = o.users_id")->get();
      return $a;
    }
    public function deleteUniversalCampaign($where,$from,$id)
    {
      $a = $this->campaign->delete($from,array("$where"=>$id));
      if($this->campaign->affected_rows() > 0)
      {
        return array("status"=>1,"msg"=>"Delete Successfully");
      }else{
        return array("status"=>0,"msg"=>"Delete Failed","debug"=>$this->campaign->affected_rows());
      }
    }
    public function countPartisipan()
    {
      $a = $this->campaign->select("*")->from("users a")->join("usersmeta b","a.id_users = b.users_id")->where("b.meta_value","user")->get();
      return $a->num_rows();
    }
    public function getAvatar($user_id)
    {
      $e = $this->campaign->get_where("usersmeta",array("users_id"=>$user_id,"meta_key"=>"email"));
      if($e->num_rows() > 0)
      {
        $email = $e->result()[0]->meta_value;
      }else{
        $email = "defaultfrasindoavatar@gmail.com";
      }
      return $this->gravatar->get($email);
    }
    public function universalStream($campaign,$sort="desc")
    {
      if($campaign == "twitter")
      {
          $a = $this->campaign->select("b.username,a.id_tc,a.users_id,a.unique_code,a.id_tweet,a.status_code,a.date_created,a.date_validated")->from("twittercampaign a")->join("users b","b.id_users = a.users_id")->limit(4,0)->order_by("a.date_created",$sort)->get();
          return $a;
      }elseif ($campaign == "blog") {
        $a = $this->campaign->select("b.username,a.*")->from("blogcampaign a")->limit(4,0)->join("users b","b.id_users = a.users_id")->order_by("a.created",$sort)->get();
        return $a;
      }elseif ($campaign == "yt") {
        $a = $this->campaign->select("b.username,a.id_ytc,a.users_id,a.unique_code,a.status_code,a.date_created,a.date_validated")->from("ytcampaign a")->join("users b","b.id_users = a.users_id")->limit(4,0)->order_by("a.date_created",$sort)->get();
        return $a;
      }elseif ($campaign == "sign") {
        $a = $this->campaign->select("b.username,a.*")->from("signcampaign a")->join("users b","b.id_users = a.users_id")->order_by("a.created",$sort)->limit(4,0)->get();
        return $a;
      }elseif ($campaign == "trans") {
        $a = $this->campaign->select("b.username,a.*")->from("transcampaign a")->join("users b","b.id_users = a.users_id")->order_by("a.created",$sort)->limit(4,0)->get();
        return $a;
      }
    }
    public function streamCompleted($sort="asc")
    {
      $a = $this->campaign->select("IF(a.twitter = 1,'Completed','Failed') as twitter,IF(a.yt = 1,'Completed','Failed') as youtube,IF(a.sign = 1,'Completed','Failed') as sign,IF(a.blog = 1,'Completed','Failed') as blog,IF(a.trans = 1,'Completed','Failed') as trans,users.username,a.date,a.users_id")->from("users")->join("bonusmeta a","a.users_id = users.id_users")->order_by("a.date",$sort)->limit(4,0)->get();
      return $a;
    }
    public function streamCampaign()
    {
      $a = $this->campaign->select("*")->from("users a")->join("twittercampaign ta","ta.users_id = a.id_users","left")->join("ytcampaign yta","yta.users_id = a.id_users","left")->join("signcampaign sc","sc.users_id = a.id_users","left")->join("transcampaign trc","trc.users_id = a.id_users","left")->join("blogcampaign bc","bc.users_id = a.id_users","left")->get();
      return $a;
    }
    public function updateUniversalCampaign($where,$from,$id,$status=1)
    {
      if($status == 1)
      {
        $a = $this->campaign->where($where,$id)->update($from,array("status"=>1,"validated"=>date("Y-m-d")));
      }else{
        $a = $this->campaign->where($where,$id)->update($from,array("status"=>0,"validated"=>"0000-00-00"));
      }
      if($this->campaign->trans_status())
      {
        return array("status"=>1,"msg"=>"Update Successfully");
      }else{
        return array("status"=>0,"msg"=>"Update Failed","debug"=>$this->campaign->affected_rows());
      }
    }
    public function deleteUniqYoutube($unique_code)
    {
      $this->campaign->delete("ytcampaign",array("unique_code"=>$unique_code));
      if($this->campaign->affected_rows() > 0)
      {
        return array("status"=>1,"msg"=>"Delete Successfully");
      }else{
        return array("status"=>0,"msg"=>"Delete Failed","debug"=>$this->campaign->affected_rows());
      }
    }
    public function deleteUniqTwitter($unique_code)
    {
      $this->campaign->delete("twittercampaign",array("unique_code"=>$unique_code));
      if($this->campaign->affected_rows() > 0)
      {
        return array("status"=>1,"msg"=>"Delete Successfully");
      }else{
        return array("status"=>0,"msg"=>"Delete Failed");
      }
    }
    public function youtubeUpdateStatus($unique_code,$type="accept")
    {
      if($type == "accept")
      {
        $a = $this->campaign->where("unique_code",$unique_code)->update("ytcampaign",array("status_code"=>1,"date_validated"=>date("Y-m-d")));
      }else{
        $a = $this->campaign->where("unique_code",$unique_code)->update("ytcampaign",array("status_code"=>0,"date_validated"=>"0000-00-00"));
      }
      if($this->campaign->trans_status())
      {
        return array("status"=>1,"msg"=>"Update Successfully");
      }else{
        return array("status"=>0,"msg"=>"Update Failed");
      }
    }
    public function twiiterUpdateStatus($unique_code,$type="accept")
    {
      if($type == "accept")
      {
        $a = $this->campaign->where("unique_code",$unique_code)->update("twittercampaign",array("status_code"=>1,"date_validated"=>date("Y-m-d")));
      }else{
        $a = $this->campaign->where("unique_code",$unique_code)->update("twittercampaign",array("status_code"=>0,"date_validated"=>"0000-00-00"));
      }
      if($this->campaign->trans_status())
      {
        return array("status"=>1,"msg"=>"Update Successfully");
      }else{
        return array("status"=>0,"msg"=>"Update Failed");
      }
    }
    public function getTwitterAdmin()
    {
      $d = $this->campaign->get("twittercampaign");
      $a = array();
      $ia = 0;
      foreach ($d->result() as $key => $value) {
        $z = $this->validateTwitter($value->unique_code,$value->id_tweet);
        $username = $this->campaign->get_where("users",array("id_users"=>$value->users_id));
        $username = $username->result()[0];
        if($z->status == 1)
        {
          $a[$ia] = array("hastag"=>$value->unique_code,"user"=>$username->username,"created_date"=>$value->date_created,"validated_date"=>$value->date_validated,"status"=>$value->status_code,"data"=>$z->data);
        }else {
          $a[$ia] = array("hastag"=>$value->unique_code,"user"=>$username->username,"created_date"=>$value->date_created,"validated_date"=>$value->date_validated,"status"=>$value->status_code,"data"=>$z->data);
        }
        $ia++;
      }
      return (object) $a;
    }
    public function validateTwitter($hashtag,$idtweet)
    {
      $data = array(
        'id' => $idtweet
      );
      $s = $this->twitter->get('statuses/show',$data);
      $a = array();
      $a = (object) $a;
      $a->statuses[0] = $s;
      $hitung = count($s);
      if($hitung > 0)
      {
        $d = $this->campaign->distinct()->select("*")->from("users")->join("twittercampaign a","a.users_id = users.id_users")->where("a.unique_code",$hashtag)->get();
        if($d->num_rows() > 0)
        {
          if(isset($a->statuses[0]->id_str))
          {
            $sname = $a->statuses[0]->user->screen_name;
          }else{
            $sname = null;
          }

          $id = $d->result()[0]->id_users;
          $twitter_screen = $this->campaign->get_where("usersmeta",array("users_id"=>$id,"meta_key"=>"twitter"));
          if($twitter_screen->num_rows() > 0)
          {
            $k = (explode("@",$twitter_screen->result()[0]->meta_value))[1];
            if($k == $sname)
            {
              $d = $this->checkValidate($hashtag);
              $a->validtweet = $d;
              return (object) array("status"=>1,"msg"=>"Data Validated","data"=>$a);
            }else{
              return (object) array("status"=>0,"msg"=>"Wrong Data","data"=>null,"ucode"=>$hashtag,"debug"=>$a->statuses);
            }
          }else{
            return (object) array("status"=>0,"msg"=>"Wrong Data","data"=>null,"ucode"=>$hashtag,"debug"=>$a->statuses);
          }
        }else{
          return (object) array("status"=>0,"msg"=>"Wrong Data","data"=>null,"ucode"=>$hashtag,"debug"=>$a->statuses);
        }
      }else{
        return (object) array("status"=>0,"msg"=>"User or Tweet Not Found","data"=>null,"ucode"=>$hashtag,"debug"=>$a->statuses);
      }
    }
    public function updateBounty($data)
    {
      if(($data["b_twitter"] + $data["b_vlog"] + $data["b_signature"] + $data["b_translate"] + $data["b_blog"]) == 100)
      {
        $s = 1;
        foreach ($data as $key => $value) {
          if($key == "b_twitter")
          {
            $a = $this->campaign->where("meta_key",$key)->update("campaignmeta",array("meta_value"=>$value));
            if($this->campaign->trans_status() === FALSE)
            {
              $s = 0;
              break;
            }
          }elseif ($key == "b_signature") {
            $a = $this->campaign->where("meta_key",$key)->update("campaignmeta",array("meta_value"=>$value));
            if($this->campaign->trans_status() === FALSE)
            {
              $s = 0;
              break;
            }
          }elseif ($key == "b_translate") {
            $a = $this->campaign->where("meta_key",$key)->update("campaignmeta",array("meta_value"=>$value));
            if($this->campaign->trans_status() === FALSE)
            {
              $s = 0;
              break;
            }
          }elseif ($key == "b_vlog") {
            $a = $this->campaign->where("meta_key",$key)->update("campaignmeta",array("meta_value"=>$value));
            if($this->campaign->trans_status() === FALSE)
            {
              $s = 0;
              break;
            }
          }elseif ($key == "b_blog") {
            $a = $this->campaign->where("meta_key",$key)->update("campaignmeta",array("meta_value"=>$value));
            if($this->campaign->trans_status() === FALSE)
            {
              $s = 0;
              break;
            }
          }elseif ($key == "r_signature") {
            $a = $this->campaign->where("meta_key",$key)->update("campaignmeta",array("meta_value"=>$value));
            if($this->campaign->trans_status() === FALSE)
            {
              $s = 0;
              break;
            }
          }elseif ($key == "r_translate") {
            $a = $this->campaign->where("meta_key",$key)->update("campaignmeta",array("meta_value"=>$value));
            if($this->campaign->trans_status() === FALSE)
            {
              $s = 0;
              break;
            }
          }elseif ($key == "r_vlog") {
            $a = $this->campaign->where("meta_key",$key)->update("campaignmeta",array("meta_value"=>$value));
            if($this->campaign->trans_status() === FALSE)
            {
              $s = 0;
              break;
            }
          }elseif ($key == "r_blog") {
            $a = $this->campaign->where("meta_key",$key)->update("campaignmeta",array("meta_value"=>$value));
            if($this->campaign->trans_status() === FALSE)
            {
              $s = 0;
              break;
            }
          }elseif ($key == "r_twitter") {
            $a = $this->campaign->where("meta_key",$key)->update("campaignmeta",array("meta_value"=>$value));
            if($this->campaign->trans_status() === FALSE)
            {
              $s = 0;
              break;
            }
          }
        }
        if($s == 1)
        {
          return array("status"=>1,"msg"=>"Update Successfully");
        }else {
          return array("status"=>0,"msg"=>"Update Failed");
        }
      }else{
        return array("status"=>0,"msg"=>"All Bonus Must Total 100");
      }
    }
    public function fetchSetting()
    {
      $a = $this->campaign->get("campaignmeta");
      $az = array();
      foreach ($a->result() as $key => $value) {
        if($value->meta_key == "b_twitter")
        {
          $az[$value->meta_key] = $value->meta_value;
        }elseif ($value->meta_key == "b_signature") {
          $az[$value->meta_key] = $value->meta_value;
        }elseif ($value->meta_key == "b_translate") {
          $az[$value->meta_key] = $value->meta_value;
        }elseif ($value->meta_key == "b_vlog") {
          $az[$value->meta_key] = $value->meta_value;
        }elseif ($value->meta_key == "b_blog") {
          $az[$value->meta_key] = $value->meta_value;
        }elseif ($value->meta_key == "r_signature") {
          $az[$value->meta_key] = $value->meta_value;
        }elseif ($value->meta_key == "r_translate") {
          $az[$value->meta_key] = $value->meta_value;
        }elseif ($value->meta_key == "r_vlog") {
          $az[$value->meta_key] = $value->meta_value;
        }elseif ($value->meta_key == "r_blog") {
          $az[$value->meta_key] = $value->meta_value;
        }elseif ($value->meta_key == "r_twitter") {
          $az[$value->meta_key] = $value->meta_value;
        }
      }
      return (object) $az;
    }
    public function getUsers($id='')
    {
      if($id == null)
      {
        $getLogin = $this->campaign->select("*")->from("users")->join("usersmeta a","a.users_id = users.id_users")->where("a.meta_value","user")->distinct()->get();
        if($getLogin->num_rows() > 0)
        {
          $a = array();
          $i = 0;
          foreach ($getLogin->result() as $key => $value) {
            $dataUsers = $this->campaign->get_where("usersmeta",array("users_id"=>$value->id_users));
            if($dataUsers->num_rows() > 0)
            {
              $za = array();
              $iz = 0;
              foreach ($dataUsers->result() as $keys => $values) {
                if($values->meta_key == "nama")
                {
                  $za[$values->meta_key] = $values->meta_value;
                }elseif ($values->meta_key == "email") {
                  $za[$values->meta_key] = $values->meta_value;
                }elseif ($values->meta_key == "ardor_addr") {
                  $za[$values->meta_key] = $values->meta_value;
                }elseif ($values->meta_key == "btc_addr") {
                  $za[$values->meta_key] = $values->meta_value;
                }elseif ($values->meta_key == "youtube") {
                  $za[$values->meta_key] = $values->meta_value;
                }elseif ($values->meta_key == "twitter") {
                  $za[$values->meta_key] = $values->meta_value;
                }
              }
              $a[$i++] = array("data_users"=>array("id_users"=>$value->id_users,"username"=>$value->username,"status"=>$value->status,"detail"=>$za));
            }
          }
          return array("status"=>1,"msg"=>"Users Found","data"=>$a);
        }else{
          return array("status"=>0,"msg"=>"Users not Found","data"=>array());
        }
      }else{
        $getLogin = $this->campaign->select("*")->from("users")->join("usersmeta a","a.users_id = users.id_users")->where("a.meta_value","user")->where("a.users_id",$id)->distinct()->get();
        if($getLogin->num_rows() > 0)
        {
          $a = array();
          $i = 0;
          foreach ($getLogin->result() as $key => $value) {
            $dataUsers = $this->campaign->get_where("usersmeta",array("users_id"=>$value->id_users));
            if($dataUsers->num_rows() > 0)
            {
              $za = array();
              $iz = 0;
              foreach ($dataUsers->result() as $keys => $values) {
                if($values->meta_key == "nama")
                {
                  $za[$values->meta_key] = $values->meta_value;
                }elseif ($values->meta_key == "email") {
                  $za[$values->meta_key] = $values->meta_value;
                }elseif ($values->meta_key == "ardor_addr") {
                  $za[$values->meta_key] = $values->meta_value;
                }elseif ($values->meta_key == "btc_addr") {
                  $za[$values->meta_key] = $values->meta_value;
                }elseif ($values->meta_key == "youtube") {
                  $za[$values->meta_key] = $values->meta_value;
                }elseif ($values->meta_key == "twitter") {
                  $za[$values->meta_key] = $values->meta_value;
                }
              }
              $a[$i++] = array("data_users"=>array("id_users"=>$value->id_users,"username"=>$value->username,"status"=>$value->status,"detail"=>$za));
            }
          }
          return array("status"=>1,"msg"=>"Users Found","data"=>$a);
        }else{
          return array("status"=>0,"msg"=>"Users not Found","data"=>array());
        }
      }
    }
    public function getAdmin($id='')
    {
      if($id == null)
      {
        $getLogin = $this->campaign->select("*")->from("users")->join("usersmeta a","a.users_id = users.id_users")->where("a.meta_value","admin")->distinct()->get();
        if($getLogin->num_rows() > 0)
        {
          $a = array();
          $i = 0;
          foreach ($getLogin->result() as $key => $value) {
            $dataUsers = $this->campaign->get_where("usersmeta",array("users_id"=>$value->id_users));
            if($dataUsers->num_rows() > 0)
            {
              $za = array();
              $iz = 0;
              foreach ($dataUsers->result() as $keys => $values) {
                if($values->meta_key == "email")
                {
                  $za["email"] = $values->meta_value;
                }elseif ($values->meta_key == "nama") {
                  $za["nama"] = $values->meta_value;
                }
              }
              $a[$i++] = array("data_users"=>array("id_users"=>$value->id_users,"username"=>$value->username,"status"=>$value->status,"detail"=>$za));
            }
          }
          return array("status"=>1,"msg"=>"Admin Found","data"=>$a);
        }else{
          return array("status"=>0,"msg"=>"Admin not Found","data"=>array());
        }
      }else{
        $getLogin = $this->campaign->select("*")->from("users")->join("usersmeta a","a.users_id = users.id_users")->where("a.meta_value","admin")->where("a.users_id",$id)->distinct()->get();
        if($getLogin->num_rows() > 0)
        {
          $a = array();
          $i = 0;
          foreach ($getLogin->result() as $key => $value) {
            $dataUsers = $this->campaign->get_where("usersmeta",array("users_id"=>$value->id_users));
            if($dataUsers->num_rows() > 0)
            {
              $za = array();
              $iz = 0;
              foreach ($dataUsers->result() as $keys => $values) {
                if($values->meta_key == "email")
                {
                  $za["email"] = $values->meta_value;
                }elseif ($values->meta_key == "nama") {
                  $za["nama"] = $values->meta_value;
                }
              }
              $a[$i++] = array("data_users"=>array("id_users"=>$value->id_users,"username"=>$value->username,"status"=>$value->status,"detail"=>$za));
            }
          }
          return array("status"=>1,"msg"=>"Admin Found","data"=>$a);
        }else{
          return array("status"=>0,"msg"=>"Admin not Found","data"=>array());
        }
      }
    }
    public function updateIdTweet($id='',$code='')
    {
      return $this->campaign->where("unique_code",$code)->update("twittercampaign",array("id_tweet"=>$id));
    }
    public function cekYt($data='')
    {
      $a = $this->campaign->get_where("usersmeta",array("users_id"=>$data,"meta_key"=>"youtube"));
      if($a->num_rows() > 0)
      {
          $z = $this->yt->getChannelById($a->result()[0]->meta_value);
          if($z != false)
          {
            return array("status"=>1,"msg"=>"Success");
          }else{
            return array("status"=>0,"msg"=>"Your ChanelID Wrong");
          }
      }else {
        return array("status"=>0,"msg"=>"Your ChannelID Empty, Please Fill in Settings");
      }
    }
    public function getFolowers($screen,$req = 20)
    {
      $data = array(
        'screen_name' => $screen,
        'count' => $req
      );
      $s = $this->twitter->get('followers/ids',$data);
      if(!isset($s->errors))
      {
        if(!isset($s->error))
        {
          $h = count($s->ids);
          if($req == $h)
          {
            return array("status"=>1,"msg"=>"Success");
          }else{
            return array("status"=>0,"msg"=>"Followers Not Same as Requirement, Your Follow is ".$h." Required Followers is ".$req);
          }
        }else{
          return array("status"=>0,"msg"=>"Your Account Is Private");
        }

      }else{
        return array("status"=>0,"msg"=>"Failed to Fetch, Screen Name Failed Check your Twitter Username");
      }

    }
    public function getTwitterUniq($data='')
    {
      return $this->campaign->get_where("twittercampaign",array("unique_code"=>$data));
    }
    public function checkValidateYt($uniqcode)
    {
      $data = $this->campaign->get_where("twittercampaign",array("unique_code"=>$uniqcode));
      if($data->num_rows() > 0)
      {
        if($data->row()->status_code != 0)
        {
          return true;
        }else{
          return false;
        }
      }else{
        return false;
      }
    }
    public function checkValidate($uniqcode)
    {
      $data = $this->campaign->get_where("twittercampaign",array("unique_code"=>$uniqcode));
      if($data->num_rows() > 0)
      {
        if($data->row()->status_code != 0)
        {
          return true;
        }else{
          return false;
        }
      }else{
        return false;
      }
    }
    public function updateInfo($data,$pass=null)
    {
      if($pass == null)
      {
        $status = 1;
        foreach ($data as $key => $value) {
          if($key == "nama")
          {
            $d = $this->campaign->where("users_id",$this->session->id_users)->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
          }elseif ($key == "email") {
            $d = $this->campaign->where("users_id",$this->session->id_users)->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
          }elseif ($key == "ardor_addr") {
            $d = $this->campaign->where("users_id",$this->session->id_users)->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
          }elseif ($key == "btc_addr") {
            $d = $this->campaign->where("users_id",$this->session->id_users)->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
          }elseif ($key == "youtube") {
            $d = $this->campaign->where("users_id",$this->session->id_users)->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
          }elseif ($key == "twitter") {
            $d = $this->campaign->where("users_id",$this->session->id_users)->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
          }
        }
        if($status == 1)
        {
          return array("status"=>1,"msg"=>"Data Successfully Updated");
        }else{
          return array("status"=>0,"msg"=>"Data Failed To Update","debug"=>$status);
        }
      }else{
        $updatePass = $this->campaign->where("id_users",$this->session->id_users)->update("users",array("password"=>$this->encrypt->encode($pass)));
        if($updatePass)
        {
          $status = 1;
          foreach ($data as $key => $value) {
            if($key == "nama")
            {
              $d = $this->campaign->where("users_id",$this->session->id_users)->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
            }elseif ($key == "email") {
              $d = $this->campaign->where("users_id",$this->session->id_users)->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
            }elseif ($key == "ardor_addr") {
              $d = $this->campaign->where("users_id",$this->session->id_users)->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
            }elseif ($key == "btc_addr") {
              $d = $this->campaign->where("users_id",$this->session->id_users)->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
            }elseif ($key == "youtube") {
              $d = $this->campaign->where("users_id",$this->session->id_users)->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
            }elseif ($key == "twitter") {
              $d = $this->campaign->where("users_id",$this->session->id_users)->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
            }
          }
          if($status == 1)
          {
            return array("status"=>1,"msg"=>"Data Successfully Updated");
          }else{
            return array("status"=>0,"msg"=>"Data Failed To Update","debug"=>$status);
          }
        }else{
          return array("status"=>1,"msg"=>"Fail to Update Data","debug"=>"Fail in Password :".$updatePass);
        }
      }
    }
    public function fetchUserInfo($sesi)
    {
      $d =  $this->campaign->select("*")->from("users")->join("usersmeta a","a.users_id = users.id_users")->where("users.id_users",$sesi)->get();
      $a = array();
      foreach ($d->result() as $key => $value) {
        if($value->meta_key == "email")
        {
          $a["email"] = $value->meta_value;
        }elseif ($value->meta_key == "twitter") {
          $a["twitter"] = $value->meta_value;
        }elseif ($value->meta_key == "ardor_addr") {
          $a["ardor_addr"] = $value->meta_value;
        }elseif ($value->meta_key == "btc_addr") {
          $a["btc_addr"] = $value->meta_value;
        }elseif ($value->meta_key == "nama") {
          $a["nama"] = $value->meta_value;
        }elseif ($value->meta_key == "youtube") {
          $a["youtube"] = $value->meta_value;
        }elseif ($value->meta_key == "blog_unique") {
          $a["blog_unique"] = $value->meta_value;
        }
      }
      if($d->num_rows() > 0)
      {
        return array("status"=>1,"data"=>$a);
      }else{
        $a = array("email"=>null,"twitter"=>null,"ardor_addr"=>null,"btc_addr"=>null,"nama"=>null,"youtube"=>null,"blog_unique"=>null);
        return array("status"=>0,"data"=>$a);
      }
    }
    public function savelinktrans($data)
    {
      $i =  $this->campaign->insert("transcampaign",$data);
      if($i)
      {
        return array("status"=>1,"msg"=>"Successfully Saved");
      }else{
        return array("status"=>0,"msg"=>"Failed to Submit, Server Error");
      }
    }
    public function delAdmin($id='')
    {
      $d = $this->campaign->delete("users",array("id_users"=>$id));
      if($d)
      {
        return array("status"=>1,"msg"=>"Data Successfully to Delete");
      }else{
        return array("status"=>0,"msg"=>"Data Failed to Delete");
      }
    }
    public function editAdmin($data)
    {
      if($data["password"] != "")
      {
        $logUpdate = $this->campaign->where("id_users",$data["id_users"])->update("users",array("password"=>$this->encrypt->encode($data["password"])));
        if($logUpdate)
        {
          $s = 1;
          foreach ($data as $key => $value) {
            if($key == "email")
            {
              $a = $this->campaign->where("users_id",$data["id_users"])->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
              if(!$a)
              {
                break;
                $s = 0;
              }
            }elseif ($key == "nama") {
              $a = $this->campaign->where("users_id",$data["id_users"])->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
              if(!$a)
              {
                break;
                $s = 0;
              }
            }
          }
          if($s == 1)
          {
            return array("status"=>1,"msg"=>"Data Updated");
          }else{
            return array("status"=>0,"msg"=>"Data Failed to Update");
          }
        }else{
          return array("status"=>0,"msg"=>"Data Failed to Update, Password Cannot Update");
        }
      }else{
        $s = 1;
        foreach ($data as $key => $value) {
          if($key == "email")
          {
            $a = $this->campaign->where("users_id",$data["id_users"])->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
            if(!$a)
            {
              break;
              $s = 0;
            }
          }elseif ($key == "nama") {
            $a = $this->campaign->where("users_id",$data["id_users"])->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
            if(!$a)
            {
              break;
              $s = 0;
            }
          }
        }
        if($s == 1)
        {
          return array("status"=>1,"msg"=>"Data Updated");
        }else{
          return array("status"=>0,"msg"=>"Data Failed to Update");
        }
      }
    }

    public function editUsers($data)
    {
      if($data["password"] != "")
      {
        $logUpdate = $this->campaign->where("id_users",$data["id_users"])->update("users",array("password"=>$this->encrypt->encode($data["password"])));
        if($logUpdate)
        {
          $s = 1;
          foreach ($data as $key => $value) {
            if($key == "nama")
            {
              $d = $this->campaign->where("users_id",$data["id_users"])->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
              if(!$d)
              {
                $s = 0;
                break;
              }
            }elseif ($key == "email") {
              $d = $this->campaign->where("users_id",$data["id_users"])->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
              if(!$d)
              {
                $s = 0;
                break;
              }
            }elseif ($key == "ardor_addr") {
              $d = $this->campaign->where("users_id",$data["id_users"])->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
              if(!$d)
              {
                $s = 0;
                break;
              }
            }elseif ($key == "btc_addr") {
              $d = $this->campaign->where("users_id",$data["id_users"])->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
              if(!$d)
              {
                $s = 0;
                break;
              }
            }elseif ($key == "youtube") {
              $d = $this->campaign->where("users_id",$data["id_users"])->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
              if(!$d)
              {
                $s = 0;
                break;
              }
            }elseif ($key == "twitter") {
              $d = $this->campaign->where("users_id",$data["id_users"])->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
              if(!$d)
              {
                $s = 0;
                break;
              }
            }
          }
          if($s == 1)
          {
            return array("status"=>1,"msg"=>"Data Updated","debug"=>$value);
          }else{
            return array("status"=>0,"msg"=>"Data Failed to Update");
          }
        }else{
          return array("status"=>0,"msg"=>"Data Failed to Update, Password Cannot Update");
        }
      }else{
        $s = 1;
        foreach ($data as $key => $value) {
          if($key == "nama")
          {
            $d = $this->campaign->where("users_id",$data["id_users"])->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
            if(!$d)
            {
              $s = 0;
              break;
            }
          }elseif ($key == "email") {
            $d = $this->campaign->where("users_id",$data["id_users"])->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
            if(!$d)
            {
              $s = 0;
              break;
            }
          }elseif ($key == "ardor_addr") {
            $d = $this->campaign->where("users_id",$data["id_users"])->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
            if(!$d)
            {
              $s = 0;
              break;
            }
          }elseif ($key == "btc_addr") {
            $d = $this->campaign->where("users_id",$data["id_users"])->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
            if(!$d)
            {
              $s = 0;
              break;
            }
          }elseif ($key == "youtube") {
            $d = $this->campaign->where("users_id",$data["id_users"])->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
            if(!$d)
            {
              $s = 0;
              break;
            }
          }elseif ($key == "twitter") {
            $d = $this->campaign->where("users_id",$data["id_users"])->where("meta_key",$key)->update("usersmeta",array("meta_value"=>$value));
            if(!$d)
            {
              $s = 0;
              break;
            }
          }
        }
        if($s == 1)
        {
          return array("status"=>1,"msg"=>"Data Updated","debug"=>$value);
        }else{
          return array("status"=>0,"msg"=>"Data Failed to Update");
        }
      }
    }
    public function  addAdmin($data)
    {
      $insLogin = $this->campaign->insert("users",array("username"=>$data["username"],"password"=>$this->encrypt->encode($data["password"]),"status"=>1));
      $id = $this->campaign->insert_id();
      if($insLogin)
      {
        $i = 0;
        $a = array();
        foreach ($data as $key => $value) {
          $i++;
          if($key == "email")
          {
            $a[$i] = array("users_id"=>$id,"meta_key"=>$key,"meta_value"=>$value);
          }elseif ($key == "nama") {
            $a[$i] = array("users_id"=>$id,"meta_key"=>$key,"meta_value"=>$value);
          }
        }
        $i = $i + 1;
        $a[$i] = array("users_id"=>$id,"meta_key"=>"level_user","meta_value"=>"admin");
        $insertBatch = $this->campaign->insert_batch("usersmeta",$a);
        if($insertBatch)
        {
          return array("status"=>1,"msg"=>"Data Successfully Saved");
        }else{
          return array("status"=>0,"msg"=>"Fail to Save Data","debug"=>array("status"=>$insertBatch,"postdata"=>$data));
        }
      }else{
        $this->campaign->delete("users",array("id_users"=>$id));
        return array("status"=>0,"msg"=>"Fail to Register Admin ID : ".$id);
      }
    }
    public function addUsers($data,$type="admin")
    {
      if($type == "admin")
      {
        $insLogin = $this->campaign->insert("users",array("username"=>$data["username"],"password"=>$this->encrypt->encode($data["password"]),"status"=>1));
        $id = $this->campaign->insert_id();
        if($insLogin)
        {
          $i = 0;
          $a = array();
          foreach ($data as $key => $value) {
            $i++;
            if($key == "email")
            {
              $a[$i] = array("users_id"=>$id,"meta_key"=>$key,"meta_value"=>$value);
            }elseif ($key == "twitter") {
              $a[$i] = array("users_id"=>$id,"meta_key"=>$key,"meta_value"=>$value);
            }elseif ($key == "ardor_addr") {
              $a[$i] = array("users_id"=>$id,"meta_key"=>$key,"meta_value"=>$value);
            }elseif ($key == "btc_addr") {
              $a[$i] = array("users_id"=>$id,"meta_key"=>$key,"meta_value"=>$value);
            }elseif ($key == "nama") {
              $a[$i] = array("users_id"=>$id,"meta_key"=>$key,"meta_value"=>$value);
            }elseif ($key == "youtube") {
              $a[$i] = array("users_id"=>$id,"meta_key"=>$key,"meta_value"=>$value);
            }elseif ($key == "blog_unique") {
              $a[$i] = array("users_id"=>$id,"meta_key"=>$key,"meta_value"=>$value);
            }
          }
          $i = $i + 1;
          $a[$i] = array("users_id"=>$id,"meta_key"=>"level_user","meta_value"=>"user");
          if(array_key_exists("ardor_addr",$a) && array_key_exists("btc_addr",$a))
          {
            $a[$i+1] = array("users_id"=>$id,"meta_key"=>"ardor_addr","meta_value"=>null);
          }
          $insertBatch = $this->campaign->insert_batch("usersmeta",$a);
          if($insertBatch)
          {
            return array("status"=>1,"msg"=>"Data Successfully Saved");
          }else{
            return array("status"=>0,"msg"=>"Fail to Save Data","debug"=>array("status"=>$insertBatch,"postdata"=>$data));
          }
        }else{
          $this->campaign->delete("users",array("id_users"=>$id));
          return array("status"=>0,"msg"=>"Fail to Register Users ID : ".$id);
        }
      }else{

      }
    }
    public function savelinksign($data)
    {
      $i =  $this->campaign->insert("signcampaign",$data);
      if($i)
      {
        return array("status"=>1,"msg"=>"Successfully Saved");
      }else{
        return array("status"=>0,"msg"=>"Failed to Submit, Server Error");
      }
    }
    public function savelink($data)
    {
      $i =  $this->campaign->insert("blogcampaign",$data);
      if($i)
      {
        return array("status"=>1,"msg"=>"Successfully Saved");
      }else{
        return array("status"=>0,"msg"=>"Failed to Submit, Server Error");
      }
    }
    public function savecode($data)
    {
      $d = array();
      $i = 0;
      foreach ($data["code"] as $key => $value) {
        $d[$key] = array("unique_code"=>$value,"date_created"=>date("Y-m-d"),"users_id"=>$this->session->id_users);
      }
      $ibatch = $this->campaign->insert_batch("twittercampaign",$d);
      if($ibatch)
      {
        return array("status"=>1,"msg"=>"Successfully Saved");
      }else{
        return array("status"=>0,"msg"=>"Opps Fail to Save");
      }
    }
    public function savecodeytd($data)
    {
      $d = array();
      $i = 0;
      foreach ($data["code"] as $key => $value) {
        $d[$key] = array("unique_code"=>$value,"date_created"=>date("Y-m-d"),"users_id"=>$this->session->id_users);
      }
      $ibatch = $this->campaign->insert_batch("ytcampaign",$d);
      if($ibatch)
      {
        return array("status"=>1,"msg"=>"Successfully Saved");
      }else{
        return array("status"=>0,"msg"=>"Opps Fail to Save");
      }
    }
    public function getUniqidYtd($sesi)
    {
      return $this->campaign->get_where("ytcampaign",array("users_id"=>$sesi));
    }
    public function fetchSubmitedTrans($id)
    {
      return $this->campaign->get_where("transcampaign",array("users_id"=>$id));
    }
    public function fetchSubmitedSign($id)
    {
      return $this->campaign->get_where("signcampaign",array("users_id"=>$id));
    }
    public function fetchSubmited($id)
    {
      return $this->campaign->get_where("blogcampaign",array("users_id"=>$id));
    }
    public function getUniqid($sesi)
    {
      return $this->campaign->get_where("twittercampaign",array("users_id"=>$sesi));
    }
    public function whois($sesi)
    {
      $d = $this->campaign->get_where("users",array("id_users"=>$sesi));
      if($d->num_rows() > 0)
      {
        return $d->row()->username;
      }else{
        return "Failed Identifications";
      }
    }
    public function getTwitterUser($id)
    {
      $a = $this->campaign->get_where("usersmeta",array("meta_key"=>"twitter","users_id"=>$id));
      if($a->num_rows() > 0)
      {
        $idt = $a->result()[0]->meta_value;
        if($idt != null)
        {
          $as = explode("@",$idt);
          return $as[1];
        }else{
          return 0;
        }
      }
    }
    public function getBonus($users_id)
    {
      $a = $this->campaign->get_where("bonusmeta",array("users_id"=>$users_id));
      $x = array();
      $ix = 0;
      foreach ($a->result() as $key => $value) {
        $o = $this->calculatedBonus($value->id_bonus);
        $x[$ix++] = array("id_bonus"=>$value->id_bonus,"date"=>$value->date,"data"=>$o);
      }
      return $x;
    }
    public function calculatedBonus($idbonus)
    {
      $a = $this->campaign->get_where("bonusmeta",array("id_bonus"=>$idbonus));
      $fund = $a->result()[0]->cb_allocated;
      $dTrigger = $a->result()[0]->date;
      $fmytrans = $this->campaign->get_where("bonusmeta",array("id_bonus"=>$idbonus,"trans"=>1,"date"=>$dTrigger));
      $fmytwitter = $this->campaign->get_where("bonusmeta",array("id_bonus"=>$idbonus,"twitter"=>1,"date"=>$dTrigger));
      $fmysign = $this->campaign->get_where("bonusmeta",array("id_bonus"=>$idbonus,"sign"=>1,"date"=>$dTrigger));
      $fmyyt = $this->campaign->get_where("bonusmeta",array("id_bonus"=>$idbonus,"yt"=>1,"date"=>$dTrigger));
      $fmyblog = $this->campaign->get_where("bonusmeta",array("id_bonus"=>$idbonus,"blog"=>1,"date"=>$dTrigger));
      $ftrans = $this->campaign->get_where("bonusmeta",array("trans"=>1,"date"=>$dTrigger));
      $ftwitter = $this->campaign->get_where("bonusmeta",array("twitter"=>1,"date"=>$dTrigger));
      $fsign = $this->campaign->get_where("bonusmeta",array("sign"=>1,"date"=>$dTrigger));
      $fyt = $this->campaign->get_where("bonusmeta",array("yt"=>1,"date"=>$dTrigger));
      $fblog = $this->campaign->get_where("bonusmeta",array("blog"=>1,"date"=>$dTrigger));
      $cftrans = $ftrans->num_rows();
      $cftwitter = $ftwitter->num_rows();
      $cfsign = $fsign->num_rows();
      $cfyt = $fyt->num_rows();
      $cfblog = $fblog->num_rows();
      $cfmytrans = $fmytrans->num_rows();
      $cfmytwitter = $fmytwitter->num_rows();
      $cfmysign = $fmysign->num_rows();
      $cfmyyt = $fmyyt->num_rows();
      $cfmyblog = $fmyblog->num_rows();
      $twitter = 0;
      $yt = 0;
      $blog = 0;
      $trans = 0;
      $sign = 0;
      if($cfmytrans > 0)
      {
        $trans = (($a->result()[0]->cb_trans*$fund)/100) / $cftrans;
      }
      if($cfmytwitter > 0)
      {
        $twitter = (($a->result()[0]->cb_twitter*$fund)/100) / $cftwitter;
      }
      if($cfmysign > 0)
      {
        $sign = (($a->result()[0]->cb_sign*$fund)/100) / $cfsign;
      }
      if($cfmyyt > 0)
      {
        $yt = (($a->result()[0]->cb_yt*$fund)/100) / $cfyt;
      }
      if($cfmyblog > 0)
      {
        $blog (($a->result()[0]->cb_blog*$fund)/100) / $cfblog;
      }
      $res = array("twitter"=>$twitter,"yt"=>$yt,"blog"=>$blog,"trans"=>$trans,"sign"=>$sign);
      return $res;
    }
    public function login($user,$pass)
    {
      $cekUser = $this->campaign->get_where("users",array("username"=>$user,"status"=>1));
      if($cekUser->num_rows() > 0)
      {
        $validate_pass = $this->encrypt->decode($cekUser->result()[0]->password);
        if($validate_pass == $pass)
        {
          $data = $this->campaign->select("*")->from("users")->join("usersmeta a","a.users_id = users.id_users")->where("a.users_id",$cekUser->result()[0]->id_users)->get();

          $this->session->set_userdata("id_users",$data->result()[0]->id_users);
          foreach ($data->result() as $key => $value) {
            if($value->meta_key == "email")
            {
              $this->session->set_userdata("email",$value->meta_value);
            }elseif ($value->meta_key == "twitter") {
              $this->session->set_userdata("twitter",$value->meta_value);
            }elseif ($value->meta_key == "ardor_addr") {
              $this->session->set_userdata("ardor_addr",$value->meta_value);
            }elseif ($value->meta_key == "btc_addr") {
              $this->session->set_userdata("btc_addr",$value->meta_value);
            }elseif ($value->meta_key == "nama") {
              $this->session->set_userdata("nama",$value->meta_value);
            }elseif ($value->meta_key == "youtube") {
              $this->session->set_userdata("youtube",$value->meta_value);
            }elseif ($value->meta_key == "blog_unique") {
              $this->session->set_userdata("blog_unique",$value->meta_value);
            }elseif ($value->meta_key == "level_user") {
              if($value->meta_value == "user")
              {
                $this->session->set_userdata("c_access",1);
              }elseif ($value->meta_value == "admin") {
                $this->session->set_userdata("c_accessAdmin",1);
              }elseif ($value->meta_value == "op") {
                $this->session->set_userdata("c_accessOp",1);
              }
            }
          }
          return array("status"=>1,"msg"=>"Username and Password Corrected","data"=>$data->result());
        }else{
          return array("status"=>0,"msg"=>"Password not Match");
        }
      }else{
        return array("status"=>0,"msg"=>"Username not Found");
      }
    }
}

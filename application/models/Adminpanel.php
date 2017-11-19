<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Adminpanel extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }

    function createUser($email,$password,$nama,$user)
    {
        $checkUser = $this->db->get_where("login",array("email"=>$email))->num_rows();
        if($checkUser < 1)
        {
            $pas = $this->encrypt->encode($password);
            $insert = $this->db->insert("login",array("user_identity"=>$user,"email"=>$email,"password"=>$pas,"status"=>1));
        }else{
            $insert = false;
        }
        if($insert)
        {
             $this->load->helper('string');
             $lastID = $this->db->insert_id();
             $insertUser = $this->db->insert("user_info",array("nama"=>$nama,"login_id"=>$lastID,"nxt_address"=>random_string("alnum",10)));
             if($insertUser)
             {
                 $autoLogin = random_string("alnum",10);
                 $media = $this->load->database('media88', TRUE);
                 @$t_hasher = new PasswordHash(12, FALSE); // Define the iterations once.
                 @$hash = $t_hasher->HashPassword($password);
                 $insert1 = $media->insert("users",array("user_login"=>$user,"user_pass"=>$hash,"user_registered"=>date("Y-m-d H:i:s"),"user_email"=>$email,"user_status"=>0,"display_name"=>$user));
                 $data = array(
                            array(
                               'user_id' =>$media->insert_id(),
                               'meta_key' => 'media88_capabilities' ,
                               'meta_value' => 'a:1:{s:10:"subscriber";b:1;}'
                            ),
                            array(
                               'user_id' =>$media->insert_id(),
                               'meta_key' => 'pkg_autologin_code' ,
                               'meta_value' => $autoLogin
                            ),
                            array(
                               'user_id' =>$media->insert_id(),
                               'meta_key' => 'media88_user_level' ,
                               'meta_value' => 0
                            )
                         );
                 $insert2 = $media->insert_batch("usermeta",$data);
                 if($insert1 && $insert1)
                 {
                   return array("status"=>1,"msg"=>"Register Successfull","autoLogin"=>$autoLogin,"id_login"=>$lastID);
                 }else{
                   return array("status"=>0,"msg"=>"Register Failed");
                 }
             }else{
                 $deleteLogin = $this->db->delete("login",array("id_login"=>$lastID));
                 if($deleteLogin)
                 {
                     return array("status"=>0,"msg"=>"Registration Fail","fairMsg"=>$insertUse);
                 }else{
                     return array("status"=>0,"msg"=>"Fatal Critical Please Contact Administrator");
                 }
             }
        }else{
             return array("status"=>0,"msg"=>"Registration Fail","fairMsg"=>$checkUser);
        }
    }
    function deletePeriode($id)
    {
      $cek = $this->db->get_where("crowdsale",array('id_crowdsale' =>$id));
      if($cek->num_rows() > 0)
      {
        $delete = $this->db->delete("crowdsale",array("id_crowdsale"=>$id));
      }else{
        $delete = false;
      }
      if($delete)
      {
        return array("status"=>1,"msg"=>"Data Successfully Deleted");
      }else{
        return array("status"=>0,"msg"=>"Data Not Found");
      }
    }
    function updatePeriode($data)
    {
      $cek = $this->db->get_where("crowdsale",array("id_crowdsale"=>$data["id_crowdsale"]));

      if($data["sell"] > 0 && $cek->num_rows() > 0)
      {
        $round = count($data["data"]);
        $sellcoin = $data["sell"];
        $date = date("Y-m-d H:i:s");
        $insert = $this->db->where("id_crowdsale",$data["id_crowdsale"])->update("crowdsale",array("round"=>$round,"coinsell"=>$sellcoin));
        if($insert)
        {
          $lastID = $data["id_crowdsale"];
          $dataMeta = array();
          $no = 0 ;
          $meta = 1;
          $getID = $this->db->get_where("crowdsale_meta",array("crowdsale_id"=>$lastID));
          $getID = $getID->result();
          foreach ($data["data"] as $key => $value) {
            $statusTimer = ($value["bonus"] >= 0)?"open":"close";
            $bonusMeta =  ($value["bonus"] >= 0)?$value["bonus"]:0;
            $json = array("timer_type"=>$statusTimer,"data"=>array("timer_start"=>$value["start_date"]." 00:00:00","timer_end"=>$value["end_date"]." 00:00:00","timer_bonus"=>$bonusMeta));
            $updateData = array("id_meta"=>$getID[$no]->id_meta,"crowdsale_id"=>$lastID,"meta_key"=>$meta,"meta_value"=>json_encode($json));
            $up = $this->db->where("id_meta",$getID[$no]->id_meta)->update("crowdsale_meta",$updateData);
            $no++;
            $meta++;
            if($up)
            {
                $s = true;
            }else{
                $s = false;
                break;
            }
          }

          if($s)
          {
              return array("status"=>1,"msg"=>"Successfully Update Crowdsale");
          }else{
            return array("status"=>0,"msg"=>"Insert Failed");
          }

        }
      }else{
        return array("status"=>0,"msg"=>"ID Not Found");
      }
    }
    function createPeriode($data)
    {
      if($data["sell"] > 0)
      {
        $round = count($data["data"]);
        $sellcoin = $data["sell"];
        $date = date("Y-m-d H:i:s");
        $insert = $this->db->insert("crowdsale",array("round"=>$round,"coinsell"=>$sellcoin,"created"=>$date));
        if($insert)
        {
          $lastID = $this->db->insert_id();
          $dataMeta = array();
          $no = 0 ;
          $meta = 1;
          foreach ($data["data"] as $key => $value) {
            $statusTimer = ($value["bonus"] >= 0)?"open":"close";
            $bonusMeta =  ($value["bonus"] >= 0)?$value["bonus"]:0;
            $json = array("timer_type"=>$statusTimer,"data"=>array("timer_start"=>$value["start_date"]." 00:00:00","timer_end"=>$value["end_date"]." 00:00:00","timer_bonus"=>$bonusMeta));

            $dataMeta[$no++] = array("crowdsale_id"=>$lastID,"meta_key"=>$meta++,"meta_value"=>json_encode($json));
          }
          $insert2 = $this->db->insert_batch("crowdsale_meta",$dataMeta);
          if($insert2)
          {
              return array("status"=>1,"msg"=>"Successfully Create Crowdsale");
          }else{
            return array("status"=>0,"msg"=>"Insert Failed");
          }

        }else{
          return array("status"=>0,"msg"=>"Insert Failed");
        }
      }else{
        return array("status"=>0,"msg"=>"Coin Sell Must more than 0");
      }
    }
    function getCrowdsale()
    {
      return $this->db->get("crowdsale");
    }
  }

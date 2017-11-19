<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Acc extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }
    function listUser()
    {
        $admin = $this->db->select("id_users,login_id,nama,nxt_address,btc_address,user_identity,email")->from("user_info a")->join("login c","c.id_login=a.login_id")->get();
        return $admin;
    }
    function cekToken($token='',$addr='')
    {
      if($token != null && $addr != null)
      {

          try {
              $ch = curl_init();

              if (FALSE === $ch)
                  throw new Exception('failed to initialize');

              curl_setopt($ch, CURLOPT_URL, 'http://serverfrasindocom-at.cloud.revoluz.io:49409/nxt?=%2Fnxt&requestType=decodeToken&website=frasindo.com&token='.urlencode($token));
              curl_setopt($ch, CURLOPT_HEADER, false);
              curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
              curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
              curl_setopt($ch, CURLOPT_POST, true);
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
          if($dataJson->valid && $dataJson->accountRS == $addr)
          {
            return true;
          }else{
            return false;
          }
        }else{
          return false;
        }
    }
    function listAdmin()
    {
      $admin = $this->db->select("c.id_login,a.nama,b.department_name,c.status,c.email")->from("admin_info a")->join("department b","a.dep_id=b.id_department")->join("login c","c.id_login=a.login_id")->get();
      return $admin;
    }
    function listDep()
    {
      return $this->db->get("department");
    }
    function wipeAccount($email)
    {
      $media = $this->load->database('media88', TRUE);
      $cek_wp = $media->get_where("users",array("user_email"=>$email));
      $cek_shop = $this->db->get_where("login",array("email"=>$email));
      if($cek_shop->num_rows() > 0 || $cek_wp->num_rows() > 0)
      {
        $wipe_shop = $this->db->delete("login",array("email"=>$email));
        if($this->db->affected_rows() > 0)
        {
          $getID = $media->get_where("users",array("user_email"=>$email))->row()->ID;
          $wipe_wp = $media->delete("users",array("user_email"=>$email));
          if($media->affected_rows() > 0)
          {
            $wipe_wpmeta = $media->delete("usermeta",array("user_id"=>$getID));
            if($media->affected_rows() > 0)
            {
              return array("status"=>1,"msg"=>"Data Successfully Deleted");
            }else{
              return array("status"=>0,"msg"=>"Sweeping Account Step 3, Account not Found in WPMETA Database");
            }
          }else{
            return array("status"=>0,"msg"=>"Sweeping Account Step 2, Account not Found in WP Database");
          }
        }else {
          return array("status"=>0,"msg"=>"Sweeping Account Step 1, Account not Found in Shop Database");
        }
      }else{
        return array("status"=>0,"msg"=>"Sweeping Account Failed, Target Account not Found");
      }
    }
    function createAdmin($data)
    {
        $cek_email = $this->db->get_where("login",array("email"=>$data["email"]));
        $cek_user = $this->db->get_where("login",array("user_identity"=>$data["user"]));
        $cek_dep = $this->db->get_where("department",array("id_department"=>$data["depid"]));
        if($cek_email->num_rows() == 0 && $cek_user->num_rows() == 0 && $cek_dep->num_rows() > 0)
        {
          $pas = $this->encrypt->encode($data["pass"]);
          $insert_login = $this->db->insert("login",array("user_identity"=>$data["nama"],"email"=>$data["email"],"password"=>$pas,"access"=>1,"status"=>1));
          if($insert_login)
          {
            $lastID = $this->db->insert_id();
            $insert_admin = $this->db->insert("admin_info",array("nama"=>$data["nama"],"dep_id"=>$data["depid"],"login_id"=>$lastID));
            if($insert_admin)
            {
              $administrator = 'a:1:{s:13:"administrator";b:1;}';
              $nickname = $data["email"];
              $name = $data["nama"];
              $media = $this->load->database('media88', TRUE);
              @$t_hasher = new PasswordHash(12, FALSE); // Define the iterations once.
              @$hash = $t_hasher->HashPassword($data["pass"]);
              $insert_wp = $media->insert("users",array("user_login"=>$data["user"],"user_pass"=>$hash,"user_registered"=>date("Y-m-d H:i:s"),"user_email"=>$data["email"],"user_status"=>0,"display_name"=>$name));
              if($insert_wp)
              {
                $this->load->helper('string');
                $autoLogin = random_string("alnum",10);
                $data = array(
                           array(
                              'user_id' =>$media->insert_id(),
                              'meta_key' => 'media88_capabilities' ,
                              'meta_value' => $administrator
                           ),
                           array(
                              'user_id' =>$media->insert_id(),
                              'meta_key' => 'pkg_autologin_code' ,
                              'meta_value' => $autoLogin
                           ),
                           array(
                              'user_id' =>$media->insert_id(),
                              'meta_key' => 'media88_user_level' ,
                              'meta_value' => 10
                           ),
                           array(
                              'user_id' =>$media->insert_id(),
                              'meta_key' => 'show_admin_bar_front' ,
                              'meta_value' => true
                           )
                        );
                $insert_wpmeta = $media->insert_batch("usermeta",$data);
                if($insert_wpmeta)
                {
                  return array("status"=>1,"msg"=>"Successfully Save Admin Account");
                }else{
                  $rollback = $media->delete("users",array("ID"=>$media->insert_id()));
                  if($rollback)
                  {
                    return array("status"=>0,"msg"=>"Failed to Save Step 4, System Error (Rollback Successfully)");
                  }else{
                    return array("status"=>0,"msg"=>"Failed to Save Step 4, System Error (Rollback Failed)");
                  }
                }
              }else{
                $rollback = $this->db->delete("login",array("id_login"=>$lastID));
                if($rollback)
                {
                  return array("status"=>0,"msg"=>"Failed to Save Step 3, System Error (Rollback Successfully)");
                }else{
                  return array("status"=>0,"msg"=>"Failed to Save Step 3, System Error (Rollback Failed)");
                }
              }
            }else{
              return array("status"=>0,"msg"=>"Failed to Save Step 2, System Error");
            }
          }else{
            return array("status"=>0,"msg"=>"Failed to Save Step 1, System Error");
          }

        }else{
          return array("status"=>0,"msg"=>"Failed to Save Duplicate user or email");
        }
    }
    function checksaldo($addr,$name)
    {
      $nxt_server = "http://serverfrasindocom-at.cloud.revoluz.io:49409";

      $param2 = "/nxt?=%2Fnxt&requestType=searchAssets&query=".$name;
      try {
          $ch = curl_init();

          if (FALSE === $ch)
              throw new Exception('failed to initialize');

          curl_setopt($ch, CURLOPT_URL, $nxt_server.$param2);
          curl_setopt($ch, CURLOPT_HEADER, false);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
          curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
          curl_setopt($ch, CURLOPT_POST, true);

          $content = curl_exec($ch);

          if (FALSE === $content)
              throw new Exception(curl_error($ch), curl_errno($ch));
           $assetCek =  json_decode($content);
           $id = $assetCek->assets[0]->asset;
      } catch(Exception $e) {
          trigger_error(sprintf(
              'Curl failed with error #%d: %s',
              $e->getCode(), $e->getMessage()),
              E_USER_ERROR);

      }
      $param = "/nxt?=%2Fnxt&requestType=getAccountAssets&account=".$addr."&asset=".$id;
      try {
          $ch = curl_init();

          if (FALSE === $ch)
              throw new Exception('failed to initialize');

          curl_setopt($ch, CURLOPT_URL, $nxt_server.$param);
          curl_setopt($ch, CURLOPT_HEADER, false);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
          curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
          curl_setopt($ch, CURLOPT_POST, true);

          $content = curl_exec($ch);

          if (FALSE === $content)
              throw new Exception(curl_error($ch), curl_errno($ch));
           $data =  json_decode($content);
           return $data;

      } catch(Exception $e) {
          trigger_error(sprintf(
              'Curl failed with error #%d: %s',
              $e->getCode(), $e->getMessage()),
              E_USER_ERROR);

      }
    }
    function updateNXT($nxt,$btc,$sesi)
    {
        $getUser = $this->db->get_where("user_info",array("login_id"=>$sesi));
        if($getUser->num_rows() > 0)
        {
            $this->db->where('login_id',$sesi);
            $data = array("nxt_address"=>trim($nxt," "),"btc_address"=>$btc);
            $updateData = $this->db->update('user_info', $data);
            if($updateData)
            {
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    function totalParticipant(){
    	return $this->db->get("user_info")->num_rows();
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Chatmodel extends CI_Model {
  public function __construct()
  {
          parent::__construct();
  }
  public function get_message($tipe, $ke, $user)
  {
    $data = array();
		if($tipe == 'rooms'){
			if($ke == 'all'){
        $sql = $this->db->where("tipe",$tipe)->order_by("date","asc")->get("chatuser");
			}else{
				$sql = $this->db->where("ke",$ke)->order_by("date","asc")->get("chatuser");
			}
      foreach ($sql->result() as $key => $value) {
				$data[] = array(
					'name' => $value["name"],
					'avatar' => $this->gravatar->get($this->session->email),
					'message' => $value["message"],
					'tipe' => $value["tipe"],
					'date' => $value["date"],
					'selektor' => $value["ke"]
				);
			}
    }else if($tipe == 'users'){
			if($ke == 'all'){
        $sql = $this->db->where("(name = ".$user." and tipe= ".$tipe.") OR (ke = ".$ke." and tipe = ".$tipe.")")->order_by("date","asc")->get("chatuser");
			}else{
        $sql = $this->db->where("(name = ".$user." and ke= ".$ke.") OR (name = ".$user." and ke = ".$ke.")")->order_by("date","asc")->get("chatuser");
			}
      foreach ($sql->result() as $key => $value) {
				$data[] = array(
					'name' => $value["name"],
					'avatar' => $this->gravatar->get($this->session->email),
					'message' => $value["message"],
					'tipe' => $value["tipe"],
					'date' => $value["date"],
					'selektor' => ($value['name'] == $user ? $value['ke'] : $value['name'])
				);
			}
		}
		return $data;
  }
  public function get_user($user='')
  {
    if($user == null)
    {
      $value = $this->db->get("login");
      foreach ($value->result() as $key => $value) {
        $data[] = array(
  				'name' => $r['user_identity'],
  				'avatar' => $this->gravatar->get($this->session->email),
  				'login' => "2016-10-01 17:27:57",
  				'status' => "online"
  			);
      }
    }
    return $data;
  }
  public function send_message($name, $ke, $message, $date, $avatar, $tipe)
  {
    $insert = $this->db->insert("chatuser",array("name"=>$name,"ke"=>$ke,"avatar"=>$avatar,"message"=>$message,"tipe"=>$tipe,"date"=>date("Y-m-d H:i:s")));
    if($insert)
    {
      $data["status"] = "success";
    }else{
      $data["status"] = "failed";
    }
    return $data;
  }
  public function user_logout($value='')
  {
    $data['status'] = 'success';
		return $data;
  }
}

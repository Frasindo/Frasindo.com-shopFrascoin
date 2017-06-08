<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Acc extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }
    function updateNXT($nxt,$btc,$sesi)
    {
        $getUser = $this->db->get_where("user_info",array("login_id"=>$sesi));
        if($getUser->num_rows() > 0)
        {
            $this->db->where('login_id',$sesi);
            $data = array("nxt_address"=>$nxt,"btc_address"=>$btc);
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

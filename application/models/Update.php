<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Update extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }
    function read_user($data)
    {
        return $this->db->get_where("user_info",$data);
    }
    function update_user($id,$data)
    {
        $this->db->where("login_id",$id);
        return $this->db->update("user_info",$data);
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Activate extends CI_Controller {
	public function code($code='')
	{
      if($code != null)
      {
        $db = $this->db->get_where("login",array("status"=>0,"password"=>base64_decode(urldecode($code))));
        if($db->num_rows() > 0)
        {
          $update = $this->db->where("id_login",$db->result()[0]->id_login)->update("login",array("status"=>1));
          if($update)
          {
            echo "Your Account Successfully Activated";
          }else{
            echo "Your Account Failed Activated";
          }
        }else{
          show_404();
        }
      }else{
        show_404();
      }
  }
  function forgot($code='')
  {
    if($code != null)
    {
      
    }else{
      show_404();
    }
  }
}

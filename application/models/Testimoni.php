<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Testimoni extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }
    function fetch($sort='desc')
    {
      $query = $this->db->select(array("nama","isi","job","company","img"))->order_by('id_testi', $sort)->get_where("testimoni",array("status"=>1));
      return $query->result();
    }
    function get($status=1)
    {
      if($status == 1)
      {
        $query = $this->db->select(array("id_testi","nama","isi","job","company","img","status"))->get_where("testimoni",array("status"=>1));
      }else{
        $query = $this->db->select(array("id_testi","nama","isi","job","company","img","status"))->get_where("testimoni",array("status"=>0));
      }
      return $query->result();
    }
    function setStatus($status='',$id)
    {
      if($status != null && $id != null)
      {
        if($status == 1)
        {
          $query = $this->db->where("id_testi",$id)->update("testimoni",array("status"=>1));
        }else{
          $query = $this->db->where("id_testi",$id)->update("testimoni",array("status"=>0));
        }
        return $query;
      }else{
        return false;
      }
    }
    function count($type=1)
    {
      if($type == 1)
      {
        $query = $this->db->select(array("nama","isi","job","company","img"))->get_where("testimoni",array("status"=>1));
      }else{
        $query = $this->db->select(array("nama","isi","job","company","img"))->get_where("testimoni",array("status"=>0));
      }
      return $query->num_rows();
    }
    function add($login_id,$nama,$isi,$img,$job='',$company='')
    {
      return $this->db->insert("testimoni",array("login_id"=>$login_id,"nama"=>$nama,"isi"=>$isi,"job"=>$job,"company"=>$company,"img"=>$img));
    }
  }

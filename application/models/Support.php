<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Support extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }
    function list_ticket($id='')
    {

        $this->db->select("ticket.id_tiket,ticket.isi,ticket.masalah,department.department_name,ticket.date,ticket.status,ticket.closed_date");
        $this->db->from("ticket");
        $this->db->join("login","login.id_login = ticket.login_id");
        $this->db->join("department","department.id_department = ticket.department_id");
        if($id == null)
        {
          $sesi = $this->session->id_login;
          $this->db->where("login.id_login",$sesi);
        }else{
          $this->db->where("ticket.id_tiket",$id);
        }
        $this->db->order_by("ticket.date","desc");
        $data = $this->db->get();
        return $data;
    }
    function list_ticket_by_dep()
    {
      $sesi = $this->session->id_login;
      $f = $this->db->get_where("admin_info",array("login_id"=>$sesi));
      $z = $this->db->get_where("department",array("id_department"=>$f->result()[0]->dep_id));
      $this->db->select("ticket.masalah,ticket.id_tiket,ticket.isi,ticket.date,ticket.closed_date,ticket.status,a.department_name,b.nama");
      $this->db->from("ticket");
      $this->db->join("department a","ON a.id_department = ticket.department_id");
      $this->db->join("user_info b","ON b.login_id = ticket.login_id");
      $this->db->where("department_id",$f->result()[0]->dep_id);
      return $this->db->get()->result();

    }
    function list_reply($id)
    {
      $this->db->select("*");
      $this->db->from("reply_ticket");
      $this->db->join("ticket","ticket.id_tiket = reply_ticket.ticket_id");
      $this->db->join("department","department.id_department = ticket.department_id");
      $this->db->where("ticket.id_tiket",$id);
      return $this->db->get();
    }
    function create_ticket($data)
    {
      $data["date"] = date("Y-m-d");
      $data["login_id"] = $this->session->id_login;
      return $this->db->insert("ticket",$data);
    }
    function closed_ticket($id)
    {
        $ticket = $this->db->where("id_tiket",$id)->update("ticket",array("status"=>3,"closed_date"=>date("Y-m-d")));
        return $ticket;
    }
    function reply_ticket($id,$msg)
    {
        $reply_by = ($this->db->get_where("admin_info",array("login_id"=>$this->session->id_login))->num_rows() > 0)?"admin":"user";
        if($reply_by == "admin")
        {
          $this->db->where("id_tiket",$id)->update("ticket",array("status"=>1));
        }else{
          $this->db->where("id_tiket",$id)->update("ticket",array("status"=>2));
        }
        return $this->db->insert("reply_ticket",array("ticket_id"=>$id,"isi_reply"=>$msg,"reply_by"=>$reply_by,"reply_date"=>date("Y-m-d")));
    }
    function deplist()
    {
      return $this->db->get("department");
    }
  }

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends CI_Controller {
  public function __construct()
  {
          parent::__construct();
          $this->load->model("adminpanel");
          $this->load->model("bill");
          $this->load->model("acc");
  }
	public function index()
	{
      if($this->session->access == 1)
      {
				$data["judul"] = "Administrator Panel";
				$data["user_info"] = array("nama"=>$this->session->nama);
				$data["data_page"] = null;
        $adminInfo = $this->db->get_where("admin_info",array("login_id"=>$this->session->id_login));
        $ticket = $this->db->where("department_id",$adminInfo->result()[0]->dep_id)->where("status = 1 OR status = 0")->get("ticket");
        $user = $this->db->get("user_info");
        $datacrowdale = $this->bill->getBonusNow(date("d-m-Y"));
        if($this->db->get_where("crowdsale",array("id_crowdsale"=>$datacrowdale["id_crowdsale"]))->num_rows() > 0)
        {
          $fras = $this->db->get_where("crowdsale",array("id_crowdsale"=>$datacrowdale["id_crowdsale"]))->row()->coinsell;
        }else{
          $fras = "END CROWDSALE";
        }
        $data["listAdmin"] = $this->acc->listAdmin();
        $data["fras"] = $fras;
        $data["tiket"] = $ticket->num_rows();
        $data["totalUser"] = $user->num_rows();
        $data["crowdsaleItem"] = $this->adminpanel->getCrowdsale();

				$data["page"] = "home/homeAdmin";
				$this->load->view("adminLTE/_headerAdmin",$data);
				$this->load->view("adminLTE/_homeAdmin",$data);
				$this->load->view("adminLTE/_footerAdmin");
      }else{
        redirect(base_url("admin/login"),'refresh');
      }
  }
  function login()
  {
    $data["judul"] = "Administrator";
    $data["page"] = "login/loginAdmin";
    $this->load->view("loginTemplate/_header",$data);
    $this->load->view("loginTemplate/_content",$data);
    $this->load->view("loginTemplate/_footer");
  }
	function page($page='')
	{
		if($this->session->access == 1)
		{
			if($page != null)
			{
					if($page == "testify")
					{
						$this->load->model("testimoni");
						if(isset($_POST["approve"]))
						{
							$status = 1;
						}else{
							$status = null;
						}
						$data["judul"] = "Testify Manager";
						$data["user_info"] = array("nama"=>$this->session->nama);
						$data["data_page"] = null;
						$data["approve"] = $this->testimoni->count();
						$data["unapprove"] = $this->testimoni->count(0);
						$data["list"] = $this->testimoni->get($status);
						$data["page"] = "pages/testifyAdmin";
						$this->load->view("adminLTE/_headerAdmin",$data);
						$this->load->view("adminLTE/_homeAdmin",$data);
						$this->load->view("adminLTE/_footerAdmin");
					}elseif($page == "ticket"){
            $this->load->model("support");
            $val = $this->uri->segment(5);
            $identify = $this->uri->segment(4);
            if($identify != "detail")
            {
  						$data["judul"] = "Ticket Manager";
  						$data["user_info"] = array("nama"=>$this->session->nama);
  						$data["data_page"] = $this->support->list_ticket_by_dep();
  						$data["page"] = "pages/ticketAdmin";
  						$this->load->view("adminLTE/_headerAdmin",$data);
  						$this->load->view("adminLTE/_homeAdmin",$data);
  						$this->load->view("adminLTE/_footerAdmin");
            }else{
							if(is_numeric($val)){
			          $stat = $this->db->get_where("ticket",array("id_tiket"=>$val));
			          if($stat->num_rows() > 0)
			          {
		            if($this->input->post("reply") != null && $stat->result()[0]->status < 3)
		            {
		              $msg = $this->input->post("reply",true);
		              $insert  = $this->support->reply_ticket($val,$msg);
		              if($insert)
		              {
		                $data["alert_comments"] = "<div class='alert alert-success'><p>Reply Successfully</p></div>" ;
		              }else{
		                $data["alert_comments"] = "<div class='alert alert-danger'><p>Opps Something Wrong, Wait Sec !</p></div>" ;
		              }
		            }
		            if(isset($_POST["close"]) && $stat->result()[0]->status < 3)
		            {
		              $id = $this->support->closed_ticket($val);
		              if($id)
		              {
		                $data["alert"] = "<div class='alert alert-success'><p>Ticket Closed Successfully</p></div>" ;
		              }else{
		                $data["alert"] = "<div class='alert alert-danger'><p>Oops Something Error</p></div>" ;
		              }
		            }
								$list = $this->support->list_ticket($val);
								$reply = $this->support->list_reply($val);
								$data["judul"] = "Detail Tiket";
	  						$data["data_page"] = array("dataTicket"=>$list,"dataReply"=>$reply);
								$data["page"] = "pages/detail_ticketAdmin";
		            $this->load->view("adminLTE/_headerAdmin",$data);
		            $this->load->view("adminLTE/_homeAdmin",$data);
		            $this->load->view("adminLTE/_footerAdmin");
							}else{
								show_404();
							}
						}else{
              show_404();
            }
            }
					}elseif($page == "usermanage"){
            $cr = $this->acc->listUser();
            $no = 0;
            $d = array();
            foreach ($cr->result() as $key => $value) {
              $fras = $this->acc->checksaldo($value->nxt_address,"asemcoin");
              $fras = (isset($fras->asset))?$fras->quantityQNT:0;
              $statusFill = (count((explode("-",$value->nxt_address))) > 1)?$value->nxt_address:false;
              $d[$no++] = array("email"=>$value->email,"fiilingAddr"=>$statusFill,"frasBalance"=>$fras,"id_login"=>$value->login_id,"id_users"=>$value->id_users,"username"=>$value->user_identity,"nama"=>$value->nama,"email"=>$value->email,"nxt_address"=>$value->nxt_address,"btc_address"=>$value->btc_address);
            }
            $data["listUser"] = $d;
            $data["judul"] = "Users Manager";
            $data["user_info"] = array("nama"=>$this->session->nama);
            $data["data_page"] = null;
            $data["page"] = "pages/userManage";
            $this->load->view("adminLTE/_headerAdmin",$data);
            $this->load->view("adminLTE/_homeAdmin",$data);
            $this->load->view("adminLTE/_footerAdmin");
          }else{
            show_404();
          }
			}else{
        show_404();
			}
		}else{
			show_404();
		}
	}
}

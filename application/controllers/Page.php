<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH . 'third_party/coinbase/vendor/autoload.php';
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Address;
use Coinbase\Wallet\Resource\Account;

class Page extends CI_Controller {
    public $apiKey;
    public $secretApi;
    function __construct()
    {
        parent::__construct();
        $this->load->library("upload_lib");
        $this->load->model("update");
        $this->load->model("bill");
        $this->apiKey = "B60xwCy8vBdIAfxn";
        $this->secretApi = "KvyQYfQHX44tGXgvIDipdkhsE8cut9zz";
        if($this->session->access == null)
      	{
      	    exit(show_404());
      	}
        if($this->session->nxt_address == null)
        {
           exit(show_404());
        }
    }
    function chat()
    {
      $data["judul"] ="Chat Room";
      $this->load->view("chat/room",$data);
    }
    function history($param = null)
    {
        if($param == "btc")
        {
            $this->load->model("bill");
            $this->load->model("acc");
            $totalPartisipan = $this->acc->totalParticipant();
            $fixedFras = $this->bill->getFixedFras();
            $investTotal = $this->bill->totalInvest($this->apiKey,$this->secretApi);
            $Tinvest = number_format($investTotal,8);
            $data["user_info"] = array("nama"=>$this->session->nama,"picture"=>base_url($this->session->avatar));
            $data["judul"] ="Sales History of Frasindo";
            $data["data_page"] = array("data"=>array("tp"=>$totalPartisipan,"Tinvest"=>$Tinvest,"fixedFras"=>$fixedFras));
            $data["page"] = "history/btc";
            $this->load->view("adminLTE/_header",$data);
            $this->load->view("adminLTE/_home",$data);
            $this->load->view("adminLTE/_footer");
        }else{
            show_404();
        }
    }
    function ticket($type="read")
    {
      $this->load->model("support");
      if($type == "read")
      {
        $list = $this->support->list_ticket();
        $data["user_info"] = array("nama"=>$this->session->nama,"picture"=>base_url($this->session->avatar));
        $data["judul"] ="Support Ticket";
        $data["data_page"] = $list;
        $data["page"] = "pages/ticket";
        $this->load->view("adminLTE/_header",$data);
        $this->load->view("adminLTE/_home",$data);
        $this->load->view("adminLTE/_footer");
      }elseif ($type == "create") {
        $dep = $this->support->deplist();
        if($this->input->post("isi",true) != null)
        {
          $data = $this->input->post(NULL,true);
          if($this->support->create_ticket($data))
          {
            $data["alert"] = "<div class='alert alert-success'><p>Ticket Created Successfully</p></div>";
          }else{
            $data["alert"] = "<div class='alert alert-danger'><p>Opps Ticket Failed to Created</p></div>";
          }
        }
        $data["user_info"] = array("nama"=>$this->session->nama,"picture"=>base_url($this->session->avatar));
        $data["judul"] ="Support Ticket";
        $data["data_page"] = $dep;
        $data["page"] = "pages/add_ticket";
        $this->load->view("adminLTE/_header",$data);
        $this->load->view("adminLTE/_home",$data);
        $this->load->view("adminLTE/_footer");
      }elseif ($type == "close") {

      }elseif($type == "detail"){
        if(is_numeric($this->uri->segment(4))){
          $stat = $this->db->get_where("ticket",array("id_tiket"=>$this->uri->segment(4)));
          if($stat->num_rows() > 0)
          {
            if($this->input->post("reply") != null && $stat->result()[0]->status < 3)
            {
              $msg = $this->input->post("reply",true);
              $insert  = $this->support->reply_ticket($this->uri->segment(4),$msg);
              if($insert)
              {
                $data["alert_comments"] = "<div class='alert alert-success'><p>Reply Successfully</p></div>" ;
              }else{
                $data["alert_comments"] = "<div class='alert alert-danger'><p>Opps Something Wrong, Wait Sec !</p></div>" ;
              }
            }
            if(isset($_POST["close"]) && $stat->result()[0]->status < 3)
            {
              $id = $this->support->closed_ticket($this->uri->segment(4));
              if($id)
              {
                $data["alert"] = "<div class='alert alert-success'><p>Ticket Closed Successfully</p></div>" ;
              }else{
                $data["alert"] = "<div class='alert alert-danger'><p>Oops Something Error</p></div>" ;
              }
            }
            $list = $this->support->list_ticket();
            $reply = $this->support->list_reply($this->uri->segment(4));
            $data["user_info"] = array("nama"=>$this->session->nama,"picture"=>base_url($this->session->avatar));
            $data["judul"] ="Support Ticket";
            $data["data_page"] = array("dataTicket"=>$list,"dataReply"=>$reply);
            $data["page"] = "pages/detail_tiket";
            $this->load->view("adminLTE/_header",$data);
            $this->load->view("adminLTE/_home",$data);
            $this->load->view("adminLTE/_footer");
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
    function account()
    {
        $this->load->model("acc");
        if($this->uri->segment(3) == "ardr")
        {

        }else {
            if(!isset($_GET["add"]))
            {
              if($this->session->authy == 0 or $this->session->authyConfirm != null){
              $dataUser = $this->update->read_user(array("login_id"=>$this->session->id_login))->result()[0];
              if($dataUser->tokenTwofactor == null)
              {
                  $secret = $this->googleauthenticator->createSecret();
                  $this->update->update_user($this->session->id_login,array("tokenTwofactor"=>$secret));
              }else{
                  $secret = $dataUser->tokenTwofactor;
              }
              $qrCodeUrl = $this->googleauthenticator->getQRCodeGoogleUrl('Frasindo Login Guard', $this->session->username, $secret);
              $data["authy"] = (isset($qrCodeUrl))?$qrCodeUrl:null;


              if(isset($_GET["reset"]))
              {
                  $this->session->unset_userdata("avatar");
                  redirect(base_url(),'refresh');
              }
              if(isset($_GET["delete"]))
              {
                $cek = $this->db->get_where("setAcc",array("id_acc"=>$this->input->get("delete")));
                if($cek->num_rows() > 0)
                {

                    $delete = $this->db->delete("setAcc",array("id_acc"=>$this->input->get("delete")));
                    if($delete)
                    {
                      $data["alert_m"] = "<div class='alert alert-success'><p>Your Data Successfully Deleted</p></div>";
                    }else{
                      $data["alert_m"] = "<div class='alert alert-danger'><p>Sorry Server Error</p></div>";
                    }
                }else {
                    $data["alert_m"] = "<div class='alert alert-danger'><p>Sorry Selected Data Not Found</p></div>";
                }
              }
              $configuration = Configuration::apiKey($this->apiKey, $this->secretApi);
              $client = Client::create($configuration);
              $client->getAccounts();
              $data = $client->decodeLastResponse()["data"];
              $id_acc = "";
              foreach($data as $list_key => $value){
                 if($value["name"] == $this->session->nxt_address){
                     $id_acc = $value["id"];
                 }
              }
              $account = $client->getAccount($id_acc);
              if(isset($_GET["setPrimary"]))
              {
                $cek = $this->db->get_where("setAcc",array("id_acc"=>$this->input->get("setPrimary")));
                if($cek->num_rows() > 0)
                {
                  $old = $this->session->nxt_address;
                  $oldNote = $this->db->get_where("user_info",array("nxt_address"=>$old))->result()[0]->notes;
                  $new = $this->db->get_where("setAcc",array("id_acc"=>$this->input->get("setPrimary")))->result()[0];
                  $this->db->where("nxt_address",$old);
                  $update =  $this->db->update("user_info",array("nxt_address"=>$new->nxt_address,"notes"=>$new->notes));
                  $setAcUp = $this->db->where("nxt_address",$new->nxt_address)->update("setAcc",array("nxt_address"=>$old,"notes"=>$oldNote));
                  if($update && $setAcUp)
                  {
                    $account->setName($new->nxt_address);
                    $client->updateAccount($account);
                    $this->session->unset_userdata("nxt_address");
                    $this->session->set_userdata("nxt_address",$new->nxt_address);
                    $data["alert_m"] = "<div class='alert alert-success'><p>Change Primary Account Successfully</p></div>";
                  }else{
                    $data["alert_m"] = "<div class='alert alert-danger'><p>Something Wrong</p></div>";
                  }
                }else{
                  $data["alert_m"] = "<div class='alert alert-danger'><p>Sorry Selected Data Not Found</p></div>";
                }
              }
              if(isset($_POST["nama"]))
              {
                  $data = $this->input->post(NULL,true);
                  $update = $this->update->update_user($this->session->id_login,$data);
                  if($update)
                  {
                      $data["alert_m"] = $this->upload_lib->alert("success","Request Success","Update Profile Success").$this->upload_lib->alihkan(base_url("page/account"),1000);
                      $this->session->set_userdata("nama",$data["nama"]);
                  }else{
                      $data["alert_m"] = $this->upload_lib->alert("danger","Request Failed","Update Profile Failed").$this->upload_lib->alihkan(base_url("page/account"),1000);;
                  }
              }
              $data["user_info"] = array("nama"=>$this->session->nama,"picture"=>base_url($this->session->avatar));
              $data["judul"] ="Setting Account";
              $data["data_page"] = $dataUser;
              $data["page"] = "pages/account";
              $this->load->view("adminLTE/_header",$data);
              $this->load->view("adminLTE/_home",$data);
              $this->load->view("adminLTE/_footer");
              }else{
                  redirect(base_url(),'refresh');
              }
            }else{
              if(isset($_POST["sARDR"]))
              {
                $data = $this->input->post(null,true);
                unset($data["sARDR"]);
                if(strlen($data["nxt_address"]) == 24 && $data["token"] != null)
                {
                    try {
                        $ch = curl_init();

                        if (FALSE === $ch)
                            throw new Exception('failed to initialize');

                        curl_setopt($ch, CURLOPT_URL, 'http://server.frasindo.com:49409/nxt?=%2Fnxt&requestType=decodeToken&website=frasindo.com&token='.urlencode($data["token"]));
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
                    unset($data["token"]);
                    $cek = $this->db->get_where("user_info",array("nxt_address"=>$data["nxt_address"]));
                    $cek2 = $this->db->get_where("setAcc",$data);
                    $id = $this->db->get_where("user_info",array("login_id"=>$this->session->id_login));
                    $data["id_user"] = $id->result()[0]->id_users;
                    if($cek->num_rows() < 1 && $cek2->num_rows() < 1 && $dataJson->valid && $dataJson->accountRS == $data["nxt_address"])
                    {

                        $insert1 = $this->db->insert("setAcc",$data);
                        if($insert1)
                        {
                            $data["alert_m"] = "<div class='alert alert-success'><p>Your Address Successfully Saved</p><p><a href='".base_url("page/account")."' class='btn btn-primary'>Back To Manage ARDOR Account</a></p></div>";
                        }else {
                            $data["alert_m"] = "<div class='alert alert-danger'><p>Sorry Server Error Please Try Again</p></div>";
                        }
                    }else{
                      $data["alert_m"] = "<div class='alert alert-danger'><p>Sorry Your Address Duplicate Entry or Your Token is Wrong</p></div>";
                    }
                }else{
                  $data["alert_m"] = "<div class='alert alert-danger'><p>Sorry Please Input Your ARDOR Account and Your Token </p></div>";
                }
              }
              $id = $this->db->get_where("user_info",array("login_id"=>$this->session->id_login))->result()[0]->id_users;
              $dataUser = $this->update->read_user(array("login_id"=>$this->session->id_login))->result()[0];
              $data["user_info"] = array("nama"=>$this->session->nama,"picture"=>base_url($this->session->avatar));
              $data["judul"] ="Add ARDOR Account";
              $data["data_page"] = $dataUser;
              $data["page"] = "pages/add_ardr";
              $this->load->view("adminLTE/_header",$data);
              $this->load->view("adminLTE/_home",$data);
              $this->load->view("adminLTE/_footer");
            }

        }

    }
}

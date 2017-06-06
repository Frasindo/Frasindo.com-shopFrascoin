<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }
    function login($user,$pass)
    {
        $checkUser = $this->db->get_where("login",array("email"=>$user));
        if(!empty($checkUser->result()))
        {
            $validate_pass = $this->encrypt->decode($checkUser->result()[0]->password);
            if($validate_pass == $pass)
            {
                $id_login = $checkUser->result()[0]->id_login;
               
                $userInfo = $this->db->get_where("user_info",array("login_id"=>$checkUser->result()[0]->id_login));
                $adminInfo = $this->db->get_where("admin_info",array("login_id"=>$checkUser->result()[0]->id_login));
                if($checkUser->result()[0]->access == 0)
                {
                    return array("status"=>1,"msg"=>"Login Success","data"=>(object)array("access"=>$checkUser->result()[0]->access,"btc_address"=>$userInfo->result()[0]->btc_address,"nxt_address"=>$userInfo->result()[0]->nxt_address,"id_login"=>$checkUser->result()[0]->id_login ,"email"=>$checkUser->result()[0]->email));
                }elseif($checkUser->result()[0]->access == 1)
                {
                    return array("status"=>1,"msg"=>"Login Success","data"=>(object)array("access"=>$checkUser->result()[0]->access,"name"=>$adminInfo->result()[0]->nama,"email"=>$checkUser->result()[0]->email));
                }
            }else{
                return array("status"=>0,"msg"=>"Email and Password not Found");
            }
        }else{
            return array("status"=>0,"msg"=>"Email not Registered");
            
        }
    }
    function register($email,$password)
    {
        $checkUser = $this->db->get_where("login",array("email"=>$email))->num_rows();
        if($checkUser < 1)
        {
            $insert = $this->db->insert("login",array("email"=>$email,"password"=>$this->encrypt->encode($password)));
        }else{
            $insert = false;
        }
        if($insert)
        {
             $lastID = $this->db->insert_id();
             $insertUser = $this->db->insert("user_info",array("login_id"=>$lastID,"nxt_address"=>"0"));
             if($insertUser)
             {
                 return array("status"=>1,"msg"=>"Register Successfull");
             }else{
                 $deleteLogin = $this->db->delete("login",array("id_login"=>$lastID));
                 if($deleteLogin)
                 {
                     return array("status"=>0,"msg"=>"Registration Fail");
                 }else{
                     return array("status"=>0,"msg"=>"Fatal Critical Please Contact Administrator");
                 }
             }
        }else{
             return array("status"=>0,"msg"=>"Registration Fail Check Your Email");
        }
    }
}

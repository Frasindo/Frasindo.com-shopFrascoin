<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Rest extends \Restserver\Libraries\REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

    }
    function test_get()
    {
        $gen = $this->encrypt->decode("Q2yWVnifxVcJRs3Zz/kU1lkaW3swznsyrUBhOh2MA4torFNtMNnwOyW5Dw/T/5ki2fPc8y1+Elf2ms/prpy6Sw==");
        $this->response(array("status"=>$gen));
    }
    function createNXT_get()
    {
        $autoGen = $this->encrypt->encode(rand(1000,100000));
        try {
            $ch = curl_init();

            if (FALSE === $ch)
                throw new Exception('failed to initialize');

            curl_setopt($ch, CURLOPT_URL, 'http://91.235.72.49:7876/nxt?requestType=getAccountId&secretPhrase='.$autoGen);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
            curl_setopt($ch, CURLOPT_POST, true);

            $content = curl_exec($ch);

            if (FALSE === $content)
                throw new Exception(curl_error($ch), curl_errno($ch));
             $data =  json_decode($content);
             $this->response(array("status"=>1,"data"=>array("nxt_address"=>$data->accountRS,"public_key"=>$data->publicKey,"secretKey"=>$autoGen)));
        } catch(Exception $e) {
            trigger_error(sprintf(
                'Curl failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);

        }
        
    }
    function saveNXT_post()
    {
        $this->load->model("acc");
        $addr = $this->input->post("nxt_address",true);
        if($addr != null)
        {
            $update = $this->acc->updateNXT($addr,$this->session->id_login);
            if($update)
            {
                $this->session->unset_userdata("nxt_address");
                $this->session->set_userdata("nxt_address",$addr);
                $this->response(array("status"=>1,"msg"=>"Update NXT Account Successfully"));
            }else{
                $this->response(array("status"=>0,"msg"=>"Update NXT Account Failed"));
            }
        }else{
            $this->response(array("status"=>0,"msg"=>"Address is Null Please Wait"));
        }
        
    }
    function login_post()
    {
        $this->load->model("auth");
        $email = $this->input->post("email",true);
        $pass = base64_decode($this->input->post("pass",true));
        $validate = filter_var($email, FILTER_VALIDATE_EMAIL);
        if($validate == true)
        {
            $data = $this->auth->login($email,$pass);
            if($data["status"] == 1)
            {
                $loginData = $data["data"];
                $this->session->set_userdata("id_login",$loginData->id_login);
                $this->session->set_userdata("access",$loginData->access);
                $this->session->set_userdata("nxt_address",$loginData->nxt_address);
                $this->session->set_userdata("email",$loginData->email);
            }
            $this->response($data);
        }else{
            $this->response(array("status"=>0,"msg"=>"Email Not Valid"));
        }
    }
    function register_post()
    {
        $this->load->model("auth");
        $email = $this->input->post("email",true);
        $pass = base64_decode($this->input->post("pass",true));
        $validate = filter_var($email, FILTER_VALIDATE_EMAIL);
        if($validate == true)
        {
            $data = $this->auth->register($email,$pass);
            $this->response($data);
        }else{
            $this->response(array("status"=>0,"msg"=>"Email Not Valid"));
        }
    }
}

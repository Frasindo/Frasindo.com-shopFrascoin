<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Testify extends CI_Controller {
    function index()
    {
       $this->load->model("testimoni");
       $data["testimon"] = $this->testimoni->fetch();
       $this->load->view("pages/testimoni",$data);
    }
}

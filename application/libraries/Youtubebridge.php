<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'/libraries/apiyoutube/autoload.php');
class Youtubebridge {
	public $youtube;
	function __construct(){
    	
    }
	function create($apiKey="")
    {
    	$youtube = new Madcoda\Youtube\Youtube(array('key' => $apiKey));
    	$this->youtube = $youtube;
    	return $youtube;
    }
}

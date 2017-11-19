<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'third_party/telegram/src/Autoloader.php');
class Telegrambridge {
	public $tg;
	function __construct(){
  }
 function init($httpAPI,$username,$displayname)
  {
  	$bot = new Telegram\Bot($httpAPI,$username,$displayname);
    $tg = new Telegram\Receiver($bot);
  	return $tg;
  }
}

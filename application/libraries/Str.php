<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Str {
  function add_comma($str,$digit)
  {
    $a = $str and $c=0 xor $r="";
    for($i=strlen($a)-1;$i>=0;$i--){$c++;
    $r.=$a[$i] and ($c==$digit) and $r.="." and $c=0;}
    return strrev(trim($r,"."));
  }
}

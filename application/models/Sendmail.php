<?php ('BASEPATH') OR exit('No direct script access allowed');
class Sendmail extends CI_Model {
    public function __construct()
    {
            parent::__construct();
    }
    public function activationCampaign()
    {
      $config = Array(
                 'protocol' => 'sendmail',
                 'mailpath' => '/usr/sbin/sendmail',
                 'mailtype'  => 'html',
                 'charset'   => 'iso-8859-1'
             );
      $this->load->library('email', $config);
      $this->email->set_newline("\r\n");
      $this->email->from('info@frasindo.com','FrasindoSHOP - Email Notification');
      $this->email->to($email);
      $this->email->subject('Activate Your Account');
      $template = '<table style="max-width:600px" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td><table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td align="left"><img src="https://frasindo.com/GRAFIK%20SIMPAN/Logo%20FRASINDO%20Email%20188x64.png"></img></td></tr></tbody></table></td></tr><tr height="16"></tr><tr><td><table style="min-width:332px;max-width:600px;border:1px solid #f0f0f0;border-bottom:0;border-top-left-radius:3px;border-top-right-radius:3px" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#99265A"><tbody><tr><td colspan="3" height="72px"></td></tr><tr><td width="32px"></td><td style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:24px;color:#ffffff;line-height:1.25;min-width:300px">Your Account Password Reseted </td><td width="32px"></td></tr><tr><td colspan="3" height="18px"></td></tr></tbody></table></td></tr><tr><td><table style="min-width:332px;max-width:600px;border:1px solid #f0f0f0;border-top:0" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF"><tbody><tr><td colspan="3" height="18px"></td></tr><tr><td width="32px"></td><td style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:13px;color:#202020;line-height:1.5">Your account at FrasindoSHOP with email '.$email.' request for reset password, this is your new temporary password '.$stringPass.'</td><td width="10px"></td></tr><tr><td colspan="3" height="18px"></td></tr></tbody></table></td></tr><tr><td><table style="min-width:332px;max-width:600px;border:1px solid #f0f0f0;border-bottom:1px solid #c0c0c0;border-top:0;border-bottom-left-radius:3px;border-bottom-right-radius:3px" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#FAFAFA"><tbody><tr height="16px"><td rowspan="3" width="32px"></td><td></td><td rowspan="3" width="32px"></td></tr><tr><td><table style="min-width:300px" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:13px;color:#202020;line-height:1.5;padding-bottom:4px"></td></tr><tr><td style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:13px;color:#202020;line-height:1.5;padding:4px 0">Please change your password in Account Setting</td></tr><tr><td style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:13px;color:#202020;line-height:1.5;padding-top:28px">PT Frasindo Lima Mandiri</td></tr><tr height="16px"></tr><tr><td><table style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:12px;color:#b9b9b9;line-height:1.5"><tbody><tr><td></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr height="32px"></tr></tbody></table></td></tr><tr height="16"></tr><tr><td style="max-width:600px;font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:10px;color:#bcbcbc;line-height:1.5"></td></tr><tr><td><table style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:10px;color:#666666;line-height:18px;padding-bottom:10px"><tbody><tr><td>You received email from automatic responder .</td></tr><tr height="6px"></tr><tr><td><div style="direction:ltr;text-align:left">&copy; 2017 PT Frasindo Lima Mandiri</div></td></tr></tbody></table></td></tr></tbody></table>';
      $this->email->message($template);
      $sendIt = $this->email->send();
      if($sendIt)
      {
        return array("status"=>1,"msg"=>"Your password has been reset");
      }else{
        return array("status"=>0,"msg"=>"Fail to reset your password");
      }
    }
    function forgot($email)
    {
      if($email != null)
      {
         $findEmail = $this->db->get_where("login",array("email"=>$email));
         if($findEmail->num_rows() > 0)
         {
           $this->load->helper('string');
           $stringPass = random_string("alnum",10);
           $newpass = $this->encrypt->encode($stringPass);
           $update = $this->db->where("email",$email)->update("login",array("password"=>$newpass));
           if($update)
           {
             $config = Array(
                 'protocol' => 'sendmail',
                 'mailpath' => '/usr/sbin/sendmail',
                 'mailtype'  => 'html',
                 'charset'   => 'iso-8859-1'
             );
             $this->load->library('email', $config);
             $this->email->set_newline("\r\n");
             $this->email->from('info@frasindo.com','FrasindoSHOP - Email Notification');
             $this->email->to($email);
             $this->email->subject('Recover Your Account');
             $template = '<table style="max-width:600px" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td><table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td align="left"><img src="https://frasindo.com/GRAFIK%20SIMPAN/Logo%20FRASINDO%20Email%20188x64.png"></img></td></tr></tbody></table></td></tr><tr height="16"></tr><tr><td><table style="min-width:332px;max-width:600px;border:1px solid #f0f0f0;border-bottom:0;border-top-left-radius:3px;border-top-right-radius:3px" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#99265A"><tbody><tr><td colspan="3" height="72px"></td></tr><tr><td width="32px"></td><td style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:24px;color:#ffffff;line-height:1.25;min-width:300px">Your Account Password Reseted </td><td width="32px"></td></tr><tr><td colspan="3" height="18px"></td></tr></tbody></table></td></tr><tr><td><table style="min-width:332px;max-width:600px;border:1px solid #f0f0f0;border-top:0" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF"><tbody><tr><td colspan="3" height="18px"></td></tr><tr><td width="32px"></td><td style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:13px;color:#202020;line-height:1.5">Your account at FrasindoSHOP with email '.$email.' request for reset password, this is your new temporary password '.$stringPass.'</td><td width="10px"></td></tr><tr><td colspan="3" height="18px"></td></tr></tbody></table></td></tr><tr><td><table style="min-width:332px;max-width:600px;border:1px solid #f0f0f0;border-bottom:1px solid #c0c0c0;border-top:0;border-bottom-left-radius:3px;border-bottom-right-radius:3px" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#FAFAFA"><tbody><tr height="16px"><td rowspan="3" width="32px"></td><td></td><td rowspan="3" width="32px"></td></tr><tr><td><table style="min-width:300px" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:13px;color:#202020;line-height:1.5;padding-bottom:4px"></td></tr><tr><td style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:13px;color:#202020;line-height:1.5;padding:4px 0">Please change your password in Account Setting</td></tr><tr><td style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:13px;color:#202020;line-height:1.5;padding-top:28px">PT Frasindo Lima Mandiri</td></tr><tr height="16px"></tr><tr><td><table style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:12px;color:#b9b9b9;line-height:1.5"><tbody><tr><td></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr height="32px"></tr></tbody></table></td></tr><tr height="16"></tr><tr><td style="max-width:600px;font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:10px;color:#bcbcbc;line-height:1.5"></td></tr><tr><td><table style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:10px;color:#666666;line-height:18px;padding-bottom:10px"><tbody><tr><td>You received email from automatic responder .</td></tr><tr height="6px"></tr><tr><td><div style="direction:ltr;text-align:left">&copy; 2017 PT Frasindo Lima Mandiri</div></td></tr></tbody></table></td></tr></tbody></table>';
             $this->email->message($template);
             $sendIt = $this->email->send();
             if($sendIt)
             {
               return array("status"=>1,"msg"=>"Your password has been reset");
             }else{
               return array("status"=>0,"msg"=>"Fail to reset your passwords".$this->email->print_debugger());
             }
           }else{
             return array("status"=>0,"msg"=>"Fail to reset your password");
           }
         }else{
           return array("status"=>0,"msg"=>"This email not found");
         }
      }else{
        return array("status"=>0,"msg"=>"Please Fill Email Field");
      }
    }
  }

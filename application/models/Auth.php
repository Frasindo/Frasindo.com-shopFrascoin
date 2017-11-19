<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model("campaign_model");
    }

    function login($user, $pass) {
        $checkUser = $this->db->get_where("login", array("email" => $user, "status" => 1));
        if ($checkUser->num_rows() > 0) {
            $validate_pass = $this->encrypt->decode($checkUser->result()[0]->password);
            if ($validate_pass == $pass) {
                $id_login = $checkUser->result()[0]->id_login;

                $userInfo = $this->db->get_where("user_info", array("login_id" => $checkUser->result()[0]->id_login));
                $adminInfo = $this->db->get_where("admin_info", array("login_id" => $checkUser->result()[0]->id_login));
                if ($checkUser->result()[0]->access == 0) {
                    return array("status" => 1, "msg" => "Login Success", "data" => (object) array("authy" => $userInfo->result()[0]->twofactor, "avatar" => $userInfo->result()[0]->avatar, "nama" => $userInfo->result()[0]->nama, "username" => $checkUser->result()[0]->user_identity, "access" => $checkUser->result()[0]->access, "btc_address" => $userInfo->result()[0]->btc_address, "nxt_address" => $userInfo->result()[0]->nxt_address, "id_login" => $checkUser->result()[0]->id_login, "email" => $checkUser->result()[0]->email));
                } elseif ($checkUser->result()[0]->access == 1) {
                    return array("status" => 1, "msg" => "Login Success", "data" => (object) array("access" => $checkUser->result()[0]->access, "nama" => $adminInfo->result()[0]->nama, "admin_id" => $adminInfo->result()[0]->admin_id, "id_login" => $checkUser->result()[0]->id_login, "email" => $checkUser->result()[0]->email, "username" => $checkUser->result()[0]->user_identity));
                }
            } else {
                return array("status" => 0, "msg" => "Email and Password not Found");
            }
        } else {
            return array("status" => 0, "msg" => "Email not Registered / Your Account not Activated");
        }
    }

    function autloginWP($email) {
        $this->load->helper('string');
        $media = $this->load->database('media88', TRUE);
        $autoLogin = random_string("alnum", 10);
        $id = (isset($media->get_where("users", array("user_email" => $email))->result()[0]->ID)) ? $media->get_where("users", array("user_email" => $email))->result()[0]->ID : null;
        if ($id != null) {
            if ($media->get_where("usermeta", array('user_id' => $id, 'meta_key' => 'pkg_autologin_code'))->num_rows() > 0) {
                $media->where(array("user_id" => $id, "meta_key" => "pkg_autologin_code"));
                $data = array(
                    'user_id' => $id,
                    'meta_key' => 'pkg_autologin_code',
                    'meta_value' => $autoLogin
                );
                $up = $media->update("usermeta", $data);
                if ($up) {
                    return array("status" => 1, "msg" => "Link Generated", "code" => $autoLogin);
                } else {
                    return array("status" => 0, "msg" => "Fail Update Link");
                }
            } else {
                $data = array(
                    'user_id' => $id,
                    'meta_key' => 'pkg_autologin_code',
                    'meta_value' => $autoLogin
                );
                $ins = $media->insert("usermeta", $data);
                if ($ins) {
                    return array("status" => 1, "msg" => "Link Generated", "code" => $autoLogin);
                } else {
                    return array("status" => 0, "msg" => "Fail Insert Link");
                }
            }
        } else {
            return array("status" => 0, "msg" => "Null ID");
        }
    }

    function register($email, $password, $nama, $user) {
        $checkUser = $this->db->get_where("login", array("email" => $email))->num_rows();
        if ($checkUser < 1) {
            $pas = $this->encrypt->encode($password);
            $insert = $this->db->insert("login", array("user_identity" => $user, "email" => $email, "password" => $pas));
        } else {
            $insert = false;
        }
        if ($insert) {
            $this->load->helper('string');
            $lastID = $this->db->insert_id();
            $insertUser = $this->db->insert("user_info", array("login_id" => $lastID, "nxt_address" => random_string("alnum", 10)));
            if ($insertUser) {
                $autoLogin = random_string("alnum", 10);
                $media = $this->load->database('media88', TRUE);
                @$t_hasher = new PasswordHash(12, FALSE); // Define the iterations once.
                @$hash = $t_hasher->HashPassword($password);
                $insert1 = $media->insert("users", array("user_login" => $user, "user_pass" => $hash, "user_registered" => date("Y-m-d H:i:s"), "user_email" => $email, "user_status" => 0, "display_name" => $user));
                $data = array(
                    array(
                        'user_id' => $media->insert_id(),
                        'meta_key' => 'media88_capabilities',
                        'meta_value' => 'a:1:{s:10:"subscriber";b:1;}'
                    ),
                    array(
                        'user_id' => $media->insert_id(),
                        'meta_key' => 'pkg_autologin_code',
                        'meta_value' => $autoLogin
                    ),
                    array(
                        'user_id' => $media->insert_id(),
                        'meta_key' => 'media88_user_level',
                        'meta_value' => 0
                    )
                );
                $insert2 = $media->insert_batch("usermeta", $data);
                $this->load->helper("string");
                $dataCamp = array("username" => $user, "password" => $password, "email" => $email, "twitter" => null, "youtube" => null, "ardor_addr" => null, "btc_addr" => null, "nama" => $user, "blog_unique" => strtoupper(random_string("alnum", 8)));
                $statusCamp = true;
                $insCamp = $this->campaign_model->addUsers($dataCamp);
                if ($insCamp["status"] != 1) {
                    $statusCamp = false;
                }
                if ($insert1 && $insert1 && $statusCamp) {
                    $config = Array(
                        'protocol' => 'sendmail',
                        'mailpath' => '/usr/sbin/sendmail',
                        'mailtype' => 'html',
                        'charset' => 'iso-8859-1'
                    );
                    $this->load->library('email', $config);
                    $this->email->set_newline("\r\n");
                    $this->email->from('info@frasindo.com', 'FrasindoSHOP - Email Notification');
                    $this->email->to($email);
                    $this->email->subject('Activate Your Account');
                    $template = '<table style="max-width:600px" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td><table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td align="left"><img src="https://frasindo.com/GRAFIK%20SIMPAN/Logo%20FRASINDO%20Email%20188x64.png"></img></td></tr></tbody></table></td></tr><tr height="16"></tr><tr><td><table style="min-width:332px;max-width:600px;border:1px solid #f0f0f0;border-bottom:0;border-top-left-radius:3px;border-top-right-radius:3px" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#99265A"><tbody><tr><td colspan="3" height="72px"></td></tr><tr><td width="32px"></td><td style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:24px;color:#ffffff;line-height:1.25;min-width:300px">Activate Your Account </td><td width="32px"></td></tr><tr><td colspan="3" height="18px"></td></tr></tbody></table></td></tr><tr><td><table style="min-width:332px;max-width:600px;border:1px solid #f0f0f0;border-top:0" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF"><tbody><tr><td colspan="3" height="18px"></td></tr><tr><td width="32px"></td><td style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:13px;color:#202020;line-height:1.5">Hi ' . $user . '<br>Thank you for registering at <a href="https://www.frasindo.com/">Frasindo</a> and <a href="https://www.frasindo.com/shop/campaign">Frasindo Campaign</a>,Activate your account by click this activate link <a href="' . base_url("activate/code/" . urlencode(base64_encode($pas))) . '">here</a>, or copy this link below into your address bar in your browser : <br>' . base_url("activate/code/" . urlencode(base64_encode($pas))) . '</td><td width="10px"></td></tr><tr><td colspan="3" height="18px"></td></tr></tbody></table></td></tr><tr><td><table style="min-width:332px;max-width:600px;border:1px solid #f0f0f0;border-bottom:1px solid #c0c0c0;border-top:0;border-bottom-left-radius:3px;border-bottom-right-radius:3px" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#FAFAFA"><tbody><tr height="16px"><td rowspan="3" width="32px"></td><td></td><td rowspan="3" width="32px"></td></tr><tr><td><table style="min-width:300px" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:13px;color:#202020;line-height:1.5;padding-bottom:4px"></td></tr><tr><td style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:13px;color:#202020;line-height:1.5;padding:4px 0">If you not register into our service, please ignore this email</td></tr><tr><td style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:13px;color:#202020;line-height:1.5;padding-top:28px">PT Frasindo Lima Mandiri</td></tr><tr height="16px"></tr><tr><td><table style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:12px;color:#b9b9b9;line-height:1.5"><tbody><tr><td></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr height="32px"></tr></tbody></table></td></tr><tr height="16"></tr><tr><td style="max-width:600px;font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:10px;color:#bcbcbc;line-height:1.5"></td></tr><tr><td><table style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:10px;color:#666666;line-height:18px;padding-bottom:10px"><tbody><tr><td>You received email from automatic responder .</td></tr><tr height="6px"></tr><tr><td><div style="direction:ltr;text-align:left">&copy; 2017 PT Frasindo Lima Mandiri</div></td></tr></tbody></table></td></tr></tbody></table>';
                    $this->email->message($template);
                    $sendIt = $this->email->send();
                    return array("status" => 1, "msg" => "Register Successfull", "autoLogin" => $autoLogin, "id_login" => $lastID);
                } else {
                    return array("status" => 0, "msg" => "Register Failed");
                }
            } else {
                $deleteLogin = $this->db->delete("login", array("id_login" => $lastID));
                if ($deleteLogin) {
                    return array("status" => 0, "msg" => "Registration Fail", "fairMsg" => $insertUse);
                } else {
                    return array("status" => 0, "msg" => "Fatal Critical Please Contact Administrator");
                }
            }
        } else {
            return array("status" => 0, "msg" => "Registration Fail", "fairMsg" => $checkUser);
        }
    }

}

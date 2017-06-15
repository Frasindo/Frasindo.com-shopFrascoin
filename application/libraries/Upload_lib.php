<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Upload_lib {
        function base64_encode_image ($filename=string,$filetype=string) {
            if ($filename) {
                $imgbinary = fread(fopen($filename, "r"), filesize($filename));
                return 'data:image/'.$filetype.';base64,'.base64_encode($imgbinary);
            }
        }
        function alihkan($url,$time)
        {
            $redir = "<script>setTimeout(function () {window.location.replace('" . $url . "');},".$time.")</script>";
            return $redir;
        }
        function upload_file($target_direktori,$files,$allowed_files,$prefix_name="")
        {
            $target_dir = $target_direktori;
            $files_base = basename($files["name"]);
            $target_file = $target_dir . $files_base;
            $uploadOk = 1;
            $FileType = pathinfo($target_file,PATHINFO_EXTENSION);
            if(in_array($FileType,$allowed_files))
            {
                if(move_uploaded_file($files["tmp_name"], $target_dir.$prefix_name."_".sha1($files_base).".".$FileType))
                {
                    return json_encode(array("status"=>1,"files_name"=>$target_dir.$prefix_name."_".sha1($files_base).".".$FileType));
                }else{
                    return json_encode(array("status"=>0,"error"=>"Gagal Upload Files"));
                }
            }else{
                return json_encode(array("status"=>0,"error"=>"File Tidak Di Ijinkan : .".$FileType));
            }
        }
        function alert($type,$title,$content,$addons="",$time="")
        {
            $icon = ($type == "success")?"check":"ban";
            if($addons != "" && $time != "")
            {
                return '<div class="alert alert-'.$type.' alert-dismissible">   
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-'.$icon.'"></i> '.$title.'</h4>'.$content.'</div><meta http-equiv="refresh" content="'.$time.';URL="'.$addons.'"" />';
            }else{
                return '<div class="alert alert-'.$type.' alert-dismissible">   
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-'.$icon.'"></i> '.$title.'</h4>'.$content.'</div>';
            }

        }
}
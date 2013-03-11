<?php
include_once("Decrypt.class.php");

    /*
    *加密方式的登录处理
    *阶段2：处理逻辑
    */
    function login_test() {
        
        $dec_tool = new Decrypt(Doo::conf()->private_key,Doo::conf()->public_key);

        $enc = XUtil::xget('enc1');
        if(!empty($enc)){
            $password_enc = XUtil::xget('password');
            $password_enc = base64_decode($password_enc);

            $r = $dec_tool->rsa_decrpyt($enc,$decrypted);             
            if($r){
               $random_key = $decrypted;

               $salt = $_SESSION['session_token_guid'];
               $random_key = $dec_tool->xor_enc($salt,$random_key);
               $decrypted_string = $dec_tool->aes_decrypt($password_enc,$random_key);
               $password = base64_decode($decrypted_string);
               echo "decrypted password:$password<br/>";
            }
            else{
               echo "cannot get the enc";
            }


        } 

    }

    /*
    *加密方式的登录处理
    *阶段1：获取token
    */
    function request_token(){
        //返回public_key以及sessionID下去
        $callback = XUtil::xget("callback");
        $public_key = Doo::conf()->public_key;
        $guid = (string)uniqid();
        //$guid = '1';
        $data['p'] = $public_key;
        $data['s'] = $guid;
        $_SESSION['session_token_guid'] = $guid;
        echo "$callback(".json_encode($data).")";
        
    }

?>

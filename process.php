<?php

    /*
    * 接下来三个方法是辅助方法，主要是在处理UCS-2和UTF-8的转换上
    */
    function unichr($u) {
        return chr($u);
    }

    function mb_ord($utf8Character){
        $k = mb_convert_encoding($utf8Character, 'UCS-2LE', 'UTF-8'); 
        $k1 = ord(substr($k, 0, 1)); 
        $k2 = ord(substr($k, 1, 1)); 
        return $k2 * 256 + $k1; 
    }

    function CodeAndEncode($_key,$_str)
    {
         $keyUnicodeSum=0;
         $codedStr = "";
         for( $j = 0; $j<strlen($_key); $j++ )
         {

              $keyUnicodeSum += ord($_key[$j]); 
         }
         $str_len = mb_strlen($_str,'utf-8');
          
         for( $i = 0; $i<$str_len; $i++ )
         {
              $tcChar = mb_substr($_str, $i, 1,'utf-8');
              $c = mb_ord($tcChar);

              $_strXOR =   $c ^ $keyUnicodeSum ;
              $codedStr .= unichr( $_strXOR );  
         }

         if($str_len==0){
             $codedStr = unichr($keyUnicodeSum);
         }

         return $codedStr;
    }


    /*
    *加密方式的登录处理
    *阶段2：处理逻辑
    */
    function login_test() {
        $enc = XUtil::xget('enc1');
        if(!empty($enc)){
            $password_enc = XUtil::xget('password');
            $password_enc = base64_decode($password_enc);

            $enc = base64_decode($enc);
            $enc = base64_encode(pack("H*",$enc));
            
            $private = Doo::conf()->private_key;
            $public = Doo::conf()->public_key;

            $encrypted = base64_decode($enc);
           
            $r = openssl_private_decrypt($encrypted, $decrypted, $private,OPENSSL_NO_PADDING);
            if($r){
               $decrypted = strrev($decrypted);
               
               $decrypted = rtrim($decrypted,"\0");
               $random_key = $decrypted;

               $salt = $_SESSION['session_token_guid'];
               $r = CodeAndEncode($salt,$random_key);
               //对称解密
               $keys = md5($r);
               $cipher_alg = MCRYPT_RIJNDAEL_128;
               $iv='1234567812345678';
               $decrypted_string = mcrypt_decrypt($cipher_alg, $keys, $password_enc,MCRYPT_MODE_CBC,$iv);
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

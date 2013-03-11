<?php
class Decrypt{

    private $private_key;
    private $public_key;

    public function __construct($private_key, $public_key) 
    { 
        $this->private_key = $private_key;
        $this->public_key = $public_key;
    } 

    /*
    * 接下来三个方法是辅助方法，主要是在处理UCS-2和UTF-8的转换上
    */
    private function unichr($u) {
        return chr($u);
    }

    private function mb_ord($utf8Character){
        $k = mb_convert_encoding($utf8Character, 'UCS-2LE', 'UTF-8'); 
        $k1 = ord(substr($k, 0, 1)); 
        $k2 = ord(substr($k, 1, 1)); 
        return $k2 * 256 + $k1; 
    }

    public function xor_enc($_key,$_str)
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
              $c = $this->mb_ord($tcChar);

              $_strXOR =   $c ^ $keyUnicodeSum ;
              $codedStr .= $this->unichr( $_strXOR );  
         }

         if($str_len==0){
             $codedStr = $this->unichr($keyUnicodeSum);
         }

         return $codedStr;
    }

    /*
    * 使用私钥对密文进行解密
    */
    public function rsa_decrpyt($enc,&$decrypted){
            $enc = base64_decode($enc);
            $encrypted = pack("H*",$enc);
            
            $private = $this->private_key;
            $public = $this->public_key;

            $r = openssl_private_decrypt($encrypted, $decrypted, $private,OPENSSL_NO_PADDING);
            if($r){
               $decrypted = strrev($decrypted);
               $decrypted = rtrim($decrypted,"\0");
            
               return True;
            }
            else{
               return False;
            }
    }

    public function aes_decrypt($password_enc,$key){
               //对称解密
               $keys = md5($key);
               $cipher_alg = MCRYPT_RIJNDAEL_128;
               $iv='1234567812345678';
               $decrypted_string = mcrypt_decrypt($cipher_alg, $keys, $password_enc,MCRYPT_MODE_CBC,$iv);
               return $decrypted_string;

    }

}

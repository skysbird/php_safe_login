<?php
require_once("Decrypt.class.php");
class DecryptTest extends PHPUnit_Framework_TestCase{
	public function setUp(){
	 }
	public function tearDown(){ }
    /*
    * 测试RSA解密
    */
	public function test_rsa_dec(){
        $public_key = "C29F81FF1F1875D1F50666D560C274848A4EDE8C43347966BB57ADC2513361EC0FA96A36E61FA2239ADE60ED6DC693D46DA00CEC4DCC84A13CB7BC2DD599BD71D3D7BB4706E98EDC9A1945BC634023786B162A1E1ADF02850043B76BF09AB2F13D512C5F1A9AE11A7F3FC47D2A2A180344F9E5076500E7BB63536F3A611135CD";

        $private_key = "-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQDCn4H/Hxh10fUGZtVgwnSEik7ejEM0eWa7V63CUTNh7A+pajbm
H6Ijmt5g7W3Gk9RtoAzsTcyEoTy3vC3Vmb1x09e7RwbpjtyaGUW8Y0AjeGsWKh4a
3wKFAEO3a/CasvE9USxfGprhGn8/xH0qKhgDRPnlB2UA57tjU286YRE1zQIDAQAB
AoGAboctyZh8SLUzRS5zcd8dUwRFJEheBlgHys9Rg/CfkLYCcwE6Kli+uR/DuSI9
3K+pzZQ+opjQVGZJWENLeGo2VoY63hRM42yF1Dt8IL7dmx2afE4ZlwB/cZFtE6gi
LuYLsP9Be+h6AIEjitnnI2BEeA1TwMpRSc1gqdG5g5wu2aECQQD8VZkUL2b7mesU
DY1M+vt8pOHsx2SkVq4Mxth7JOvo8pD/WSMnbINaVu6MFRW+zDhvWbz+Q88xL8e9
l43WOc6ZAkEAxXNJzVqm4CZ1CrSvTb9R9bJXJjxMfyzVRhOszAoi/Oc7XbbYwLBW
QmAZfzX9oPtGGajH5gJNp5bDSmEecM+lVQJBALLq6sjiN44s+/9TAJ7V013093DR
jO3tvCm5EKR4cIHTBLbZ+FAq5BQ5UZmoFawc1+M0aQqNACtrKqCnBl4gzPkCQFhd
mj/vPBPA4kyiRHpVD0cYQ2x3O/0GgYRVNdYzCymICseMF0FVKaWXAJIwBYxQKDU/
lgbYLQy9qjTVdhwisekCQFEEX26IX/jez6WpijIKeO/SEYEandKM+OsX+IcWWAvq
hmS9Un3h1gMEjh7TbUXRPvan8sdbyprkNwQAD9d2zSY=
-----END RSA PRIVATE KEY-----";

        $random_key = "AE184F105618D4E8EE06C4AA9DEB9351";
        $salt = "513df64dece51";
        $enc = "YTlmZDJmY2E1MDFhMWJkYWUxNWIxYTFiZWQyM2MwODJmNzkzMjJlMzcwZjlhZjI1Y2E5ZDA2ODU0OWI2ZmJkNTJmODc2NzY3ZjFiNTY5YjE4YTEwZDI2MGM5ZDgwYTRiYTU4MjQ5ZTM4MWEwOTdkYTllOTlmZGRlMzY1MzkwNmY2NWExYmVmM2EyM2YxOGY0YmEyZjExMTk0MmYxNzc0YjYwOWZhZGU0ZWExODNhNDI1YTM0Y2M5NzEyMjc1NDg3MjdlY2Y2ZDc5YTMzZWYyMzUyY2FmNWM5ZTU1OGFlN2FjN2M1MzI4NGRhM2FmODdlMmU0ZDIyYWE0MThkOTRjMQ";
        $dec_tool = new Decrypt($private_key,$public_key);
        $r = $dec_tool->rsa_decrpyt($enc,$decrypted);             
        $this->assertTrue($r);
        if($r){ 
            $random_key_decrypt = $dec_tool->xor_enc($salt,$decrypted);
            $this->assertTrue($random_key==$random_key_decrypt);
        }

 
	}

	public function test_aes_dec(){
       $pass = "asdf";
       $key = "7E0771CD40C7A59FE9173C368B7F43A1";
       $enc = "tI3QDN5VGKk3h1V0mEdDqw==";
       $enc = base64_decode($enc);
       $private_key = $public_key = "";
       $dec_tool = new Decrypt($private_key,$public_key);
       $decrypted = $dec_tool->aes_decrypt($enc,$key);
       $decrypted = base64_decode($decrypted);
       $this->assertTrue($pass==$decrypted);
    }


}
?>

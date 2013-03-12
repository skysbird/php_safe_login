A RSA crypt based login process solution.

File description:

js/* 
    Javascript library for login_test.html example use case, including RSA,AES encrypt algorithm.

Decrypt.class.php  
    Library for RSA,AES decrypt on php server-side logic.

process.php
    An example server side workflow for this solution. Recommend to view with seqence chart. (Notice this file cannot be run as php-cli or as web application, this is just for introduce the workflow of this solution.)

DecryptTest.php
    PHPUnit TestCase for Decrypt.class.php logic.



Sequence Chart

![rsa.png](https://raw.github.com/skysbird/php_safe_login/master/rsa.png)
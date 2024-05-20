<?php
require_once('database.php');   
function checkAuth() {
 $row = db_get_Pass_Login();
 if (empty($_SERVER['PHP_AUTH_USER']) ||
    empty($_SERVER['PHP_AUTH_PW']) ||
    $_SERVER['PHP_AUTH_USER'] != $row["login"] ||
    password_verify($_SERVER['PHP_AUTH_PW'], $row["password"])) {
         header('HTTP/1.1 401 Unanthorized');
         header('WWW-Authenticate: Basic realm="My site"');
         print('<h1>401 Требуется авторизация</h1>');
         exit();
     }
}
checkAuth();
?>

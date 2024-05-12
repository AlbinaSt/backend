<?php

header('Content-Type: text/html; charset=UTF-8');

$session_started = false;
if ($_COOKIE[session_name()] && session_start()) {
  $session_started = true;
  if (!empty($_SESSION['login'])) {
      if (!empty($_COOKIE['logout'])) {
            setcookie('logout', '', 100000);
            session_destroy();
        }
    header('Location: ./');
    exit();
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    setcookie('error', '', 100000);
    $messages[] = '<div class="error">Неверный логин или пароль</div>';
  }
 
$values = array();
$values['login'] = empty($_COOKIE['login_value']) ? '' : strip_tags($_COOKIE['login_value']);
$values['password'] = empty($_COOKIE['password_value']) ? '' : strip_tags($_COOKIE['password_value']);

?>

<body>
<form action="" method="post">
  <?php 
  if (!empty($messages)) {
  print('<div id="messages">');
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}
?>
  <input name="login" <?php if ($errors['error']) {print 'class="error"';} ?> value="<?php print $values['login']; ?>"/>
  <input name="password" <?php if ($errors['error']) {print 'class="error"';} ?> value="<?php print $values['password']; ?>"/>
  <input type="submit" value="Войти" />
</form>
  </body>
</html>
  
<?php
}

else {
    include('../db.php');
    $db = new PDO('mysql:host=localhost;dbname=' . $db_name, $db_login, $db_pass,
   [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); 
    $login = $_POST['login'];
    $password = $_POST['password'];

    try{
    $stmt = $db->prepare("SELECT * FROM users WHERE login = :login");
    $stmt->execute(array(':login' => $login));
    $use = $stmt->fetch();

    setcookie('login_value', $_POST['login'], time() + 30 * 24 * 60 * 60);
    setcookie('password_value', $_POST['password'], time() + 30 * 24 * 60 * 60);
  
    if ($use && password_verify($password, $use['password'])) {
      
    setcookie('login_value', '', 100000);
    setcookie('password_value', '', 100000);
    } else {
     setcookie('error', '1', time() + 24 * 60 * 60);
     header('Location: login.php');
     exit();
    }
    if (!$session_started) {
      session_start();
    }
      
   $login = $_POST['login'];
   $password = $_POST['password'];
   $_SESSION['login'] = $_POST['login'];
      
   $stmt = $db->prepare("SELECT user_id  FROM users WHERE login = :login");
    $stmt->execute([':login' => $login]);
   $data = $stmt->fetch(PDO::FETCH_ASSOC);

   $_SESSION['uid'] = $data['user_id'];

   } catch(PDOException $e){
     print('Error : ' . $e->getMessage());
     exit();
   }

  header('Location: ./');
}

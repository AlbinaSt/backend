<?php

header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  
  $messages = array();

  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    setcookie('login', '', 100000);
    setcookie('pass', '', 100000);

    echo "<script>alert('Спасибо, результаты сохранены.')</script>";

    if (!empty($_COOKIE['pass'])) {
      $messages[] = sprintf('Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>
        и паролем <strong>%s</strong> для изменения данных.',
        strip_tags($_COOKIE['login']),
        strip_tags($_COOKIE['pass']));
    }
  }

  $errors = array();
  $errors['fio'] = !empty($_COOKIE['fio_error']);
  $errors['telephone'] = !empty($_COOKIE['telephone_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['year'] = !empty($_COOKIE['year_error']);
  $errors['abilities'] = !empty($_COOKIE['abilities_error']);
  $errors['radio-1'] = !empty($_COOKIE['radio_error']);
  $errors['field-name-2'] = !empty($_COOKIE['field_error']);
  $errors['check-1'] = !empty($_COOKIE['check_error']);


  if (empty($_POST['fio']) || !preg_match('/^[a-zA-Zа-яА-Я\s]+$/', $_POST['fio'])) {
    $errors['fio'] = true;
    setcookie('fio_error', 'Заполните имя.', time() + 100000, "/");
}
  
  if (empty($_POST['telephone']) || !preg_match('/^+?[0-9\s-]*$/', $_POST['telephone'])) {
    $errors['telephone'] = true;
    setcookie('telephone_error', 'Заполните номер телефона.', time() + 100000, "/");
}

  if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = true;
    setcookie('email_error', 'Введите корректный email адрес.', time() + 100000, "/");
} 

   if ($errors['year']) {
    setcookie('year_error', '', 100000);
    $messages[] = '<div class="error">Введите дату рождения.</div>';
  }

   if ($errors['radio-1']) {
    setcookie('radio_error', '', 100000);
    $messages[] = '<div class="error">Выберите пол.</div>';
  }

   if ($errors['abilities']) {
    setcookie('abilities_error', '', 100000);
    $messages[] = '<div class="error">Выберите языки.</div>';
  }

  if ($errors['field-name-2']) {
    setcookie('field_error', '', 100000);
    $messages[] = '<div class="error">Введите биографию.</div>';
  }

   if ($errors['check-1']) {
    setcookie('check_error', '', 100000);
    $messages[] = '<div class="error">Необходимо согласие.</div>';
  }
  

  $values = array();
  $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
  $values['telephone'] = empty($_COOKIE['telephone_value']) ? '' : $_COOKIE['telephone_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['year'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
  $values['radio-1'] = empty($_COOKIE['radio_value']) ? '' : $_COOKIE['radio_value'];
  $values['abilities'] = empty($_COOKIE['abilities_value']) ? '' : $_COOKIE['abilities_value'];
  $values['field-name-2'] = empty($_COOKIE['field_value']) ? '' : $_COOKIE['field_value'];
  $values['check-1'] = empty($_COOKIE['check_value']) ? '' : $_COOKIE['check_value'];

  if (session_start() && (!empty($_SESSION['login'])) && (!empty($_COOKIE[session_name()])) && $errors) {
  // Если нет предыдущих ошибок ввода, есть кука сессии, начали сессию и
  // ранее в сессию записан факт успешного логина.
  include('../db.php');
  $db = new PDO('mysql:host=localhost;dbname=' . $db_name, $db_login, $db_pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); 

  try{
    $stmt = $db->prepare("SELECT user_id  FROM users WHERE login = :login");
    $stmt->execute(['login' => $_SESSION['login']]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $stmt = $db->prepare("SELECT l.language_name
    FROM application_languages AS a JOIN programming_languages AS l ON a.language_id = l.id WHERE a.application_id = :user_id");
    $stmt->execute(['user_id' => $data['user_id']]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $languages = [];
    foreach ($rows as $row) {
        $languages[] = htmlspecialchars($row['name']);
    }

    $abilities_serialized = serialize($languages);
    
    $stmt = $db->prepare("SELECT name, phone, email, data, pol, bio, ok  FROM application WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $data['user_id']]);
    $row = $stmt->fetch();

           $values = [
        'name' => htmlspecialchars($row['fio']),
        'phone' => htmlspecialchars($row['telephone']),
        'email' => htmlspecialchars($row['email']),
        'data' => htmlspecialchars($row['year']),
        'pol' => htmlspecialchars($row['radio-1']),
        'bio' => htmlspecialchars($row['field-name-2']),
        'ok' => htmlspecialchars($row['check-1']),
        'abilities' => $languages
    ];
  }
            
    catch(PDOException $e){
      print('Error : ' . $e->getMessage());
      exit();
    }
    setcookie('name_value',$row['name'], time() + 30 * 24 * 60 * 60);
    setcookie('phone_value',$row['phone'], time() + 30 * 24 * 60 * 60);
    setcookie('email_value',$row['email'], time() + 30 * 24 * 60 * 60);
    setcookie('data_value',$row['data'], time() + 30 * 24 * 60 * 60);
    setcookie('pol_value',$row['pol'], time() + 30 * 24 * 60 * 60);
    setcookie('bio_value',$row['bio'], time() + 30 * 24 * 60 * 60);
    setcookie('ok_value',$row['ok'], time() + 30 * 24 * 60 * 60);
    setcookie('abilities_value', $abilities_serialized, time() + 30 * 24 * 60 * 60);

	  
    printf('Вход с логином %s, uid %d', $_SESSION['login'], $_SESSION['uid']);
  
}

  include('form.php');
}

else {
  $errors = FALSE;
   if (empty($_POST['fio'])) {
  
    setcookie('fio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('fio_value', $_POST['fio'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['telephone'])) {
    
    setcookie('telephone_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    
    setcookie('telephone_value', $_POST['telephone'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['email'])) {
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['year'])) {
    setcookie('year_error', '1', time() + 24 * 60 * 60);
    setcookie('year_value', '', time() - 3600);
    $errors = TRUE;
  }
  else {
    setcookie('year_value', $_POST['year'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['radio-1'])) {
    setcookie('radio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('radio_value', $_POST['radio-1'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['abilities'])) {
    setcookie('abilities_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('abilities_value', serialize($_POST['abilities']), time() + 30 * 24 * 60 * 60);
  }

   if (empty($_POST['field-name-2'])) {
    setcookie('field_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('field_value', $_POST['field-name-2'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['check-1'])) {
    setcookie('check_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('check_value', $_POST['check-1'], time() + 30 * 24 * 60 * 60);
  }

  if ($errors) {
    header('Location: index.php');
    exit();
  }
  setcookie('fio_value', $_POST['fio'], time() + 365 * 24 * 60 * 60);
  setcookie('telephone_value', $_POST['telephone'], time() + 365 * 24 * 60 * 60);
  setcookie('email_value', $_POST['email'], time() + 365 * 24 * 60 * 60);
  setcookie('year_value', $_POST['year'], time() + 365 * 24 * 60 * 60);
  setcookie('radio_value', $_POST['radio-1'], time() + 365 * 24 * 60 * 60);
  setcookie('abilities_value', serialize($_POST['abilities']), time() + 365 * 24 * 60 * 60);
  setcookie('field_value', $_POST['field-name-2'], time() + 365 * 24 * 60 * 60);
  setcookie('check_value', $_POST['check-1'], time() + 365 * 24 * 60 * 60);

  if ($errors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    header('Location: index.php');
    exit();
  }
	  
  else {
    setcookie('fio_error', '', 100000);
    setcookie('telephone_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('year_error', '', 100000); 
    setcookie('radio_error', '', 100000); 
    setcookie('abilities_error', '', 100000);
    setcookie('field_error', '', 100000);
    setcookie('check_error', '', 100000); 
  }



	
  // Проверяем меняются ли ранее сохраненные данные или отправляются новые.
  if (!empty($_COOKIE[session_name()]) &&
      session_start() && !empty($_SESSION['login'])) {
          include('../db.php');
$db = new PDO('mysql:host=localhost;dbname=' . $db_name, $db_login, $db_pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); 
    try
    {
    $stmt = $db->prepare("SELECT user_id  FROM users WHERE login = :login");
    $stmt->execute(['login' => $_SESSION['login']]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $sql = "UPDATE application SET name = :name, phone = :phone, email = :email,  data = :data, pol = :pol, bio = :bio, ok = :ok WHERE id = :user_id";
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':name', $_POST['fio']);
    $stmt->bindParam(':phone', $_POST['telephone']);
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->bindParam(':data', $_POST['year']);
    $stmt->bindParam(':pol', $_POST['radio-1']);
    $stmt->bindParam(':bio', $_POST['field-name-2']);
    $stmt->bindParam(':ok', $_POST['check-1']);
    $stmt->bindParam(':user_id', $data['user_id']);
    $stmt->execute();
      
    $stmt_delete = $db->prepare("DELETE FROM application_languages WHERE application_id = :user_id");
    $stmt_delete->bindParam(':user_id', $data['user_id']);
    $stmt_delete->execute();
  
       foreach ($_POST['abilities'] as $ability) {
    $stmtLang = $db->prepare("SELECT id FROM programming_languages WHERE language_name = ?");
    $stmtLang->execute([$ability]);
    $languageId = $stmtLang->fetchColumn();

    $stmtApLang = $db->prepare("INSERT INTO application_language (application_id, language_id) VALUES (:User_Id, :Id_language)");
    $stmtApLang->bindParam(':Id_language', $languageId);
    $stmtApLang->bindParam(':User_Id', $data['user_id']);
    $stmtApLang->execute();
   
  }
}
	    catch(PDOException $e){
      print('Error : ' . $e->getMessage());
      exit();
    }
  }
  else {
  include('../db.php');
$db = new PDO('mysql:host=localhost;dbname=' . $db_name, $db_login, $db_pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); 
    $login = 'user' . uniqid();
try{
    // Запрос для выбора всех логинов из базы данных
$statement = $db->prepare("SELECT login FROM users");
$statement->execute();
$logins = $statement->fetchAll(PDO::FETCH_COLUMN);
 }
    catch(PDOException $e){
      print('Error : ' . $e->getMessage());
      exit();
    }
while (in_array($login, $logins)) {
    $login = 'user' . uniqid(); 
}
    $password = substr(md5(rand()), 0, 8); 
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
    setcookie('login', $login, time() + 24 * 60 * 60);
    setcookie('pass', $password, time() + 24 * 60 * 60);

    try {
      $stmt = $db->prepare("INSERT INTO application (name, phone, email, data, pol, bio, ok) VALUES (?, ?, ?, ?, ?, ?, ?)");
      $stmt->execute([$_POST['fio'], $_POST['telephone'], $_POST['email'], $_POST['year'], $_POST['radio-1'], $_POST['field-name-2'], $_POST['check-1']]);
      $User_Id = $db->lastInsertId();

      $stmt = $db->prepare("INSERT INTO users (user_id, login, password) VALUES (?, ?, ?)");
      $stmt->execute([$User_Id, $login, $hashPassword]);

      foreach ($_POST['abilities'] as $ability) {
    $stmtLang = $db->prepare("SELECT id FROM programming_languages WHERE language_name = ?");
    $stmtLang->execute([$ability]);
    $languageId = $stmtLang->fetchColumn();

    $stmtApLang = $db->prepare("INSERT INTO application_languages (application_id, language_id) VALUES (:User_Id, :Id_language)");
    $stmtApLang->bindParam(':Id_language', $languageId);
    $stmtApLang->bindParam(':User_Id', $User_Id);
    $stmtApLang->execute();
}
    }
    catch(PDOException $e){
      print('Error : ' . $e->getMessage());
      exit();
}
  }

  // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
  header('Location: ./');
}

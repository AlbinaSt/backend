<?php
/**
 * Реализовать возможность входа с паролем и логином с использованием
 * сессии для изменения отправленных данных в предыдущей задаче,
 * пароль и логин генерируются автоматически при первоначальной отправке формы.
 */

// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // Массив для временного хранения сообщений пользователю.
  $messages = array();

  // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Выдаем сообщение об успешном сохранении.
  if (!empty($_COOKIE['save'])) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save', '', 100000);
    setcookie('login', '', 100000);
    setcookie('pass', '', 100000);
    // Выводим сообщение пользователю.
    $messages[] = 'Спасибо, результаты сохранены.';
    // Если в куках есть пароль, то выводим сообщение.
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


  // Если нет предыдущих ошибок ввода, есть кука сессии, начали сессию и
  // ранее в сессию записан факт успешного логина.
  include('../db.php');
  $db = new PDO('mysql:host=localhost;dbname=' . $db_name, $db_login, $db_pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); 

  if (empty($errors) && !empty($_COOKIE[session_name()]) &&
      session_start() && !empty($_SESSION['login'])) {
        if ($stmt = $mysqli->prepare("SELECT name, telephone, email, data, pol, bio, ok FROM application WHERE uid = ?")) {
        $stmt->bind_param("i", $_SESSION['uid']);
        $stmt->execute();
        $stmt->bind_result($_POST['fio'], $_POST['telephone'], $_POST['email'], $_POST['year'], $_POST['radio-1'], $_POST['field-name-2'], $_POST['check-1']);
        
        if ($stmt->fetch()) {
            // Экранируем полученные данные
            $_POST['fio'] = htmlspecialchars($fio, ENT_QUOTES);
            $_POST['year'] = htmlspecialchars($_POST['date'], ENT_QUOTES);
            $_POST['telephone'] = htmlspecialchars($_POST['telephone'], ENT_QUOTES);
            $_POST['email'] = htmlspecialchars($email, ENT_QUOTES);
            $_POST['radio-1'] = htmlspecialchars($POST_['pol'], ENT_QUOTES);
            $_POST['field-name-2'] = htmlspecialchars($_POST['bio'], ENT_QUOTES);
            $_POST['check-1'] = htmlspecialchars($_POST['ok'], ENT_QUOTES);

           $values = array(
                'fio' => $fio,
                'date' => $date,
                'telephone' => $telephone,
                'email' => $email
            );
            

    printf('Вход с логином %s, uid %d', $_SESSION['login'], $_SESSION['uid']);
  }
		$stmt->close();
    }
}

  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
  // Проверяем ошибки.
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
    setcookie('field_value', $_POST['field'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['check-1'])) {
    setcookie('check_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('check_value', $_POST['check'], time() + 30 * 24 * 60 * 60);
  }

  if ($errors) {
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
    // TODO: тут необходимо удалить остальные Cookies.
  }

  // Проверяем меняются ли ранее сохраненные данные или отправляются новые.
  if (!empty($_COOKIE[session_name()]) &&
      session_start() && !empty($_SESSION['login'])) {
    // TODO: перезаписать данные в БД новыми данными,
    // кроме логина и пароля.
  }
  else {
    $length = 8;
    $chars = 'qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP'; 
	  $size = strlen($chars) - 1; 
	  $pass = ''; 
	  while($length--) {
	   	$pass .= $chars[random_int(0, $size)]; 
      $login .= $chars[random_int(0, $size)]; 
    }
    // Сохраняем в Cookies.
    setcookie('login', $login);
    setcookie('pass', $pass);

    try {
  $stmt = $db->prepare("INSERT INTO application SET name = ?, phone = ?, email = ?, data = ?, pol = ?, bio = ?, ok = ?");
  $stmt->execute([$_POST['fio'], $_POST['telephone'], $_POST['email'], $_POST['year'], $_POST['radio-1'], $_POST['field-name-2'], $_POST['check-1']]);
  $application_id = $db->lastInsertId();
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}

foreach ($_POST['abilities'] as $language) {

  $stmt = $db->prepare("SELECT id FROM programming_languages WHERE language_name = ?");
    $stmt->execute([$language]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $language_id = $result['id'];
      $stmt = $db->prepare("INSERT INTO application_languages (application_id, language_id) VALUES (?, ?)");
        $stmt->execute([$application_id, $language_id]);
    } else {
        echo "Язык программирования '$language' не найден в базе данных.";
    }
}
  }

  // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
  header('Location: ./');
}

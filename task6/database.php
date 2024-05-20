<?php
include('../db.php');
global $db;
$db = new PDO('mysql:host=localhost;dbname=' . $db_name, $db_login, $db_pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);



function row_date($stmt) {
  return $stmt->fetch(PDO::FETCH_ASSOC);
}


function row_all($stmt) {
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function query_date($query) {
  global $db;
  $stmt = $db->prepare($query);
  $args = func_get_args();
  array_shift($args);
  $res = $stmt->execute($args);
  if ($res) {
    return row_all($stmt);
  } else {
    return false;
  }
}

function executeQuery($query, $default = FALSE) {
    global $db;
    $result = $db->query($query);
    if ($result) {
        return row_All($result);
    } else {
        return $defaul;
    }
}

function result_date($query) {
  global $db;
  $stmt = $db->prepare($query);
  $args = func_get_args();
  array_shift($args);
  $res = $stmt->execute($args);
  if ($res) {
    if ($row = db_row($stmt)) {
      return $row;
    }
    }
  else {
    return false;
  }
}

function command($query) {
  global $db;
  $stmt = $db->prepare($query);
  $args = func_get_args();
  array_shift($args);
  $res = $stmt->execute($args);
  return $res;
}

function insert_id() {
  global $db;
  return $db->lastInsertId();
}

function get_all_user($default = FALSE) {
  $query = "SELECT a.id, a.name, a.phone, a.email, a.data, a.pol, a.bio, a.ok, u.login, GROUP_CONCAT(DISTINCT l2.name SEPARATOR ', ') as languages
                        FROM application a
                        INNER JOIN users u ON a.id = u.user_id
                        LEFT JOIN application_languages al ON a.id = al.application_id
                        LEFT JOIN programming_languages l ON al.language_id = l.id
                        GROUP BY a.id, a.name, a.phone, a.email, a.data, a.pol, a.bio, a.ok, u.login";
  $value = db_query($query);
  if (!$value) {
    return $default;
  }
  else {
    return $value;
  }
}

function get_status_language($default = FALSE) {
$query = "SELECT l.language_name, count(*) AS count_users
            FROM application a 
            INNER JOIN application_languages al ON a.id = al.application_id
            INNER JOIN programming_languages l ON al.language_id = l.id
            GROUP BY l.language_name";
  $value = db_query($query);
  if (!$value) {
    return $default;
  }
  else {
    return $value;
  }
}

function get_user_id($user_id) {
  $value = db_query("SELECT user_id FROM users WHERE user_id = ?", $user_id);
  if ($value == FALSE) {
    return FALSE;
  }
  else {
    return TRUE;
}
}

function delete_by_id($user_id) {
  $value1 = db_query("DELETE FROM users WHERE user_id = ?", $user_id);
  $value2 = db_query("DELETE FROM application_languages WHERE user_id = ?", $user_id);
  $value3 = db_query("DELETE FROM application WHERE user_id = ?", $user_id);
}

function get_Login($user_id, $default = FALSE) {
  $value = db_result("SELECT login FROM users WHERE user_id = ?", $user_id);
  if (!$value) {
    return $default;
  }
  else {
    return $value;
  }
}

function get_pass_login($default = FALSE) {
  $value = db_result("SELECT login, password FROM admin");
    if (!$value) {
          return $default;
  }
  else {
    return $value;
  }
}

function get_pass_login_user($login, $default = FALSE) {
  $value = db_result("SELECT * FROM users WHERE login = ?", $login);
    if (!$value) {
          return $default;
  }
  else {
    return $value;
  }
}

function get_languages($id) {
  $value = db_query("SELECT l.name
FROM application_languages AS al JOIN programming_languages AS l ON al.language_id = l.id WHERE a.id = ? ", $id);
  if ($value == FALSE) {
    return FALSE;
  }
  else {
    return $value;
}
}

function get_form_user($id, $default = FALSE) {
  $value = db_result("SELECT name, phone, email, data, pol, bio, ok  FROM application WHERE id = ?", $id);
    if (!$value) {
          return $default;
  }
  else {
    return $value;
  }
}

function get_language_id($language_name, $default = FALSE) {
  $value = db_result("SELECT id FROM programming_languages WHERE language_name = ?", $language_name);
    if (!$value) {
          return $default;
  }
  else {
    return $value;
  }
}

function get_logins() {
  $value = db_query("SELECT login FROM users");
  if ($value == FALSE) {
    return FALSE;
  }
  else {
    return $value;
}
}

function set_application($id, $name, $phone, $email, $data, $pol, $bio, $ok, $abilities) {
 $errors = FALSE;
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
  
if($errors == TRUE) 
{
  return "Error";
}
else{
  $v = get_user_id($id);
  if ($v == FALSE) {
    $login = 'user_' . uniqid();
  $logins = get_logins();
  while (in_array($login, $logins)) {
    $login = 'user_' . uniqid(); 
}
    $password = substr(md5(rand()), 0, 8); 
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    setcookie('login', $login, time() + 24 * 60 * 60);
    setcookie('pass', $password, time() + 24 * 60 * 60);

    $q1 = command("INSERT INTO application (name, phone, email, data, pol, bio, ok) VALUES (?, ?, ?, ?, ?, ?, ?)", $fio, $telephone, $email, $year, $radio-1, $field-name-2, $check-1);
    if($q1 <= 0) 
    {
      return FALSE;
        }
    $UserId = insert_id();

      $q2 = db_command("INSERT INTO users (user_id, login, password) VALUES (?, ?, ?)", $UserId, $login, $hashedPassword);
        if($q2 <= 0) 
    {
      return FALSE;
        }
  }
  else {
     $q1 = db_command("UPDATE application SET name = ?, phone = ?, email = ?,  data = ?, pol = ?, bio = ?, ok = ? WHERE id = ?", $name, $phone, $email, $data, $pol, $bio, $ok, $userid);
      if($q1 <= 0) 
    {
      return FALSE;
        }
      
  $q2 = db_command("DELETE FROM application_languages WHERE application_id = ?", $application_id);
        if($q2 <= 0) 
    {
      return FALSE;
        }
    $UserId = $user_id;
}
        foreach ($abilities as $ability) {
    $languageId = db_get_language_id($ability)['id'];
    $q3 = db_command("INSERT INTO application_languages (application_id, language_id) VALUES (?, ?)", $UserId, $languageId);
            if($q3 <= 0) 
    {
      return FALSE;
        }
      }
    return TRUE;
  }
}


function Query($query) {
    global $db;
    try {
        $result = $db->query($query);
        if ($result) {
            return $result;
        } else {
            logError(db_error());
        }
    } catch (PDOException $e) {
        logError($e->getMessage());
    }
}

function error_data() {
    global $db;
    return $db->errorInfo();
}

function log_error($errorInfo) {
    error_log(print_r($errorInfo, true));
}
?>

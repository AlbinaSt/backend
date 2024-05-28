<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');


// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
  if (!empty($_GET['save'])) {
    // Если есть параметр save, то выводим сообщение пользователю
    echo "<script>alert('Спасибо, результаты сохранены.')</script>";
  }
  // Включаем содержимое файла form.php.
  include('form.php');
  // Завершаем работу скрипта.
  exit();
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.

// Проверяем ошибки.

$errors = FALSE;
if (empty($_POST['fio'])) {
    print('Заполните имя.<br/>');
    $errors = TRUE;
} elseif (!preg_match('/^[\p{L}\s]+$/u', $_POST['fio'])) {
    print('Имя может содержать только буквы и пробелы.<br/>');
    $errors = TRUE;
} elseif (strlen($_POST['fio']) > 150) {
    print('Имя '.$_POST['fio'].' не должно превышать 150 символов.<br/>');
    $errors = TRUE;
}

if (empty($_POST['telephone'])) {
    print('Заполните телефон.<br/>');
    $errors = TRUE;
} elseif (!preg_match('/^\d+$/', $_POST['telephone'])) {
    print('Телефон должен состоять только из цифр.<br/>');
    $errors = TRUE;
}elseif (strlen($_POST['telephone']) > 11) {
            print('Телефон '.$_POST['telephone'].' не должно превышать 11 символов.<br/>');
            $errors = TRUE;
        }
if (empty($_POST['year'])) {
  print('Заполните дату.<br/>');
  $errors = TRUE;
} elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['year'])) {
  print('Дата должна быть в формате YYYY-MM-DD.<br/>');
  $errors = TRUE;
}
if (empty($_POST['email'])) {
    print('Заполните адрес электронной почты.<br/>');
    $errors = TRUE;
} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    print('Введите корректный адрес электронной почты.<br/>');
    $errors = TRUE;
}elseif (strlen($_POST['email']) > 150) {
            print('Адрес электронной почты '.$_POST['email'].' не должен превышать 150 символов.<br/>');
            $errors = TRUE;
        }
if (empty($_POST['check-1'])) {
    print('Заполните пол.<br/>');
    $errors = TRUE;
} elseif ($_POST['check-1'] !== 'ж' && $_POST['check-1'] !== 'м') {
    print('Выберите только мужской или женский пол.<br/>');
    $errors = TRUE;
}

if (empty($_POST['radio-1'])) {
    print('Подтвердите соглашение.<br/>');
    $errors = TRUE;
} elseif ($_POST['radio-1'] !== 'on') {
    print('Подтвердите соглашение.<br/>');
    $errors = TRUE;
}
$allowed_languages = array("Pascal", "C", "C++", "JavaScript", "PHP", "Python", "Java", "Haskel");

if (empty($_POST['abilities'])) {
    print('Выберите хотя бы 1 язык программирования.<br/>');
    $errors = TRUE;
} else {
    foreach ($_POST['abilities'] as $language) {
        if (!in_array($language, $allowed_languages)) {
            print('Выберите только представленные языки.<br/>');
            $errors = TRUE;
            break;
        }
    }
}
if (empty($_POST['field-name-2'])) {
  print('Запоните биографию.<br/>');
  $errors = TRUE;
}elseif (strlen($_POST['field-name-2']) > 300) {
            print('Биография '.$_POST['field-name-2'].' не должна превышать 300 символов.<br/>');
            $errors = TRUE;
        }
if (empty($_POST['abilities'])) {
    print('Выберите хотя бы 1 язык программирования.<br/>');
    $errors = TRUE;
}



// *************
// Тут необходимо проверить правильность заполнения всех остальных полей.
// *************

if ($errors) {
  // При наличии ошибок завершаем работу скрипта.
  exit();
}

// Сохранение в базу данных.
include('../db.php');
$db = new PDO('mysql:host=localhost;dbname=' . $db_name, $db_login, $db_pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); // Заменить test на имя БД, совпадает с логином uXXXXX

// Подготовленный запрос. Не именованные метки.
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



//  stmt - это "дескриптор состояния".
 
//  Именованные метки.
//$stmt = $db->prepare("INSERT INTO test (label,color) VALUES (:label,:color)");
//$stmt -> execute(['label'=>'perfect', 'color'=>'green']);
 
//Еще вариант
/*$stmt = $db->prepare("INSERT INTO users (firstname, lastname, email) VALUES (:firstname, :lastname, :email)");
$stmt->bindParam(':firstname', $firstname);
$stmt->bindParam(':lastname', $lastname);
$stmt->bindParam(':email', $email);
$firstname = "John";
$lastname = "Smith";
$email = "john@test.com";
$stmt->execute();
*/

// Делаем перенаправление.
// Если запись не сохраняется, но ошибок не видно, то можно закомментировать эту строку чтобы увидеть ошибку.
// Если ошибок при этом не видно, то необходимо настроить параметр display_errors для PHP.
 header('Location: ?save=1');

<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');


// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
  if (!empty($_GET['save'])) {
    // Если есть параметр save, то выводим сообщение пользователю.
    <script>
    alert('Спасибо, результаты сохранены.');
    </ script>
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
}

if (empty($_POST['year'])) {
  print('Заполните год.<br/>');
  $errors = TRUE;
}

if (empty($_POST['telephone'])) {
  print('Заполните телефон.<br/>');
  $errors = TRUE;
}

if (empty($_POST['email'])) {
  print('Заполните почту.<br/>');
  $errors = TRUE;
}

if (empty($_POST['radio-1'])) {
  print('Выберете вариант.<br/>');
  $errors = TRUE;
}

if (empty($_POST['field-name-2'])) {
  print('Введите текст.<br/>');
  $errors = TRUE;
}

if (empty($_POST['check-1'])) {
  print('Необходимо согласие.<br/>');
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

$user = 'u67437'; // Заменить на ваш логин uXXXXX
$pass = '3609200'; // Заменить на пароль, такой же, как от SSH
$db = new PDO('mysql:host=localhost;dbname=u67437', $user, $pass,
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

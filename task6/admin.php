<?php

/**
 * Задача 6. Реализовать вход администратора с использованием
 * HTTP-авторизации для просмотра и удаления результатов.
 **/

// Пример HTTP-аутентификации.
// PHP хранит логин и пароль в суперглобальном массиве $_SERVER.
// Подробнее см. стр. 26 и 99 в учебном пособии Веб-программирование и веб-сервисы.
if (empty($_SERVER['PHP_AUTH_USER']) ||
    empty($_SERVER['PHP_AUTH_PW']) ||
    $_SERVER['PHP_AUTH_USER'] != 'admin' ||
    md5($_SERVER['PHP_AUTH_PW']) != md5('123')) {
  header('HTTP/1.1 401 Unanthorized');
  header('WWW-Authenticate: Basic realm="My site"');
  print('<h1>401 Требуется авторизация</h1>');
  exit();
}

print('Вы успешно авторизовались и видите защищенные паролем данные.');

// *********
// Здесь нужно прочитать отправленные ранее пользователями данные и вывести в таблицу.
// Реализовать просмотр и удаление всех данных.
// *********



<?php
require_once('database.php');   
require_once('authorization.php'); 
echo 'Вы успешно авторизовались и видите защищенные паролем данные.'."<br>"; 
?>
    <form action="" method="POST">
            <input name="delete"/>
          <input type="submit" name = "button" value="Delete" />
            <input name="update"/>
          <input type="submit" name = "button" value="Update" />
    </form>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if($_POST['button'] == "Delete")
    {
        if(!empty($_POST['delete']))
    {
    $user_id = $_POST['delete'];
    $result = db_get_UserId($user_id);

if ($result) {
    $result = db_delete_by_id($userid);
    echo "Данные успешно удалены. <br>";
    header('Location: admin.php');
    exit();
}
else {
    echo "userid не найден в базе данных. <br>";
}
    }
    else{
            echo "заполните userid <br>";
        }
    }
        if($_POST['button'] == "Update")
    {
        if(!empty($_POST['update']))
        {
        session_start();
      $userid = $_POST['update'];
    $result = db_get_UserId($userid);
    if ($result) {
    $data = db_get_Login($userid);
    $_SESSION['login'] = $data['login'];

    $_SESSION['uid'] = $userid;
    header('Location: index.php');
        exit();
    }
    else {
    echo "userid не найден в базе данных. <br>";
}
    }
        else{
            echo "заполните userid <br>";
        }
    }
}
$results = db_get_Alluser();

    // Вывод данных
    foreach ($results as $row) {
        echo "Пользователь с login " . $row['login'] ." и id ". $row['userid'] . "<br>";
        echo "Name: " . $row['name'] . "<br>";
        echo "Phone: " . $row['phone'] . "<br>";
        echo "Email: " . $row['email'] . "<br>";
        echo "Data: " . $row['data'] . "<br>";
        echo "Gender: " . $row['pol'] . "<br>";
        echo "Bio: " . $row['bio'] . "<br>";
        echo "Ok: " . $row['ok'] . "<br>";
        echo "Languages: " . $row['languages'] . "<br><br>";
    }
    echo "Статистика языков " . "<br>";
    $query = "SELECT l2.name, count(*) AS count_users
            FROM application3 a 
            INNER JOIN ap_lan3 al3 ON a.userid = al3.userid
            INNER JOIN language2 l2 ON al3.id_language = l2.id
            GROUP BY l2.name";

 $languages = db_get_StatusLanguage();
    // Вывод результатов
    foreach ($languages as $row) {
        echo "{$row['name']} язык любят: {$row['count_users']} пользователя <br>";
    }
?>

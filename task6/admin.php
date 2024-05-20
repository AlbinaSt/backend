<?php

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

<?php
require_once('database.php');   
    
<?php
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
    $result = get_user_id($id);

if ($result) {
    $result = delete_by_id($id);
    echo "Данные успешно удалены. <br>";
    header('Location: admin.php');
    exit();
}
else {
    echo "Id не найден в базе данных. <br>";
}
    }
    else{
            echo "Заполните id <br>";
        }
    }
        if($_POST['button'] == "Update")
    {
        if(!empty($_POST['update']))
        {
        session_start();
      $userid = $_POST['update'];
    $result = get_user_id($id);
    if ($result) {
    $data = get_login($user_id);
    $_SESSION['login'] = $data['login'];

    $_SESSION['uid'] = $userid;
    header('Location: index.php');
        exit();
    }
    else {
    echo "Id не найден в базе данных. <br>";
}
    }
        else{
            echo "Заполните id <br>";
        }
    }
}
$results = get_all_user();

    foreach ($results as $row) {
        echo "Пользователь с login " . $row['login'] ." и id ". $row['user_id'] . "<br>";
        echo "Name: " . $row['name'] . "<br>";
        echo "Telephone: " . $row['phone'] . "<br>";
        echo "Email: " . $row['email'] . "<br>";
        echo "Data: " . $row['data'] . "<br>";
        echo "Gender: " . $row['pol'] . "<br>";
        echo "Bio: " . $row['bio'] . "<br>";
        echo "Ok: " . $row['ok'] . "<br>";
        echo "Languages: " . $row['languages'] . "<br><br>";
    }
    echo "Статистика языков " . "<br>";
    $query = "SELECT l.language_name, count(*) AS count_users
            FROM application a 
            INNER JOIN application_languages al ON a.id = al.application_id
            INNER JOIN programming_languages l ON al.language_id = l.id
            GROUP BY l.language_name";

 $languages = get_status_language();
    foreach ($languages as $row) {
        echo "{$row['name']} язык любят: {$row['count_users']} пользователя <br>";
    }
?>

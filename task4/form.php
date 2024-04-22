<html>
  <head>
    <title>Task 4</title>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" type="text/css"/>
    <style>
 body{
    background:#556B2F;
    margin:0
  }

.form{
  width:400px;height:auto;background:#e6e6e6;border-radius:8px;box-shadow:0 0 40px -10px #000; margin: calc(50vh - 220px) auto; padding:20px 30px;max-width:calc(100vw - 40px);box-sizing:border-box;font-family:'Montserrat',sans-serif;position:relative}

h2{
  margin:10px 0;padding-bottom:10px;width:180px;color:#78788c;border-bottom:3px solid #78788c}


p:before
  {content:attr(type);display:block;margin:28px 0 0;font-size:14px;color:#5a5a5a}

button
  {float:right;padding:8px 12px;margin:8px 0 0;font-family:'Montserrat',sans-serif;border:2px solid #78788c;background:0;color:#5a5a6e;cursor:pointer;transition:all .3s}

button:hover
  {background:#78788c;color:#fff}

.radio-1 { 
  display: inline;
}

  @media (max-width: 600px) {
  .form {
    width: 90%;
    margin: 20px auto;
    padding: 15px;
  }

  h2 {
    width: 100%;
  }

  input1 {
    width: 100%;
  }
}
.error {
  border: 2px solid red;
}
    </style>
  </head>
  <body>

<?php
if (!empty($messages)) {
  print('<div id="messages">');
  // Выводим все сообщения.
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}

// Далее выводим форму отмечая элементы с ошибками классом error
// и задавая начальные значения элементов ранее сохраненными.
?>

    <form class="form" action="" method="POST">
      <h2>Заявка</h2>
      <br />
      Введите имя: <br /><input type="text" name="name" value="<?php echo isset($_COOKIE['name']) ? $_COOKIE['name'] : ''; ?>" pattern="[a-zA-Zа-яА-Я\s]+" title="Имя должно содержать только буквы и пробелы" required>
      <br />
      Введите телефон: <br /> <input type="tel" name="telephone" value="<?php echo isset($_COOKIE['phone']) ? $_COOKIE['phone'] : ''; ?>" pattern="^\+?[0-9\s-]*" title="Введите корректный номер телефона" required>
      <br />
      Введите почту: <br /> <input type="email" name="email" value="<?php echo isset($_COOKIE['email']) ? $_COOKIE['email'] : ''; ?>" title="Введите корректный email адрес" required>
      <br />
      Введите дату рождения: <br /><input name="year" type="date" <?php if ($errors['year']) {print 'class="error"';} ?> value="<?php print $values['year']; ?>" />
      <br />
      <label>
        Ваш пол:</label>
        <br />
          <class="radio-1"> <input
            type="radio"
            checked="checked"
            name="radio-1"
            value="м"
          />Мужчина</class>
        <br />
        <class="radio-1"><input type="radio" name="radio-1" value="ж" />Женщина</class>
        <br />
        <br />

  <script>
    $(document).ready(function() {
       $('#example-getting-started').multiselect();
    });
  </script>
  <label>
  Любимый язык программирования:
      <br />
    <select id="example-getting-started" class = "f" name="abilities[]" multiple="multiple">
            <option disabled>Выберите любимый язык пр.</option>
            <option value="Pascal">Pascal</option>
            <option value="C">C</option>
            <option value="C++">C++</option>
            <option value="JavaScript">JavaScript</option>
            <option value="PHP">PHP</option>
            <option value="Python">Python</option>
            <option value="Java">Java</option>
            <option value="Haskel">Haskel</option>
        </select>
  </label>
  <br />
        <label>
          Биография:<br />
          <textarea
            name="field-name-2"
            placeholder="Введите текст"
          ></textarea></label
        ><br />
        <br />
   <input type="checkbox" checked="checked" name="check-1" /> С
          контрактом ознакомлен
        <br />
      <br />
      <input type="submit" value="ok" />
    </form>
  </body>
</html>

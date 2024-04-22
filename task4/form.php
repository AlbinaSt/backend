<html>
  <head>
    <title>Task 4</title>
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
      <input name="fio" <?php if ($errors['fio']) {print 'class="error"';} ?> value="<?php print $values['fio']; ?>" />
      <input name="telephone" type="tel" <?php if ($errors['telephone']) {print 'class="error"';} ?> value="<?php print $values['telephone']; ?>" />
      <input name="email" type="email" <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>" />
      <input name="year" type="date" <?php if ($errors['year']) {print 'class="error"';} ?> value="<?php print $values['year']; ?>" />
      <input name="email" type="email" <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>" />
      <input type="submit" value="ok" />
    </form>
  </body>
</html>

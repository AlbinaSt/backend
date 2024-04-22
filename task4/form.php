<html>
  <head>
    <title>Task 4</title>
    <style>
input {
  
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

    <form action="" method="POST">
      <input name="fio" <?php if ($errors['fio']) {print 'class="error"';} ?> value="<?php print $values['fio']; ?>" />
      <input name="telephone" type="tel" <?php if ($errors['telephone']) {print 'class="error"';} ?> value="<?php print $values['telephone']; ?>" />
      <input name="email" type="email" <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>" />
      <input name="year" type="date" <?php if ($errors['year']) {print 'class="error"';} ?> value="<?php print $values['year']; ?>" />
      <input name="email" type="email" <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>" />
      <input type="submit" value="ok" />
    </form>
  </body>
</html>

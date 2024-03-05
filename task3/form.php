<form action="" method="POST">
  <label>
    Имя:<br />
    <input 
      name="fio"
      placeholder="Введите имя"
      /> <br />
  </label>
  <label>
          Телефон:<br />
          <input
            name="telephone"
            type="tel"
            placeholder="Введите номер телефона"
          /> </label
        ><br />
        <label>
          Email:<br />
          <input
            name="email"
            type="email"
            placeholder="Введите вашу почту"
          /> </label
        ><br />
        <br />
        <label>
          Дата рождения:<br />
          <input name="year" value="2000-01-01" type="date" /> </label
        ><br />
        <br />
        Ваш пол:<br />
        <label
          ><input
            type="radio"
            checked="checked"
            name="radio-1"
            value="м"
          />
          Мужчина</label
        >
        <br />
        <label
          ><input type="radio" name="radio-1" value="ж" /> Женщина</label
        ><br />
        <br />
  
        <label>
          Биография:<br />
          <textarea
            name="field-name-2"
            placeholder="Введите текст"
          ></textarea></label
        ><br />
        <br />
   <label
          ><input type="checkbox" checked="checked" name="check-1" /> С
          контрактом ознакомлен</label
        ><br />
        <br />
  
  <input type="submit" value="ok" />
</form>


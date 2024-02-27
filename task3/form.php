<form action="" method="POST">
  <input name="fio" />
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
          Выберете любимый язык программирования:<br />
          <select name="field-name-3" multiple="multiple">
            <option value="value1" selected="selected">Pascal</option>
            <option value="value2">C</option>
            <option value="value3">C++</option>
            <option value="value4">JavaScript</option>
            <option value="value5">PHP</option>
            <option value="value6">Python</option>
            <option value="value4">Java</option>
            <option value="value5">Haskel</option>
            <option value="value6">Clojure</option>
            <option value="value4">Prolog</option>
            <option value="value5">Scala</option>
          </select> </label
        ><br />
        <br />
   <label
          ><input type="checkbox" checked="checked" name="check-1" /> С
          контрактом ознакомлен</label
        ><br />
        <br />
  </select>
  
  <input type="submit" value="ok" />
</form>


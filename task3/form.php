<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css"/>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" type="text/css"/>

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

  <script>
    $(document).ready(function() {
       $('#example-getting-started').multiselect();
    });
  </script>
  
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


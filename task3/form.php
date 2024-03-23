<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css"/>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" type="text/css"/>
<style>
  body{background:#59ABE3;margin:0}

.form{width:400px;height:auto;background:#e6e6e6;border-radius:8px;box-shadow:0 0 40px -10px #000;margin:calc(50vh - 220px) auto;padding:20px 30px;max-width:calc(100vw - 40px);box-sizing:border-box;font-family:'Montserrat',sans-serif;position:relative}

h2{margin:10px 0;padding-bottom:10px;width:180px;color:#78788c;border-bottom:3px solid #78788c}

input1{width:100%;padding:10px;box-sizing:border-box;background:none;outline:none;resize:none;border:0;font-family:'Montserrat',sans-serif;transition:all .3s;border-bottom:2px solid #bebed2}

input1:focus{border-bottom:2px solid #78788c}

p:before{content:attr(type);display:block;margin:28px 0 0;font-size:14px;color:#5a5a5a}

button{float:right;padding:8px 12px;margin:8px 0 0;font-family:'Montserrat',sans-serif;border:2px solid #78788c;background:0;color:#5a5a6e;cursor:pointer;transition:all .3s}

button:hover{background:#78788c;color:#fff}

.radio-1 { 
  display: inline;
}
</style>
<body>
<form class="form" action="" method="POST">
  <h2>ЗАЯВКА</h2>
  
  <label>
    Имя:<br />
    <input 
      class="input1"
      name="fio"
      placeholder="Введите имя"
      /> <br />
  </label>
  <label>
          Телефон:<br />
          <input
            class="input1"
            name="telephone"
            type="tel"
            placeholder="Введите номер телефона"
          /> </label
        ><br />
        <label>
          Email:<br />
          <input
            class="input1"
            name="email"
            type="email"
            placeholder="Введите вашу почту"
          /> </label
        ><br />
        <br />
        <label>
          Дата рождения:<br />
          <input class="input1" name="year" value="2000-01-01" type="date" /> </label
        ><br />
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
  
  <input class="button" type="submit" value="Отправить" />
</form>

</body>

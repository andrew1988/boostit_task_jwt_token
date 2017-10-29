<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">.
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script>
        $(document).ready(function(){

          var token;
          var user_id = 0;
          $("#register").submit(function(e){
            e.preventDefault();
            name = $("#name").val();
            email =  $("#email").val();
            password =  $("#password").val();
            $.ajax({
              url: "{{route('register')}}",
              dataType: "json",
              type: "POST",
              data: {"name":name,"email":email,"password":password},
              success: function (data) {
                alert("Utilizatorul a fost creat");
              }
            });
          });


          $("#login").submit(function(e){
            e.preventDefault();
            email =  $("#log-email").val();
            password =  $("#log-password").val();
            $.ajax({
	             url: "{{route('login')}}",
	             dataType: "json",
	             type: "POST",
	             data: {"email":email,"password":password},
	               success: function (data) {
                   token = data.result;
                  //get user data
                  $.ajax({
      	              url: "{{route('get-info')}}",
      	              dataType: "json",
      	              type: "POST",
      	               data: {"token":token},
      	                  success: function (data) {
      		                console.log(data)
                          user_id = data.result.id;
      	               }
                     });
	                 }
                  });
                });
              $("#getData").submit(function(e){
                    e.preventDefault();
                    $.ajax({
	                     url: "{{route('get-city')}}",
	                     dataType: "json",
	                     type: "POST",
	                     data: {"token":token,"user_id":user_id},
	                     success: function (data) {
		                          console.log(data)
	                      }
                      });
                    });

              $("#addCity").submit(function(e){
                  e.preventDefault();
                  city = $("#city").val();
                  unitate_masura = $("#unitate_masura").val();
                  $.ajax({
	                    url: "{{route('add-city')}}",
	                    dataType: "json",
	                    type: "POST",
	                    data: {"token":token,"city":city,"unitate_masura":unitate_masura,"user_id":user_id},
	                    success: function (data) {
		                      console.log(data)
	                    }
                  });
              });
          });
</script>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
              inregistrare user:
              <form action="" id="register" method="post">
                <input type="text" name="name" id="name" placeholder="nume">
                <input type="text" name="email" id="email" placeholder="email">
                <input type="password" name="password"  id="password" placeholder="nume">
                <input type="submit" value="register">
              </form>
              Logare user cu jwt token:
                <form action="" id="login" method="post">
                  <input type="text" name="log-email" id="log-email" placeholder="email">
                  <input type="password" name="log-password"  id="log-password" placeholder="nume">
                  <input type="submit" value="Login">
                </form>
                Adauga Oras: atentie orasele in limba engleza si trebuie sa fie reale
                <form action="" id="addCity" method="post">
                  <input type="text" name="city" id="city" placeholder="Nume oras">
                  <select name="unitate_masura" id="unitate_masura">
                    <option value='c'>Celsius</option>
                    <option value="f">Fahrenheit</option>
                  </select>
                  <input type="submit" value="Adauga Oras">
                </form>
                Acceseaza informatii meteo in json si le afiseaza cu console log.
                <form action="" id="getData" method="post">
                  <input type="submit" value="Afiseaza Informatii">
                </form>

            </div>
        </div>
    </body>
</html>

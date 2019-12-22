<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>

    <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>

      <script>
        $(document).ready(function(){
          let compteur = 0;
          let compteurMeteoCall = 0;


          $("#btn").on("click", function(){

            compteur ++
            $("#test").load("nouveau.txt");

            if(compteur % 2 === 0){
              $(".divAdded").each(function(){
                $(".divAdded").load("nouveau.txt");
                $(".divAdded").css("background-color", "grey");
              });
            } else{
              $("#test").after("<div class='divAdded' style='background-color: blue;'>ce contenu n'est pas loadé avec ajax</div>");
            }
          });

          // section dédié au call vers une api en ajax

          $("#submitCity").on("click", function(){
            var ville = $("#inputVille").val();
            // var ville = 6077265;
            var cleApi = "&APPID=be40ddd99fa6c67ae22093bb962c8c6a";
            console.log(ville);

            ville != "" ? setInterval(checkMeteo, 2000) : $("#erreur").html("erreur, veuillez enter le nom d'une ville");




            function checkMeteo(){

              $.ajax({
                url: 'https://api.openweathermap.org/data/2.5/weather?q=' + ville + "&units=metric" + cleApi,
                type: "GET",
                dataType: "jsonp",
                //ici on met jsonp car en json car sa nous sort une erreur, le p permet de bypasser les trouble de cross domain
                success: function(data){
                  //le résultat de mon call est stocké dans le paramètre data, ansi je peut m'en servir dans ma fonction
                  console.log(data);
                  var widget = show(data);

                  $("#show").html(widget);
                  $("#inputVille").val("");
                }
              });
            }
          });

          function show(data){
            var apiIcone =  data.weather[0].icon;
            var urlArray = ['http://openweathermap.org/img/w/', apiIcone, '.png'];
            var joindedArray = urlArray.join("");
            compteurMeteoCall ++



            return "<h2 >le call api est lancé au 1.5 secondes, il à été lancé : "+ compteurMeteoCall + "fois" +  "</h2>" +
            "<h2 id='cityName'>city name : "+ data.name +"</h2>" +
            "<img id='icone' src='"+joindedArray+"' />" +
            "<h2>weather: "+ data.weather[0].main +"</h2>" +
            "<h2>description : "+ data.weather[0].description +"</h2>"+
            "<h2>temperature : "+ data.main.temp +"</h2>"+
            "<h2>pressure : "+ data.main.pressure +"</h2>"+
            "<h2>humidity : "+ data.main.humidity +"</h2>"+
            "<h2>wind speed : "+ data.wind.speed +"</h2>"+
            "<h2>minimum temperature : "+ data.main.temp_min +"</h2>"+
            "<h2>maximum temperature : "+ data.main.temp_max +"</h2>" ;

            // $("#cityName").after('<img id="icone" alt="image non trouvé"/>');
            // $("#icone").attr("src", iconeImage);
          }
        });
      </script>

  </head>
  <body>
<button id="btn">clickez pour utiliser load()</button>
    <div>
      <p id="test">
        c'est le contenu d'origine
      </p>
    </div>

    <div id="meteoContainer">
      <h1>application meteo en temps réelle</h1>
      <p id="erreur">

      </p>
      <input type="text" id="inputVille" name="inputVille" placeholder="entrez le nom de la ville"/>
      <button id="submitCity" name="submitCity" type="submit">rechercher la ville</button>

      <div id="show">

      </div>

    </div>



  </body>
</html>

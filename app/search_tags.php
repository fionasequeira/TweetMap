<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <title>TweetMap: Filter By location</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="home.css">
</head>

<body>
  <?php include('navbar.php'); 
  $input = $_POST['hashtag'];
  ?>
  <div align="center"class="container">
    <p align="center">T    W    E    E    T             BY        TAGS</p>
    <div align="center"id="googleMap" style="width:90%;height:600px;"></div>
    <script type="text/javascript" >
    function myMap() {
      var gmarkers = [];
      var map = new google.maps.Map(document.getElementById('googleMap'), {
        center: new google.maps.LatLng(49.04350, 4.9579),
        zoom: 2
        });
      var iconBase = 'https://maps.google.com/mapfiles/kml/shapes/';
<?php
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, 'https://search-twittermap-nw73jhaynemichjbsdkqe4l5n4.us-east-1.es.amazonaws.com/tweet/_search?size=10000');
        $json = curl_exec($ch);
        curl_close($ch);
        // echo($json);
        // $new = $json["hits"]["hits"];
        $obj = json_decode($json,true);
        // $get = file_get_contents('search.json');
        // $obj = json_decode($get, true);
        $length = count($obj["hits"]["hits"]);
        echo ' var locations = [ ';
        for ($i=0; $i < $length; $i++) {
          $jsonn = $obj["hits"]["hits"][$i]["_source"];
          if(stripos(str_replace("\n", "<br/>", $jsonn["text"]), $input) !== false) {
          $longitude = $jsonn["coordinates"]["coordinates"][0];
          $latitude = $jsonn["coordinates"]["coordinates"][1];
          $name = $jsonn["handle"];
          $tweet = str_replace("\n", "<br/>", $jsonn["text"]);
          $tweet = str_replace('"', '\"', $tweet);
          $country = $jsonn["place"]["country"];
          $date = $jsonn["time"];
          echo '['.$latitude.','.$longitude.',"'.$name.'","'.$tweet.'","'.$country.'",'.$date.'],';
          // echo $latitude;
          // echo $Longitude;
        } }
        echo '];';
      ?>

      // var infomarker, i
      for (var i =0; i < locations.length; i++) {
        var lat = locations[i][0];
        var longitude = locations[i][1];
        var name = locations[i][2];
        var tweet = locations[i][3];
        var country = locations[i][4];
        var date = locations[i][5];

        latlngset = new google.maps.LatLng(lat, longitude);

        var infomarker = new google.maps.Marker({  
          map: map, 
          title: "loan", 
          icon: iconBase + "info-i_maps.png",
          position: latlngset  
          });
        map.setCenter(infomarker.getPosition())
        var content = "<u>Name:</u>" + name + "<br/><u>Tweet :</u>" + tweet + "<br/><u>Country :</u>" + country + "<br/><u>Date:</u>" + date   
        var infowindow = new google.maps.InfoWindow()

        google.maps.event.addListener(infomarker,'click', (function(infomarker,content,infowindow){ 
          return function() {
            infowindow.setContent(content);
            infowindow.open(map,infomarker);
          };
        }) (infomarker,content,infowindow)); 
        gmarkers.push(infomarker);
      }
}
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD-nsMPz4dIJ4lHSr8GB3pwK2KlUt51VVE&callback=myMap&libraries=geometry"></script>
    <div id="latlong">
      <p align="center">Latitude: <input size="20" type="text" id="latbox" name="lat"> Longitude: <input size="20" type="text" id="lngbox" name="lng" ></p>
  </div>
</div>
</body>
</html>
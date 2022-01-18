<?php

require_once("security.php");

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Page apprenants</title>

	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/etudCss.css">

	<!-- FICHIER CSS LEAFLET -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>

   <!-- FICHIER JAVASCRIPT LEAFLET -->
   <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
</head>
<body>

<?php require_once("../includes/enteteuser.php") ?>


<?php
  
// $id=$_GET['id'];
$id = $_SESSION['PROFILE']['id_apprenant'];

$now = gmdate("Y-m-d");
$heure_arrive = gmdate("H:i:s");


require_once("connexionBd.php");

$req = 'SELECT * FROM apprenant WHERE id_apprenant=?';
$ps = $pdo->prepare($req);
$params=array($id);
$ps->execute($params);

if ($user=$ps->fetch()) {
  $nom_apprenant = $user['nom_apprenant'];
  $prenom_apprenant = $user['prenom_apprenant'];

  $id_formation = $user['id_formation'];
}


?>


<div class="container espace col-md-8 col-md-offset-3 col-xs-12">
	<div class="panel panel-default">
		
	<div class="panel-default coul"> <h3>BIENVENUE A VOTRE PAGE <?php echo $nom_apprenant.' '.$prenom_apprenant ?> </h3> </div>
  <div class="panel-body">

<?php


$req2 = 'SELECT * FROM presence_apprenant WHERE id_apprenant=? AND date_jour=?';
$ps2 = $pdo->prepare($req2);
$params2=array($id, $now);
$ps2->execute($params2);

if($user2=$ps2->fetch()) {

  if(!empty($user2['heure_arrivee'])){

	?>

  
    <div class="alert alert-info container espace col-md-8 col-md-offset-3 col-xs-12">
    <strong>Information!</strong> Votre heure d'arrivée a été déjà marquée pour ce jour du <?php echo $now; ?>.
    </div>

	<div class="form-group">

					<label class="control-label" for="date_jour"> Date : </label>
					<input type="text" name="date_jour" value="<?php echo $user2['date_jour']; ?>" id="date_jour" disabled="disabled" class="form-control">
					
	</div>
	<div class="form-group">

					<label class="control-label" for="heure_arrivee"> Heure d'arrivée : </label>
					<input type="text" name="heure_arrivee" value="<?php echo $user2['heure_arrivee']; ?>" id="heure_arrivee" disabled="disabled" class="form-control">
					
	</div>

	<?php
  }
	
  }
  else{
    
	?>

	<div class="container espace col-md-8 col-md-offset-3 col-xs-12">

					<label class="control-label" for="date_jour"> Date : </label>
					<input type="text" name="date_jour" value="<?php echo $now; ?>" id="date_jour" disabled="disabled" class="form-control">
					
	</div>
	<div class="container espace col-md-8 col-md-offset-3 col-xs-12">

					<label class="control-label" for="heure_arrivee"> Heure d'arrivée : </label>
					<input type="text" name="heure_arrivee" value="<?php echo $heure_arrive; ?>" id="heure_arrivee" disabled="disabled" class="form-control">
					
	</div>

	<?php

	$ps3 = $pdo->prepare("INSERT INTO presence_apprenant(date_jour, heure_arrivee, id_formation, id_apprenant) VALUES (?,?,?,?)");
	$params3=array($now, $heure_arrive, $id_formation, $id);
  
	$ps3->execute($params3);

?>

<div class="alert alert-success container espace col-md-6 col-md-offset-3 col-xs-12">
    <strong>Success!</strong> Heure d'arrivée enregistrée.
</div><br>

<?php
  }

?>
<div class="col-10 mx-auto text-center" id="map" style="width:1000px; height:500px;"></div><br>


   </div>

   
    </div>
    </div>

  <div class="container espace col-md-8 col-md-offset-3 col-xs-12">
	<div class="panel panel-default">
		
	    <div class="panel-default coul"> <h3>Marquer son heure de départ</h3></div><br>
      <div class="panel-body">

      <form method="post">
      <div class="mx-auto text-center">
					<input type="submit" name="marquer" value="marquer" onclick="return confirm('Cette action est définitive, Voulez-vous vraiment exécuter ?');" class="btn btn-success">
			</div>

      </form>


      </div>
      </div>
  </div>
  </div>

<?php

if(isset($_POST['marquer'])){

$requete = "SELECT * FROM presence_apprenant WHERE date_jour=? AND id_apprenant=?";
$pst = $pdo->prepare($requete);
$params4=array($now,$id);
$pst->execute($params4);

if($response=$pst->fetch()) {
  
  if(empty($response['heure_depart'])){
    $pst1 = $pdo->prepare("UPDATE presence_apprenant SET heure_depart=? WHERE date_jour=? AND id_apprenant=?");
    $params5=array($heure_arrive, $now,$id);

    $pst1->execute($params5);


?>
  

    <div class="alert alert-success container espace col-md-6 col-md-offset-3 col-xs-12">
    <strong>Success!</strong> Heure de départ enregistrée.
    </div>

<?php   
  }
  else{


  ?>
  

    <div class="alert alert-info container espace col-md-6 col-md-offset-3 col-xs-12">
    <strong>Info!</strong> Votre Heure de départ a déjà été renseignée.
    </div><br><br>

<?php   

  }

}
}

?>



  


<?php
// $json = file_get_contents('https://ip.seeip.org/jsonip');
	   
// 		 //Decode JSON
// 		 $json_data = json_decode($json,true);

// 		$ip= $json_data["ip"];

  
// 		$ip = trim($ip);

//     // print($ip);


// $json1 = file_get_contents('http://ip-api.com/json/'.$ip.'?fields=lat,lon');
// // 		 //Decode JSON
		 

// // print($json1);
// $json_data1 = json_decode($json1,true);

// $lat = $json_data1["lat"];
// $lon = $json_data1["lon"];
// // print($lon); 
?>   




<script>
  

// const position = {
//         lat: lat,
//         lng: lon,
//     }

    const zoomlevel = 14;

    
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function (position){
		lat = position.coords.latitude;
    lng = position.coords.longitude;
    
    
    console.log(lat,lng);


		const map = L.map('map').setView([5.342979, -4.02304], zoomlevel); 
    const mainLayer = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'pk.eyJ1IjoiZW1tYW51ZWxrb3Vha291IiwiYSI6ImNrdzRwZ2xwdTExcjkyd3A2aWQzY3g4NHYifQ.QvFklu_eb98DUivHbWDcBw'});

    mainLayer.addTo(map);

    // var marker = L.marker([lat, lng]).addTo(map);

    var circle = L.circle([5.342979, -4.02304], {
    color: 'yellow',
    fillColor: 'yellow',
    fillOpacity: 0.5,
    radius: 500
}).addTo(map);
    });
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }

</script>

</body>

</html>
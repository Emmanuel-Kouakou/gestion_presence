<?php
session_start();

if(!(isset($_SESSION['PROFILE']))){
  header("location:../authentification.php");
  exit();
}

?>

<?php


// $id = $_GET['id'];

$id = $_SESSION['PROFILE']['id_apprenant'];

require_once("../connexionBd.php");

$labels_php =[];

$ps = $pdo->prepare("SELECT id_apprenant FROM apprenant");
$ps->execute();

while($reponse=$ps->fetch()){

  $id_app = strval($reponse['id_apprenant']);
  array_push($labels_php,$id_app);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
 
  <script defer src="face-api.min.js"></script>
  <script defer src="script1.js"></script> 

  <title>Reconnaissance Faciale</title>
  
  <style>
    body {
      margin: 0;
      padding: 0;
      width: 100vw;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;

    }

    canvas {
      position: absolute;
    }
  </style>
</head>
<body>

  <video id="video" width="720" height="560" muted controls></video>
  <div id="id_apprenant"><?php echo $id ; ?></div>
  <!-- <div id="maListe"><?php echo json_encode($labels_php) ; ?></div> -->


  <!-- <input type="hidden" name="maListe" id="maListe" value=<?php echo json_encode($labels_php);?> /> -->




<script>
  var js_array = <?php echo json_encode($labels_php);?>;
 
  sessionStorage.setItem('Thearray', JSON.stringify(js_array));


</script>


</body>
</html>
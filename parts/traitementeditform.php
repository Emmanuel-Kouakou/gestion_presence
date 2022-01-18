<?php

require_once("security.php");

?>
<?php

require_once("connexionBd.php");

  
  $id = $_POST['id'];
  $libelle_formation = $_POST['libelle'];
  $duree_formation = $_POST['duree'];
  $referentiel = $_POST['referentiel'];

  

$ps = $pdo->prepare("UPDATE formation SET libelle_formation=?, duree_formation=?, id_referentiel=? WHERE id_formation=?");
$params=array($libelle_formation, $duree_formation, $referentiel, $id);

$ps->execute($params);


  

header("location:creerformation.php");
exit();

?>
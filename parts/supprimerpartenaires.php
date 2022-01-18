<?php

require_once("security.php");

?>
<?php 

 require_once("connexionBd.php");



  $id=$_GET['id'];
  $req = "DELETE FROM partenaire WHERE id_partenaire=?";
  $ps=$pdo->prepare($req);
  $params= array($id);
  $ps->execute($params);

  header("location:creerpartenaire.php");
  exit();

 
 
 ?>
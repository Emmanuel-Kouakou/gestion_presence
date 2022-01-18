<?php

require_once("security.php");

?>
<?php 

 require_once("connexionBd.php");



  $id=$_GET['id'];
  $req = "DELETE FROM formation WHERE id_formation=?";
  $ps=$pdo->prepare($req);
  $params= array($id);
  $ps->execute($params);

  header("location:creerformation.php");
  exit();

 
 
 ?>
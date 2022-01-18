
<?php

require_once("security.php");

?>

<?php

require_once("connexionBd.php");

  $nom_partenaire = $_POST['nom'];
  $id = $_POST['id'];

  

$ps = $pdo->prepare("UPDATE partenaire SET nom_partenaire=? WHERE id_partenaire=?");
$params=array($nom_partenaire, $id);

$ps->execute($params);


  

header("location:creerpartenaire.php");
exit();

?>
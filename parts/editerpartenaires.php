<?php

require_once("security.php");

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Editer partenaire</title>

	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/etudCss.css">
</head>
<body>

<?php	require_once("../includes/entete.php") ?>

<?php 

    require_once("connexionBd.php");

    $id=$_GET['id'];


    $req= "SELECT * FROM partenaire WHERE id_partenaire=?";
    $ps=$pdo->prepare($req);
    $ps->execute(array($id));
    $partenaire=$ps->fetch();

    ?>


 <div class="container espace col-md-6 col-md-offset-3 col-xs-12">
	<div class="panel panel-default">
		
		<div class="panel-default coul"> MODIFIER PARTENAIRE </div>
		<div class="panel-body">
			
			<form method="post" action="traitementedition.php" enctype="multipart/form-data">


                <div class="form-group">
                     
                     <input type="hidden" name="id" value="<?php echo($partenaire['id_partenaire']) ?>" class="form-control">
                     
                </div>
 

				<div class="form-group">

					<label class="control-label" for="nom"> Nom partenaire : </label>
					<input type="text" name="nom" id="nom" value="<?php echo($partenaire['nom_partenaire']) ?>" class="form-control">
					
				</div>

			

				<div>
					<button type="submit" name="edit" class="btn btn-success">editer</button>
				</div>
				


			</form>

		</div>

	</div>

</div>	

<?php


if(isset($_POST['edit'])){

//   $nom_partenaire = $_POST['nom'];
  

  

//   $ps2 = $pdo->prepare("UPDATE partenaire SET nom_partenaire=? WHERE id_partenaire=?");
//   $params=array($nom_partenaire, $id);

//   $ps2->execute($params);

print($_POST['nom']);

  

// header("location:creerpartenaire.php");
// exit();
}

?>




</body>
</html>
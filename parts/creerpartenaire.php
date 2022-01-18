<?php

require_once("security.php");

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Saisir partenaire</title>

	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/etudCss.css">
</head>
<body>

<?php	require_once("../includes/entete.php") ?>


 <div class="container espace col-md-6 col-md-offset-3 col-xs-12">
	<div class="panel panel-default">
		
		<div class="panel-default coul"> ENREGISTRER NOUVEAU PARTENAIRE </div>
		<div class="panel-body">
			
			<form method="post" action="creerpartenaire.php" enctype="multipart/form-data">

				<div class="form-group">

					<label class="control-label" for="nom"> Nom partenaire : </label>
					<input type="text" name="nom" id="nom" class="form-control">
					
				</div>

			

				<div>
					<button type="submit" name="save" class="btn btn-success">enregistrer</button>
				</div>
				


			</form>

		</div>

	</div>

</div>	

<?php
require_once("connexionBd.php");

if(isset($_POST['save']) && !empty($_POST['nom'])){

  $nom_partenaire = $_POST['nom'];
  

  

  $ps = $pdo->prepare("INSERT INTO partenaire(nom_partenaire) VALUES (?)");
  $params=array($nom_partenaire);

  $ps->execute($params);

//   header("location:etudiants.php");
//   exit();
?>

<div class="alert alert-success container espace col-md-6 col-md-offset-3 col-xs-12">
  <strong>Success!</strong> Partenaire bien enregistré.
</div>

<?php
}

?>


<?php


 $req = 'SELECT * FROM partenaire';
 $ps = $pdo->prepare($req);
 $ps->execute();

 ?>


<div class="container espace col-md-6 col-xs-12">
	<div class="panel panel-info espace">

		<div class="panel-heading coul"> LISTE DES PARTENAIRES </div>
		<div class="panel-body">


  <table class="table table-striped">
  	
   <tr>
   	<th>Nom partenaire</th>
   </tr>

   <?php 
     while ($reponse=$ps->fetch()) {
		 
     	?>

     	<tr>
            <td><?php echo $reponse['nom_partenaire']; ?></td>
     		

     		
      
      <td><button type="submit" class="btn btn-warning"><a href="editerpartenaires.php?id=<?php echo $reponse['id_partenaire']; ?>" style="color: white">editer</a></button></td>
        
      <td><button type="submit" class="btn btn-danger"><a onclick="return confirm('Etes vous sures de vouloir supprimer ?');" href="supprimerpartenaires.php?id=<?php echo $reponse['id_partenaire']; ?>" style="color: white">supprimer</a></button></td>

     	</tr>

    <?php 	
     }
   ?>

  </table>

  </div>
  </div>

  </div>

</body>
</html>
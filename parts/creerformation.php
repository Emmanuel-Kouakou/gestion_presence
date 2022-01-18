<?php

require_once("security.php");

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Saisir formation</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/etudCss.css">
</head>
<body>

<?php	require_once("../includes/entete.php") ?>


 <div class="container espace col-md-6 col-xs-12">
	<div class="panel panel-default">
		
		<div class="panel-default coul"> ENREGISTRER NOUVELLE FORMATION </div>
		<div class="panel-body">
			
			<form method="post" action="creerformation.php" enctype="multipart/form-data">

				<div class="form-group">

					<label class="control-label" for="libelle"> Libellé formation : </label>
					<input type="text" name="libelle" id="libelle" class="form-control">
					
				</div>

                <div class="form-group">

					<label class="control-label" for="duree"> Durée formation : </label>
					<input type="number" name="duree" id="duree" class="form-control">
					
				</div>

                <div class="form-group">

                <?php 
                require_once('connexionBd.php');                                                                   
               // Affiche les résultats d'un requête dans une liste déroulante
                $ps2 = $pdo->prepare("SELECT * FROM referentiel");
                $ps2->execute();

                echo '<select name="referentiel" id="referentiel">';

    

                 while ( $reponse=$ps2->fetch() ) {
                  echo '<option value="'.$reponse['id_referentiel'].'">'.$reponse['libelle_referentiel'].'</option>';
                    }

                echo '</select>';

    ?>

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

if(isset($_POST['save']) && !empty($_POST['libelle']) && !empty($_POST['duree']) && !empty($_POST['referentiel'])){

  $libelle_formation = $_POST['libelle'];
  $duree_formation = $_POST['duree'];
  $referentiel = $_POST['referentiel'];
  

  

  $ps = $pdo->prepare("INSERT INTO formation(libelle_formation, duree_formation, id_referentiel) VALUES (?, ?, ?)");
  $params=array($libelle_formation, $duree_formation, $referentiel);

  $ps->execute($params);

//   header("location:etudiants.php");
//   exit();

?>

<div class="alert alert-success container espace col-md-8 col-xs-12">
  <strong>Success!</strong> Formation bien enregistré.
</div>

<?php
}

?>


<?php


 $req = 'SELECT * FROM formation f INNER JOIN referentiel r ON f.id_referentiel=r.id_referentiel';
 $ps = $pdo->prepare($req);
 $ps->execute();

 ?>


<div class="container espace col-md-6 col-xs-12">
	<div class="panel panel-info espace">

		<div class="panel-heading coul"> LISTE DES FORMATIONS </div>
		<div class="panel-body">


  <table class="table table-striped">
  	
   <tr>
   	<th>Libellé formation</th>
    <th>Durée</th>
    <th>Nom référentiel</th>
   </tr>

   <?php 
     while ($reponse=$ps->fetch()) {
     	?>

     	<tr>
            <td><?php echo $reponse['libelle_formation']; ?></td>
            <td><?php echo $reponse['duree_formation']; ?></td>
            <td><?php echo $reponse['libelle_referentiel']; ?></td>
     		

     		<!-- <td> <img src="images/<?php echo $reponse['PHOTOS']; ?>" width="100" height="100"></td> -->

      
      <td><button type="submit" class="btn btn-warning"><a href="editerformations.php?id=<?php echo $reponse['id_formation']; ?>" style="color: white">editer</a></button></td>
        
      <td><button type="submit" class="btn btn-danger"><a onclick="return confirm('Etes vous sures de vouloir supprimer ?');" href="supprimerformation.php?id=<?php echo $reponse['id_formation'];  ?>" style="color: white">supprimer</a></button></td>

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
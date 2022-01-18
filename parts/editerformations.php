
<?php

require_once("security.php");

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Editer formation</title>

	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/etudCss.css">
</head>
<body>

<?php	require_once("../includes/entete.php") ?>


<?php 

    require_once("connexionBd.php");

    $id=$_GET['id'];

    

    $req= "SELECT * FROM formation f INNER JOIN referentiel r ON f.id_referentiel=r.id_referentiel WHERE id_formation=?";
    $ps=$pdo->prepare($req);
    $ps->execute(array($id));
    $formation=$ps->fetch();

    ?>


 <div class="container espace col-md-6 col-md-offset-3 col-xs-12">
	<div class="panel panel-default">
		
		<div class="panel-default coul"> MODIFIER FORMATION </div>
		<div class="panel-body">
			
			<form method="post" action="traitementeditform.php" enctype="multipart/form-data">

                <div class="form-group">
                     
                     <input type="hidden" name="id" value="<?php echo($formation['id_formation']) ?>" class="form-control">
                     
                </div>

				<div class="form-group">

					<label class="control-label" for="libelle"> Libellé formation : </label>
					<input type="text" name="libelle" value="<?php echo($formation['libelle_formation']) ?>" id="libelle" class="form-control">
					
				</div>

                <div class="form-group">

					<label class="control-label" for="duree"> Durée formation : </label>
					<input type="number" name="duree" value="<?php echo($formation['duree_formation']) ?>" id="duree" class="form-control">
					
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
					<button type="submit" name="edit" class="btn btn-success">modifier</button>
				</div>
				


			</form>

		</div>

	</div>

</div>
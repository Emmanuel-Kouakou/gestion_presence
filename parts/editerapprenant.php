<?php

require_once("security.php");

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Apprenants</title>

	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/etudCss.css">
</head>
<body>

<?php	require_once("../includes/entete.php") ?>

<?php 

    require_once("connexionBd.php");

    $id=$_GET['id'];


    

    $req= "SELECT * FROM apprenant a INNER JOIN formation f ON a.id_formation=f.id_formation WHERE id_apprenant=?";
    $ps=$pdo->prepare($req);
    $ps->execute(array($id));
    $apprenant=$ps->fetch();

    ?>


 <div class="container espace col-md-6 col-md-offset-3 col-xs-12">
	<div class="panel panel-default">
		
		<div class="panel-default coul"> MODIFIER APPRENANT </div>
		<div class="panel-body">
			
			<form method="post" action="traitementeditappr.php" enctype="multipart/form-data">

            <div class="form-group">
                     
                     <input type="hidden" name="id" value="<?php echo($apprenant['id_apprenant']) ?>" class="form-control">
                     
                </div>

				<div class="form-group">

					<label class="control-label" for="nom"> Nom apprenant : </label>
					<input type="text" name="nom" id="nom" required="required" value="<?= $apprenant['nom_apprenant'];?>" class="form-control">
					
				</div>

                <div class="form-group">

					<label class="control-label" for="prenom"> Prenom apprenant : </label>
					<input type="text" name="prenom" id="prenom" required="required" value="<?= $apprenant['prenom_apprenant'];?>" class="form-control">
					
				</div>


                <div class="form-group">

                <label class="control-label" for="Adresse"> Adresse : </label>
                <input type="text" name="adresse" id="adresse" required="required" value="<?= $apprenant['adresse'];?>" class="form-control">

                </div> 

                <div class="form-group">

                <?php 
                require_once('connexionBd.php');                                                                   
               // Affiche les résultats d'un requête dans une liste déroulante
                $ps2 = $pdo->prepare("SELECT * FROM formation");
                $ps2->execute();

                echo '<select name="formation" id="formation">';

    

                 while ( $reponse=$ps2->fetch() ) {
                  echo '<option value="'.$reponse['id_formation'].'">'.$reponse['libelle_formation'].'</option>';
                    }

                echo '</select>';

    ?>

                </div>

                <div class="form-group">

                  <label class="control-label" for="photo1"> photo 1 (Format jpg; première photo : "1.jpg" ): </label>
                  <input type="file" name="photo1" id="photo1" accept=".jpg" class="form-control">
                  <img src="reconnaissance/labeled_images/<?php echo $apprenant['id_apprenant']; ?>/<?php echo $apprenant['photo1']; ?>" width="100" height="100">


                </div>

                <div class="form-group">

                  <label class="control-label" for="photo2"> photo 2 (Format jpg; première photo : "2.jpg" ): </label>
                  <input type="file" name="photo2" id="photo2" accept=".jpg" class="form-control">
                  <img src="reconnaissance/labeled_images/<?php echo $apprenant['id_apprenant']; ?>/<?php echo $apprenant['photo2']; ?>" width="100" height="100">


                </div>

                <div class="form-group">

                  <label class="control-label" for="photo3"> photo 3 (Format jpg; première photo : "3.jpg" ): </label>
                  <input type="file" name="photo3" id="photo3" accept=".jpg" class="form-control">
                  <img src="reconnaissance/labeled_images/<?php echo $apprenant['id_apprenant']; ?>/<?php echo $apprenant['photo3']; ?>" width="100" height="100">


                </div>

			

				<div>
					<button type="submit" name="edit" class="btn btn-success">modifier</button>
				</div>
				


			</form>

		</div>

	</div>

</div>	

</html>

    
</body>

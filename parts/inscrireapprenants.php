
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


 <div class="container espace col-md-6 col-md-offset-3 col-xs-12">
	<div class="panel panel-default">
		
		<div class="panel-default coul"> ENREGISTRER UN NOUVEAU APPRENANT </div>
		<div class="panel-body">
			
			<form method="post" action="inscrireapprenants.php" enctype="multipart/form-data">

				<div class="form-group">

					<label class="control-label" for="nom"> Nom apprenant : </label>
					<input type="text" name="nom" id="nom" required="required" class="form-control">
					
				</div>

                <div class="form-group">

					<label class="control-label" for="prenom"> Prenom apprenant : </label>
					<input type="text" name="prenom" id="prenom" required="required" class="form-control">
					
				</div>

                <div class="form-group">

                    <label class="control-label" for="nom_user"> Nom utilisateur : </label>
                    <input type="text" name="nom_user" id="nom_user" required="required" class="form-control">

                </div>

                <div class="form-group">

                    <label class="control-label" for="mot_de_passe"> Mot de passe : </label>
                    <input type="password" name="mot_de_passe" id="mot_de_passe" required="required" class="form-control">

                </div>

                <div class="form-group">

                    <label class="control-label" for="c_mot_de_passe"> Confirmer mot de passe : </label>
                    <input type="password" name="c_mot_de_passe" id="c_mot_de_passe" required="required" class="form-control">

                </div>

                <div class="form-group">

                <label class="control-label" for="Adresse"> Adresse : </label>
                <input type="text" name="adresse" id="adresse" required="required" class="form-control">

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

                </div>

                <div class="form-group">

                  <label class="control-label" for="photo2"> photo 2 (Format jpg; première photo : "2.jpg" ): </label>
                  <input type="file" name="photo2" id="photo2" accept=".jpg" class="form-control">

                </div>

                <div class="form-group">

                  <label class="control-label" for="photo3"> photo 3 (Format jpg; première photo : "3.jpg" ): </label>
                  <input type="file" name="photo3" id="photo3" accept=".jpg" class="form-control">

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



if(isset($_POST['save']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['adresse']) && !empty($_POST['formation']) && isset($_POST['nom_user']) && isset($_POST['mot_de_passe']) && isset($_POST['c_mot_de_passe']) && !empty($_FILES['photo1']['name']) && !empty($_FILES['photo2']['name']) && !empty($_FILES['photo3']['name']) ){

  if($_POST['mot_de_passe']==$_POST['c_mot_de_passe']){ 
  $nom = $_POST['nom'];
  $prenom = $_POST['prenom'];
  $adresse = $_POST['adresse'];
  $user = $_POST['nom_user'];
  $mot_de_passe = $_POST['mot_de_passe'];
  $id_formation = $_POST['formation'];

  $nomPhoto1 = $_FILES['photo1']['name'];
  $nomPhoto2 = $_FILES['photo2']['name'];
  $nomPhoto3 = $_FILES['photo3']['name'];

    if($nomPhoto1=="1.jpg" && $nomPhoto2="2.jpg" && $nomPhoto3="2.jpg"){

  //Le serveur apache place les fichiers qu'il reçoit dans un dossier temporaire.

  $fichierTempo1 = $_FILES['photo1']['tmp_name'];
  $fichierTempo2 = $_FILES['photo2']['tmp_name'];
  $fichierTempo3 = $_FILES['photo3']['tmp_name'];

// Déplacer le fichier dans un dossier.

$ps0 = $pdo->prepare("SELECT * FROM apprenant WHERE nom_utilisateur=? AND mot_de_passe=?");
$params0=array($user, $mot_de_passe);

$ps0->execute($params0);

if($rep=$ps0->fetch()){
?>

  <div class="alert alert-info container espace col-md-6 col-md-offset-3 col-xs-12">
  <strong>Success!</strong> L'apprenant existe déjà.
  </div>
  
  <?php
}else{

  $ps = $pdo->prepare("INSERT INTO apprenant(nom_apprenant, prenom_apprenant, nom_utilisateur, mot_de_passe, adresse, id_formation, photo1, photo2, photo3) VALUES (?, ?, ?,?,?,?, ?, ?,?)");
  $params=array($nom, $prenom, $user, $mot_de_passe, $adresse, $id_formation, $nomPhoto1, $nomPhoto2, $nomPhoto3);

  $ps->execute($params);

//   header("location:etudiants.php");
//   exit();


?>

<div class="alert alert-success container espace col-md-6 col-md-offset-3 col-xs-12">
  <strong>Success!</strong> Apprenant bien enregistré.
</div>

<?php

$ps2 = $pdo->prepare("SELECT id_apprenant FROM apprenant WHERE nom_utilisateur=? AND mot_de_passe=? AND id_formation=?");
$params2=array($user, $mot_de_passe, $id_formation);

$ps2->execute($params2);

while($reponse=$ps2->fetch()){

    $path = 'reconnaissance/labeled_images/'.$reponse['id_apprenant'].'/';

    if(!file_exists($path)){
      
      mkdir($path);

      $fichier1 = $path.$nomPhoto1;
      $fichier2 = $path.$nomPhoto2;
      $fichier3 = $path.$nomPhoto3;


    move_uploaded_file($fichierTempo1, $fichier1);
    move_uploaded_file($fichierTempo2, $fichier2);
    move_uploaded_file($fichierTempo3, $fichier3);

    }

   

  
}

?>

<?php
  
  }

   }else{

?>


<div class="alert alert-warning container espace col-md-6 col-md-offset-3 col-xs-12">
    <strong>Info!</strong> Les noms des photos ne correspondent pas. Veuillez respecter les consignes indiquées.
</div>

<?php


     }

}else{
    ?>
    <div class="alert alert-danger container espace col-md-6 col-md-offset-3 col-xs-12">
    <strong>Erreur!</strong> Vérifier les mot de passes.
  </div>

<?php
    } 


}






?>
<br><br>
    
</body>

</html>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>

	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/etudCss.css">
</head>
<body>

<?php	require_once("../includes/entete2.php") ?>


 <div class="container espace col-md-6 col-md-offset-3 col-xs-12">
	<div class="panel panel-default">
		
		<div class="panel-default coul"> AUTHENTIFICATION FORMATEUR</div>
		<div class="panel-body">
			
			<form method="post" action="authentification_form.php">

				<div class="form-group">

					<label class="control-label" for="username"> Nom d'utilisateur : </label>
					<input type="text" name="username" id="username" class="form-control">
					
				</div>

				<div class="form-group">

					<label class="control-label" for="password"> Mot de passe : </label>
					<input type="password" name="password" id="password" class="form-control">
					
				</div>

				<div>
					<button type="submit" name="login" class="btn btn-success">login</button>
				</div>
				


			</form>

		</div>

	</div>

</div>	

</body>
</html>

<?php

if(isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])){

	$username = $_POST['username'];
	$password = $_POST['password'];
   
   
	require_once("connexionBd.php");
   
	try {
   
	 $req = "SELECT * FROM formateur WHERE nom_user_form=? AND mot_de_passe_form=?";
	 $ps= $pdo->prepare($req);
	 $ps->execute( array($username, $password) );
   
	 if ($user=$ps->fetch()) {
   
		 // session_start();
		 // $_SESSION['PROFILE']=$user;
		 
		 header("location:feuille_presence.php");
		 exit();
	 }else{

		?>

      <div class="alert alert-danger container espace col-md-6 col-md-offset-3 col-xs-12">
      <strong>Erreur!</strong> Vous ne faites pas partir de la liste des formateurs.
      </div>

				<?php
   
	 }
		
	} catch (PDOException $e) {
		die('Erreur de syntaxe'.$e->getMessage());
	}

}

	?>


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
		
		<div class="panel-default coul"> AUTHENTIFICATION APPRENANT</div>
		<div class="panel-body">
			
			<form method="post" action="authentification_apprenant.php">

			   

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
			<div>
			<a href="inscrireapprenants.php">Inscription</a>
			<!-- <button type="submit" class="btn btn-warning"><a href="inscrireapprenants.php">Inscription</a></button> -->
            </div>
		</div>

	</div>

</div>	

<?php

      if(isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])){
         
		$username = $_POST['username'];
		$password = $_POST['password'];
	    
	   
		require_once("connexionBd.php");
	   
		try {
	   
		 $req = "SELECT * FROM apprenant WHERE nom_utilisateur=? AND mot_de_passe=?";
		 $ps= $pdo->prepare($req);
		 $ps->execute( array($username, $password) );
	   
	   
		 
	   
	   
		 if ($user=$ps->fetch()) {

			$json = file_get_contents('https://ip.seeip.org/jsonip');

		    //Decode JSON
			$json_data = json_decode($json,true);
			$ip= $json_data["ip"];
			$ip = trim($ip);
			

			$id = $user['id_apprenant'];
			if($ip=='105.235.111.211'){
                
				header("location:emarge_user.php?id=$id");
				exit();
			}else{
				?>

      <div class="alert alert-danger container espace col-md-6 col-md-offset-3 col-xs-12">
      <strong>Erreur!</strong> Connectez-vous au réseau WIFI de la Mtn Academy pour continuer.
      </div>

				<?php
			}
	   
			 
		 }else{
		   // header("location:authentification_apprenant.php");
          

    ?>
     
	<div class="alert alert-warning container espace col-md-6 col-md-offset-3 col-xs-12">
      <strong>Impossible de se connecter!</strong> Vous ne faites pas parti de la liste des apprenants. Veuillez vous adresser à votre formateur pour plus de détails.
    </div>

	<?php
		 }
			
		} catch (PDOException $e) {
			die('Erreur de syntaxe'.$e->getMessage());
		}

	  }

?>

</body>
</html>




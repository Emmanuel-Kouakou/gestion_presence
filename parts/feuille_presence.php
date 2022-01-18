
<?php

require_once("security.php");

?>

<!DOCTYPE html>
<html>
<head>
	<title>Feuille présence</title>

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="../css/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/etudCss.css">
</head>
<body>

	<?php require("../includes/entete.php")
    
    ?>

<div class="col-md-12 col-xs-12">
	<div class="panel panel-info espace">    

 <div class='row'>
 <div class="row col-md-6 boxlayout">
<form action = "feuille_presence.php" method = "post">

    <?php 
            require_once('connexionBd.php');                                                                   
     // Affiche les résultats d'un requête dans une liste déroulante
    $ps2 = $pdo->prepare("SELECT * FROM formation");
    $ps2->execute();

    ?>



   <select class="form-select col-md-6" aria-label="Default select example" name="admin" id="admin">
   <?php
   while ( $reponse=$ps2->fetch() ) {

    ?>

   <option value="<?php echo $reponse['id_formation']; ?>"><?php echo $reponse['libelle_formation']; ?></option>

   <?php
   }
   ?>
   </select>


   <input type = "submit" class="btn btn-success" name="s" value = "Rechercher">

</form>
</div>

<div class="row col-md-6 boxlayout">
   <form action = "feuille_presence.php" method = "post">

   <div>

   <input type = "Date" class="col-md-6" name = "date">

   </div>


   <input type = "submit" name = "d" value = "Rechercher">

</form>

</div>

</div><br>

<div class="row">
<div class="row col-md-6 boxlayout">
<form class="navbar-form navbar-left" action="feuille_presence.php" method="post" role="search">
    <div class="form-group">
        <input type="text" class="form-control" name="nom" placeholder="Search">
    </div>

    <!-- <div class="form-group">
    <button type="submit" name="search" class="btn btn-info">Rechercher</button>
    </div> -->
</form>
</div>

</div>


  <?php 
     
     if(isset($_POST['d'])){
         
        $date_jour = $_POST['date'];   
        $req = 'SELECT p.date_jour, p.heure_arrivee, p.heure_depart, p.id_formation, f.libelle_formation, p.id_apprenant, a.nom_apprenant, a.prenom_apprenant FROM presence_apprenant AS p INNER JOIN apprenant AS a ON p.id_apprenant = a.id_apprenant INNER JOIN formation AS f ON p.id_formation = f.id_formation WHERE p.date_jour=?';
        $ps = $pdo->prepare($req);
        $params=array($date_jour);
        $ps->execute($params);


     }
  
  ?>



    <!-- <form action = "feuille_presence.php" method = "post">
       <input type = "search" name = "terme">
       <input type = "submit" name = "s" value = "Rechercher">
   </form>   -->


   <?php


if(isset($_POST['nom']) && !empty($_POST['nom'])){



   $nom = $_POST['nom'];

   $req = 'SELECT p.date_jour, p.heure_arrivee, p.heure_depart, p.id_formation, f.libelle_formation, p.id_apprenant, a.nom_apprenant, a.prenom_apprenant FROM presence_apprenant AS p INNER JOIN apprenant AS a ON p.id_apprenant = a.id_apprenant INNER JOIN formation AS f ON p.id_formation = f.id_formation WHERE a.nom_apprenant=? OR a.prenom_apprenant=?';
   $ps = $pdo->prepare($req);
   $params=array($nom, $nom);
   $ps->execute($params);


}


if(isset($_POST['s'])){
    $id_fr = (int) $_POST['admin'];   
    $req = 'SELECT p.date_jour, p.heure_arrivee, p.heure_depart, p.id_formation, f.libelle_formation, p.id_apprenant, a.nom_apprenant, a.prenom_apprenant FROM presence_apprenant AS p INNER JOIN apprenant AS a ON p.id_apprenant = a.id_apprenant INNER JOIN formation AS f ON p.id_formation = f.id_formation WHERE p.id_formation=?';
    $ps = $pdo->prepare($req);
    $params=array($id_fr);
    $ps->execute($params);

   }

   if(!isset($_POST['s']) && !isset($_POST['d']) && !isset($_POST["nom"])) {

  
  $req = 'SELECT p.date_jour, p.heure_arrivee, p.heure_depart, p.id_formation, f.libelle_formation, p.id_apprenant, a.nom_apprenant, a.prenom_apprenant FROM presence_apprenant AS p INNER JOIN apprenant AS a ON p.id_apprenant = a.id_apprenant INNER JOIN formation AS f ON p.id_formation = f.id_formation
 ';
 $ps = $pdo->prepare($req);
 $ps->execute();

   }
   

?>

  

		<div class="panel-heading coul"> LISTE DE PRESENCES DES APPRENANTS </div>
		<div class="panel-body">


  <table class="table table-striped">
  	
   <tr>
   	<th>Date</th><th>Heure d'arrivée</th><th>Heure de départ</th><th>Nom apprenant</th><th>Prenom apprenant</th><th>Nom formation</th>
   </tr>

   <?php 
     while ($reponse=$ps->fetch()) {
     	?>

     	<tr>
            <td><?php echo $reponse['date_jour']; ?></td>
     		<td><?php echo $reponse['heure_arrivee']; ?></td>
     		<td><?php echo $reponse['heure_depart']; ?></td>
     		<td><?php echo $reponse['nom_apprenant']; ?></td>
            <td><?php echo $reponse['prenom_apprenant']; ?></td>
            <td><?php echo $reponse['libelle_formation']; ?></td>

     		<!-- <td> <img src="images/<?php echo $reponse['PHOTOS']; ?>" width="100" height="100"></td> -->

      
      <!-- <td><button type="submit" class="btn btn-warning"><a href="editerEtudiants.php?id=<?php echo $reponse['CODE']; ?>">editer</a></button></td>
        
      <td><button type="submit" class="btn btn-danger"><a onclick="return confirm('Etes vous sures de vouloir supprimer ?');" href="supprimerEtudiants.php?id=<?php echo $reponse['CODE']; ?>">supprimer</a></button></td> -->

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
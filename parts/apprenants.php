<?php

require_once("security.php");

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Apprenants</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/etudCss.css">
</head>
<body>

<?php	require_once("../includes/entete.php") ?>


 
<?php
require_once("connexionBd.php");

?>



<div class="container col-md-10 col-xs-12">
	<div class="panel panel-info espace">

		


<br>
<form action = "apprenants.php" method = "post">

<?php 
                                                                        
 // Affiche les résultats d'un requête dans une liste déroulante
$ps2 = $pdo->prepare("SELECT * FROM formation");
$ps2->execute();

?>



<select class="form-select col-md-4" aria-label="Default select example" name="admin" id="admin">


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


<br> 

<div class="panel-heading coul"> LISTE DES APPRENANTS DE SIMPLON </div>
 <div class="panel-body">

<?php
if(isset($_POST['s'])){

    $id_fr = (int) $_POST['admin'];   
    $req = 'SELECT * FROM apprenant a INNER JOIN formation f ON a.id_formation=f.id_formation WHERE a.id_formation=?';
    $ps = $pdo->prepare($req);
    $params=array($id_fr);
    $ps->execute($params);

}else{

 $req = 'SELECT * FROM apprenant a INNER JOIN formation f ON a.id_formation=f.id_formation';
 $ps = $pdo->prepare($req);
 $ps->execute();

}

 ?>




  <table class="table table-striped">
  	
   <tr>
   	<th>Nom</th>
    <th>Prenoms</th>
    <th>Adresse</th>
    <th>Formation</th>
    <th>Photo</th>

   </tr>

   <?php 
     while ($reponse=$ps->fetch()) {
     	?>

     	<tr>
            <td><?php echo $reponse['nom_apprenant']; ?></td>
            <td><?php echo $reponse['prenom_apprenant']; ?></td>
            <td><?php echo $reponse['adresse']; ?></td>
            <td><?php echo $reponse['libelle_formation']; ?></td>
     		

     		<td> <img src="reconnaissance/labeled_images/<?php echo $reponse['id_apprenant']; ?>/<?php echo $reponse['photo1']; ?>" width="100" height="100"></td>

      
      <td><button type="submit" class="btn btn-warning"><a href="editerapprenant.php?id=<?php echo $reponse['id_apprenant']; ?>" style="color: white">editer</a></button></td>
        
      <td><button type="submit" class="btn btn-danger"><a onclick="return confirm('Etes vous sures de vouloir supprimer ?');" href="supprimerapprenants.php?id=<?php echo $reponse['id_apprenant']; ?>" style="color: white">supprimer</a></button></td>

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
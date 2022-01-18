<?php

require_once("security.php");

?>
<?php

require_once("connexionBd.php");

  
  $id = $_POST['id'];
  $nom_apprenant = $_POST['nom'];
  $prenom_apprenant = $_POST['prenom'];
  $adresse = $_POST['adresse'];
  $formation = $_POST['formation'];
  
  $nomPhoto1 = $_FILES['photo1']['name'];
  $nomPhoto2 = $_FILES['photo2']['name'];
  $nomPhoto3 = $_FILES['photo3']['name'];



  if($nomPhoto1=="1.jpg" && $nomPhoto2=="2.jpg" && $nomPhoto3=="3.jpg"){

       $fichierTempo1 = $_FILES['photo1']['tmp_name'];
       $fichierTempo2 = $_FILES['photo2']['tmp_name'];
       $fichierTempo3 = $_FILES['photo3']['tmp_name'];

       $ps = $pdo->prepare("UPDATE apprenant SET nom_apprenant=?, prenom_apprenant=?, adresse=?, id_formation=?, photo1=?, photo2=?, photo3=? WHERE id_apprenant=?");
       $params=array($nom_apprenant, $prenom_apprenant, $adresse, $formation, $nomPhoto1, $nomPhoto2, $nomPhoto3, $id);
       $ps->execute($params);
    

//  FONCTION POUR EFFACER LE REPERTOIRE
function RepEfface($dir)
    {
    $handle = opendir($dir);
    while($elem = readdir($handle)) 
//ce while vide tous les repertoire et sous rep
    {
        if(is_dir($dir.'/'.$elem) && substr($elem, -2, 2) !== '..' && substr(
$elem, -1, 1) !== '.') //si c'est un repertoire
        {
            RepEfface($dir.'/'.$elem);
        }
        else
        {
            if(substr($elem, -2, 2) !== '..' && substr($elem, -1, 1) !== '.')
            {
                unlink($dir.'/'.$elem);
            }
        }
            
    }
    
    $handle = opendir($dir);
    while($elem = readdir($handle)) //ce while efface tous les dossiers
    {
        if(is_dir($dir.'/'.$elem) && substr($elem, -2, 2) !== '..' && substr(
$elem, -1, 1) !== '.') //si c'est un repertoire
        {
            RepEfface($dir.'/'.$elem);
            rmdir($dir.'/'.$elem);
        }    
    
    }
    rmdir($dir); //ce rmdir eface le repertoire principale
   }
       

           $path = 'reconnaissance/labeled_images/'.$id.'/';

           RepEfface($path);
       
           if(!file_exists($path)){
             
             mkdir($path);
       
             $fichier1 = $path.$nomPhoto1;
             $fichier2 = $path.$nomPhoto2;
             $fichier3 = $path.$nomPhoto3;
       
       
           move_uploaded_file($fichierTempo1, $fichier1);
           move_uploaded_file($fichierTempo2, $fichier2);
           move_uploaded_file($fichierTempo3, $fichier3);
         
       
       
       
           }
  
           header("location:apprenants.php");
           exit();
        }
        else{
            ?>

<script>
window.alert("Respecter les consignes indiquées pour les photos");
document.location.href="/gestion_presence/parts/apprenants.php";
</script>


<?php

// header("location:apprenants.php");
// exit();
        }
  




  



?>
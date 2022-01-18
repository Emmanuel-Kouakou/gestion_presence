<?php

require_once("security.php");

?>
<?php 

 require_once("connexionBd.php");



  $id=$_GET['id'];
  $req = "DELETE FROM apprenant WHERE id_apprenant=?";
  $ps=$pdo->prepare($req);
  $params= array($id);
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

  header("location:apprenants.php");
  exit();

 
 
 ?>
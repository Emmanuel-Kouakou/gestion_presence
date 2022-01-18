<?php

try {

	$chaineDeConnexion = 'mysql:host=localhost;dbname=gestion_presence';
	$pdo = new PDO($chaineDeConnexion, 'root', '');
	
} catch (Exception $e) {

	die('Erreur de connexion : '. $e->getMessage());
	
}

?>
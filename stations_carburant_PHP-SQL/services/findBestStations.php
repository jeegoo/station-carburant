
<?php
 //authors: kebir  , chalabi
require('lib/servicesInit.php');

try{
   $reponse=$data->getBestStations(10);
   makeService($reponse,"no stations found!");  //creer le Json affiche  "no stations found!" en cas d'erreur
} catch (PDOException $e){
   produceError($e->getMessage());
}


?>

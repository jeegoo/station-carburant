<?php
 //authors: kebir  , chalabi
require_once('lib/servicesInit.php');

$id_station=testOneParamValidity("id");


try{
   $reponse=$data->getPosts($id_station);
   makeService($reponse,"no post found !");  //creer le Json affiche  "no post found !" en cas d'erreur
} catch (PDOException $e){
   produceError($e->getMessage());
}


?>

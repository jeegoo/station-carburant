<?php
 //authors: kebir  , chalabi
require_once('lib/servicesInit.php');
require('lib/session_init.php');

$post=true;
$prams=["station","titre","contenu"];
$res=testManyParamsValidity($prams);
$auteur=$_SESSION["user"]->pseudo;

$station=$res["station"];
$titre=$res["titre"];
$contenu=$res["contenu"];



try{
   $reponse=$data->createPost($auteur,$station,$titre,$contenu);
   makeService($reponse,"no post found  !");

} catch (PDOException $e){
   produceError($e->getMessage());
}



?>

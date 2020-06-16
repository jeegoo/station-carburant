<?php
 //authors: kebir  , chalabi
require_once('lib/servicesInit.php');
require('lib/session_init.php');

$post=true;
if(isset($_SESSION['user'])){
      $prams=["id","avis"];
      $res=testManyParamsValidity($prams);
      $user=$_SESSION["user"]->pseudo;
      $id=$res["id"];
      $avis=$res["avis"];


      try{
         $reponse=$data->notePost($user,$id,$avis);
         makeService($reponse,"no post found  !");  //creer le Json affiche  "no post found !" en cas d'erreur

      } catch (PDOException $e){
         produceError($e->getMessage());
      }
}

?>

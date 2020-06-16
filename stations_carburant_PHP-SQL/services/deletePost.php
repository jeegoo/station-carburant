<?php
 //authors: kebir  , chalabi
require_once('lib/servicesInit.php');
require('lib/session_init.php');

if(isset($_SESSION["user"])) {
        $post=true;
        $auteur=$_SESSION["user"]->pseudo;
        $id=testOneParamValidity("id");

        try{
           $reponse=$data->deletePost($id,$auteur);
           makeService($reponse,"no post found !");  //creer le Json affiche  "no post found !" en cas d'erreur

        } catch (PDOException $e){
           produceError($e->getMessage());
        }
}


?>

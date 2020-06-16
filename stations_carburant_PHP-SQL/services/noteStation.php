<?php
 //authors: kebir  , chalabi

require_once('lib/servicesInit.php');
require('lib/session_init.php');
if(isset($_SESSION['user'])){
        $post=true;
        $prams=["id","global","accueil","prix","service"];
        $res=testManyParamsValidity($prams);
        $id=$res["id"];
        $global=$res["global"];
        $accueil=$res["accueil"];
        $prix=$res["prix"];
        $service=$res["service"];
        $user=$_SESSION['user']->pseudo;


        try{
           $reponse=$data->noteStation($id,$global,$accueil,$prix,$service,$user);
           makeService($reponse,"no station found !");  //creer le Json affiche  "no post found !" en cas d'erreur

        } catch (PDOException $e){
           produceError($e->getMessage());
        }
}


?>

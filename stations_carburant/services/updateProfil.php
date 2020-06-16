<?php
 //authors: kebir  , chalabi
require_once('lib/servicesInit.php');
require('lib/session_init.php');
if(isset($_SESSION['user'])){

    $post=true;

    $prams=["mail","description","ville","password"];
    $valideParams=[];
    foreach ($prams as $param )
       if(isset($_POST[$param]) && $_POST[$param]!="" )
                 array_push($valideParams,$param);
    if($valideParams!=[]){
            $res=testManyParamsValidity($valideParams);
            $mail=$res["mail"];
            $description=$res["description"];
            $ville=$res["ville"];
            $password=$res["password"];
            $pseudo=$_SESSION['user']->pseudo;


            try{
              $reponse=$data->updateProfil($mail,$description,$ville,$password,$pseudo);
              makeService($reponse,"not updated correctly!");  //creer le Json affiche  "no post found !" en cas d'erreur

            } catch (PDOException $e){
           produceError($e->getMessage());
          }
    }
  else
        makeService(false,"nothing to update!");
}

?>

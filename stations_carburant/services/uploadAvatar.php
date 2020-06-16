<?php
 //authors: kebir  , chalabi

require_once('lib/servicesInit.php');
require('lib/session_init.php');
if(isset($_SESSION['user'])){
        $post=true;
        $res=testOneParamValidity("image");
        $data=['data'=>$flux,'mimetype'=>$_FILES['image']['type'];
        $user=$_SESSION['user']->pseudo;


        try{
           $reponse=$data->storeAvatar($data,$user);
           makeService($reponse,"image not supported! ");  //creer le Json affiche  "no post found !" en cas d'erreur

        } catch (PDOException $e){
            produceError($e->getMessage());
        }
}


?>

<?php
 //authors: kebir  , chalabi
   require_once('lib/servicesInit.php');
   $imgHeader=true;
  $user=testOneParamValidity("user");
  try{
     $reponse=$data->getAvatar($user);
     $flux=$reponse['data'];
     $mimetype=$reponse['mimetype'];
     header("Content-Type : image/jpeg");
     //echo $flux;

  } catch (PDOException $e){
      produceError($e->getMessage());
  }







 ?>

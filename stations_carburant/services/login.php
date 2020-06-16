<?php
 //authors: kebir  , chalabi
require_once('lib/servicesInit.php');
require('lib/session_init.php');

if(isset($_SESSION['user']))  {    //if already logged in
       makeService(FALSE,"already logged in!");    //stop the script
       exit();
     }


$params=["login","password"];
$res=testManyParamsValidity($params);
$login=$res["login"];
$password=$res["password"];
$pass=true;    //set to hide the password value
//$post=true;

try{
   $reponse=$data->login($login,$password);
   if ($reponse!=false){
        $_SESSION['user']= new User($reponse["pseudo"],$reponse["nom"],$reponse["description"]);
        makeService($reponse,"");  //creer le Json affiche  "no post found !" en cas d'erreur
        }
    else
       makeService(FALSE,"user not fount!");



} catch (PDOException $e){
   produceError($e->getMessage());
}


?>

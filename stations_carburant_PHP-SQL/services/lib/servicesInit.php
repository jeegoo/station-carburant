<?php
 //authors: kebir  , chalabi
spl_autoload_register(function ($className) {
    include ("lib/{$className}.class.php");
});
date_default_timezone_set ('Europe/Paris');
set_include_path('..');
if(!isset($imgHeader))
    header('Content-type: application/json; charset=UTF-8');
if(isset($post))
    $args = new RequestParameters("post");
else
     $args = new RequestParameters();

$data = new DataLayer();
function answer($reponse){
    global $args;
    global $pass;


    $reponse['args'] = $args->getValues();
    if(isset($pass)){

         unset($reponse['args']['password']);


       }
  //  $reponse['time'] = date('d/m/Y H:i:s');
    echo json_encode($reponse);
}

function produceError($message){
    echo answer(['status'=>'error','message'=>$message]);
}

function produceResult($result,$time){

    $reponse=['status'=>'ok','result'=>$result];
    if($time)
         $reponse['result']['time']=date('d/m/Y H:i:s');
    echo answer($reponse);
}


function valideArgs($args){
    if (!($args->isValid())){
          produceError( implode(' ',$args->getErrorMessages()) );
          exit();
      }
      else if($args->getValues()==[]){
        produceError('missing arg');
        exit();
      }
}

function testOneParamValidity($param){

        global $args;
        $args->defineNonEmptyString($param);
        valideArgs($args);
        return $args->getValue($param);

}

function testManyParamsValidity($params){

        global $args;

        foreach ($params as $key => $value) {
              $args->defineNonEmptyString($value);}
        valideArgs($args);
        return $args->getValues();

}

function makeService($reponse,$msgError,$time=FALSE){
      if($reponse!==FALSE)
          produceResult($reponse,$time);
      else
          produceError($msgError);
}

 ?>

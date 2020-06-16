<?php




function postInDataBase($id,$auteur="",$connexion){
       if($auteur=="")
           $sql="select id from posts where  id=:id";
      else
            $sql="select id from posts where auteur=:auteur and id=:id";
       $stmt=$connexion->prepare($sql);
       if($auteur!="")
              $stmt->bindValue(":auteur",$auteur);
       $stmt->bindValue(":id",$id);
       $stmt->execute();
       $res=$stmt->fetchAll();

       if($res==[])
           return false;
       return true;
}


function updateUserPostsInfo($attribut,$pseudo,$connexion,$operation="+"){

      $sql="update users set $attribut=$attribut$operation 1  where pseudo=:pseudo";
      $stmt=$connexion->prepare($sql);

      $stmt->bindValue(":pseudo",$pseudo);
      $stmt->execute();
}

function getRating($actuelNote,$newNote){

          return ($actuelNote+$newNote)/2;
     }


function notNullParams($mail,$description,$ville,$password){
  $params=["mail","description","ville","password"];

  $bindVars="";
  foreach ($params as $key=>$value ) {

    if(${$value}!=null )
        $bindVars.=$value."=:".$value.",";
    else
        unset($params[$key]);
  }
  $bindVars=trim ($bindVars, "," );

  return ["params"=>$params,"requete"=>$bindVars];

}

function correctyUpdated($before,$after,$paramChanged){
      return array_diff_assoc($before,$after);
}

 ?>

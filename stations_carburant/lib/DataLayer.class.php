    <?php
    require_once("lib/db_parms.php");
    require_once('lib/postsGestions.php');
    require_once('lib/User.class.php');
    Class DataLayer{
        private $connexion;
        public function __construct(){

                $this->connexion = new PDO(
                           DB_DSN, DB_USER, DB_PASSWORD,
                           [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                           ]
                         );

        }
/*
        function getAllStations(){
          $sql = <<<EOD
          select *
          from stationsp2
EOD;
         $stmt=$this->connexion->prepare($sql);
         $stmt->execute();
         return $stmt->fetchAll();
    }

*/

    function login($login, $password){
        $sql = <<<EOD
        select pseudo,nom,description,password
        from users
EOD;


        $stmt = $this->connexion->prepare($sql);

        $stmt->execute();
        $res = $stmt->fetchAll();

        for ($i=0; $i <count($res) ; $i++)
              if (crypt($password, $res[$i]['password']) == $res[$i]['password'] && $res[$i]['pseudo']==$login)
                    return $res[$i];
       return false;

      //  return new User($res[0]["pseudo"],$res[0]["nom"],$res[0]["description"]);

      }


    function getStation($id){
          $sql = <<<EOD
          select *
          from stationsp2 where id=:id
EOD;
          $stmt=$this->connexion->prepare($sql);
          $stmt->bindValue(":id",$id);
          $stmt->execute();
          $res=$stmt->fetchAll();
          if($res==[])
              return false;
          return $res;
    }

    function getBestStations($nbrBestStations){
         $sql = <<<EOD
         select *
         from stationsp2 order by noteglobale desc limit :nbrBestStations
EOD;
         $stmt=$this->connexion->prepare($sql);
         $stmt->bindValue(":nbrBestStations",$nbrBestStations);
         $stmt->execute();
         $res=$stmt->fetchAll();
         if($res==[])
            return false;
         return $res;
    }

       function getPosts($id_station){
          $sql = <<<EOD
          select *
          from posts where station=:id_station
EOD;
          $stmt=$this->connexion->prepare($sql);
          $stmt->bindValue(":id_station",$id_station);
          $stmt->execute();
          $res=$stmt->fetchAll();
          //if($res==[])
            //return false;
          return $res;
    }

        function getMesPosts($auteur){
            $sql = <<<EOD
            select *
            from posts where auteur=:auteur order by id desc
EOD;
            $stmt=$this->connexion->prepare($sql);
            $stmt->bindValue(":auteur",$auteur);
            $stmt->execute();
            $res=$stmt->fetchAll();
            if($res==[])
                return false;
            return $res;
    }


        function getUser($pseudo){
            $sql = <<<EOD
            select *
            from users where pseudo=:pseudo
EOD;
            $stmt=$this->connexion->prepare($sql);
            $stmt->bindValue(":pseudo",$pseudo);
            $stmt->execute();
            $res=$stmt->fetchAll();
            if($res==[])
                return false;
            return $res[0];
    }

    //********************************************

     function noteStation($id,$global,$accueil,$prix,$service,$user){

       $res=$this->getStation($id);
       if($res==[])
             return false;


       $sql = <<<EOD
       update  stationsp2
          set   nbnotes=nbnotes+1,
               noteglobale=TRUNC((noteglobale+:global)/2,1),
               noteaccueil=TRUNC((noteaccueil+:accueil)/2,1),
               noteprix=TRUNC((noteprix+:prix)/2,1),
               noteservice=TRUNC((noteservice+:service)/2,1)
       where id=:id
EOD;

        $stmt=$this->connexion->prepare($sql);
        $stmt->bindValue(":global",$global);
        $stmt->bindValue(":accueil",$accueil);
        $stmt->bindValue(":prix",$prix);
        $stmt->bindValue(":service",$service);
        $stmt->bindValue(':id',$id);
        $stmt->execute();
        updateUserPostsInfo("nbavis",$user,$this->connexion);
        return $this->getStation($id);
    }

     function createPost($auteur,$station,$titre,$contenu){


        $sql = <<<EOD
        insert into posts
        (auteur,station,titre,contenu,datecreation)
        values (:auteur,:station,:titre,:contenu,NOW())
EOD;

       $res1=$this->getUser($auteur)["nbposts"];
       $stmt=$this->connexion->prepare($sql);
       $stmt->bindValue(":auteur",$auteur);
       $stmt->bindValue(":station",$station);
       $stmt->bindValue(":titre",$titre);
       $stmt->bindValue(":contenu",$contenu);
       $stmt->execute();
       updateUserPostsInfo("nbposts",$auteur,$this->connexion);
       $res2=$this->getUser($auteur)["nbposts"];
       if( ($res1+1) !=$res2)
            return false;
       return $this->getMesPosts($auteur)[0]["id"];
    }



    function deletePost($id,$auteur){

      if(! postInDataBase($id,$auteur,$this->connexion))
           return false;
       $sql = <<<EOD
       delete from posts
       where auteur=:auteur and id=:id
EOD;

      $stmt=$this->connexion->prepare($sql);
      $stmt->bindValue(":auteur",$auteur);
      $stmt->bindValue(":id",$id);
      $stmt->execute();

      updateUserPostsInfo("nbposts",$auteur,$this->connexion,"-");
      return $id;
    }



    function notePost($user,$id,$avis){
          if(! postInDataBase($id,"",$this->connexion) ||($avis!="like" && $avis!="nolike") )
              return false;
          elseif($avis=="like")
                $sql='update posts set nblikes=nblikes+1 where id=:id';
          else
                $sql='update posts set nbnolikes=nbnolikes+1 where id=:id';


          $stmt=$this->connexion->prepare($sql);
          $stmt->bindValue(":id",$id);
          $stmt->execute();
          updateUserPostsInfo("nb".$avis,$user,$this->connexion);
          return $id;

    }


    function createUser($pseudo,$password){


      if($this->getUser($pseudo)!=[])
           return false;
       $sql = <<<EOD
       insert into users
       (pseudo,password)
       values (:pseudo,:password)
EOD;

      $stmt=$this->connexion->prepare($sql);
      $stmt->bindValue(":pseudo",$pseudo);
      $stmt->bindValue(":password",password_hash($password,CRYPT_BLOWFISH));
      $stmt->execute();

      return $pseudo;
    }


    function updateProfil($mail,$description,$ville,$password,$pseudo){

      $infoToChange=notNullParams($mail,$description,$ville,$password);

      $sql="update users set ".$infoToChange["requete"];
      $sql.=" where pseudo =:pseudo";

      $stmt=$this->connexion->prepare($sql);
      $stmt->bindValue(":pseudo",$pseudo);
      foreach ($infoToChange["params"] as $key =>$value){
         $stmt->bindValue($value,${$value});
       }
      $stmt->execute();
      $res=$this->getUser($pseudo);

      if($res==[])
          return false;
      return $res;
    }

    function storeAvatar($imageSpec, $login){

        if(substr($imageSpec['mimetype'],0,5)!="image")
              return false;
        $sql = <<<EOD
        update users
        set avatar=:avatar,
        mimetype=:mimetype
        where login=:login
EOD;

      $stmt=$this->connexion->prepare($sql);
      $stmt->bindValue(':login',$login);
      $stmt->bindValue(':avatar',$imageSpec['data'],PDO::PARAM_LOB );
      $stmt->bindValue(':mimetype',$imageSpec['mimetype']);
      $stmt->execute();
      return true;

}

     function getAvatar($login){
            $requete = $this->connexion->prepare("select mimetype, avatar from users where login=:login");
            $requete->bindValue(':login',$login);
            $requete->execute();
            $requete->bindColumn('mimetype', $mimetype);
            $requete->bindColumn('avatar', $flux, PDO::PARAM_LOB);
            $res = $requete->fetch();
            if ($res){

                return ['data'=>$flux,'mimetype'=>$mimetype];
            }
            else { return false;} // pas de résultat.
          }





    }


    ?>

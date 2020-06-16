<?php
     require('lib/redirect_to_login.php');
 ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <meta charset="UTF-8"/>
    <title>Stations</title>
      <link rel="stylesheet" type="text/css" href="css/stations.css" />
     <script src="js/display_profil.js"></script>
  </head>
<body>
  <?php

      require('components/header.php');

  ?>
  <form name="upload_image" action="" method = "post" enctype="multipart/form-data">
   <fieldset>
      <legend>Nouvel avatar</legend>
      <input type="file" name="image" required="required"/>
      <button type="submit" name="valid" value="envoyer">Envoyer</button>
    </fieldset>
  </form>

 <form id="profil" action="" method="POST">
   <div > <img id="avatar" src="" alt="no image!"/> </div>
   <fieldset>
    <label for="nom">Nom :</label>
    <input type="text" name="nom" id="nom" value=""/> </input>
    <label for="pseudo">Pseudo :</label>
    <span id="pseudo"><?php echo $_SESSION['user']->pseudo?></span><br/>
    <label for="nbposts">Nombre de posts :</label>
    <span id="nbposts"></span><br/>
    <label for="nbavis">Nombre de Stations notées :</label>
    <span id="nbavis"></span><br/>
    <label for="total">Nombre de notes données en global :</label>
    <span id="total"></span><br/>
    <label for="nblike">Nombre de likes :</label>
    <span id="nblike"></span><br/>
    <label for="nbnolike">Nombre de dislikes :</label>
    <span id="nbnolike"></span><br/>
    <label for="ville">Ville :</label>
    <input type="text" name="ville" id="ville" value=""/> </input>
    <label for="email">Email: </label>
    <input type="email" name="mail" id="mail"  /></input></div>
    <label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password" value=""> </input></br>
    <label for="description">Description :</label>
    <textarea name="description" id="description" /></textarea>

    <button  type="submit" style="display:none;" name="valid">Valider</button>
   </fieldset>
  </form>
    <button id="modifier" >Modifier</button>



<?php
   require('components/footer.php');
 ?>

</body>
</html>


<header>
<script  src="js/utils.js"> </script>
<script   src="js/action_logout.js"> </script>
<div class="header">
  <a href="#default" class="logo">Stations</a>
  <div class="header-right">
    <a class="active" id="accueil_active" href="index.php">Accueil</a>
    <a  id="recherche_content_active" href="recherche.php">Recherche</a>
    <?php
    require('lib/session_init.php');
     if(isset($_SESSION['user'])){
          $connectedUserMenu = <<<EOD
          <a id="posts_active" href="mesPosts.php">Mes posts</a>
          <a id="profil_active" href="monProfil.php">Mon profil</a>
          <a href="#about" id="logout">Deconnexion</a>
EOD;
}
     else{
          $connectedUserMenu ="<a href=\"signIn.php\">Sign in</a>".
          "<a href=\"signUp.php\">Sign up</a>";
        }

     echo $connectedUserMenu;
     ?>

  </div>
</div>


</header>

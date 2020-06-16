
<?php
   require('lib/session_init.php');
   if(isset($_SESSION['user'])){
          require('pageAccueil.php');
          exit();
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <meta charset="UTF-8"/>
    <title>Authentifiez-vous</title>
    <link rel="stylesheet" type="text/css" href="css/login.css" />
    <script src="js/utils.js"></script>
    <script src="js/action_login.js"></script>
</head>
<body>

<h2>Authentifiez-vous</h2>

<form method="POST" action="" id="form_login">
 <fieldset>
  <label for="login">Login :</label>
  <input type="text" name="login" id="login" required="required" autofocus/>
  <label for="password">Mot de passe :</label>
  <input type="password" name="password" id="password" required="required" />
  <button type="submit" name="valid">OK</button>
 </fieldset>
</form>
<p>Pas encore inscrit ? <a href="register.php">créez un compte.</a></p>
 <p id="error"></p>
</body>
</html>

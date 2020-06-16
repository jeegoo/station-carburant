<?php
/*
  Si la variable globale $erreurCreation est définie, un message d'erreur est affiché
  dans un paragraphe de classe 'message'
*/
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <meta charset="UTF-8"/>
    <title>Création d'utilisateur</title>
    <script src="js/utils.js"></script>
    <script src="js/action_signup.js"></script>
</head>
<body>
<h2>Demande de création d'un utilisateur</h2>

<?php
 if (isset($erreurCreation) && $erreurCreation)
   echo "<p class='message'>Le compte n'a pas pu être créé</p>";
?>

<form method="POST" action="" id="form_signup">
 <fieldset>
   <label for="pseudo">Pseudo :</label>
   <input type="text" name="pseudo" id="pseudo" required="required" autofocus/>
  <label for="password">Mot de passe :</label>
  <input type="password" name="password" id="password" required="required" />
  <button type="submit" name="valid">Sign up</button>
 </fieldset>
</form>
 <p id="result"></p>
</body>
</html>

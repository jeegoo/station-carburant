<?php
     require('lib/redirect_to_login.php');
 ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <meta charset="UTF-8"/>
    <title>Stations</title>
      <link rel="stylesheet" type="text/css" href="css/stations.css" />
      <link rel="stylesheet" type="text/css" href="css/mesPosts.css" />
    <script src="js/display_posts.js"></script>
  </head>
<body>
  <?php

      require('components/header.php');


  ?>
<p id="error"> </p>
 <section id="display_posts">
   <form id="posts" method="POST">
   </form>
 </section>



<?php
   require('components/footer.php');
 ?>

</body>
</html>

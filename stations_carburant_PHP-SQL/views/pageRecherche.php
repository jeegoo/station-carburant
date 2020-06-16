<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <meta charset="UTF-8"/>
    <title>Stations</title>
    <link rel="stylesheet" type="text/css" href="css/stations.css" />
    <link rel="stylesheet" type="text/css" href="css/mesPosts.css" />
    <link rel="stylesheet" type="text/css" href="css/rechechreStations.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="crossorigin=""/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="crossorigin="""></script>

    <script src="js/display_recherche.js"></script>
  </head>
<body>
  <?php
      require('components/header.php');
      if(isset($_GET["id"]))
         echo '<input type="hidden" value="'.$_GET["id"].'"></input>';

  ?>
  <section id="recherche_content">
    <div id="formulaire">
    <form id="recherche" method="GET" action="">
              <div>
                <div>
                    <fieldset>
                    <legend>Commune: </legend>
                    <input type="text"  name="commune"  required="required">
                  </fieldset>
                </div>
                <div>
                  <fieldset>
                  <legend >Carburants: </legend>

                    <label >Gazol</label>
                    <input type="checkbox" name="carburants[]" value="1" />
                    <label >SP95</label>
                    <input type="checkbox" name="carburants[]" value="2" />
                    <label >E85</label>
                    <input type="checkbox" name="carburants[]" value="3" />
                    <label >GPLc</label>
                    <input type="checkbox" name="carburants[]" value="4" />
                    <label >E10</label>
                    <input type="checkbox" name="carburants[]" value="5" />
                    <label >SP98</label>
                    <input type="checkbox" name="carburants[]" value="6" />
                  </fieldset>
                </div>
                <div>
                  <fieldset>
                  <legend>Rayon:</legend>
                  <input type="text"  name="rayon" value="1" >
                 </fieldset>
               </div>
               <div>
                  <input type="submit" value="Submit">
              </div>
            </div>
              </form>
    </div>
    <div id="carte">
    </div>
    <div id="station_data">
             <div id="description">
             </div>
              <form id="rating_form" method="POST">
              </form>

              <form id="posts" method="POST">
              </form>
    </div>

    </section>
    <?php

       if(isset($_SESSION['user']))
            echo '<input type="hidden" id="connected" ></input>';
       require('components/footer.php');
     ?>
    </body>
    </html>

<?php
/* argument : une liste (table) de coureurs.
*    chaque élément de la liste est une table associative avec les clés 'equipe','dossard', 'nom'
*  résultat : chaîne contenant le code HTML d'une table présentant ces infos
*/


function makeThead($centent){
     return "<thead>$centent</thead>";
}


/**
*renvoie le code html d'une balise th en html
*/
function makeTh($centent){
  //creer un element th d'une table contenant $n
  return "<th>$centent</th>";
}

/**
*renvoie le code html d'une balise td  avec attribut si attribut !='' sans attribut sinon
*/
function makeTd($content,$attribut=""){
    //creer un element td d'une table contenant $n
    if($attribut=="")
       return "<td>$content</td>";
    else
       return  "<td data-$attribut=\"$content\">$content</td>";
}

/**
*renvoie le code html d'une balise tr
*/
function makeTr($code){

        return "<tr> $code </tr>";
}
/**
*renvoie le code html d'une balise table
*/
function makeTable($centent){

   return "<table>$centent</table>";
}

function makeDiv($content,$class=""){
        if($classe !="")
               return "<div class=\"$class\">$content</div>";
        return "<div>$content</div>";


}

function best10StationstoHTML($bestStations){
   $info=["marque","adresse","nbnotes",
   "noteglobale","noteaccueil","noteservice"];
    $res = "";

    foreach ($info as $key)
        $res.=makeTh($key);
    $res=makeThead(makeTr($res));
    foreach ($bestStations as $station) {
       $ligne="";
       foreach ($info as $key )
           $ligne.=makeTd($station[$key]);
       $res.=makeTr($ligne);
    }

    return makeTable($res);
}


function postToHtml($post){
      $postcode=makeDiv("<img src=\"../images/avatar_def.png\">","post_img");
      foreach (["datecreation","auteur","contenu"] as $value)
            $postcode.=makeDiv($post[$value],"post_$value");
      return $postcode;

}

function allPostsToHTML($posts){

      $res="";
      foreach ($posts as $post)
           $res.=postToHtml($post);
      return $res;
}







function genericTableToHTML($table){
    if (count($table)==0){
        return "<p>table vide</p>";
    }
    $res = "<table><thead><tr>";
    foreach($table[0] as $attName=>$value){
        $res .="<td>{$attName}</td>";
    }
    $res .= "</tr></thead>\n<tbody>";
    foreach ($table as $ligne) {
        $res .= "<tr><td>". implode("</td><td>",$ligne). "</td></tr>\n";
    }
    $res .= "</tbody></table>\n";
    return $res;
}

/*
 * argument :  table associative avec les clés 'nom', 'couleur' 'directeur'
 * résultat : représentation HTML de ces informations (div contenant 3 span, par exemple)
 **/
function equipeToHTML($infoEquipe){
    return "<div><span>Équipe : {$infoEquipe['nom']}</span>, <span>couleur : {$infoEquipe['couleur']}</span>, <span>directeur : {$infoEquipe['directeur']}</span></div>";
}
function coureursToHTML($table){
    $res = '<table><thead><tr><td>dossard</td><td>nom</td></tr></thead><tbody>';
    foreach ($table as $coureur) {
        $res .= "<tr><td>{$coureur['dossard']}</td><td>{$coureur['nom']}</td></tr>";
    }
    $res .= '</tbody></table>';
    return $res;
}
function equipesToOptionsHTML($liste){
    $res="";
    foreach($liste as $info){
        $res .= "<option value='{$info['nom']}'>{$info['nom']} ({$info['couleur']})</option>\n";
    }
    return $res;
}
function coureursToOptionsHTML($liste){
    $res="";
    foreach($liste as $info){
        $res .= "<option value='{$info['dossard']}'>{$info['nom']} ({$info['dossard']})</option>\n";
    }
    return $res;
}

function etapesToOptionsHTML($liste){
    $res="";
    foreach($liste as $info){
        $res .= "<option value='{$info['numero']}'>{$info['numero']} - {$info['nom']}</option>\n";
    }
    return $res;
}

function etapesToHTML($table){
    $res = '<table><thead><tr><td>numéro</td><td>nom</td></tr></thead><tbody>';
    foreach ($table as $etape) {
        $res .= "<tr><td>{$etape['numero']}</td><td>{$etape['nom']}</td></tr>";
    }
    $res .= '</tbody></table>';
    return $res;
}


?>

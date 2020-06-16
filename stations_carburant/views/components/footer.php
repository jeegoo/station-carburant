<script>
function refrechActive(){
     var tab=["accueil","recherche_content","posts","profil"];
     var active=document.getElementsByClassName("active")[0];
     var elt;
     for(let e of tab){
            elt=document.getElementById(e);
            if(elt!=null){
                  active.removeAttribute("class");
                  document.getElementById(e+"_active").setAttribute("class","active");
                  return true;
            }
     }}
refrechActive();
</script>

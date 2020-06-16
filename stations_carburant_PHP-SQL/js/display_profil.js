window.addEventListener('load',initProfil);
var submit;
var modifier;
var avatar;
function initProfil(){
    sendUser();
    submit=document.querySelector('button[type="submit"]');
    avatar=document.getElementById("avatar");
    modifier=document.getElementById("modifier");
    modifier.addEventListener('click',editForm);
    document.forms.profil.addEventListener('submit',sendFormMonProfil);
}

function sendUser(){ // form event listener

    let pseudo=document.getElementById("pseudo").textContent;
    let url = 'services/findUtilisateur.php?pseudo='+pseudo;
    fetchFromJson(url, { method: 'get' })
    .then(processAnswer)
    .then(diplayMesInfos, errorMsg);

    url = 'services/.getAvatar.php?user='+pseudo;
    fetchFromJson(url, { method: 'get' })
    .then(processAnswer)
    .then(diplayMesInfos, errorMsg);

}


function editForm(){
        let inputsDisabled=document.querySelectorAll('*[disabled=""]');
        for (e of inputsDisabled){
             e.disabled=false;
        }

        submit.style.display="block";
        modifier.style.display="none";
}

function diplayMesInfos(info){

         let toSpan=["nbposts","nbavis","total","nblike","nbnolike"];
         let toInput=["nom","description","ville","mail"];
         for(let e of toSpan )
             displayInfo(e,info[e]);
         for(let e of toInput )
             displayInfo(e,info[e],true);
         displayInfo("password","",true);
}

function sendFormMonProfil(ev){
        ev.preventDefault();
        let args = new FormData(this);
        let url = 'services/updateProfil.php';
        fetchFromJson(url, { method: 'post', body: args, credentials: 'same-origin' })
        .then(processAnswer)
        .then(refrechContent, errorMsg);
}

function refrechContent(){
      sendUser();
      submit.style.display="none";
      modifier.style.display="block";
}

function errorMsg(error,emptyArg){


   var p  = document.getElementById("error");
   if(typeof(emptyArg) != 'undefined')
         p.textContent = "selectionner au moins un post à supprimer ";
   else
      p.textContent = "no post found  ";
}




function displayInfo(elt,content,value){
    var e=document.getElementById(elt);
    if(typeof(value) == 'undefined')
         e.textContent=content;
    else{
       e.disabled=true;
       e.value=content;
     }
}

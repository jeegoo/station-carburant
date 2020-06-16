
window.addEventListener('load',sendFromAccueil);

function sendFromAccueil(ev){ // form event listener

  ev.preventDefault(); // empêche l'envoi normal
  let url = 'services/findBestStations.php';
  fetchFromJson(url)
  .then(processAnswer)
  .then(displayAccueil, errorMsg);
}


function displayAccueil(info){
      function insertContent(keys,body,list){
            for (let line of list){
              let row = body.insertRow();
              for (let x of keys){
                let elt=row.insertCell();

                if(x=="marque"){
                      a=document.createElement('button');
                      a.type="submit";a.name="id";a.value=line.id;
                      a.textContent = line[x];
                      elt.appendChild(a);}
                else
                     elt.textContent = line[x];
              }
            }
      }
       let keys=["marque","nom","adresse","ville","nbnotes",
       "noteglobale","noteaccueil","	noteprix","noteservice"];
       document.forms.accueil.appendChild(listToTable(info,keys,insertContent));

}

function errorMsg(error){

     let p  = document.getElementById("error");
     p.innerHTML = "login ou mot  de passe incorrect ";
}

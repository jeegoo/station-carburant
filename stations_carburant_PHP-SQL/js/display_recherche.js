//Authors : KEBIR JUGURTHA
//          CHALABI ADIB

window.addEventListener("load",initStation);
var map,corrent_station_id,station_research,
    station_data,starsTotal,connected,ratingForm,
    corrent_posts,stat_description,likesAndDislikes;

function initStation(){
      dessinerCarte();
      starsTotal=5;
      connected=document.getElementById("connected");
      stat_description=document.getElementById("description");
      ratingForm=document.getElementById("rating_form");
      corrent_posts=document.getElementById("posts");
      let corrent_station=document.querySelector('input[type="hidden"]');
      station_research=document.getElementById("recherche_content");
      station_data=document.getElementById("station_data");
      if(corrent_station != null){
           corrent_station_id=corrent_station.value;
           fetchStation(corrent_station_id,displayStation);}


     document.forms.recherche.addEventListener('submit',fetchSearchedStations);
     corrent_posts.addEventListener("submit",fetchCreatePost);
     ratingForm.addEventListener("submit",fetchNoteStation);
}

function dumpThisElement(elt){

   if(elt!=null)

      elt.textContent="";
}

function dessinerCarte(){

     map = L.map('carte').setView([50.60976, 3.13909], 16);

    // ajout du fond de carte OpenStreetMap
    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    map.on("popupopen",activerBouton);

}

function fetchStation(id,displayFunction){
      let url='services/findStation.php?id='+id;
      fetchFromJson(url,{method:'get'}).then(processAnswer).then(displayFunction,errorMsg);
}

function fetchSearchedStations(ev){
      ev.preventDefault();
      let args=new FormData(this);
      let commune=args.get("commune");
      let rayon=args.get("rayon");
      let carburants=args.getAll("carburants[]").join(',');
      let url=`http://webtp.fil.univ-lille1.fr/~clerbout/carburant/recherche.php?
      commune=${commune}&carburants=${carburants}&rayon=${rayon}`;
      fetchFromJson(url,{method:'get'}).then(processAnswerStationDescription).then(placerMarqueurs,errorMsg);

}

function fetchCreatePost(ev){
    ev.preventDefault();
    let args=new FormData(this);
    args.append("station",corrent_station_id);
    let url = 'services/createPost.php';
    fetchFromJson(url, { method: 'post', body: args, credentials: 'same-origin' })
    .then(processAnswer)
    .then(fetchStationPosts, errorMsg);
}

function fetchNoteStation(ev){
      ev.preventDefault();
      let args=new FormData(this);
      args.append("id",corrent_station_id);
      let url = 'services/noteStation.php';
      fetchFromJson(url, { method: 'post', body: args, credentials: 'same-origin' })
      .then(processAnswer)
      .then(displayRatingInfo, errorMsg);
}

function fetchNotePost(){
      let args=new FormData();
      args.append("id",this.parentNode.dataset.id);
      args.append("avis",this.firstChild.dataset.value);
      let url = 'services/notePost.php';
      fetchFromJson(url, { method: 'post', body: args, credentials: 'same-origin' })
      .then(processAnswer)
      .then(fetchStationPosts, errorMsg);
}

function fetchStationPosts(){
     let url='services/findPosts.php?id='+corrent_station_id;
     fetchFromJson(url,{method:'get'}).then(processAnswer).then(displayStationPost,errorMsg);
}

function fetchStationDescription(){
  let url='http://webtp.fil.univ-lille1.fr/~clerbout/carburant/infoStation.php?id='+corrent_station_id;
  fetchFromJson(url,{method:'get'}).then(processAnswerStationDescription).then(displayStationDescription,errorMsg);
}

function activerBouton(ev) {
    var noeudPopup = ev.popup._contentNode; // le noeud DOM qui contient le texte du popup
    var bouton = noeudPopup.querySelector("button"); // le noeud DOM du bouton inclu dans le popup
    bouton.addEventListener("click",boutonActive); // en cas de click, on déclenche la fonction boutonActive
}

function boutonActive() {
    // this est ici le noeud DOM de <button>. La valeur associée au bouton est donc this.value
    fetchStation(this.value,displayStationInfo);

}

function processAnswerStationDescription(answer){

         if (answer.status!="ok")
               throw new Error("nothing found");
          return answer.data;
}

function errorMsg(error,emptyArg){

   console.log(error);
}

function setRatings(elt,rating,starsTotal) {

        // Get percentage
        const starPercentage = (rating / starsTotal) * 100;

        // Round to nearest 10
        const starPercentageRounded  = `${Math.round(starPercentage / 10) * 10}%`;

        // Set width of stars-inner to percentage
        elt.style.width = starPercentageRounded;

    }

function createRatingSystem(rating,starsTotal){
      let div =document.createElement("div");
      div.className="stars-outer";
      let div2=document.createElement("div");
      div2.className="stars-inner";
      setRatings(div2,rating,starsTotal);
      div.appendChild(div2);

      return div;
}

function displayRatingInfo(info){
      function insertRatingContent(keys,body,list){
            for(let key of keys){
                  let striped=key.substr(4);
                  row=body.insertRow();
                  row.insertCell().textContent=striped;
                  if(key != "noteglobale"){
                        row.className=key;
                        row.insertCell().appendChild(createRatingSystem(info[0][key],starsTotal));
                      }
                  else { striped="global";}
                  row.insertCell().textContent='( '+info[0][key]+' )';
                  if(connected)
                        row.insertCell().appendChild(makeDiv(`<input type="number" name=${striped} class="rating-control" \
                  step="0.1" max="5" placeholder="Rate 1 - 5" ></input>`));
            }
            if(connected)
                body.insertRow().insertCell().appendChild(makeInput("valider","submit","noter"));
            else
                body.insertRow().insertCell().appendChild(makeDiv('<a href="pageLogin.php">Je note </a>'));
        }

      dumpThisElement(ratingForm);
      let keys=["noteglobale","noteaccueil","noteprix","noteservice"];
      let table=listToTable(info,keys,insertRatingContent,["Avis de clients : "]);
      table.className="station_rating";
      ratingForm.appendChild(table);

}

function createPostingArea(){

      let comment=makeDiv("<h4>Laisser un commentaire :</h4><label>Titre : </label>");
      let title=makeInput("titre","text","");
      let postComment=makeDiv("Commentaire : </label>")
      let textarea=document.createElement("textarea");
      textarea.cols="50";
      textarea.name="contenu";
      comment.appendChild(title);
      comment.appendChild(postComment);
      comment.appendChild(textarea);
      comment.appendChild(makeInput("poster","submit","Poster"));
      return comment;
}


function displayStationPost(info){
      function activeLikesNdislikes(){
            likesAndDislikes=document.getElementsByClassName("reacte_post");

            for(let e of likesAndDislikes)
                 e.addEventListener("click",fetchNotePost) ;
      }
          //vider les posts
      dumpThisElement(corrent_posts);
      let posts=displayPosts(info,function(post,line){post.setAttribute('data-id',line.id);});
      corrent_posts.appendChild(posts);
      if(connected !=null){
           activeLikesNdislikes();
           posts.appendChild(createPostingArea());

         }
      else
           posts.appendChild(makeDiv('<a href="pageLogin.php">Je commente</a>'));


}

function placerMarqueurs(l) {
   var id,insee,lat,lon,button,texte,point;
   var pointList= [];
   for (var i=0; i<l.length; i++){ // pour chaque ligne, insertion d'un marqueur sur la carte
         id = l[i].id;
         insee = l[i].cp;
         lat=l[i].latitude;
         lon=l[i].longitude;
         button="<button type=\"button\" value=\""+id+"\">Choisir</button>";
         texte = "<p>identifiant:"+id +"</p><p>latitude :"+lat+"</p><p>longitude:"+lon+"</p>"+button;
        // insertion du marqueur selon les coordonnées trouvées dans les attributs data-lat et data-lon :
         point = [lat,lon];
        L.marker(point).addTo(map).bindPopup(texte);
        pointList.push(point);
   }
   // ajustement de la zone d'affichage de la carte aux points marqués
    map.fitBounds(pointList);
}

function displayStationInfo(info){
      dumpThisElement(ratingForm);
      dumpThisElement(corrent_posts);
      dumpThisElement(description);
      corrent_station_id=info[0].id;
      displayRatingInfo(info);
      fetchStationDescription(info[0].id);
      fetchStationPosts();
}

function displayStationDescription(description){
      function descContent(keys,body,list){
        for (let line of list){
          let row = body.insertRow();
          for (let x of keys){
            let elt=row.insertCell();
            elt.textContent=line[x];
          }
    }}
      let services,div,price;
      price=listToTable(description.prix,Object.keys(description.prix[0]),descContent);
      div=makeDiv("<h4>Les Prix :</h4>");
      div.className="price";
      div.appendChild(price);
      stat_description.appendChild(div);
      if(description.services.length!=0){
            services=makeUlList(description.services);
            div=makeDiv("<h4>Les Services :</h4>");
            div.className="services";
            div.appendChild(services);
            stat_description.appendChild(div);}


}

function displayStation(info){
       //station_research.get
       placerMarqueurs(info);
       displayStationInfo(info);
}

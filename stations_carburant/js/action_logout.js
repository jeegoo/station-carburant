
window.addEventListener('load',initLogout);

function initLogout(){
  let logout=document.getElementById("logout");
  if(logout!=null)
     logout.addEventListener('click',sendLogout);
}

function sendLogout(ev){ // form event listener

  ev.preventDefault();
  let url = 'services/logout.php';
  fetchFromJson(url)
  .then(processAnswer)
  .then(displayInfoEtape, displayErrorEtape);
}


function displayInfoEtape(etapeInfo){
       document.location.href="logout.php";

}

function displayErrorEtape(error){

  let p = document.createElement('p');
  p.innerHTML = error.message;
  let cible  = document.querySelector('body');
//  cible.textContent=''; // effacement
  cible.appendChild(p);
}

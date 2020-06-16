
window.addEventListener('load',initLogin);

function initLogin(){
  document.forms.form_login.addEventListener('submit',sendFormLogin);
}

function sendFormLogin(ev){ // form event listener

  ev.preventDefault(); // empêche l'envoi normal
  let args = new FormData(this);
  let url = 'services/login.php';
  fetchFromJson(url, { method: 'post', body: args, credentials: 'same-origin' })
  .then(processAnswer)
  .then(redirect, errorMsg);
}


function redirect(info){
       document.location.href="index.php";

}

function errorMsg(error){
     console.log(error);
     let p  = document.getElementById("error");
     p.innerHTML = "login ou mot  de passe incorrect ";
}

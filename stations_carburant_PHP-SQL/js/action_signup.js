
window.addEventListener('load',initSignup);

function initSignup(){
  document.forms.form_signup.addEventListener('submit',sendFormSignup);
}

function sendFormSignup(ev){ // form event listener

  ev.preventDefault(); // empêche l'envoi normal
  let args = new FormData(this);
  let url = 'services/createUtilisateur.php';
  fetchFromJson(url, { method: 'post', body: args, credentials: 'same-origin' })
  .then(processAnswer)
  .then(redirect, errorMsg);
}


function redirect(info){
       let p  = document.getElementById("result");
       p.innerHTML = "Le compte a été bien créé !! redirection en cours ...";
       setTimeout(function(){document.location.href="signIn.php";}, 1000);


}

function errorMsg(error){
        let p  = document.getElementById("result");
        p.innerHTML = "pseudo deja pris !!";
}

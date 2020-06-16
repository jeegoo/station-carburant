
window.addEventListener('load',initPost);
var posts;
function initPost (){
       posts=document.getElementById("posts");
       sendFormMesPosts();
}

function sendFormMesPosts(){ // form event listener

  let url = 'services/findMesPosts.php';
  fetchFromJson(url, { credentials: 'same-origin' })
  .then(processAnswer)
  .then(desplayMesPosts, errorMsg);
}



function desplayMesPosts(info){
   function addCheckBoxBotton(post,line){
            post.appendChild(makeCeckBoxButton(line.id));
   }
    posts.appendChild(displayPosts(info,addCheckBoxBotton));
    posts.appendChild(makeDiv('<input type="submit" value="remove"></input>','remove'));
    posts.addEventListener("submit",deletePost);
    document.getElementById("display_posts").appendChild(posts);
}

function deletePost(ev){
    ev.preventDefault(); // empêche l'envoi normal
    let args=formDataToQueryString(new FormData(this)).split("&");
    for(arg of args){
        if(arg==""){
             return errorMsg(error,true);
        }
        let url = 'services/deletePost.php?'+arg;
          fetchFromJson(url, { method:'get',credentials: 'same-origin' });
}
        postDeleted();
}

function postDeleted(){

   document.forms.posts.textContent = "";

   sendFormMesPosts();
}
function errorMsg(error,emptyArg){
   var p  = document.getElementById("error");
   if(typeof(emptyArg) != 'undefined')
         p.textContent = "selectionner au moins un post à supprimer ";
   else
      p.textContent = "no post found  ";
}

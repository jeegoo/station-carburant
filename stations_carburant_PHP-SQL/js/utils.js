
  /*
 *   get query string from FormData object
 *   fd : FormData instance
 *   returns : query string with fd parameters (without initial '?')
 */
function formDataToQueryString (fd){
  return Array.from(fd).map(function(p){return encodeURIComponent(p[0])+'='+encodeURIComponent(p[1]);}).join('&');
}

{
  let makeFetchFunction = function (type){
    let processResponse = function(response){ if (response.ok) return response[type](); throw Error(response.statusText); };
    return function(...args){ return fetch(...args).then(processResponse); };
  };
  /*
   *   Fetch functions :
   *      same arguments as fetch()
   *      each function returns a Promise resolving as received data
   *      each function throws an Error if not response.ok
   *   fetchText : returns Promise resolving as received data, as string
   *   fetchObject : returns Promise resolving as received data, as object (from JSON data)
   *   fetchFromJson : fetchFromObject alias
   *   fetchBlob : returns Promise resolving as received data, as Blob
   *     ...
   */
  var fetchObject = makeFetchFunction('json');
  var fetchFromJson = fetchObject;
  var fetchBlob = makeFetchFunction('blob');
  var fetchText = makeFetchFunction('text');
  var fetchArrayBuffer = makeFetchFunction('arrayBuffer');
  var fetchFormData = makeFetchFunction('formData');
}

function processAnswer(answer){
    
     if (answer.status!="ok")
            throw new Error('Error');
     return answer.result;

}

function make_img(src){

      return '<img src="'+src+'" alt="not found"/>';
}

function makeDiv(content,classe){
       let div=document.createElement('div');
       div.innerHTML=content;
       if(typeof(classe) != 'undefined')
             div.className=classe;
       return div;
}


function displayPosts(info,insertSomeProperties){
      // document.getElementById("error").textContent="";
       //let form=makeForm("posts","POST");

       let div=makeDiv("<h4>Commentaires :</h4>")
       let post=makeDiv("","post");
       for (let line of info){
            post.appendChild(makeDiv(make_img("images/avatar_def.png"),"img_post"));
            post.appendChild(makeDiv("posté le :"+line.datecreation,"date_post"));
            post.appendChild(makeDiv(line.auteur,"auteur_post"));
            post.appendChild(makeDiv(line.contenu,"contenu_post"));
            post.appendChild(makeDiv(line.nblikes,"nblikes_post"));
            post.appendChild(makeDiv('<a href="#" data-value="like">'+make_img("images/like.png")+'</a>',"like_post reacte_post"));
            post.appendChild(makeDiv(line.nbnolikes,"nbdislikes_post"));
            post.appendChild(makeDiv('<a href="#" data-value="nolike">'+make_img("images/dislike.png")+'</a>',"dislike_post reacte_post"));
            insertSomeProperties(post,line);
            div.appendChild(post);
            post=makeDiv("","post");
          }
          return div;

}

function makeUlList(data,name){

     let ul=document.createElement("ul"),li;
     for (let e of data){
        li= document.createElement("li");
        li.textContent=e;
        ul.appendChild(li);  }
     return ul;
}

function makeForm(id,methode){
    let form=document.createElement("form");
    form.setAttribute("id",id);
    form.method=methode;
    return form;

}

function listToTable(list,keys,insertContent,head){
  let table = document.createElement('table');
  let row = table.createTHead().insertRow();
  let elt,a,headerElts;
  if(typeof(head)!="undefined")
      headerElts=head;
  else
      headerElts=keys;
  for (let x of headerElts){
    let th=document.createElement('th');
    th.textContent = x;
    row.appendChild(th);}
  let body = table.createTBody();
  insertContent(keys,body,list);
  return table;
}

function makeInput(name,type,value){
      let input=document.createElement("input");
      input.name=name;
      input.value=value;
      input.type=type;
      return input;
}
function makeCeckBoxButton(id){
    return makeDiv('<input type="checkbox" name="id" value="'+id+'"></input>',"delete_post");
}

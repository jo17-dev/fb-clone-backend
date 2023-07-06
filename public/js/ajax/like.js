// this will manage the likes system: printing an modify it
// ce fichier doit savoir si l'user a déjas liker ou non une page
var likes = document.querySelectorAll('.like-btn');

likes.forEach(item =>{
    var id_post = item.value;

    if(window.XMLHttpRequest){ // chrome
        xhr = new XMLHttpRequest();
    }else{ // ie, others
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }

    var csrfToken = document.getElementsByName("csrf-token")[0].content; // take the csrf-token value
    var userId = document.getElementsByName("session")[0].content; // take id of the authenticated user 

    // initiate an send the data via get method

    xhr.open("POST", "/api/likes" , true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.send("_token="+csrfToken+"&id_post="+id_post+"&id_user="+userId);

    xhr.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200 ){ // if evrythings the data transfert is successfull
            let result = JSON.parse(this.responseText);

            item.innerText += " "+result.likes_number; // we add the likes number to the DOM
        }
    }
});

// Code For like /displike a post

likes.forEach(item =>{
    item.addEventListener('click', function(){
        var id_post = item.value;

        if(window.XMLHttpRequest){ // chrome
            xhr = new XMLHttpRequest();
        }else{ // ie, others
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        }
    
        var csrfToken = document.getElementsByName("csrf-token")[0].content; // take the csrf-token value
        var userId = document.getElementsByName("session")[0].content; // take id of the authenticated user 
    
        // initiate an send the data via get method
    
        xhr.open("GET", "/api/likes?id_post="+id_post+"&id_user="+userId , true);
        xhr.send();
    
        xhr.onreadystatechange = function () {
            if(this.readyState == 4 && this.status == 200 ){ // if evrythings the data transfert is successfull
                let result = JSON.parse(this.responseText);
    
                item.innerText = "like "+result.likes_number; // we add the likes number to the DOM
            }
        }
    })
});

var likes = document.querySelectorAll('.like-btn');

likes.forEach(item =>{
    
    if(window.XMLHttpRequest){ // chrome
        xhr = new XMLHttpRequest();
    }else{ // ie, others
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }

    var id_comment = item.value; // take the id value of this comment

    var userId = document.getElementsByName("session")[0].content; // take id of the authenticated user 

    item.addEventListener('click', function(){
    
        // initiate an send the data via get method
    
        xhr.open("GET", "/api/likescomment?id_comment="+id_comment+"&id_user="+userId , true);
        xhr.send();
    
        xhr.onreadystatechange = function () {
            if(this.readyState == 4 && this.status == 200 ){ // if evrythings the data transfert is successfull
                let result = JSON.parse(this.responseText);

                console.log("Fait avec succes"+result.liked);
    
                item.innerText = "like "+result.likes_number; // we add the likes number to the DOM
            }
        }
    })
/* Here we retreive the likes numbers for each comments
* Here we have an additional argument: type=likes_nber : as this two request
* will be manage with the same 
LikeController::like_comment, thi will indicate the operation to do on each cases */

    xhr.open("GET", "/api/likescomment?id_comment="+id_comment+"&id_user="+userId+"&retreive_likes=1" , true);
    xhr.send();

    xhr.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200 ){ // if evrythings the data transfert is successfull
            let result = JSON.parse(this.responseText);

            // console.log("Success retreiving "+result.liked);

            item.innerText = "like "+result.likes_number; // we add the likes number to the DOM
        }
    }
});
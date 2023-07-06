

function friendshipDecision(decision, id_notification, target){
    if(window.XMLHttpRequest){ // chrome
        xhr = new XMLHttpRequest();
    }else{
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    var csrfToken = document.getElementsByName("csrf-token")[0].content, // take the csrf-token value
        params = "_token="+csrfToken+"&id_notification="+id_notification+"&decision="+decision;
    
    // initiate an send the date via post method
    xhr.open("GET", "/notification/friendship?"+params , true);

    xhr.send();
    
    xhr.onreadystatechange = function () {
        console.log(this.readyState);
        if(this.readyState == 4 && this.status == 200 ){ // if evrythings the data transfert is successfull
    
            let result = JSON.parse(this.responseText);
            console.log(result.done);
            target.remove();
        }
    }
}
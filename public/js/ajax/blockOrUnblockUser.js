
function toogleBlock(id_discution){
    if(window.XMLHttpRequest){ // chrome
        xhr = new XMLHttpRequest();
    }else{ // ie, others
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    var csrfToken = document.getElementsByName("csrf-token")[0].content; // take the csrf-token value
    var userId = document.getElementsByName("session")[0].content; // take id of the authenticated user 
    
    // initiate an send the data via get method
    
    xhr.open("POST", "/api/discution" , true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.send("_token="+csrfToken + "id_discution="+id_discution + "&id_user="+userId);
    
    xhr.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200 ){ // if evrythings the data transfert is successfull
            let result = JSON.parse(this.responseText);
            console.log("Fait proprement");
            // item.innerText = "like "+result.likes_number; // we add the likes number to the DOM
        }
    }
}
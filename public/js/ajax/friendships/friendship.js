// this file is to search an user(s) by his username via Ajax an print it

var senderId = document.getElementsByName("session")[0].content;

// elements are the db informations , parent is the parent tag identification...
function addInDom(elements, parent){

    let tag = "li"; // this is the tag who'll be use to print each data

    var inviteBtn = document.createElement("button"); // this is the invite/discuss button
    inviteBtn.innerText = "Invite" ;
    inviteBtn.setAttribute("class","invite-btn");

    for(let i=0; i<elements.length; i++ ){
            let item = elements[i];
    // this user is already in frienship with the current user, invite btn become discuss btn
            if(item['is_friend'] == true){
                inviteBtn.innerText = "Discuss";
                tag = "a";
            }

            // we should not print the current user data
            if(item['id'] == senderId){
                continue;
            }

            console.log(item['is_friend']);


            inviteBtn.setAttribute("value", item['id']);
            inviteBtn.setAttribute("onclick", "invite(this.value, senderId)");

            let child = document.createElement(tag);
            if(tag == "a"){
                child.setAttribute("href", "/discution/"+item['id']);
            }
            child.appendChild(inviteBtn);
            child.innerHTML += ' ' + item['username'] + ' ' + item['email']+ ' ';
            parent.appendChild(child);
            tag = "li";
    }
    console.log(elements.length+ " element(s)");
}


function search_users(data){

    // Here we'll do an AJAX request to retreive the data about the users form the database to print it

// initiate a XMLHttpRequest depending on the browser
    if(window.XMLHttpRequest){ // chrome
        xhr = new XMLHttpRequest();
    }else{
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }

    var csrfToken = document.getElementsByName("csrf-token")[0].content; // take the csrf-token value

// initiate an send the date via post method
    xhr.open("POST", "/api/friendship" , true);
    xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
    xhr.send("_token="+csrfToken+"&username="+data+"&senderId="+senderId);

    xhr.onreadystatechange = function () {
        console.log(this.readyState);
        if(this.readyState == 4 && this.status == 200 ){ // if evrythings the data transfert is successfull

            let result = JSON.parse(this.responseText);

            return addInDom(result.users, document.getElementById('result'));
        }
    }
}

// event for send the data to the friendship controller

document.getElementById('search-btn').addEventListener("click", ()=>{

    document.getElementById('result').innerHTML = ' ';
    search_users(document.getElementById('userSearch').value);
});


// ***************** Here is donne the friendship invitation where we click on "invite" btn

    // this function send an the current id to friendshipController::invite to find this user an send it an invitation
var invite = function(receiverId, senderId)
{
    console.log("SenderId: "+senderId);
    console.log("receiver Id "+ receiverId);
    // Here we'll do an AJAX request to retreive the data about the users form the database to print it
    // initiate a XMLHttpRequest depending on the browser
    if(window.XMLHttpRequest){ // chrome
        xhr = new XMLHttpRequest();
    }else{
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }

    console.log("receiver id: "+receiverId);

    // initiate an send the data via get method

    xhr.open("GET", "/api/friendship/"+receiverId+"/"+senderId , true);
    xhr.send();

    xhr.onreadystatechange = function () {
        console.log(this.readyState);
        if(this.readyState == 4 && this.status == 200 ){ // if evrythings the data transfert is successfull
            let result = JSON.parse(this.responseText);
            console.log(result.notification_sended)
            // return result.notification_sended;
        }
    }
}
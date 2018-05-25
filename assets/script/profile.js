var changebtn = document.querySelector(".changebtn");
changebtn.onclick = editProfile;

var cancelbtn = document.querySelector(".cancelbtn");
cancelbtn.onclick = cancel;

var savebtn = document.querySelector(".savebtn");

var passbtn = document.querySelector(".passbtn")
var deletebtn = document.querySelectorAll(".deletebtn");
console.log(passbtn);
for (var i = 0; i < deletebtn.length; i++) {
    deletebtn[i].onclick = function () {
        deleteArticle(this);
    }
}

var defautuser = {
    "lastname": "Dupond",
    "username": "Jean-Dupond42",
    "firstname": "Jean",
    "email": "Jean-Dupond42@gmail.com",
    "birthday": "15 novembre 1989",
    "description": "aime les ponts"

}
function editProfile() {
    var input = document.querySelectorAll(".movable");
    for (var i = 0; i < input.length; i++) {
        var classList = input[i].classList;
        var name = input[i].getAttribute("name");
        var newinput = document.createElement("input");
        if (name == "description") {
            var newinput = document.createElement("textarea");
            newinput.innerHTML = user[name];
        }
        newinput.setAttribute("value", (user[name]));
        newinput.classList = classList;
        newinput.name = name;
        parentElement = input[i].parentElement;
        parentElement.replaceChild(newinput, input[i]);
    }
    changebtn.classList += " none";
    cancelbtn.classList.remove("none");
    passbtn.classList += " none";
    savebtn.classList.remove("none");
    return false;
}
function cancel() {
    var input = document.querySelectorAll(".movable");
    for (var i = 0; i < input.length; i++) {
        var classList = input[i].classList;
        var nameattr = input[i].getAttribute("name");
        var newinput = document.createElement("p");
        newinput.classList = classList;
        newinput.setAttribute("name", nameattr);
        if (user[nameattr] === "") {
            newinput.innerHTML = defautuser[nameattr];
        }
        else {
            newinput.innerHTML = user[nameattr];
        }
        parentElement = input[i].parentElement;
        parentElement.replaceChild(newinput, input[i]);
    }
    changebtn.classList.remove("none");
    cancelbtn.classList += " none";
    passbtn.classList.remove("none");
    savebtn.classList += " none";
    return false;
}
function json(response) {
    return response.json()
}
function deleteArticle(btn) {
    var userId = btn.id;
    /([0-9]+)/.exec(userId);
    var id = (RegExp.$1);
    var url = '?action=deleteArticle&id=' + id;
    fetch(url, {
        method: 'get',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        credentials: 'include'
    })
        .then(json)
        .then(function (data) {
            if (data.status === "ok") {
                var el = document.getElementById(userId);
                var parent = el.parentNode;
                while (parent.firstChild) {
                    parent.removeChild(parent.firstChild);
                }
            }
        })
        .catch(function (error) {
            console.log('Request failed', error);
        });
}
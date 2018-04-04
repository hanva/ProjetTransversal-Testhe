var dataArray = [];
var login = document.querySelector(".login");
var logpop = document.querySelector('.loginpopup');
var register = document.querySelector(".register");
var registerpop = document.querySelector(".registerpopup");

function getRequest(url, action = "") {
    var request = new XMLHttpRequest();
    request.open('GET', url, true);
    request.onload = function () {
        data = (request.responseText);
        dataArray.push(data);
        if (action)
            action(data);
    }
    request.send();
}
function popup(data) {
    login.innerHTML += dataArray[0];
    register.innerHTML += dataArray[1];
    var loginform = document.querySelector(".loginform");
    var registerform = document.querySelector(".registerform");
    login.onclick = function () {
        loginform.classList.remove("none");
        registerform.classList += " none";
    }
    register.onclick = function () {
        registerform.classList.remove("none");
        loginform.classList += " none";
    }
}
getRequest('./popup/login.html');
getRequest('./popup/register.html', popup);
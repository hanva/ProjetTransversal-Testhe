var dataArray = [];
var login = document.querySelector(".login");
var register = document.querySelector(".register");
var popup = document.querySelector(".popup");

function getRequest(url, action = "") {
    var request = new XMLHttpRequest();
    request.open('GET', url, true);
    request.onload = function () {
        data = (request.responseText);
        dataArray.push(data);
        if (action) {
            printpop(dataArray);
        }
    }
    request.send();
}
function printpop(data) {
    login.onclick = function () {
        popup.innerHTML = dataArray[0];
        popup.classList.remove("none");
    }
    register.onclick = function () {
        popup.innerHTML = dataArray[1];
        popup.classList.remove("none");
        testcool("ok");
    }
}
getRequest('./popup/login.html');
getRequest('./popup/register.html', popup);
var dataArray = [];
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
    register.onclick = function () {
        popup.innerHTML = dataArray[1];
        popup.classList.remove("none");
        emailverif();
        var closePopup = document.querySelector(".close-popup");
        var btn = document.querySelector(".registerbtn");
        var login = document.querySelector(".login");
        console.log(login);
        login.onclick= function () {
          printLogin();
        };
        btn.onclick = function () {
            createAccount();
        };
        closePopup.onclick = function () {
            closePop();
        };
    }
}
function printLogin() {
    popup.innerHTML = dataArray[0];
    popup.classList.remove("none");
    var passwordForgoten = document.querySelector(".passwordForgoten");
    return passwordForgoten;
    
}
function closePop() {
    popup.classList.add("none");
}
function emailverif() {
    // document.forms['register-form'].elements['username'].focus();
    var blockErrors = document.querySelector(".blockErrors");
    document.querySelector(".emailinput").onkeyup = function () {
        var emailRegEx = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (false === emailRegEx.test(this.value)) {
            blockErrors.innerHTML = 'Saisir un email valide <br>';
        } else {
            blockErrors.innerHTML = '';
        }
    }
}
function json(response) {
    return response.json()
}
function changePassword() {
    return false;
    var email = document.querySelector(".email")
    var url = '?action=changePassword';
    fetch(url, {
        method: 'post',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'email=' + email,
        credentials: 'include'
    })
        .then(json)
        .then(function (data) {
            console.log(data);
        })
        .catch(function (error) {
            console.log('Request failed', error);
        });
}
function createAccount() {
    var email = document.querySelector(".emailinput").value;
    var nickname = document.querySelector(".nicknameinput").value;
    var password = document.querySelector(".passwordinput").value;
    var errorMessage = '';
    var blockErrors = document.querySelector(".blockErrors");
    if (6 > email.length) {
        errorMessage += 'Email non valide <br>';
    }
    if (4 > nickname.length) {
        errorMessage += 'Saisir 4 caractères minimum pour le pseudo <br>';
    }
    if (6 > password.length) {
        errorMessage += 'Saisir 6 caractères minimum pour le mot de passe<br>';
    }
    if (0 !== errorMessage.length) {
        blockErrors.innerHTML = errorMessage;
        return false;
    }
    else {
        var url = '?action=createAccount';
        fetch(url, {
            method: 'post',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: 'email=' + email + '&username=' + nickname + '&password=' + password,
            credentials: 'include'
        })
            .then(json)
            .then(function (data) {
                console.log(data);
            })
            .catch(function (error) {
                console.log('Request failed', error);
            });
    };
}

getRequest('./popup/login.html');
getRequest('./popup/register.html', popup);
getRequest('./popup/passwordForgoten.html');
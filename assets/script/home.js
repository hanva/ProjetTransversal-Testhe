var dataArray = [];
var register = document.querySelector(".printregisterbtn");
var popup = document.querySelector(".popup");
var login = document.querySelector(".loginbtn");
var pass = document.querySelector(".passwordforgotenbtn");
var popregister = document.querySelector(".register-content")
var poppassword = document.querySelector(".password-content")
var loginpop = document.querySelector(".login-content")

register.onclick = function () {
    printRegister();
}
function printRegister() {
    switchClass(popregister, loginpop, poppassword);
    openPop();
    login.onclick = function () {
        printLogin();
    }
    var registerbtn = document.querySelector(".registerbtn");
    registerbtn.onclick = function () {
        createAccount();
    }
    var closepop = document.getElementById("cross");
    closepop.onclick = function () {
        closePop(popregister);
    }

};
function printLogin() {
    switchClass(loginpop, popregister, poppassword);
    var popbtn = document.querySelectorAll(".printregisterbtn")[1];
    popbtn.onclick = function () {
        printRegister();
    }

    var passwordbtn = document.querySelector(".passwordForgoten");
    passwordbtn.onclick = function () {
        printPassword();
    }
    var loginbtn = document.querySelector(".login-btn");
    loginbtn.onclick = function () {
        loginAction();
    }
    var close = document.getElementById("cross");
    console.log(close);
    close.onclick = function () {
        closePop(loginpop);
    }


}
function printPassword() {
    switchClass(poppassword, loginpop, popregister);
    var login = document.querySelector(".passwordNotForgoten");
    login.onclick = function () {
        printLogin();
    }
    var passbtn = document.querySelector(".forgotpasswordbtn");
    passbtn.onclick = function () {
        askNewPassword();
    }
    var popbtn = document.querySelectorAll(".printregisterbtn")[1];
    popbtn.onclick = function () {
        printRegister();
    }
    var close = document.getElementById("cross");
    console.log(close);
    close.onclick = function () {
        closePop(poppassword);
    }
}
function switchClass(first, second, third) {
    first.classList.remove("none");
    first.classList += " flex";
    if (second.classList.contains("flex")) {
        second.classList.remove("flex");
        second.classList += " none";
    }
    if (third.classList.contains("flex")) {
        third.classList.remove("flex");
        third.classList += " none";
    }
}
function closePop(el) {
    popup.classList.add("none");
    if (el.classList.contains("flex")) {
        el.classList.remove("flex");
        el.classList += " none";
    }
}
function openPop() {
    if (popup.classList.contains("none")) {
        popup.classList.remove("none");
    }
}


function json(response) {
    return response.json()
}
function askNewPassword() {
    var email = document.querySelector(".emailpassword").value;
    var blockSucess = document.querySelector(".blockSucess");
    var url = '?action=passwordForgoten';
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
            blockSucess.innerHTML = data.email;
        })
        .catch(function (error) {
            console.log('Request failed', error);
        });
}
function changePassword() {
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
function loginAction() {
    var username = document.querySelector(".login-username").value;
    var password = document.querySelector(".login-password-field").value;
    var blockErrors = document.querySelector(".blockErrors");
    blockErrors.innerHTML = "";
    var url = '?action=login';
    fetch(url, {
        method: 'post',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'username=' + username + "&password=" + password,
        credentials: 'include'
    })
        .then(json)
        .then(function (data) {
            if (data.error) {
                blockErrors.innerHTML = data.error;
            }
            else {
                location.reload();
            }
        })
        .catch(function (error) {
            console.log('Request failed', error);
        });
}
function createAccount() {
    var email = document.querySelector(".emailinput").value;
    var nickname = document.querySelector(".nicknameinput").value;
    var password = document.querySelector(".passwordinput").value;
    var emailBlock = document.querySelector(".emailBlock");
    emailBlock.innerHTML = "";
    var nickBlock = document.querySelector(".nickBlock");
    nickBlock.innerHTML = "";
    var passwordBlock = document.querySelector(".passBlock");
    passwordBlock.innerHTML = "";
    var errorMessage = '';
    var blockErrors = document.querySelector(".blockErrors");
    if (6 > email.length) {
        errorMessage += 1
        emailBlock.innerHTML = 'Email non valide <br>';
    }
    if (4 > nickname.length) {
        errorMessage += 1
        nickBlock.innerHTML = 'Saisir 4 caractères minimum pour le mot de passe<br>';
    }
    if (6 > password.length) {
        errorMessage += 1
        passwordBlock.innerHTML = 'Saisir 6 caractères minimum pour le mot de passe<br>';
    }
    if (0 !== errorMessage.length) {
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
                if (data.username) {
                    nickBlock.innerHTML = data.username;
                }
                else if (data.email) {
                    emailBlock.innerHTML = data.email;
                }
                else if (data.password) {
                    passwordBlock.innerHTML = data.password;
                }
                else {
                    switchClass(loginpop, popregister, poppassword);
                    wait(300);
                    var blockSucess = document.querySelector(".blockSucess");
                    console.log(blockSucess);
                    blockSucess.innerHTML = "Bien joué ! Veuillez valider votre email pour vous connecter !"
                }
            })
            .catch(function (error) {
                console.log('Request failed', error);
            });
    };
}
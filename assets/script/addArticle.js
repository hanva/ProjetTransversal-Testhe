
window.onload = checkUser(type);

function checkUser(e) {
    if (e === "recette") {
        printRecipeForm();
    }
    else {
        printModeratorForm();
    }
}
$(function () {
    $('textarea').froalaEditor()
});

function printRecipeForm() {
    var select = document.querySelector(".select");
    removeNone(select);
    var addInput = document.querySelector(".addinput");
    removeNone(addInput);
    addInput.onclick = function () {
        addIngredient();
    }
}
function printModeratorForm() {
    var select = document.querySelector(".select");
    var addInput = document.querySelector(".addinput");
    addNone(addInput);
    addNone(select);
    removeIngredients();
    var type = document.querySelector(".type");
    type.onchange = function () {
        checkUser(type.value);
    }
}
function addIngredient() {
    var input = document.createElement("input")
    input.className += " ingredient";
    var container = document.querySelector(".ingredients");
    container.appendChild(input);
}
function removeIngredients() {
    var ingredient = document.querySelector(".ingredient");
    if (ingredient !== null) {
        var parent = ingredient.parentNode;
        while (parent.firstChild) {
            parent.removeChild(parent.firstChild);
        }
    }
}

function removeNone(el) {
    if (el.classList.contains("none")) {
        el.classList.remove("none");
    }
}
function addNone(el) {
    if (el.classList.contains("none") === false) {
        el.classList.add("none");
    }
}

document.querySelector(".addArticle").onclick = function () {
    var title = document.querySelector(".title").value;
    var type = document.querySelector(".type").value;
    var picture = document.querySelector(".picture");
    var picname = $('#picture').prop('files')[0].name;
    var content = document.querySelector('.content').value;
    var article = {
        "title": title,
        "type": type,
        "picture": picname,
        "content": content,
    }
    if (document.querySelector(".tag").classList.contains("none") === false) {
        var tag = document.querySelector(".tag").value;
        var ingredients = document.querySelector(".ingredients").childNodes;
        article.tag = tag;
        var finalingredients = "";
        for (var i in ingredients) {
            if (ingredients[i].value !== undefined) {
                finalingredients = finalingredients + ingredients[i].value + ","
            }
        }
        finalingredients = finalingredients.slice(0, -1);
        article.ingredients = finalingredients;
    }
    if (title.length > 0 && picname !== undefined && content.length > 0) {
        PostFile(article);
    }
    else {
        return false;
    }
}
function PostFile(obj) {
    var file_data = $('#picture').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    $.ajax({
        url: '?action=addArticle', // point to server-side PHP script 
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function (data) {
            if (obj.ingredients === undefined) {
                addArticle(obj);
            }
            else {
                addRecipe(obj);
            }
        },
        error: function (data) {
            alert("meh")
        }
    })
}
function addArticle(obj) {
    var url = '?action=addArticle';
    console.log(obj.picture);
    fetch(url, {
        method: 'post',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'title=' + obj.title + "&type=" + obj.title + "&content=" + obj.content + "&picture=" + obj.picture,
        credentials: 'include'
    })
        .then(json)
        .then(function (data) {
            window.location = '?action=home&addArticle=1';
        })
        .catch(function (error) {
            console.log('Request failed', error);
        });
};
function addRecipe(obj) {
    var url = '?action=addArticle';
    fetch(url, {
        method: 'post',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'title=' + obj.title + "&type=" + obj.title + "&content=" + obj.content + "&picture=" + obj.picture + "&ingredients=" + obj.ingredients + "&tag=" + obj.tag,
        credentials: 'include'
    })
        .then(json)
        .then(function (data) {
            window.location = '?action=home&addArticle=1';
        })
        .catch(function (error) {
            console.log('Request failed', error);
        });
};


function json(response) {
    return response.json()
}


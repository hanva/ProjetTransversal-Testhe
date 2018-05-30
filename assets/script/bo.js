var info = document.querySelectorAll(".info");
var savebtn = document.querySelectorAll(".Save");
var deletebtn = document.querySelectorAll(".deleteUser");
var saveArticle = document.querySelectorAll(".saveArticle");
var deleteArticle = document.querySelectorAll(".deleteArticle");
var saveComment = document.querySelectorAll(".saveComment");
var deleteComment = document.querySelectorAll(".deleteComment");


function json(response) {
    return response.json()
}
function deleteAction(btn, action) {
    var userId = btn.id;
    /([0-9]+)/.exec(userId);
    var id = (RegExp.$1);
    var url = '?action=' + action + '&id=' + id;
    fetch(url, {
        method: 'get',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        credentials: 'include'
    })
        .then(json)
        .then(function (data) {
            var el = document.getElementById(userId);
            var parent = el.parentNode;
            while (parent.firstChild) {
                parent.removeChild(parent.firstChild);
            }
        })
        .catch(function (error) {
            console.log('Request failed', error);
        });
};
function saveAction(btn, keys, action) {
    var data = {};
    var id = btn.id;
    var j = 0;
    var content = document.querySelectorAll('#' + id);
    for (i = 0; i < content.length; i++) {
        if (content[i].value !== undefined) {
            var value = content[i].value;
        }
        else {
            var value = content[i].innerHTML;
        }
        if (value !== null) {
            if (value.length === 0)
                value.length === null;
            data[keys[j]] = value;
            j++;
        }
    }
    var url = '?action=' + action + '&id=' + data["id"];
    fetch(url, {
        method: 'post',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: 'content=' + JSON.stringify(data),
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
for (var i = 0; i < saveArticle.length; i++) {
    saveArticle[i].onclick = function () {
        saveAction(this, articlekeys, "modifyAllArticles");
    }
};
for (var i = 0; i < saveComment.length; i++) {
    saveComment[i].onclick = function () {
        saveAction(this, commentkeys, "modifyComments");
    }
};
for (var i = 0; i < savebtn.length; i++) {
    savebtn[i].onclick = function () {
        saveAction(this, userkeys, "modifyUser");
    }
};
for (var i = 0; i < deleteArticle.length; i++) {
    deleteArticle[i].onclick = function () {
        deleteAction(this, "deleteArticle");
        captureEvents
    }
};
for (var i = 0; i < deleteComment.length; i++) {
    deleteComment[i].onclick = function () {
        deleteAction(this, "deleteComment");
    }
};

for (var i = 0; i < deletebtn.length; i++) {
    deletebtn[i].onclick = function () {
        deleteAction(this, "deleteUser");
    }
};


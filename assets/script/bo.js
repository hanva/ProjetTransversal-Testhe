var info = document.querySelectorAll(".info");
var savebtn = document.querySelectorAll(".Save");
var deletebtn = document.querySelectorAll(".deleteUser");
var saveArticle = document.querySelectorAll(".saveArticle");
var deleteArticle = document.querySelectorAll(".deleteArticle");


function json(response) {
    return response.json()
}
for (var i = 0; i < deleteArticle.length; i++) {
    deleteArticle[i].onclick = function () {
        var articleId = this.id;
        /([0-9]+)/.exec(articleId);
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
                var el = document.getElementById(articleId);
                var parent = el.parentNode;
                while (parent.firstChild) {
                    parent.removeChild(parent.firstChild);
                }
            })
            .catch(function (error) {
                console.log('Request failed', error);
            });
    };
};
for (var i = 0; i < deletebtn.length; i++) {
    deletebtn[i].onclick = function () {
        var userId = this.id;
        /([0-9]+)/.exec(userId);
        var id = (RegExp.$1);
        var url = '?action=deleteUser&id=' + id;
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
};

for (var i = 0; i < savebtn.length; i++) {
    savebtn[i].onclick = function () {
        var data = {};
        var id = this.id;
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
                data[userkeys[j]] = value;
                j++;
            }
        }
        var url = '?action=modifyDataBase&id=' + data["id"];
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
}

var info = document.querySelectorAll(".info");
var savebtn = document.querySelectorAll(".Save");
var deletebtn = document.querySelectorAll(".deleteUser");

for (var i = 0; i < info.length; i++) {
    info[i].onclick = function () {
    }
}

function json(response) {
    return response.json()
}
for (var i = 0; i < deletebtn.length; i++) {
    deletebtn[i].onclick = function () {
        var classname = this.classList[1];
        /([0-9]+)/.exec(classname);
        id = (RegExp.$1);
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
                var el = document.querySelector("." + classname);
                var parent = el.parentNode;
                parent.removeChild(el);
            })
            .catch(function (error) {
                console.log('Request failed', error);
            });
    };
};

for (var i = 0; i < savebtn.length; i++) {
    savebtn[i].onclick = function () {
        var data = {};
        var classname = this.classList[1];
        var j = 0;
        var content = document.querySelectorAll("." + classname)[0].childNodes;
        for (i = 0; i < content.length; i++) {
            if (content[i].value !== undefined) {
                if (content[i].value.length === 0)
                    content[i].value.length === null;
                data[userkeys[j]] = content[i].value;
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

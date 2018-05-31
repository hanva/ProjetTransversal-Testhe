window.onload = function () {
    var likesbtn = document.querySelectorAll(".likes");
    isHighlight(likesbtn);
    for (var i = 0; i < likesbtn.length; i++) {
        likesbtn[i].onclick = function () {
            like(this);
        }
    }
}
function json(response) {
    return response.json()
}
function removeA(arr) {
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax = arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}
function isHighlight(btns) {
    var url = '?action=like';
    fetch(url, {
        method: 'get',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        credentials: 'include'
    })
        .then(json)
        .then(function (data) {
            if (data === "not connected") {
                for (var i = 0; i < btns.length; i++) {
                    disable(btns[i]);
                }
            }
            else {
                highlight(document.getElementById(data));
            }
        })
        .catch(function (error) {
            console.log('Request failed', error);
        });
};
function like(btn) {
    var likesbtn = document.querySelectorAll(".likes")
    var btids = [];
    for (var i = 0; i < likesbtn.length; i++) {
        btids.push(likesbtn[i].id);
    }
    var otherid = removeA(btids, btn.id);
    otherid = otherid.toString();
    var otherbtn = document.getElementById(otherid);
    var url = '?action=like&id=' + btn.id + "&otherid=" + otherid;
    fetch(url, {
        method: 'get',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        credentials: 'include'
    })
        .then(json)
        .then(function (data) {
            if (data === "not connected") {
                alert("connectez vous pour voter  ")
            }
            if (Number.isInteger(data.likes)) {
                btn.innerHTML = data.likes;
                highlight(btn);
                if (otherbtn.innerHTML !== data.other)
                    highlight(document.getElementById(otherid));
                document.getElementById(otherid).innerHTML = data.other;
            }
        })
        .catch(function (error) {
            console.log('Request failed', error);
        });
}
function highlight(e) {
    if (e.classList.contains("highlight")) {
        e.classList.remove("highlight");
    }
    else {
        e.classList.add("highlight");
    }
}
function disable(e) {
    e.classList.add("grey");
}
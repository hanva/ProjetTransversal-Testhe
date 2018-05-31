window.onload = function () {
    var likesbtn = document.querySelectorAll(".likes")
alert("cc")
    for (var i = 0; i < likesbtn.length; i++) {
        likesbtn[i].onclick = function () {
            like(this);
        }
    }
}
function json(response) {
    return response.json()
}
function like(btn) {
    var url = '?action=like&id=' + btn.id;
    fetch(url, {
        method: 'get',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        credentials: 'include'
    })
        .then(json)
        .then(function (data) {
            if (Number.isInteger(data)) {
                btn.innerHTML = data;
                highlight(btn);
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
var commentbtn = document.querySelector(".commentbtn")

commentbtn.onclick = comment;

function comment() {
    var content = document.querySelector(".commentcontent").value;
    if (content.length < 1) {
        return;
    }
    else {
        console.log(articleId);
        var url = '?action=writeComment';
        fetch(url, {
            method: 'post',
            headers: {
                "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
            },
            body: 'content=' + content + '&id=' + articleId,
            credentials: 'include'
        })
            .then(json)
            .then(function (data) {
                createComment(data.username, data.content);
            })
            .catch(function (error) {
                console.log('Request failed', error);
            });
    };
}
function json(response) {
    return response.json()
}

function createComment(username, content) {
    var articleDiv = $('<div class="article-comments">');
    var articleTitle = $(' <h4 ></h4>').text(username);
    var articleContent = $('<p></p></div>').html(content);
    articleDiv.append(articleTitle);
    articleDiv.append(articleContent);
    $('.commentsection').prepend(articleDiv);
}
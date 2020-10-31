const container = document.querySelector("main>.container>.row>.col-6")


request('threads/getAll',
    {},
    function (responseText) {
        responseText.forEach(function (it) {
            let post = document.createElement("div");
            post.className = 'post';

            let header = document.createElement('h2');
            header.innerHTML = it["title"];
            post.insertAdjacentElement("beforeend", header);

            let postdate = document.createElement("post-date");
            let htmlParagraphElement = document.createElement('p');
            htmlParagraphElement.innerText = 'Posted on ' + it["date_post"] + " by " + it[0]['login'];
            postdate.insertAdjacentElement('beforeend', htmlParagraphElement);
            post.insertAdjacentElement('beforeend', postdate);

            let img = document.createElement('img');
            img.src = it['img'];
            post.insertAdjacentElement('beforeend', img);

            let textDiv = document.createElement('div');
            let htmlParagraphElement1 = document.createElement('p');
            htmlParagraphElement1.innerText = it["text"].slice(0, 150) + "....";
            textDiv.insertAdjacentElement('beforeend', htmlParagraphElement1);
            post.insertAdjacentElement('beforeend', textDiv);

            post.insertAdjacentHTML('beforeend', "<div class=\"cont-reading\">\n" +
                "<a href=threads/get?" + it['id'] + ">Continue reading →</a>\n" +
                "</div>");

            container.insertAdjacentElement('beforeend', post);
            container.appendChild(post);
        })

    }, () => {
    });
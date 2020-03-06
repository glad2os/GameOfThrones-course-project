const id = document.querySelectorAll('id')[0];
const ThreadTitle = document.querySelectorAll('ThreadTitle')[0];
const date = document.querySelectorAll('date')[0];
const author = document.querySelectorAll('author')[0];
const text = document.querySelectorAll('text')[0];
const img = document.querySelectorAll('img')[0];

request('threads/get_thread',
    {"thread_number": document.getElementsByTagName("META")[2].attributes[0].value},
    function (status, responseText) {
        if (status === 200) {
            const received = JSON.parse(responseText);
            //id.innerText = received['thread'].id;
            ThreadTitle.innerText = received['thread'].title;
            date.innerText = received['thread'].date_post;
            author.innerText = received['authors'];
            text.innerText = received['thread'].text;
            img.src = received['thread'].img;
        } else {
            console.log(responseText);
            alert(JSON.parse(responseText)['issueMessage']);
        }
    });
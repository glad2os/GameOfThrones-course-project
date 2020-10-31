function nop() {
}

function request(target, body, callback = nop, fallbackCallback = e => alert(e["issueMessage"])) {
    const request = new XMLHttpRequest();
    request.open("POST", `/${target}`, true);
    request.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
    request.responseType = "json";
    request.onreadystatechange = () => {
        if (request.readyState === XMLHttpRequest.DONE) {
            if (request.status === 200) callback(request.response);
            if (request.status === 204) alert("Done!");
            else fallbackCallback(request.response);
        }
    };
    request.send(JSON.stringify(body));
}

function reg(form) {
    request('account/register', {
        "login": form.login.value,
        "password": form.password.value
    }, () => window.location.href = '/account/signin')
}

function auth(form) {
    request('account/auth', {
        "login": form.login.value,
        "password": form.password.value
    }, () => window.location.href = '/account');
}

function signOut() {
    request('account/logout', {}, () => {
        deleteCookie('login');
        deleteCookie('token');
        window.location.href = '/';
    });
}

function addThread(form) {
    request('threads/add', {
        "title": form.title.value,
        "text": form.text.value,
        "img": form.img.value,
        "author": getCookie('id')
    });
}

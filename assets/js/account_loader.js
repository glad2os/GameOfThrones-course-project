const logins = document.querySelectorAll('login');
const firstNames = document.getElementsByName('first_name');
const secondNames = document.getElementsByName('second_name');
const lastNames = document.getElementsByName('last_name');

request('user/get_info', null, function (status, responseText) {
    if (status === 200) {
        const received = JSON.parse(responseText);
        logins.forEach(function (entry) {
            entry.innerText = received.login;
        });
    } else {
        console.log(responseText);
        alert(JSON.parse(responseText).issueMessage);
    }
});
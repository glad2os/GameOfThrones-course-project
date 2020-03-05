if (getCookie('login') !== undefined) {
    let elem = document.getElementById("del");
    elem.parentNode.removeChild(elem);
    let test = document.getElementById("navbardrop2");
    test.classList.remove("dropdown-toggle");
    test.removeAttribute("data-toggle");
}

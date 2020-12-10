
var signup = document.getElementById("signUp")
if (signup) {
    signup.addEventListener("submit", signUpForm, false);
}

var login = document.getElementById("login")
if (login) {
    login.addEventListener("submit", loginform, false);
}

var watchlist = document.getElementById("watchlistForm")
if (watchlist) {
    watchlist.addEventListener("submit", watchlistName, false);
}

var search = document.getElementById("searchBar")
if (search) {
    search.addEventListener("submit", searchEmpty, false);
}

var watchname = document.getElementById("watchlistNew");
if (watchname) {
    watchname.addEventListener("keyup", watchcount, false)
}

var searchValue = document.getElementById("search");
if (searchValue) {
    searchValue.addEventListener("keyup", send_ajax_request, false);
}

var pW = document.getElementById("populateWatchlists");
if (pW) {
    pW.addEventListener("click", send_ajax_req_watchlists, false);
}

var deleteMovie = document.getElementsByClassName("deleteButton");
if (deleteMovie) {
    for (var i = 0; i < deleteMovie.length; i++) {
        deleteMovie[i].addEventListener("click", send_ajax_req_delete, false);
    }
}
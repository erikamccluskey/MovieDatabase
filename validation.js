function signUpForm(event) {

  var fname = document.getElementById("fname").value;
  var lname = document.getElementById("lname").value;
  var username = document.getElementById("username").value;
  var email = document.getElementById("emailS").value;
  var pswd = document.getElementById("password").value;
  var pswdC = document.getElementById("passwordC").value;
  var avatar = document.getElementById("fileToUpload").value;


  var regex_email = /^\w?.+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
  var regex_pswd = /(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})/;

  var msg_fname = document.getElementById("msg_fname");
  var msg_lname = document.getElementById("msg_lname");
  var msg_username = document.getElementById("msg_username");
  var msg_email = document.getElementById("msg_emailS");
  var msg_pswd = document.getElementById("msg_password");
  var msg_pswdC = document.getElementById("msg_passwordC");
  var msg_avatar = document.getElementById("msg_avatar");

  msg_fname.innerHTML = "";
  msg_lname.innerHTML = "";
  msg_username.innerHTML = "";
  msg_email.innerHTML = "";
  msg_pswd.innerHTML = "";
  msg_pswdC.innerHTML = "";
  msg_avatar.innerHTML = "";

  var result = true;
  var textNode;

  if (email == null || email == "") {
    textNode = document.createTextNode("Required. Please enter an email address.");
    msg_email.appendChild(textNode);
    result = false;
  }
  else if (regex_email.test(email) == false) {
    textNode = document.createTextNode("Email address wrong format. example: a@a.com");
    msg_email.appendChild(textNode);
    result = false;
  }

  if (pswd == null || pswd == "") {
    textNode = document.createTextNode("Required. Please enter a password.");
    msg_pswd.appendChild(textNode);
    result = false;
  }
  else if (regex_pswd.test(pswd) == false) {
    textNode = document.createTextNode("Password requirements: at least 8 characters, at least 1 digit, and at least 1 symbol).");
    msg_pswd.appendChild(textNode);
    result = false;
  }

  if (username == null || username == "") {
    textNode = document.createTextNode("Required. Please enter a username.");
    msg_username.appendChild(textNode);
    result = false;
  }

  if (fname == null || fname == "") {
    textNode = document.createTextNode("Required. Please enter your name.");
    msg_fname.appendChild(textNode);
    result = false;
  }

  if (lname == null || lname == "") {
    textNode = document.createTextNode("Required. Please enter your last name.");
    msg_lname.appendChild(textNode);
    result = false;
  }

  if (pswd != pswdC) {
    textNode = document.createTextNode("Password does not match.");
    msg_pswdC.appendChild(textNode);
    result = false;
  }
  else if (pswdC == null || pswdC == "") {
    textNode = document.createTextNode("Required. Please confirm your password.");
    msg_pswdC.appendChild(textNode);
    result = false;
  }

  if (avatar == null || avatar == "") {
    textNode = document.createTextNode("Required. Please pick an avatar.");
    msg_avatar.appendChild(textNode);
    result = false;
  }

  if (result === false) {
    event.preventDefault();
  }

}

function loginform(event) {

  var email = document.getElementById("email").value;
  var pswd = document.getElementById("pswd").value;


  var regex_email = /^\w?.+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
  var regex_pswd = /(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})/;

  var msg_email = document.getElementById("msg_email");
  var msg_pswd = document.getElementById("msg_pswd");

  msg_email.innerHTML = "";
  msg_pswd.innerHTML = "";

  var result = true;
  var textNode;

  if (email == null || email == "") {
    textNode = document.createTextNode("Required. Please enter your email address.");
    msg_email.appendChild(textNode);
    result = false;
  }
  else if (regex_email.test(email) == false) {
    textNode = document.createTextNode("Email address wrong format. example: a@a.com");
    msg_email.appendChild(textNode);
    result = false;
  }

  if (pswd == null || pswd == "") {
    textNode = document.createTextNode("Required. Please enter your password.");
    msg_pswd.appendChild(textNode);
    result = false;
  }
  else if (regex_pswd.test(pswd) == false) {
    textNode = document.createTextNode("Password requirements: at least 8 characters, at least 1 digit, and at least 1 symbol).");
    msg_pswd.appendChild(textNode);
    result = false;
  }

  if (result == false) {
    event.preventDefault();
  }

}

function watchlistName(event) {
  var name = document.getElementById("watchlistNew").value;
  var msg_watchlistName = document.getElementById("msg_watchlistName");
  var textNode;

  msg_watchlistName.innerHTML = "";

  var result = true;

  if (name == "" || name == null) {
    textNode = document.createTextNode("Name for new watchlist is required.")
    msg_watchlistName.appendChild(textNode);
    result = false;
  }
  else if (name.length > 15) {
    textNode = document.createTextNode("Name is too long. 15 characters maximum.")
    msg_watchlistName.appendChild(textNode);
    result = false;
  }

  if (result == false) {
    event.preventDefault();
  }
}

function searchEmpty(event) {
  console.log("hi");
  var result = true;
  var searchValue = document.getElementById("search").value;
  var textNode;

  var msg_search = document.getElementById("msg_search");

  msg_search.innerHTML = "";

  if (searchValue == null || searchValue == "") {
    textNode = document.createTextNode("Search cannot be empty. Please enter a valid search.");
    msg_search.appendChild(textNode);
    result = false;
  }
  if (result == false) {
    event.preventDefault();
  }
}

function watchcount(event) {
  console.log("hi");
  var text = document.getElementById("watchlistNew").value.length;
  var msg_watchlistName = document.getElementById("msg_count");
  var textNode;

  msg_watchlistName.innerHTML = "";
  if (text == 0) {
    msg_watchlistName.removeChild();
  }
  if (text < 15) {
    msg_watchlistName.style = "color:black";
    msg_watchlistName.innerHTML = (15 - text) + " characters left";
  }
  else {
    msg_watchlistName.style = "color:red";
    msg_watchlistName.innerHTML = "Too many characters";
  }

}

function send_ajax_request() {

  var searchValue = document.getElementById("search").value;

  var xmlhttp = new XMLHttpRequest();

  xmlhttp.addEventListener("readystatechange", receive_ajax_response, false);

  xmlhttp.open("GET", "getMovies.php?search=" + searchValue, true);

  xmlhttp.send();

}

function receive_ajax_response() {
  if (this.readyState == 4 && this.status == 200) {
    var message_area = document.getElementById("msg_search");
    var display_movies_body = document.getElementById("container");

    var results;

    try {
      results = JSON.parse(this.responseText);
    }

    catch {
      message_area.innerHTML = this.responseText;
      return;
    }


    if (results.length > 0) {
      display_movies_body.style.visibility = "visible";
      display_movies_body.innerHTML = "";
      message_area.innerHTML = "";

      var db_record;
      var movie;
      var form;
      var hiddenMid;
      var poster;
      var title;
      var title_text;
      var rating;
      var rating_text;

      for (var i = 0; i < results.length; i++) {
        db_record = results[i];

        movie = document.createElement("section");
        movie.setAttribute("class", "item");

        form = document.createElement("form");
        form.setAttribute("onclick", ("location.href = 'details.php?mid=" + db_record.mid));
        form.setAttribute("method", "GET");

        movie.appendChild(form);

        hiddenMid = document.createElement("input");
        hiddenMid.style.visibility = "hidden";
        hiddenMid.setAttribute("type", "hidden");
        hiddenMid.setAttribute("name", "mid");
        hiddenMid.setAttribute("type", db_record.mid);

        poster = document.createElement("img");
        poster.setAttribute("class", "watchlistposter");
        poster.setAttribute("src", db_record.poster + ".jpg");
        poster.setAttribute("alt", db_record.title + "poster");

        form.appendChild(hiddenMid);
        form.appendChild(poster);

        title = document.createElement("h3");
        title.setAttribute("class", "center");
        title_text = document.createTextNode(db_record.title);

        title.appendChild(title_text);
        movie.appendChild(title);

        rating = document.createElement("h5");
        rating.setAttribute("class", "center");
        rating_text = document.createTextNode("Rating: " + db_record.average + "/5");

        rating.appendChild(rating_text);
        movie.appendChild(rating);

        display_movies_body.appendChild(movie);

      }
    }

    else {
      display_movies_body.style.visibility = "hidden";
      message_area.innerHTML = "No results found.";
    }
  }
  return;
}

function send_ajax_req_watchlists() {

  var xmlhttp = new XMLHttpRequest();

  xmlhttp.addEventListener("readystatechange", receive_ajax_res_watchlists, false);

  xmlhttp.open("GET", "getWatchlists.php", true);

  xmlhttp.send();
}

function receive_ajax_res_watchlists() {
  if (this.readyState == 4 && this.status == 200) {
    var message_area = document.getElementById("confirm_msg");
    var display_watchlists = document.getElementById("third");

    var results;

    try {
      results = JSON.parse(this.responseText);
    }

    catch {
      message_area.innerHTML = this.responseText;
      return;
    }


    if (results.length > 0) {
      display_watchlists.style.visibility = "visible";
      display_watchlists.innerHTML = "";
      message_area.innerHTML = "";

      var db_record;
      var title;
      var form;
      var watchlistName;
      var movieId;
      var watchlistId;
      var watchlistbutton;
      var watchlistbutton_text;


      for (var i = 0; i < results.length; i++) {
        db_record = results[i];

        title = document.createElement("h3");
        title.setAttribute("class", "center");
        watchlistName = document.createTextNode(db_record.name);
        title.appendChild(watchlistName);

        display_watchlists.appendChild(title);

        form = document.createElement("form");

        watchlistId = document.createElement("input");
        watchlistId.setAttribute("type", "hidden");
        watchlistId.setAttribute("name", "watchlistId");
        watchlistId.setAttribute("value", db_record.wid);

        watchlistbutton = document.createElement("button");
        watchlistbutton.setAttribute("type", "button");
        watchlistbutton.setAttribute("id", db_record.wid);
        watchlistbutton.setAttribute("class", "watchlistbutton");
        watchlistbutton_text = document.createTextNode("Add to Watchlist");
        watchlistbutton.appendChild(watchlistbutton_text);

        form.appendChild(watchlistId);
        form.appendChild(watchlistbutton);

        display_watchlists.appendChild(form);
      }
    }
    else {
      display_watchlists.style.visibility = "hidden";
      message_area.innerHTML = "You have no watchlists.";
    }

    var wB = document.getElementsByClassName("watchlistbutton");
    if (wB) {
      for (var i = 0; i < wB.length; i++) {
        wB[i].addEventListener("click", send_ajax_req_watchlistsAdd, false);
      }
    }

  }
}

function send_ajax_req_watchlistsAdd(event) {

  var watchlistId = event.currentTarget.parentElement.children[0].value;
  var movieId = document.getElementById("movieId").value;

  var xmlhttp = new XMLHttpRequest();

  xmlhttp.addEventListener("readystatechange", receive_ajax_res_watchlistsAdd, false);

  xmlhttp.open("GET", "addToWatchlist.php?wid=" + encodeURIComponent(watchlistId) + "&mid=" + encodeURIComponent(movieId), true);

  xmlhttp.send();
}

function receive_ajax_res_watchlistsAdd() {
  if (this.readyState == 4 && this.status == 200) {
    var message_area = document.getElementById("confirm_msg");
    var result;

    try {
      result = JSON.parse(this.responseText);
    }

    catch {
      message_area.innerHTML = this.responseText;
      return;
    }

    var watchlistToEdit = document.getElementById(result);

    watchlistToEdit.firstChild.textContent = "Added to Watchlist";
  }
}

function send_ajax_req_delete(event) {

  var movieId = event.currentTarget.parentElement.firstElementChild.value;
  var watchlistId = document.getElementById("wid").value;

  var xmlhttp = new XMLHttpRequest();

  xmlhttp.addEventListener("readystatechange", receive_ajax_res_delete, false);

  xmlhttp.open("GET", "removeFromWatchlist.php?wid=" + encodeURIComponent(watchlistId) + "&mid=" + encodeURIComponent(movieId), true);

  xmlhttp.send();
}

function receive_ajax_res_delete() {
  if (this.readyState == 4 && this.status == 200) {
    var message_area = document.getElementById("delete_msg");
    var result;

    try {
      result = JSON.parse(this.responseText);
    }

    catch {
      message_area.innerHTML = this.responseText;
      return;
    }

    if (result != null) {
      message_area.innerHTML = "";
      var toDelete = document.getElementById(result);
      toDelete.remove();
    }
    else {
      message_area.innerHTML = "Error deleting";
    }

  }
}
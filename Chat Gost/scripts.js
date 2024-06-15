function sendMessage() {
    var username = document.getElementById('username').value;
    var message = document.getElementById('message').value;

    if (username == "" || message == "") {
        alert("Username and message are required!");
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "send_message.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("username=" + encodeURIComponent(username) + "&message=" + encodeURIComponent(message));

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('message').value = "";
            if (document.body.classList.contains("dark-mode")) {
                toggleDarkMode();
            }
            getMessages(); 
        }
    }
}

function getMessages() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "get_messages.php", true);
    xhr.send();

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('messages').innerHTML = xhr.responseText;
            document.getElementById('messages').scrollTop = document.getElementById('messages').scrollHeight;
        }
    }
}

setInterval(getMessages, 1000);

function toggleDarkMode() {
    var body = document.body;
    body.classList.toggle("dark-mode");
    localStorage.setItem('dark-mode', body.classList.contains('dark-mode'));
}

function clearChat() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "clear_chat.php", true);
    xhr.send();

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            getMessages();
        }
    }
}

window.onload = function() {
    if (localStorage.getItem('dark-mode') === 'true') {
        document.body.classList.add('dark-mode');
    }
    getMessages();
}

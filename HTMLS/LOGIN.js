function validateForm() {
    var user = document.loginForm.usr.value;
    var pass = document.loginForm.pwd.value;
    var username = "username";
    var password = "password";
    
    if ((user == username) && (pass == password)) {
        // Redirect to Home.html when login is successful
        window.location.href = 'Home.html';
        return true;
    } else {
        // Display alert before redirecting to LOGIN.html
        alert("Login was unsuccessful, please check your username and password");
        
        // Redirect to LOGIN.html when login is unsuccessful
        window.location.href ='LOGIN.html';
        return false;
    }
}

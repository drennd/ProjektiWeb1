function validateForm() {
    var user = document.loginForm.usr.value;
    var pass = document.loginForm.pwd.value;
    var username = "Username";
    var password = "password";
    


    if ((user != '') && (pass != '')) {
        
        window.location.href = 'Home.html';
        return true;
    } else {
         
        alert("Login was unsuccessful, please check your username and password");
        
        
        window.location.href ='LOGIN.html';
        return false;
    }
}

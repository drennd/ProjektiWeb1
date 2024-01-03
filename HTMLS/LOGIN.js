// LOGIN.js
let usersData = <?php echo json_encode($users); ?>;

function validateForm(event) {
    event.preventDefault();

    const user = document.loginForm.usr.value;
    const pass = document.loginForm.pwd.value;

    var validUser = false;

    console.log("Users Data:", usersData);

    for (let i = 0; i < usersData.length; i++) {
        if (user === usersData[i].username && pass === usersData[i].password) {
            validUser = true;
            break;
        }
    }

    if (validUser) {
        console.log("Form submitted successfully");
        document.loginForm.submit();
    } else {
        console.log("Login unsuccessful. Check username and password.");
        alert("Login was unsuccessful, please check your username and password");
    }
}

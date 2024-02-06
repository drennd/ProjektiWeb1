
  function validateForm(event) {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    // Check if username and password are not empty
    if (username.trim() === "" || password.trim() === "") {
      alert("Username and password are required");
      event.preventDefault(); // Prevent form submission
      return false;
    }

    return true; // Allow form submission if validation passes
  }


<?php
class UserRegistration {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function registerUser($email, $username, $password) {
        if ($this->validateInput($email, $username, $password)) {
            // Prepare and bind the statement
            $stmt = $this->conn->prepare("INSERT INTO users (email, username, password, role) VALUES (?, ?, ?, ?)");
            $role = 'user';
            $stmt->bind_param("ssss", $email, $username, $password, $role);

            // Execute the statement
            $stmt->execute();

            // Close the statement
            $stmt->close();

            // Redirect to a success page or perform any other actions
            header('Location: LOGIN.php');
            exit();
        } else {
            echo 'All fields are required.';
        }
    }

    private function validateInput($email, $username, $password) {
        return !empty($email) && !empty($username) && !empty($password);
    }
}

// Include the database connection file
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input from the form
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Create UserRegistration instance and pass the database connection
    $userRegistration = new UserRegistration($conn);

    // Register the new user
    $userRegistration->registerUser($email, $username, $password);
}
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Weather-Register</title>
    <link rel="stylesheet" href="REGISTER.css">
    <script src="REGISTER.js" defer></script>
</head>
<body>
  <header class="headerContainer">
    <div class="logoAndCatalog">
        <img src="./OIP.png" alt="logo" height="45px">
        <p class="catalog">Catalog-Z</p>
    </div>
    <div class="SearchBar">   
    <center><input type="text" placeholder="Search City or Zip Code" style="height: 20px; ">
    <button style="width: 50px; height: 25px; background-color: lightseagreen; border: inset 0px;"><img src="search.png" alt=""></button></center>
    </div>
    <h3 id="h3">
        <a href="Home.php"><button class="btn Home">Home</button></a>
        <a href="AboutUs.php"><button class="btn AboutUs">About Us</button></a>
        <a href="ContactUs.php"><button class="btn ContactUs">Contact Us</button></a>
        <a href="LOGIN.php"><button class="btn LogIn">Log In</button></a>
    </h3>
  </header>
  

  <div id="background-Picture">
    <img src="./pexels-magda-ehlers-636353.jpg" alt="">
</div>
<body>

    <section class="module">
      <div class="col-sm-5">
         <h4 class="font-alt">Register</h4>
        <hr class="divider-w mb-10">
        <form class="form" name="regForm" onSubmit="return validateForm(true);" action="register.php" method="post">
          <div class="form-group">
            <input class="form-control" id="Email" type="text" name="email" placeholder="Email"/>
            <div id="email_error"></div>
          </div>
          <div class="form-group">
            <input class="form-control" id="RegUser" type="text" name="username" placeholder="Username"/>
            <div id="name_error"></div>
          </div>
          <div class="form-group">
            <input class="form-control" id="RegPass" type="password" name="password" placeholder="Password"/>
          </div>
          <div class="form-group">
            <input class="form-control" id="confirmPass" type="password" name="confirmPass" placeholder="Re-enter Password"/>
            <div id="password_error"></div>
          </div>
          <div class="form-groupLR">
            <button class="btn btn-block btn-round btn-b" type="submit" value="register">Register</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>



<footer>
  <div class="footer-box">
    <div class="f">
        <h3>About Us</a></h3>
        <h3>Our Links</h3>
        <div class="ff">
            <a href=""><img src="./fb-logo.png" alt="" width="32px" height="32px"></a>
            <a href=""><img src="./twitter.png" alt="" width="32px" height="32px"></a>
            <a href=""><img src="./ig-logo.png" alt="" width="32px" height="32px"></a>
            <a href=""><img src="./pinterest.png" alt="" width="32px" height="32px"></a>
        </div>
    </div>
    <div class="footermain">
            <div class="footerleft">
                <p>Catalog-Z is free Bootstrap 5 Alpha 2 HTML Template for video and foto websites. You can freely use this TemplateMo layout for a front-end integration with any kind of CMS website.</p>
            </div>
            <div class="footercenter">
                <p>Advertise</p>
                <p>Support</p>
                <p>Our Company</p>
                <p>Contact Us</p>
            </div>
            <div class="footerright">
                <p>Terms of use</p>
                <p>Privacy Policy</p>
            </div>
        </div>
        <div class="fundi">
            <p>Copyright 2020 Catalog-Z Company. All rights reserved.</p>
            <p>Designed by TemplateMo</p>
        </div>
    </div>
  </div>
</footer>
</body>
</html>

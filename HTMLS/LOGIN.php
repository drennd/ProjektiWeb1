<?php
session_start();
include 'users.php';

if (isset($_POST['submit'])) {
    $username = $_POST['usr'];
    $password = $_POST['pwd'];
    $logged = false;

    foreach ($users as $user) {
        echo "Checking user: " . $user['username'] . "\n";
        if ($username === $user['username'] && $password === $user['password']) {
            $_SESSION['username'] = $username;
            $_SESSION['time'] = date("d/m/Y H:i", time());

            if ($user['role'] == 'admin') {
                $_SESSION['admin'] = true;
            } else {
                $_SESSION['admin'] = false;
            }

            $logged = true;
            echo "Login successful for user: " . $user['username'] . "\n";
            break; // Exit the loop when the login is successful
        }
    }

    if (!$logged) {
        echo "Te dhenat jane gabim";
        session_destroy();
        // You might want to display an error message instead of redirecting
        // header('Location: login.php');
        // exit();
    } else {
        // Redirect only when the login is successful
        header('Location: home.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <link rel="stylesheet" href="LoginCSS.css">
    <script>
        var usersData = <?php echo json_encode($users); ?>;
    </script>
   <script src="LOGIN.js" defer></script>
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

  <section class="module">
    <div class="container">
      <div class="row">
        <div class="col-sm-5 col-sm-offset-1 mb-sm-40">
          <div class="login-box">
            <h4 class="font-alt">Login</h4>
            <hr class="divider-w mb-10">
            <form name="loginForm" onsubmit='return validateForm(event);' action="LOGIN.php" method="post">
              <div class="form-group">
                <input class="form-control" id="username" name="usr" type="text" placeholder="username"/>
              </div>
              <div class="form-group">
                <input class="form-control" id="password" name="pwd" type="password" placeholder="password"/>
              </div>
              <div class="form-groupLR">
                <button class="btn btn-round btn-b" type="submit" value="login" name="submit">Login</button>
                <a href="REGISTER.php" class="btn btn-round btn-register">Register</a>
              </div>
              <div class="form-groupLR">
                <a href="" class="forgot-password">Forgot Password?</a>
              </div>
            </form>
          </div>
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

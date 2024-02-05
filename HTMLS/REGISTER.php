<?php
class UserRegistration {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function registerUser($email, $username, $password) {
        if ($this->validateInput($email, $username, $password)) {
            // Ben gati query ne variablen stmn
            $stmt = $this->conn->prepare("INSERT INTO users (email, username, password, role) VALUES (?, ?, ?, ?)");
            $role = 'user'; //role eshte konstant user (sepse kur regjistrohet bohet user)
            $stmt->bind_param("ssss", $email, $username, $password, $role);
            //^ percakton 4 parametrat per values nvariablat persiper

            // Ekzekuton vleren e meposhtme/Shton variablat ne databaaze
            $stmt->execute();

            // Perfundon Procesin
            $stmt->close();

            //Nese eshte e perfundume/Jane plotesuar parametrat kalon nLogin.php
            header('Location: LOGIN.php');
            exit();
        } else {
            echo 'All fields are required.';
        }
    }


    //Kontrollon nese nuk jane empty secila pjese e regjistrimit
    private function validateInput($email, $username, $password) {
        return !empty($email) && !empty($username) && !empty($password);
    }
}

// Include the database connection file
include('db_connection.php');

// Kontrollon nese jane vendosur/pranuar vlerat ne FrontEnd tRegister
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Merr vlerat prej inputit te userit
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Lidh klasene  mesiperme me lidhjen e databazes ($conn)
    $userRegistration = new UserRegistration($conn);

    //Shkon e perfundon procesin e userit.
    $userRegistration->registerUser($email, $username, $password);
}

//FOOTER
  //Kryen lidhjen ndermjet databazes duke marrur vetem vleren e pare te tabeles footer
    $footerQuery = "SELECT * FROM footer LIMIT 1";
    $footerResult = $conn->query($footerQuery);
    $footerData = $footerResult->fetch_assoc();
    //Merr te gjitha dhenat te lidhura me queryn e mesiperm
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
        <p class="catalog">BluehWeather</p>
    </div>
    <div class="SearchBar">   
    <center><input type="text" placeholder="Search City or Zip Code" style="height: 20px; ">
    <button style="width: 50px; height: 25px; background-color: lightseagreen; border: inset 0px;"><img src="search.png" alt=""></button></center>
    </div>
    <div class="hamburger">|||</div>
<nav>
    <h3 id="h3">
        <a href="Home.php"><button class="btn Home">Home</button></a>
        <a href="News.php"><button class="btn News">News</button></a>
        <a href="AboutUs.php"><button class="btn AboutUs">About Us</button></a>
        <a href="ContactUs.php"><button class="btn ContactUs">Contact Us</button></a>
        <a href="LOGIN.php"><button class="btn LogIn">Log In</button></a>
    </h3>
</nav>
  </header>
  

  <div id="background-Picture">
    <img src="./pexels-magda-ehlers-636353.jpg" alt="">
</div>
<body>

    <section class="module" style="margin-top: 20px">
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



<footer style="position: absolute; bottom: 20px; width: calc(100vw - 40px)">
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
    <<div class="footermain">
        <div class="footerleft">
            <p><?php echo $footerData['footer_left_txt']; ?></p>
        </div>
        <div class="footercenter">
                    <p><?php echo $footerData['advertise_txt']; ?></p>
                    <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ"><p><?php echo $footerData['support_txt']; ?></p></a>
                    <p><?php echo $footerData['company_txt']; ?></p>
                <p><?php echo $footerData['contact_txt']; ?></p>
            </div>  
            <div class="footerright">
                <p><?php echo $footerData['terms_of_use_txt']; ?></p>
                <p><?php echo $footerData['priv_policy_txt']; ?></p>
            </div>
    </div>
    <div class="fundi">
        <p>Copyright 2020 BluehWeather. NO RIGHTS RESERVED.</p>
        <p>Stolen words from TemplateMo</p>
    </div>
    
  </div>
</footer>

<script>
    const hamburger = document.querySelector(".hamburger");
    hamburger.addEventListener("click", function() {
    let nav = document.querySelector("nav");
    nav.style.display == "block" ? nav.style.display = "none" : nav.style.display = "block";
});
</script>
</body>
</html>

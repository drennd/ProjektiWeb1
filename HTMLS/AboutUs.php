<?php
session_start();
include 'db_connection.php';
    $aboutUsQuery = "SELECT * FROM about_us LIMIT 1";
    $aboutUsResult = $conn->query($aboutUsQuery);
    $aboutUsData=$aboutUsResult->fetch_assoc();

    $footerQuery = "SELECT * FROM footer LIMIT 1";
    $footerResult = $conn->query($footerQuery);
    $footerData = $footerResult->fetch_assoc();

    // Check if the log out form is submitted
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: LOGIN.php');
    exit();
}

?>
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Weather-AboutUs</title>
    <link rel="stylesheet" href="MainStyle.css">
    <style> body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
    }

    .about-us-section {
        background-color: #ffffff;
        padding: 20px;
        margin: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .containerss {
        max-width: 800px;
        margin: 0 auto;

    }
    
    .footer {
    background-color: #000;
    color: white;
    padding: 20px;
    margin-top: auto; /* Push the footer to the bottom */
    width: 100%;
    box-sizing: border-box;
}

.footer h3 {
    margin-bottom: 10px;
}

.footer a {
    color: white;
    text-decoration: none;
}

.footer a:hover {
    text-decoration: underline;
}

.f {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin-bottom: 20px;
}

.f .ff img {
    margin-right: 10px;
}

.footermain {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.footerleft,
.footercenter,
.footerright {
    flex: 1;
    margin-right: 20px;
}

.fundi {
    text-align: center;
    margin-top: 20px;
}

/* Responsive styles */
@media screen and (max-width: 600px) {
    .f .ff img {
        margin-right: 5px;
    }

    .footermain {
        flex-direction: column;
    }

    .footerleft,
    .footercenter,
    .footerright {
        margin-right: 0;
        margin-bottom: 10px;
    }
}
    
    </style>
</head>
<body>
    <header class="headerContainer navbar">
        <div class="logoAndCatalog">
            <img src="./OIP.png" alt="logo" height="45px">
            <p class="catalog">BluehWeather</p>
        </div>
        <div class="SearchBar">   
            <center>
                <input type="text" placeholder="Search City or Zip Code" style="height: 20px;">
                <button style="width: 50px; height: 25px; background-color: lightseagreen; border: inset 0px;">
                    <img src="search.png" alt="">
                </button>
            </center>
        </div>
        <div class="hamburger">|||</div>
        <nav>
            <h3>
                <a href="Home.php"><button class="btn Home">Home</button></a>
                <a href="News.php"><button class="btn News">News</button></a>
                <a href="AboutUs.php"><button class="btn AboutUs">About Us</button></a>
                <a href="ContactUs.php"><button class="btn ContactUs">Contact Us</button></a>
                <?php
                if (isset($_SESSION['username'])) {
                    // Display "Log Out" button when logged in
                    echo '<form method="post" style="display:inline;"><button class="btn LogOut" name="logout">Log Out</button></form>';
                } else {
                    // Display "Log In" button when not logged in
                    echo '<a href="LOGIN.php"><button class="btn LogIn">Log In</button></a>';
                }
                ?>
            </h3>
        </nav>
    </header>
    <header class="ndHeader">
        <center><p style="font-size: small;"><img src="./weather-icon-png-2.png" alt="" style="height:30px;">16 DEGREES TIRANA,ALBANIA</p></center>   
</header>
<div id="background-Picture">
    <img src="./pexels-magda-ehlers-636353.jpg" alt="">
</div>  


<section id="about-us" class="about-us-section">
    <div class="containerss">
    <h2>About Us</h2>
        <p><?php echo $aboutUsData['about_text']; ?></p>

        <h3>Our Mission</h3>
        <p><?php echo $aboutUsData['mission_text']; ?></p>

        <h3>Our Team</h3>
        <p><?php echo $aboutUsData['team_text']; ?></p>

        <h3>Why Choose Us?</h3>
        <p><?php echo $aboutUsData['why_choose_text']; ?></p>
    </div>
</section>



    <footer class="footer" style="position: absolute; bottom: 0px;">
        <div class="f">
            <h3><a href="Home.html">About</a></h3>
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
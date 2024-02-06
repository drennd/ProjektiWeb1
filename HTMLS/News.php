<?php
session_start();
include 'db_connection.php';  // Include your database connection code
require './StoryController.php';
$StoryController=new StoryController();

// Check if the log out form is submitted
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: LOGIN.php');
    exit();
}

//FOOTER
 

$footerQuery = "SELECT * FROM footer LIMIT 1";
$footerResult = $conn->query($footerQuery);
$footerData = $footerResult->fetch_assoc();

?>


            <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Weather-NEWS</title>
    <link rel="stylesheet" href="MainStyle.css">
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


    <div style="height:65px"></div>

    <div class="weatherWidget"></div>
    <script src="weather.js"></script>   

<div id="background-Picture">
    <img src="./pexels-magda-ehlers-636353.jpg" alt="">
</div>

   
    <p style="font-size: larger; font-weight: bolder; margin-bottom: 20px;">Latest Stories</p>
        <table style="margin: auto">
        <?php
            $latestStories=$StoryController->getLatestStories();
            
            // Display latest story data in a div with the class "slider-item"
            foreach ($latestStories as $LateStoryRow) {
                echo '<tr>';
                echo '<td>';
                echo '<div class="slider-item" style="border-radius: 10px; background: rgba(216, 254, 255, 0.75); padding: 25px; margin: 15px;">';
                echo '<div class="rubrika" style="display:flex; justify-content: space-between; flex-direction: row-reverse;">';
                echo '<img src="' . $LateStoryRow['imgPath'] . '" alt="Story Image" class="img" style="height:200px; width: 200px; object-fit: cover">';
                echo '<div class="views_date">';
                echo '<h2 style="text-align:left;word-break: break-word; max-width: 300px;">' . $LateStoryRow['name'] . '</h2>';
                echo '<p style="text-align:left;">' . $LateStoryRow['descrption'] . '</p>';
                echo '<p style="text-align:left;font-size: xx-small;">' . date("d F Y", strtotime($LateStoryRow['time'])) . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</td>';
                echo '</tr>';

            }
            ?>
        </table>

<footer class="footer">
    <div class="f">
        <h3>About Us</h3>
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
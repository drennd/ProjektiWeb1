<?php
session_start();
include 'db_connection.php';  // Përfshij kodin për lidhjen me bazën e të dhënave
require './StoryController.php';
$StoryController=new StoryController();


// Kontrollo nëse përdoruesi është i kyçur
if (!isset($_SESSION['username'])) {
    header('Location: LOGIN.php');
    exit();
}

// Kontrollo nëse është paraqitur forma për log out mbas kyqjes
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: LOGIN.php');
    exit();
}

// Kontrollo nëse përdoruesi është admin
$is_admin = isset($_SESSION['admin']) && $_SESSION['admin'];

// Nëse përdoruesi është admin, ridrejtohuni në faqen dashboard
if ($is_admin) {
    header('Location: Dashboard.php');
    exit();
}

// Marrë të dhënat nga tabela 'images'
$query = "SELECT Name, Time, imgPath FROM images ORDER BY Time DESC LIMIT 10"; // fotot e vendosura ne slider Përderisa keni një variabël
$result = mysqli_query($conn, $query);                                 //   $connection për lidhjen me bazën e të dhënave                         
// Kontrollo për gabime në query
if (!$result) {
    die('Gabim në marrjen e të dhënave: ' . mysqli_error($connection));
}

// Merr te dhenat në nje array dhe vendosen si latest story
$imageData = mysqli_fetch_all($result, MYSQLI_ASSOC);
$imageData = $StoryController->getLatestStories();
// footeri me data


    $footerQuery = "SELECT * FROM footer LIMIT 1";
    $footerResult = $conn->query($footerQuery);
    $footerData = $footerResult->fetch_assoc();
?>

 
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Weather-HOME</title>
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

<main>
   



    <div class="TopStory">
        <div class="story-container">
            <div class="Kryesorja">
                <img src="./NYC from Wildfires.jpg" alt="" class="img" style="height:400px; width: 700px;">
            </div>  
            <div class="views_date">
                <p style="font-size: larger; font-weight: bolder;">Top Story</p>
                <h2>Orange Skies due to Wildfires from NYC</h2>
                <p style="font-size: medium;"> Millions across North America are breathing the hazardous air from the wildfires in Canada. The country is facing its worst wildfire season in history.

                    New York City, which is hundreds of miles south of the blazes, has been shrouded with orange haze because of the air quality.</p>
                <p style="font-size: xx-small;">8 June 2023</p>
                <button class="read-more-button">Read More</button>
            </div>
        </div>
    </div>
    
    
    <div class="LatestStoriesSlider">
    <p style="font-size: larger; font-weight: bolder;">Latest Stories</p>
    <div class="slider-container">
        <div class="slider-wrapper">
            
        <?php  $LatestStories = $StoryController->getLatestStories();

// Display latest story data in a div with the class "slider-item"
    foreach($LatestStories as $latestStoryRow) {
        echo '<div class="slider-item">';
        echo '<div class="rubrika">';   
        echo '<img src="' . $latestStoryRow['imgPath'] . '" alt="Story Image" class="img" style="height:400px;">';
        echo '<div class="views_date">';
        echo '<h2>' . $latestStoryRow['name'] . '</h2>';
        echo '<p style="font-size: xx-small;">' . date("d F Y", strtotime($latestStoryRow['time'])) . '</p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
?>
        </div>
    </div>
</div>


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
document.addEventListener("DOMContentLoaded", function () {
    const latestStoriesSliderWrapper = document.querySelector(".LatestStoriesSlider .slider-wrapper");
    const latestStoriesSliderItems = document.querySelectorAll(".LatestStoriesSlider .slider-item");
    const latestStoriesPrevButton = document.createElement("button");
    const latestStoriesNextButton = document.createElement("button");

    let latestStoriesCurrentIndex = 0;
    let autoSlideInterval;

    function updateLatestStoriesSlider() {
        const transformValue = -latestStoriesCurrentIndex * 100 + "%";
        latestStoriesSliderWrapper.style.transform = "translateX(" + transformValue + ")";
    }

    function showLatestStoriesSlide(index) {
        latestStoriesCurrentIndex = index;
        updateLatestStoriesSlider();
    }

    latestStoriesPrevButton.innerText = "Prev";
    latestStoriesPrevButton.classList.add("slider-button");
    latestStoriesPrevButton.addEventListener("click", function () {
        latestStoriesCurrentIndex = (latestStoriesCurrentIndex - 1 + latestStoriesSliderItems.length) % latestStoriesSliderItems.length;
        updateLatestStoriesSlider();
    });

    latestStoriesNextButton.innerText = "Next";
    latestStoriesNextButton.classList.add("slider-button");
    latestStoriesNextButton.addEventListener("click", function () {
        latestStoriesCurrentIndex = (latestStoriesCurrentIndex + 1 + latestStoriesSliderItems.length) % latestStoriesSliderItems.length;
        updateLatestStoriesSlider();
    });

    document.querySelector(".LatestStoriesSlider .slider-container").appendChild(latestStoriesPrevButton);
    document.querySelector(".LatestStoriesSlider .slider-container").appendChild(latestStoriesNextButton);
});

const hamburger = document.querySelector(".hamburger");

hamburger.addEventListener("click", function() {
    let nav = document.querySelector("nav");
    nav.style.display == "block" ? nav.style.display = "none" : nav.style.display = "block";
});
</script>
    
</body>
</html>
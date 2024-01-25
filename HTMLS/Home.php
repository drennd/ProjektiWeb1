<?php
session_start();
include 'db_connection.php';  // Include your database connection code

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: LOGIN.php');
    exit();
}

// Check if the log out form is submitted
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: LOGIN.php');
    exit();
}

// Check if the user is an admin
$is_admin = isset($_SESSION['admin']) && $_SESSION['admin'];

// If the user is an admin, redirect to the admin dashboard
if ($is_admin) {
    header('Location: Dashboard.php');
    exit();
}

// Fetch data from the 'images' table
$query = "SELECT Name, Time, imgPath FROM images ORDER BY Time DESC LIMIT 10"; // Adjust the query as needed
$result = mysqli_query($conn, $query); // Assuming you have a $connection variable for database connection

// Check for errors in the query
if (!$result) {
    die('Error fetching data: ' . mysqli_error($connection));
}

// Fetch data into an array
$imageData = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
            <p class="catalog">Catalog-Z</p>
        </div>
        <div class="SearchBar">   
            <center>
                <input type="text" placeholder="Search City or Zip Code" style="height: 20px;">
                <button style="width: 50px; height: 25px; background-color: lightseagreen; border: inset 0px;">
                    <img src="search.png" alt="">
                </button>
            </center>
        </div>
        <nav>
            <h3>
            <a href="Home.php"><button class="btn Home">Home</button></a>
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
        <?php foreach ($imageData as $image): ?>
                    <div class="slider-item">
                        <img src="<?php echo $image['imgPath']; ?> " alt="<?php echo $image['Name']; ?>"style="height=100px" >
                            <div class="views_date">
                            <h2><?php echo $image['Name']; ?></h2>
                            <p style="font-size: xx-small;"><?php echo $image['Time']; ?></p>
                            </div>'
                    </div>
                <?php endforeach; ?>
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
        resetAutoSlide();
    });

    latestStoriesNextButton.innerText = "Next";
    latestStoriesNextButton.classList.add("slider-button");
    latestStoriesNextButton.addEventListener("click", function () {
        if (latestStoriesCurrentIndex === latestStoriesSliderItems.length - 1) {
            // Check if it's the last slide

            // Check if the current slide is "Snow Avalanche"
            if (latestStoriesSliderItems[latestStoriesCurrentIndex].querySelector("h2").innerText === "Snow Avalanche hitting Brezovica Park") {
                // Find the index of the "Floods" slide and set it
                const floodsIndex = Array.from(latestStoriesSliderItems).findIndex(item => item.querySelector("h2").innerText === "Floods during the Morning, South of Boston");
                latestStoriesCurrentIndex = floodsIndex !== -1 ? floodsIndex : 0;
                updateLatestStoriesSlider();
            } else {
                // Wrap around to the first slide
                latestStoriesSliderWrapper.style.transition = "none";
                latestStoriesCurrentIndex = 0;
                updateLatestStoriesSlider();

                setTimeout(() => {
                    latestStoriesSliderWrapper.style.transition = "";
                }, 50);
            }
        } else {
            // Update the index
            latestStoriesCurrentIndex = (latestStoriesCurrentIndex + 1) % latestStoriesSliderItems.length;
            updateLatestStoriesSlider();
        }
        resetAutoSlide();
    });

    document.querySelector(".LatestStoriesSlider .slider-container").appendChild(latestStoriesPrevButton);
    document.querySelector(".LatestStoriesSlider .slider-container").appendChild(latestStoriesNextButton);

    function resetAutoSlide() {
        clearInterval(autoSlideInterval);
        autoSlideInterval = setInterval(function () {
            latestStoriesNextButton.click();
        }, 15000);
    }

    // Auto slide every 20 seconds
    resetAutoSlide(20);
});
</script>
    
</body>
</html>
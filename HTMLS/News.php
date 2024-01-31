<?php
session_start();
include 'db_connection.php';  // Include your database connection code

// Check if the log out form is submitted
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: LOGIN.php');
    exit();
}


// Initialize $insertQuery variable
$insertQuery = "";

// Check if the form for adding a new story is submitted
if (isset($_POST['addStory'])) {
    // Handle form submission to add a new story
    $storyName = $_POST['storyName'];
    $storyDescription = $_POST['storyDescription'];

    // Update the path to use the "uploads" directory
    $storyImagePath = 'uploads/' . $_FILES['storyImage']['name'];

    // Move uploaded image to the specified path
    if (move_uploaded_file($_FILES['storyImage']['tmp_name'], $storyImagePath)) {
        // Insert new story into the database
        $insertQuery = "INSERT INTO Images (name, descrption, imgPath) VALUES ('$storyName', '$storyDescription', '$storyImagePath')";
        $conn->query($insertQuery);

        // Redirect to refresh the page and avoid form resubmission
        header('Location: Home.php?action=manageStories');
        exit();
    } else {
        echo "Error moving the uploaded file.";
    }
}

?>

<?php
    if (isset($_GET['action']) && $_GET['action'] === 'editUser') {
        // Retrieve user ID from URL parameter
        $userID = $_GET['id'];

        // Query to fetch user data based on ID
        $query = "SELECT * FROM users WHERE ID = $userID";
        $result = $conn->query($query);
        $userData = $result->fetch_assoc();

        // Display a form to edit user data
        ?>
        <form method="post" action="">
            <input type="hidden" name="userID" value="<?php echo $userData['ID']; ?>">
            <label>Username:</label>
            <input type="text" name="username" value="<?php echo $userData['username']; ?>">
            <label>Email:</label>
            <input type="text" name="email" value="<?php echo $userData['email']; ?>">
            <label>Role:</label>
            <input type="text" name="role" value="<?php echo $userData['role']; ?>">
            <input type="submit" name="updateUser" value="Update User">
        </form>
        <?php

        // Handle the form submission to update user data
        if (isset($_POST['updateUser'])) {
            $newUsername = $_POST['username'];
            $newEmail = $_POST['email'];
            $newRole = $_POST['role'];

            // Update user data in the database
            $updateQuery = "UPDATE users SET username='$newUsername', email='$newEmail', role='$newRole' WHERE ID=$userID";
            $conn->query($updateQuery);

            // Redirect back to the user management section
            header('Location: Dashboard.php?action=manageUsers');
            exit();
        }
    }
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
        <div class="hamburger">|||</div>
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

   
    <p style="font-size: larger; font-weight: bolder; margin-bottom: 20px;">Latest Stories</p>
        <table style="margin: auto">
        <?php
            // Query to fetch latest stories ordered by time in descending order
            $latestStoryQuery = "SELECT * FROM Images ORDER BY time DESC LIMIT 10"; // Adjust the limit as needed
            $latestStoryResult = $conn->query($latestStoryQuery);

            // Display latest story data in a div with the class "slider-item"
            while ($latestStoryRow = $latestStoryResult->fetch_assoc()) {
                echo '<tr>';
                echo '<td>';
                echo '<div class="slider-item" style="border-radius: 10px; background: rgba(216, 254, 255, 0.75); padding: 25px; margin-bottom: 20px;">';
                echo '<div class="rubrika" style="display:flex; justify-content: space-between; flex-direction: row-reverse;">';
                echo '<img src="' . $latestStoryRow['imgPath'] . '" alt="Story Image" class="img" style="height:200px; width: 200px; object-fit: cover">';
                echo '<div class="views_date">';
                echo '<h2 style="text-align:left;word-break: break-word; max-width: 300px;">' . $latestStoryRow['name'] . '</h2>';
                echo '<p style="text-align:left;">' . $latestStoryRow['descrption'] . '</p>';
                echo '<p style="text-align:left;font-size: xx-small;">' . date("d F Y", strtotime($latestStoryRow['time'])) . '</p>';
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

const hamburger = document.querySelector(".hamburger");

hamburger.addEventListener("click", function() {
    let nav = document.querySelector("nav");
    nav.style.display == "block" ? nav.style.display = "none" : nav.style.display = "block";
});
</script>
    
</body>
</html>
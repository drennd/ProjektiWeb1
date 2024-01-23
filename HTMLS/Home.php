<?php
session_start();
include 'db_connection.php';  // Include your database connection code

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: LOGIN.php');
    exit();
}

// Check if the user is an admin
$is_admin = isset($_SESSION['admin']) && $_SESSION['admin'];
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
    $storyImagePath = 'C:\\xampp\\htdocs\\GIT\\ProjektiWeb1\\HTMLS\\' . $_FILES['storyImage']['name'];

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
    <?php
      if ($is_admin) {
        echo '<div class="admin-dashboard">';
        echo '<h2>Welcome Admin</h2>';
        echo '<h3>User Management</h3>';
        echo '<a href="?action=manageUsers">Manage Users</a>';

        if (isset($_GET['action']) && $_GET['action'] === 'manageUsers') {
            // Handle user deletion
            if (isset($_GET['deleteUser'])) {
                $userIDToDelete = $_GET['deleteUser'];
                $deleteQuery = "DELETE FROM users WHERE ID = $userIDToDelete";
                $conn->query($deleteQuery);
            }

            // Query to fetch all users
            $query = "SELECT * FROM users";
            $result = $conn->query($query);

            // Display user data in a table
            echo '<h2>User Management</h2>';
            echo '<table border="1">';
            echo '<tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Action</th></tr>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['ID'] . '</td>';
                echo '<td>' . $row['username'] . '</td>';
                echo '<td>' . $row['email'] . '</td>';
                echo '<td>' . $row['role'] . '</td>';
                echo '<td><a href="?action=editUser&id=' . $row['ID'] . '">Edit</a> | <a href="?action=manageUsers&deleteUser=' . $row['ID'] . '">Delete</a></td>';
                echo '</tr>';
            }
            echo '</table>';
        }
        // Add the story management section here
        echo '<h3>Story Management</h3>';
        echo '<a href="?action=manageStories">Manage Stories</a>';

if (isset($_GET['action']) && $_GET['action'] === 'manageStories') {
    // Handle story deletion
    if (isset($_GET['deleteStory'])) {
        $storyIDToDelete = $_GET['deleteStory'];
        $deleteStoryQuery = "DELETE FROM Images WHERE ID = $storyIDToDelete";
        $conn->query($deleteStoryQuery);
    }

    // Query to fetch all stories
    $storyQuery = "SELECT * FROM Images";
    $storyResult = $conn->query($storyQuery);

    // Display story data in a table
    echo '<h2>Story Management</h2>';
    echo '<table border="1">';
    echo '<tr><th>ID</th><th>Name</th><th>Description</th><th>Time</th><th>Image</th><th>Action</th></tr>';
        while ($storyRow = $storyResult->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $storyRow['id'] . '</td>';
            echo '<td>' . $storyRow['name'] . '</td>';
            echo '<td>' . $storyRow['descrption'] . '</td>';
            echo '<td>' . $storyRow['time'] . '</td>';
            echo '<td><img src="' . $storyRow['imgPath'] . '" alt="Story Image" style="max-height: 100px;"></td>';
            echo '<td><a href="?action=editStory&id=' . $storyRow['id'] . '">Edit</a> | <a href="?action=manageStories&deleteStory=' . $storyRow['id'] . '">Delete</a></td>';
            echo '</tr>';
        }
        echo '</table>';

        // Add form for adding new stories
        echo '<h2>Add New Story</h2>';
        echo '<form method="post" action="" enctype="multipart/form-data">';
        echo 'Name: <input type="text" name="storyName" required><br>';
        echo 'Description: <textarea name="storyDescription" required></textarea><br>';
        echo 'Image: <input type="file" name="storyImage" accept="image/*" required><br>';
        echo '<input type="submit" name="addStory" value="Add Story">';
        echo '</form>';

        if (isset($_POST['addStory'])) {
            // Handle form submission to add a new story
            $storyName = $_POST['storyName'];
            $storyDescription = $_POST['storyDescription'];
            $storyImagePath = 'uploads/' . $_FILES['storyImage']['name'];
        
            // Move uploaded image to the specified path
            if (move_uploaded_file($_FILES['storyImage']['tmp_name'], $storyImagePath)) {
                // Insert new story into the database
                $insertQuery = "INSERT INTO Images (name, descrption, imgPath) VALUES ('$storyName', '$storyDescription', '$storyImagePath')";
                $conn->query($insertQuery);
              
        
                // Get the ID of the inserted story
                $storyID = $conn->insert_id;
        
                // Add the story to the Latest Stories Slider dynamically
                echo '<div class="slider-item">';
                echo '<div class="rubrika">';
                echo '<img src="' . $storyImagePath . '" alt="Story Image" class="img" style="height:100px;">';
                echo '<div class="views_date">';
                echo '<h2>' . $storyName . '</h2>';
                echo '<p style="font-size: xx-small;">' . date("d F Y") . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
        
                // Redirect to refresh the page and avoid form resubmission
                header('Location: Home.php?action=manageStories');
                exit();
            } else {
                echo "Error moving the uploaded file.";
            }
        }
}
 echo '</div>';
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
            header('Location: Home.php?action=manageUsers');
            exit();
        }
    }
    ?>




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
            <?php
            // Query to fetch latest stories ordered by time in descending order
            $latestStoryQuery = "SELECT * FROM Images ORDER BY time DESC LIMIT 5"; // Adjust the limit as needed
            $latestStoryResult = $conn->query($latestStoryQuery);

            // Display latest story data in a div with the class "slider-item"
            while ($latestStoryRow = $latestStoryResult->fetch_assoc()) {
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
<?php
session_start();
include 'db_connection.php';  // Include your database connection code


 


// Check if the user is an admin
$is_admin = isset($_SESSION['admin']) && $_SESSION['admin'];
if ($is_admin) {
    echo '<div class="admin-dashboard">';
    echo '<h2 style="margin-top:100px">Welcome Admin</h2>';
    echo '<h3>User Management</h3>';
    echo '<a href="?action=manageUsers">Manage Users</a>';
    echo '</div>';
}
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
    $storyDate = date("Y-m-d");

    // Update the path to use the "uploads" directory
    $storyImagePath = 'uploads/' . $_FILES['storyImage']['name'];

    // Move uploaded image to the specified path
    if (move_uploaded_file($_FILES['storyImage']['tmp_name'], $storyImagePath)) {
        // Insert new story into the database
        $insertQuery = "INSERT INTO Images (name, descrption, time, imgPath) VALUES ('$storyName', '$storyDescription', '$storyDate' ,'$storyImagePath')";
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
            echo '<div class="container">';
            echo '<table border="1">';
            echo '<tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Action</th></tr>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['ID'] . '</td>';
                echo '<td>' . $row['username'] . '</td>';
                echo '<td>' . $row['email'] . '</td>';
                echo '<td>' . $row['role'] . '</td>';
                echo '<td class="btnContainer"><a class="editBtn" href="?action=editUser&id=' . $row['ID'] . '">Edit</a> | <a class="deleteBtn" href="?action=manageUsers&deleteUser=' . $row['ID'] . '">Delete</a></td>';
                echo '</tr>';
            }
            echo '</table>';
            echo '</div>';
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
    echo '<div class="container">';
    echo '<table border="1">';
    echo '<tr><th>ID</th><th>Name</th><th>Description</th><th>Time</th><th>Image</th><th>Action</th></tr>';
        while ($storyRow = $storyResult->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $storyRow['id'] . '</td>';
            echo '<td>' . $storyRow['name'] . '</td>';
            echo '<td>' . $storyRow['descrption'] . '</td>';
            echo '<td>' . $storyRow['time'] . '</td>';
            echo '<td><img src="' . $storyRow['imgPath'] . '" alt="Story Image" style="max-height: 100px;"></td>';
            echo '<td><a class="editBtn" href="?action=editStory&id=' . $storyRow['id'] . '">Edit</a> | <a class="deleteBtn" href="?action=manageStories&deleteStory=' . $storyRow['id'] . '">Delete</a></td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '</div>';

        // Add form for adding new stories
        echo '<div class="formContainer">';
        echo '<h2>Add New Story</h2>';
        echo '<form method="post" action="" enctype="multipart/form-data">';
        echo '<label for="storyName">Name:</label> <input type="text" name="storyName" required><br>';
        echo '<label for="storyDescription"> Description:</label> <textarea name="storyDescription" required></textarea><br>';
        echo '<label for="storyImage"> Image:</label> <input type="file" name="storyImage" accept="image/*" required><br>';
        echo '<input type="submit" name="addStory" value="Add Story">';
        echo '</form>';
        echo '</div>';

        if (isset($_POST['addStory'])) {
            // Handle form submission to add a new story
            $storyName = $_POST['storyName'];
            $storyDescription = $_POST['storyDescription'];
            $storyImagePath = 'uploads/' . $_FILES['storyImage']['name'];

            // Move uploaded image to the specified path
            if (move_uploaded_file($_FILES['storyImage']['tmp_name'], $storyImagePath)) {
                // Insert new story into the database
                $insertQuery = "INSERT INTO Images (name, descrption, time, imgPath) VALUES ('$storyName', '$storyDescription', '$storyDate' ,'$storyImagePath')";
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
        <div class="formContainer">
        <h2>Edit User</h2>
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
    </div>
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

   
    if (isset($_GET['action']) && $_GET['action'] === 'editStory') {
        // Retrieve story ID from URL parameter
        $storyID = $_GET['id'];
    
        // Query to fetch story data based on ID
        $editStoryQuery = "SELECT * FROM Images WHERE ID = $storyID";
        $editStoryResult = $conn->query($editStoryQuery);
        $editStoryData = $editStoryResult->fetch_assoc();
    
        // Display a form to edit story data
        ?>
        <div class="formContainer">
        <h2>Edit Story</h2>
        <form method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="storyID" value="<?php echo $editStoryData['id']; ?>">
            <label for="editStoryName">Name:</label>
            <input type="text" name="editStoryName" value="<?php echo $editStoryData['name']; ?>" required><br>
            <label for="editStoryDescription">Description:</label>
            <textarea name="editStoryDescription" required><?php echo $editStoryData['descrption']; ?></textarea><br>
            <label for="editStoryImage">Image:</label>
            <input type="file" name="editStoryImage" accept="image/*"><br>
            <input type="submit" name="updateStory" value="Update Story">
        </form>
        </div>
        <?php
    
        // Handle the form submission to update story data
        if (isset($_POST['updateStory'])) {
            $editedStoryName = $_POST['editStoryName'];
            $editedStoryDescription = $_POST['editStoryDescription'];
    
            // Check if a new image file is uploaded
            if (!empty($_FILES['editStoryImage']['name'])) {
                $editedStoryImagePath = 'uploads/' . $_FILES['editStoryImage']['name'];
    
                // Move uploaded image to the specified path
                if (move_uploaded_file($_FILES['editStoryImage']['tmp_name'], $editedStoryImagePath)) {
                    // Update story data including the new image path
                    $updateStoryQuery = "UPDATE Images SET name='$editedStoryName', descrption='$editedStoryDescription', imgPath='$editedStoryImagePath' WHERE ID=$storyID";
                    $conn->query($updateStoryQuery);
                } else {
                    echo "Error moving the uploaded file.";
                }
            } else {
                // Update story data without changing the image
                $updateStoryQuery = "UPDATE Images SET name='$editedStoryName', descrption='$editedStoryDescription' WHERE ID=$storyID";
                $conn->query($updateStoryQuery);
            }
    
            // Redirect back to the story management section
            header('Location: Home.php?action=manageStories');
            exit();
        }
    }

    //About us Text Connection and ect

    $aboutUsQuery = "SELECT * FROM about_us LIMIT 1";
    $aboutUsResult = $conn->query($aboutUsQuery);
    $aboutUsData=$aboutUsResult->fetch_assoc();

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
        <?php
            // Query to fetch latest stories ordered by time in descending order
            $latestStoryQuery = "SELECT * FROM Images ORDER BY time DESC LIMIT 10"; // Adjust the limit as needed
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
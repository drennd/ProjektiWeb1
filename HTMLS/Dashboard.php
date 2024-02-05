<?php
session_start();
include 'db_connection.php';  // Include your database connection code
require './UserController.php';// require UserController
require './StoryController.php';//require StoryController
$UserController = new UserController();
$StoryController=new StoryController();

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

?>


<?php
     // Mneagjimi i userave permes metodes GET ku kryhen operacionene menagjimin e userave  

        if (isset($_GET['action']) && $_GET['action'] === 'manageUsers') {
            // Handle user deletion
            if (isset($_GET['deleteUser'])) {
                $UserController->delete();
            }

           // Query to fetch all users
            $users = $UserController->all();
         //tabela e userave
            echo '<h2>User Management</h2>';
            echo '<div class="container">';
            echo '<table border="1">';
            echo '<tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Action</th></tr>';
            while ($row = $users->fetch_assoc()) {
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
        // tabela editUsers ku editohen userat dhe i merr me GET nga USERCONTROLLER
        if (isset($_GET['action']) && $_GET['action'] === 'editUser') {
            // Retrieve user ID from URL parameter
            $userData = $UserController->get()->fetch_assoc();
    
            // merr tabelat e editume
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
    
            // Userat e updatetum ruhen me ane te ketij funksioni ku updatohen te dhenat e userave
            if (isset($_POST['updateUser'])) {
                $UserController->edit($_POST['username'], $_POST['email'], $_POST['role']);
            }
        }
       
        // Add the story management section here
        echo '<h3>Story Management</h3>';
        echo '<a href="?action=manageStories">Manage Stories</a>';

if (isset($_GET['action']) && $_GET['action'] === 'manageStories') {
    // Handle story deletion
    if (isset($_GET['deleteStory'])) {
        $StoryController->delete();
    }
   
    // Query to fetch all stories
    $story = $StoryController->all();

    // Display story data in a table
    echo '<h2>Story Management</h2>';
    echo '<div class="container">';
    echo '<table border="1">';
    echo '<tr><th>ID</th><th>Name</th><th>Description</th><th>Time</th><th>Image</th><th>Action</th></tr>';
        while ($storyRow = $story->fetch_assoc()) {
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
           $StoryController->addStory($_POST['storyName'],$_POST['storyDescription'], $_FILES['storyImage']);
        }
}
 echo '</div>';
 if (isset($_GET['action']) && $_GET['action'] === 'editStory') {
    // Retrieve user ID from URL parameter
    $editStoryData = $StoryController->get()->fetch_assoc();

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
        $StoryController->edit($_POST['editStoryName'], $_POST['editStoryDescription'], $_FILES['editStoryImage']);
    }
}
    
    ?>

<?php
   

//FOOTAH
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
        <?php
        // lidhja e add story me slider
            $LatestStories = $StoryController->getLatestStories();

            //  një foreach që përdoret për të iteruar nëpër çdo histori në listën e historive ($LatestStories), 
            //dhe për çdo histori, ekzekuton kodin brenda bllokut të foreach
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
//Vendosni event listenerin për ngjarjen "DOMContentLoaded" për të ekzekutuar skriptin pas ngarkimit të plotë të DOM.
document.addEventListener("DOMContentLoaded", function () {

    // document.querySelector dhe document.querySelectorAll.
     //latestStoriesSliderWrapper është mbështjellësi i slider-it.
    //latestStoriesSliderItems janë artikujt e slider-it.
     
    const latestStoriesSliderWrapper = document.querySelector(".LatestStoriesSlider .slider-wrapper");
    const latestStoriesSliderItems = document.querySelectorAll(".LatestStoriesSlider .slider-item");

    // Krijimi i butonave për kontrollin e slider-it per te ecur mbrapa e perpara
    const latestStoriesPrevButton = document.createElement("button");
    const latestStoriesNextButton = document.createElement("button");

    // Variabla për të mbajtur indeksin aktual të slider-it dhe intervalin e shërbimit të slider-it automatik (jo funksional)
    let latestStoriesCurrentIndex = 0;
    let autoSlideInterval;

    // Funksioni për përditësimin e pozitës së slider-it në varg.
    function updateLatestStoriesSlider() {
        const transformValue = -latestStoriesCurrentIndex * 100 + "%";
        latestStoriesSliderWrapper.style.transform = "translateX(" + transformValue + ")";
    }

    // Funksioni për shfaqjen e slide-it me indeks të caktuar.
    function showLatestStoriesSlide(index) {
        latestStoriesCurrentIndex = index;
        updateLatestStoriesSlider();
    }

    
    //Krijohen dy elementë <button> për kontrollimin e slider-it mëparshëm (latestStoriesPrevButton) dhe të ardhshëm (latestStoriesNextButton).
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

    // Shtoni butonat në divin e slider-it.
    document.querySelector(".LatestStoriesSlider .slider-container").appendChild(latestStoriesPrevButton);
    document.querySelector(".LatestStoriesSlider .slider-container").appendChild(latestStoriesNextButton);
});

// Selektimi i elementit "hamburger" eshte funksion qe shfaq butonat "nav" kur useri e zvoglon faqen me 900px
const hamburger = document.querySelector(".hamburger");
hamburger.addEventListener("click", function() {
    let nav = document.querySelector("nav");
    nav.style.display == "block" ? nav.style.display = "none" : nav.style.display = "block";
});
</script>
    
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Weather-Contact Us</title>
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
                <a href="LOGIN.php"><button class="btn LogIn">Log In</button></a>
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
    <section id="contact-us" class="contact-us-section">
        <div class="containerss">
            <h2>Contact Us</h2>
            <p>If you have any questions or concerns, feel free to reach out to us. We are here to help!</p>
            
            <div class="contact-form">
                <form action="#" method="post">
                    <label for="name">Your Name:</label>
                    <input type="text" id="name" name="name" required>
                    
                    <label for="email">Your Email:</label>
                    <input type="email" id="email" name="email" required>
                    
                    <label for="message">Your Message:</label>
                    <textarea id="message" name="message" rows="4" required></textarea>
                    
                    <button type="submit">Send Message</button>
                </form>
            </div>
            
            <div class="contact-info">
                <h3>Contact Information</h3>
                <p>Email: info@catalog-z.com</p>
                <p>Phone: +1 (123) 456-7890</p>
                <p>Address: 123 Main Street, Cityville, Country</p>
            </div>
        </div>
    </section>




    <main>
        <footer>
            <div class="f">
                <h3>About</h3>
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
                        <p>Contact</p>
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
        </main>
</body>
</html>
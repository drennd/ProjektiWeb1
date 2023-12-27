<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Weather-HOME</title>
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
    }</style>
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


<section id="about-us" class="about-us-section">
    <div class="containerss">
        <h2>About Us</h2>
        <p>Welcome to Catalog-Z, your go-to source for [Your Company/Website] information. We're dedicated to providing you with the best [content/service] with a focus on [quality/reliability/customer satisfaction].</p>
        
        <h3>Our Mission</h3>
        <p>At Catalog-Z, our mission is to [describe your mission and goals]. We strive to [provide a brief overview of what you aim to achieve].</p>
        
        <h3>Our Team</h3>
        <p>We have a passionate and dedicated team of professionals who [briefly describe the expertise and commitment of your team members].</p>
        
        <h3>Why Choose Us?</h3>
        <p>[Provide reasons why users should choose your services/products. Highlight any unique features or advantages your company offers.]</p>
    </div>
</section>




    <footer>
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
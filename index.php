<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


  <!-- Add Google Font here -->
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">

  <!-- Keep your stylesheet link after the font -->
  <link rel="stylesheet" href="style.css">

  <style>
    .disabled-link {
      pointer-events: none;
      opacity: 0.5;
      cursor: not-allowed;
    }
    .tooltip {
      position: relative;
      display: inline-block;
    }
    .tooltip .tooltip-text {
      visibility: hidden;
      width: 160px;
      background-color: black;
      color: #fff;
      text-align: center;
      border-radius: 5px;
      padding: 6px 8px;
      position: absolute;
      z-index: 1;
      top: 125%;
      left: 50%;
      transform: translateX(-50%);
      opacity: 0;
      transition: opacity 0.3s;
    }
    .tooltip:hover .tooltip-text {
      visibility: visible;
      opacity: 1;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
  <a href="#home">Home</a>
  <a href="#agenda">Agenda</a>
  <a href="#speakers">Speakers</a>
  <a href="#venue">Venue</a>
  <a href="#contact">Contact</a>

  <?php if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]): ?>
    <a href="logout.php">Logout</a>
    <a href="payment1.php">Payment</a>
    <div class="user-initial">
      <?php echo strtoupper($_SESSION["username"][0]); ?>
    </div>
  <?php else: ?>
    <!-- Disabled Payment with Tooltip -->
    <div class="tooltip">
      <a class="disabled-link">Payment</a>
      <span class="tooltip-text">Please login/signup to proceed</span>
    </div>
    <a href="login.php">Login</a>
    <a href="signup.php">Signup</a>
  <?php endif; ?>
</div>

<!-- Sections -->
<section id="home" class="section home-section">
  <div class="home-content">
    <h1>Tech. Innovation Conference 2035</h1>
    <p>Stay Ahead of the Industry</p>
  </div>
</section>

<div id="agenda" class="section">
  <section class="agenda">
    <h2>Agenda</h2>
    <div class="agenda-item">
      <span class="time">10:00</span>
      <span class="event">Meet & Greet</span>
    </div>
    <div class="agenda-item">
      <span class="time">12:00</span>
      <span class="event">Sessions Stage</span>
    </div>
    <div class="agenda-item">
      <span class="time">13:00</span>
      <span class="event">Lunch</span>
    </div>
    <div class="agenda-item">
      <span class="time">14:00</span>
      <span class="event">Networking</span>
    </div>
    <div class="agenda-item">
      <span class="time">16:00</span>
      <span class="event">Q & A Session</span>
    </div>
  </section>
</div>

<section id="speakers" class="section">
  <div class="container">
    <h2 class="section-title">Our Speakers</h2>
    <div class="speakers-container">

      <div class="speaker-card">
        <img src="image/5.jpeg" alt="Speaker 1">
        <div class="speaker-info">
          <h3>Robyn Brown</h3>
          <p>AI Researcher, Stanford</p>
        </div>
      </div>

      <div class="speaker-card">
        <img src="image/6.jpeg" alt="Speaker 2">
        <div class="speaker-info">
          <h3>Simon Powell</h3>
          <p>CTO, TechNova</p>
        </div>
      </div>

      <div class="speaker-card">
        <img src="image/7.jpeg" alt="Speaker 3">
        <div class="speaker-info">
          <h3>Britney Swanson</h3>
          <p>Professor, KAIST</p>
        </div>
      </div>

    </div>
  </div>
</section>

<div id="venue" class="section">
  <h2>Venue</h2>
  <div class="map-container">
    <iframe 
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3794.6432422616495!2d80.6107124!3d16.4419327!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a35fb64b9300115%3A0x268108abb0296183!2sVasireddy%20Venkatadri%20Institute%20of%20Technology!5e0!3m2!1sen!2sin!4v1655642064186!5m2!1sen!2sin" 
      width="100%" 
      height="450" 
      style="border:0;" 
      allowfullscreen="" 
      loading="lazy" 
      referrerpolicy="no-referrer-when-downgrade">
    </iframe>
  </div>
</div>


<section id="contact" class="contact-section">
  <div class="container">
    <h2>Contact Us</h2>
    <p>To learn more, don’t hesitate to get in touch</p>
    
    <form class="contact-form">
      <input type="email" placeholder="Your Email Address *" required>
      <button type="submit">Submit</button>
    </form>

    <div class="social-icons">
      <a href="#"><i class="fab fa-facebook-f"></i></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
      <a href="#"><i class="fab fa-twitter"></i></a>
      <a href="#"><i class="fab fa-linkedin-in"></i></a>
    </div>
  </div>
</section>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

</body>
</html>

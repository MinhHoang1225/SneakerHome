<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sneaker Home</title>
  <?php include './assets/css/aboutus.css.php' ?>
  <?php include './component/linkbootstrap5.php' ?>
</head>
<body>
<?php include_once './component/header.php' ?>

  <div class="about-section text-center">
    <div class="container">
      <h1 class="display-4">About Us</h1>
      <p class="lead">We are passionate about providing the best footwear to our customers. Our mission is to offer stylish, comfortable, and affordable shoes for everyone.</p>
      <hr>
      <p>Founded by a group of shoe lovers, we are committed to delivering quality products and excellent customer service.</p>
    </div>
  </div>

  <!-- Team Section -->
  <div class="team-section text-center">
    <div class="container">
      <h2 class="display-4">Meet Our Team</h2>
      <div class="row">
        <!-- Team Member 1 -->
        <div class="col-md-4 team-member">
          <img src="https://via.placeholder.com/150" alt="Team Member 1">
          <h5>John Doe</h5>
          <p>Founder & CEO</p>
          <p>John has a deep passion for shoes and fashion, and he started this company to bring high-quality footwear to the masses.</p>
        </div>
        <!-- Team Member 2 -->
        <div class="col-md-4 team-member">
          <img src="https://via.placeholder.com/150" alt="Team Member 2">
          <h5>Jane Smith</h5>
          <p>Marketing Director</p>
          <p>Jane is the creative mind behind our brand’s marketing strategies. She ensures that we connect with our customers on a personal level.</p>
        </div>
        <!-- Team Member 3 -->
        <div class="col-md-4 team-member">
          <img src="https://via.placeholder.com/150" alt="Team Member 3">
          <h5>Mark Lee</h5>
          <p>Operations Manager</p>
          <p>Mark oversees the daily operations and ensures everything runs smoothly, from inventory management to customer satisfaction.</p>
        </div>
      </div>
    </div>
  </div>
</body>
<?php include './component/footer.php' ?>
</html>

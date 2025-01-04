<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sneaker Home</title>
  <?php include './assets/css/aboutus.css.php'; ?>
  <?php include './component/linkbootstrap5.php'; ?>
  
</head>
<body>
  <?php include_once './component/header.php'; ?>

  <!-- Banner Section -->
  <div class="banner">
    <div class="banner-text">
      <h1>Welcome to Sneaker Home</h1>
      <p>Your one-stop shop for stylish and comfortable footwear</p>
    </div>
  </div>

  <!-- About Section -->
  <div class="about-section">
    <div class="container">
      <h1>About Us</h1>
      <p class="lead">We are passionate about providing the best footwear to our customers. Our mission is to offer stylish, comfortable, and affordable shoes for everyone.</p>
      <hr>
      <p>Founded by a group of shoe lovers, we are committed to delivering quality products and excellent customer service.</p>
    </div>
  </div>

  <!-- Team Section -->
  <div class="team-section">
    <div class="container">
      <h2>Meet Our Team</h2>
      <div class="row">
        <!-- Team Member 1 -->
        <div class="col-md-4 team-member">
          <img src="https://via.placeholder.com/150" alt="Team Member 1">
          <h5>Minh Hoang</h5>
          <p>Leader</p>
        </div>
        <!-- Team Member 2 -->
        <div class="col-md-4 team-member">
          <img src="https://via.placeholder.com/150" alt="Team Member 2">
          <h5>Vinh Tran</h5>
          <p>Member</p>
        </div>
        <!-- Team Member 3 -->
        <div class="col-md-4 team-member">
          <img src="https://via.placeholder.com/150" alt="Team Member 3">
          <h5>Thuy Trang</h5>
          <p>Member</p>
        </div>
      </div>
    </div>
  </div>

  <?php include './component/footer.php'; ?>
</body>
</html>

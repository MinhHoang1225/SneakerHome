<?php
session_start();
require_once '../controller/profilecontroller.php';

$controller = new ProfileController();
$user_id = 1; 
$user = $controller->showProfile($user_id);
$orders = $controller->getOrdersByUserId($user_id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'user_id' => $user_id,
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => $_POST['password']
    ];
    if ($controller->updateProfile($data)) {
        header("Location: profileview.php?success=1");
        exit;
    } else {
        $error_message = "Cập nhật thông tin thất bại!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sneaker Home</title>
    <link rel="stylesheet" href="../assets/css/profile.css">
</head>
<body>
    <div class="container">
        <div class="welcome-banner">
            <p>Welcome, <b><?php echo htmlspecialchars($user['name']); ?></b></p>
        </div>

        <div class="profile-section">
            <div class="profile-info">
                <div class="avatar"></div>
                <div class="user-details">
                    <h3><?php echo htmlspecialchars($user['name']); ?></h3>
                    <a href="mailto:<?php echo htmlspecialchars($user['email']); ?>">
                        <?php echo htmlspecialchars($user['email']); ?>
                    </a>
                </div>
            </div>
        </div>

        <div class="details-section">
        <form method="POST">
            <div class="details-section">
                <div class="input-group">
                    <label>Name</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" placeholder="Your Name">
                </div>
                <div class="input-group password">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" placeholder="Your Email">
                </div>
                <div class="input-group password">
                    <label>Password</label>
                    <input type="password" name="password" id="password" value="<?php echo htmlspecialchars($user['password']); ?>" placeholder="*********">
                    <span id="toggle-password-icon" onclick="togglePassword()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16" id="eye-icon">
                            <path d="M8 3.5c2.5 0 4.67 1.56 5.44 3.68-.17.11-.33.24-.5.37-1.44-1.94-3.53-3.04-5.94-3.04-2.41 0-4.5 1.11-5.94 3.04a4.647 4.647 0 0 0-.5-.37C3.33 5.06 5.5 3.5 8 3.5zm0 9c-2.5 0-4.67-1.56-5.44-3.68.17-.11.33-.24.5-.37 1.44 1.94 3.53 3.04 5.94 3.04 2.41 0 4.5-1.11 5.94-3.04a4.647 4.647 0 0 0 .5.37C12.67 10.94 10.5 12.5 8 12.5z"/>
                        </svg>
                    </span>
                </div>

                <div class="button-group">
                    <button type="submit" class="edit-btn">Edit</button>
                </div>
            </div>
        </form>
        </div>
        <?php if (isset($_GET['success'])): ?>
            <p style="color: green; text-align: center;">Profile updated successfully!</p>
        <?php endif; ?>
        <?php if (!empty($error_message)): ?>
            <p style="color: red; text-align: center;"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <div class="order-section">
            <div class="order-column">
                <h4>Order history :</h4>
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                        <div class="order-box">
                            <p>Order ID: <?php echo htmlspecialchars($order['order_id']); ?></p>
                            <p>Status: <?php echo htmlspecialchars($order['status']); ?></p>
                            <p>Total Amount: <?php echo htmlspecialchars($order['total_amount']); ?> VND</p>
                            <p>Created At: <?php echo htmlspecialchars($order['order_date']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No orders found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
<script>
    function togglePassword() {
    var passwordInput = document.getElementById('password');
    var toggleIcon = document.getElementById('toggle-password-icon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 3.5c2.5 0 4.67 1.56 5.44 3.68-.17.11-.33.24-.5.37-1.44-1.94-3.53-3.04-5.94-3.04-2.41 0-4.5 1.11-5.94 3.04a4.647 4.647 0 0 0-.5-.37C3.33 5.06 5.5 3.5 8 3.5zm0 9c-2.5 0-4.67-1.56-5.44-3.68.17-.11.33-.24.5-.37 1.44 1.94 3.53 3.04 5.94 3.04 2.41 0 4.5-1.11 5.94-3.04a4.647 4.647 0 0 0 .5.37C12.67 10.94 10.5 12.5 8 12.5z"/>
            </svg>
        `;
    } else {
        passwordInput.type = 'password'; 
        toggleIcon.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 3.5c2.5 0 4.67 1.56 5.44 3.68-.17.11-.33.24-.5.37-1.44-1.94-3.53-3.04-5.94-3.04-2.41 0-4.5 1.11-5.94 3.04a4.647 4.647 0 0 0-.5-.37C3.33 5.06 5.5 3.5 8 3.5zm0 9c-2.5 0-4.67-1.56-5.44-3.68.17-.11.33-.24.5-.37 1.44 1.94 3.53 3.04 5.94 3.04 2.41 0 4.5-1.11 5.94-3.04a4.647 4.647 0 0 0 .5.37C12.67 10.94 10.5 12.5 8 12.5z"/>
            </svg>
        `;
    }
}

</script>
</html>

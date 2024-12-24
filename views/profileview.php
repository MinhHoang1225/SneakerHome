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

    try {
        if ($controller->updateProfile($data)) {
            header("Location: profilecontroller.php?success=1");
            exit;
        } else {
            $error_message = "Cập nhật thông tin thất bại!";
        }
    } catch (Exception $e) {
        $error_message = $e->getMessage();
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
                <div class="input-group">
                    <label>Name</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" placeholder="Your Name">
                </div>
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" placeholder="Your Email">
                </div>
                <div class="input-group">
                    <label>Password (Leave blank if unchanged)</label>
                    <input type="password" name="password" placeholder="*********">
                </div>
                <div class="button-group">
                    <button type="submit" class="edit-btn">Update Profile</button>
                </div>
            </form>
            <?php if (isset($_GET['success'])): ?>
                <p style="color: green; text-align: center;">Profile updated successfully!</p>
            <?php endif; ?>
            <?php if (!empty($error_message)): ?>
                <p style="color: red; text-align: center;"><?php echo $error_message; ?></p>
            <?php endif; ?>
        </div>

        <div class="order-column">
            <h4>Order History:</h4>
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                    <div class="order-box">
                        <p>Order ID: <?php echo htmlspecialchars($order['order_id']); ?></p>
                        <p>Status: <?php echo htmlspecialchars($order['status']); ?></p>
                        <p>Total Amount: <?php echo number_format($order['total_amount']); ?> VND</p>
                        <p>Created At: <?php echo htmlspecialchars($order['order_date']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No orders found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

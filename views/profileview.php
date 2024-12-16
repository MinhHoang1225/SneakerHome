<?php
session_start();
require_once '../controller/profilecontroller.php';

$controller = new ProfileController();
$user_id = 1; 
$user = $controller->showProfile($user_id);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'user_id' => $user_id,
        'name' => $_POST['name'],
        'username' => $_POST['username'],
        'email' => $_POST['email']
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
                    <label>Full Name</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" placeholder="Your Name">
                </div>
                <div class="input-group">
                    <label>Nick Name</label>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" placeholder="Your User Name">
                </div>
                <div class="input-group password">
                    <label>Password</label>
                    <input type="password" name="password" value="**********">
                </div>
                <div class="input-group password">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" placeholder="Your Email">
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
                <div class="order-box"></div>
                <div class="order-box"></div>
                <div class="order-box"></div>
            </div>
            <div class="order-column">
                <h4>In progress :</h4>
                <div class="order-box"></div>
                <div class="order-box"></div>
                <div class="order-box"></div>
            </div>
        </div>
    </div>
</body>
</html>

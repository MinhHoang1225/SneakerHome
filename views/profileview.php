<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <?php include_once './component/linkbootstrap5.php'; ?>
    <link rel="stylesheet" href="./assets/css/profile.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">User Profile</h1>

        <!-- Success Message -->
        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>

        <!-- Error Message -->
        <?php if (!empty($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error_message']); ?>
                <?php unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

        <!-- User Information -->
        <div class="card mb-4">
            <div class="card-header">Profile Information</div>
            <div class="card-body">
                <form action="/user/updateProfile" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password (leave blank to keep unchanged)</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>

        <!-- Order List -->
        <div class="card">
            <div class="card-header">Order History</div>
            <div class="card-body">
                <?php if (!empty($orders)): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td><?= htmlspecialchars($order['order_id']); ?></td>
                                    <td><?= htmlspecialchars($order['date']); ?></td>
                                    <td><?= htmlspecialchars($order['status']); ?></td>
                                    <td>$<?= htmlspecialchars(number_format($order['total'], 2)); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No orders found.</p>
                <?php endif; ?>
            </div>
        </div>

    </div>
</body>
</html>

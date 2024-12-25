<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .confirmation-box {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 600px;
            text-align: center;
        }
        .confirmation-message {
            font-size: 1.5rem;
            color: #28a745;
            margin-top: 20px;
        }
        .order-summary {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            margin-top: 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .order-summary h4 {
            color: #007bff;
        }
        .total-price {
            font-size: 1.25rem;
            font-weight: bold;
            color: #343a40;
        }
        .back-to-home {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 10px 30px;
            font-size: 1rem;
            margin-top: 30px;
            text-align: center;
            display: block;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }
        .back-to-home:hover {
            background-color: #0056b3;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="confirmation-box">
    <!-- Success message -->
    <i class="fas fa-check-circle fa-5x text-success"></i>
    <h2 class="confirmation-message">Payment Successful!</h2>
    <p class="lead">Thank you for your purchase. Your order is being processed and will be shipped soon.</p>

    <!-- Order Summary -->
    <div class="order-summary">
        <h4>Order Summary</h4>
        <div class="row">
            <div class="col-8">
                <p><strong>Order ID:</strong> #123456789</p>
                <p><strong>Customer Name:</strong> John Doe</p>
            </div>
            <div class="col-4 text-end">
                <p class="total-price">Total: 1,500,000 VNĐ</p>
            </div>
        </div>
        <hr>
        <div class="text-center">
            <p><strong>Shipping Address:</strong></p>
            <p>123 Street, City, Country</p>
        </div>
    </div>

    <!-- Return to Home Button -->
    <a href="index.php" class="back-to-home">
        Return to Home
    </a>
</div>

<!-- Bootstrap 5 JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

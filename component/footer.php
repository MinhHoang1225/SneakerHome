<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <!-- <link rel="stylesheet" href="footer.css"> -->
     <style>
        footer {
            margin-top: 40px;
            background-color: #add8e6;
            padding: 40px 20px;
            font-family: Arial, sans-serif;
            color: #333;
        }
        .footer-container {
            display: flex;
            justify-content: space-around;
            margin-bottom: 40px;
        }

        .footer-box {
            flex: 1;
            padding: 0 20px;
            margin-left: 90px;
        }

        .footer-box h4 {
            margin-bottom: 15px;
            font-size: 18px;
            font-weight: bold;
            color: #000;
        }

        .footer-box p {
            font-size: 14px;
            line-height: 1.5;
            color: #555;
        }
        .footer-links {
            display: flex;
            justify-content: space-around;
            text-align: left;
        }

        .links-column h4 {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            margin-bottom: 10px;
        }

        .links-column ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .links-column ul li {
            margin-bottom: 8px;
        }

        .links-column ul li a {
            text-decoration: none;
            color: #555;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .links-column ul li a:hover {
            color: #000;
        }

     </style>
</head>
<body>
    <footer>
        <div class="footer-container">
            <div class="footer-box">
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 2024s, when an unknown printer.</p>
            </div>
            <div class="footer-box">
                <h4>Follow Us</h4>
                <p>Since the 2024s, when an unknown printer took a galley of type and scrambled.</p>
            </div>
            <div class="footer-box">
                <h4>Contact Us</h4>
                <p>Vinh Tran<br>
                   Minh Hoang<br>
                   Trang Bui</p>
            </div>
        </div>
        <div class="footer-links">
            <div class="links-column">
                <h4>Information</h4>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Information</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                </ul>
            </div>

            <div class="links-column">
                <h4>Service</h4>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Information</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                </ul>
            </div>

            <div class="links-column">
                <h4>My Account</h4>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Information</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                </ul>
            </div>

            <div class="links-column">
                <h4>Our Offers</h4>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Information</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>
</html>

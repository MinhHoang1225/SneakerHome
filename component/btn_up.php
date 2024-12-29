<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scroll to Top Button</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Nút Scroll to Top */
        #scrollToTopBtn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 15px;
            font-size: 18px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            width: 70px;
            height: 70px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            visibility: hidden;
            opacity: 0;
            transition: visibility 0s linear 0.3s, opacity 0.3s ease;
        }
        #scrollToTopBtn i{
            font-size:30px;
        }

        #scrollToTopBtn:hover {
            background-color: #444;
        }

        #scrollToTopBtn.show {
            visibility: visible;
            opacity: 1;
            transition-delay: 0s;
        }
    </style>
</head>
<body>


    <!-- Nút Scroll to Top -->
    <button id="scrollToTopBtn">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <script>
        // Lấy nút scroll
        const scrollToTopBtn = document.getElementById('scrollToTopBtn');

        // Lắng nghe sự kiện cuộn trang
        window.addEventListener('scroll', () => {
            if (window.scrollY > 200) { // Hiển thị nút khi cuộn hơn 200px
                scrollToTopBtn.classList.add('show');
            } else {
                scrollToTopBtn.classList.remove('show');
            }
        });

        // Xử lý khi nhấn nút
        scrollToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth' // Hiệu ứng lướt
            });
        });
    </script>
</body>
</html>

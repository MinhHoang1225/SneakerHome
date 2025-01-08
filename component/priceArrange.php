<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <?php include './component/linkbootstrap5.php'; ?>

    <style>
        .muc_gia {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        .muc_gia .muc1 {
            display: flex;
            gap: 7px;
        }

        .muc_gia .muc1 .home a {
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
        }

        .muc_gia .muc1 .home a:hover {
            text-decoration: underline;
        }

        .muc_gia .muc1 .breadcrumb {
            font-size: 16px;
            color: #555;
            margin-left: 5px;
        }

        .muc_gia .gia {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 16px;
            color: #333;
        }

        .muc_gia .gia form {
            display: flex;
            align-items: center;
        }

        .muc_gia .gia select {
            padding: 8px 12px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 6px;
            background-color: #fff;
            cursor: pointer;
            transition: border-color 0.3s ease;
        }

        .muc_gia .gia select:focus {
            border-color: #007bff;
        }

        .muc_gia .gia select option {
            padding: 8px;
        }
    </style>
</head>
<body>
    <!-- Container chính -->
    <div class="container my-3">
        <!-- Thanh điều hướng và bộ lọc -->
        <div class="muc_gia">
            <div class="muc1">
                <!-- Link Home -->
                <div class="home gap-1">
                    <a href="/SneakerHome/home" style="color:#0c6478">Home</a>
                </div>
                <!-- Breadcrumb (Hiển thị danh mục hiện tại) -->
                <div class="breadcrumb"></div>
            </div>

            <!-- Bộ lọc sắp xếp theo giá -->
            <div class="gia">
                <form id="priceForm" method="GET">
                    <select name="sort_price" id="price" onchange="submitForm()">
                        <option value="">Thứ tự mặc định</option>
                        <option value="asc" <?= isset($_GET['sort_price']) && $_GET['sort_price'] == 'asc' ? 'selected' : '' ?>>
                            Thứ tự theo giá: thấp đến cao
                        </option>
                        <option value="desc" <?= isset($_GET['sort_price']) && $_GET['sort_price'] == 'desc' ? 'selected' : '' ?>>
                            Thứ tự theo giá: cao xuống thấp
                        </option>
                    </select>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Tự động gửi form khi thay đổi giá trị sắp xếp
        function submitForm() {
            document.getElementById('priceForm').submit();
        }

        // Cập nhật nội dung breadcrumb dựa trên URL hiện tại
        document.addEventListener("DOMContentLoaded", () => {
            const breadcrumbElement = document.querySelector(".breadcrumb");

            if (!breadcrumbElement) {
                console.error("Không tìm thấy phần tử .breadcrumb");
                return;
            }

            // Lấy URL hiện tại
            const currentPage = (window.location.pathname + window.location.search).toLowerCase();

            // Ánh xạ đường dẫn với tên mục
            const pageMappings = {
                "/sneakerhome/product/productscategory?category_id=1": "Shoes",
                "/sneakerhome/product/productscategory?category_id=2": "Clothes",
                "/sneakerhome/product/productscategory?category_id=3": "Accessories",
                "/sneakerhome/product/favorite": "Collections",
            };

            // Xác định tên mục hiển thị hoặc mặc định là "Home"
            const pageName = pageMappings[currentPage] || "Home";

            // Cập nhật nội dung breadcrumb
            breadcrumbElement.innerHTML = `<b>/ ${pageName}</b>`;
        });
    </script>
</body>
</html>

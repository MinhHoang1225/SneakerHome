<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sneaker Home</title>
    <?php include "../assets/css/admin.css.php"; ?>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">
            <img src="../assets/img/Shoe Logo.png" alt="" style="width: 200px;">
        </div>
        <nav class="menu">
            <a href="#" data-section="dashboard" class="active">
                <i class="fa-solid fa-chart-line"></i> Thống kê
            </a>
            <a href="#" data-section="users">
                <i class="fa-solid fa-users"></i> Khách hàng
            </a>
            <a href="#" data-section="products">
                <i class="fa-solid fa-shoe-prints"></i> Sản phẩm
            </a>
            <a href="#" data-section="orders-by-user">
                <i class="fa-solid fa-cart-shopping"></i> QLĐH theo khách hàng
            </a>
            <a href="#" data-section="orders">
                <i class="fa-solid fa-cart-shopping"></i>QLĐH theo trạng thái
            </a>
            <a href="#" class="logout">
                <i class="fa-solid fa-sign-out-alt"></i> Đăng xuất
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main">
        <header class="header">
            <h1>Quản lý Bán Hàng</h1>
        </header>

        <!-- Section: Thống kê -->
        <section id="dashboard" class="section">
            <h2>Thống kê</h2>
            <div class="stats">
                <div class="stat">
                    <i class="fa-solid fa-users"></i>
                    <h3>Khách hàng</h3>
                    <p id="total-customers">0</p>
                </div>
                <div class="stat">
                    <i class="fa-solid fa-shoe-prints"></i>
                    <h3>Sản phẩm</h3>
                    <p id="total-products">0</p>
                </div>
            </div>
        </section>

        <!-- Section: Khách hàng -->
        <section id="users" class="section">
            <h2>Khách hàng</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dữ liệu khách hàng sẽ được thêm ở đây -->
                </tbody>
            </table>
        </section>

        <!-- Section: Sản phẩm -->
        <section id="products" class="section">
            <h2>Sản phẩm</h2>
            <button class="btn add_product">Thêm Sản Phẩm</button>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Hình ảnh</th>
                        <th>Tên Giày</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dữ liệu sản phẩm sẽ được thêm ở đây -->
                </tbody>
            </table>
        </section>

        <!-- Section: Đơn hàng theo khách hàng -->
        <section id="orders-by-user" class="section">
            <h2>QLĐH theo khách hàng</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Mã khách hàng</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Xem đơn hàng</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dữ liệu đơn hàng sẽ được thêm ở đây -->
                </tbody>
            </table>
            <div id="order-details"></div>
        </section>

        <!-- Section: Đơn hàng -->
        <section id="orders" class="section">
            <h2>Đang giao</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Tài khoản người dùng</th>
                        <th>Thời gian đặt hàng</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dữ liệu đơn hàng sẽ được thêm ở đây -->
                </tbody>
            </table>
        </section>
    </main>

  
    <!-- Modal: Thêm Sản Phẩm -->
    <div id="addProductModal" class="modal">
        <div class="modal-content">
            <span class="close " onclick="document.getElementById('addProductModal').style.display='none'">&times;</span>
            <form action="admin.php" method="POST" enctype="multipart/form-data">
                <h3 class="">Thêm Sản Phẩm</h3>
                <label for="name">Tên sản phẩm:</label>
                <input type="text" id="name" name="name" required>
                <label for="price">Giá:</label>
                <input type="text" id="price" name="price" required>
                <label for="stock">Số lượng:</label>
                <input type="number" id="stock" name="stock" required>
                <label for="image">Hình ảnh:</label>
                <input type="file" id="image" name="image" required>
                <button class="" type="submit" name="add_product">Thêm</button>
            </form>
        </div>
    </div>
</body>
<script>
function openEditModal(productId, name, price, stock, img) {
    // Hiển thị modal
    const modal = document.getElementById('editModal');
    modal.style.display = 'block';

    // Điền thông tin sản phẩm vào form
    document.getElementById('product_id').value = productId;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_price').value = price;
    document.getElementById('edit_stock').value = stock;

    // Đặt hình ảnh cũ nếu có
    if (img) {
        document.getElementById('edit_image_preview').src = `../assets/img/${img}`;
        document.getElementById('edit_image_preview').style.display = 'block';
    } else {
        document.getElementById('edit_image_preview').style.display = 'none';
    }
}

function closeModal() {
    document.getElementById('editModal').style.display = 'none';
}
        // JS cho modal
        var modal = document.getElementById("addProductModal");
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
      const menuItems = document.querySelectorAll(".menu a");
      const sections = document.querySelectorAll(".section");
      menuItems.forEach((item) => {
        item.addEventListener("click", (event) => {
          event.preventDefault();
          menuItems.forEach((menuItem) => menuItem.classList.remove("active"));
          item.classList.add("active");
          sections.forEach((section) => {
            section.style.display = "none";
          });
          const sectionId = item.getAttribute("data-section");
          const activeSection = document.getElementById(sectionId);
          if (activeSection) {
            activeSection.style.display = "block";
          }
        });
      });
      document.addEventListener("DOMContentLoaded", () => {
        sections.forEach((section) => (section.style.display = "none"));
        document.getElementById("dashboard").style.display = "block";
      });

    function confirmDelete(productName) {
    return confirm(`Bạn có chắc chắn muốn xóa sản phẩm "${productName}" không?`); }

    function updateOrderStatus(orderId, newStatus) {
        // Tạo đối tượng XMLHttpRequest
        var xhr = new XMLHttpRequest();

        // Mở kết nối POST
        xhr.open('POST', '../view/update_order_status.php', true);

        // Định nghĩa kiểu dữ liệu mà bạn sẽ gửi (x-www-form-urlencoded là kiểu phổ biến cho POST)
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Lắng nghe phản hồi từ server
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(xhr.responseText); // In ra phản hồi từ PHP
                alert(xhr.responseText); // Hiển thị thông báo phản hồi
                location.reload();
            }
        };

        // Gửi dữ liệu (dưới dạng x-www-form-urlencoded)
        var data = "order_id=" + orderId + "&status=" + encodeURIComponent(newStatus);
        xhr.send(data);
    }
    function fetchOrderDetails(orderId) {
        var detailsRow = document.getElementById('order-details-' + orderId);
        var detailsDiv = detailsRow.querySelector('div');

        // Kiểm tra nếu đã ẩn thì hiển thị và gọi AJAX
        if (detailsRow.style.display === 'none') {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../view/fetch_order_details.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    detailsDiv.innerHTML = xhr.responseText; // Đưa nội dung vào div
                    detailsRow.style.display = 'table-row'; // Hiển thị hàng
                }
            };
            xhr.send('order_id=' + orderId); // Gửi order_id đến PHP
        } else {
            // Ẩn chi tiết nếu đã hiển thị
            detailsRow.style.display = 'none';
        }
    }
document.querySelectorAll('.view-orders').forEach(item => {
    item.addEventListener('click', function(e) {
        e.preventDefault();
        const userId = this.getAttribute('data-user-id');

        fetch(`../view/get_user_orders.php?user_id=${userId}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById('order-details').innerHTML = data;
            })
            .catch(error => console.error('Lỗi khi tải đơn hàng:', error));
    });
});
    function sendExpiredNotification(userId) {
        // Gửi yêu cầu tới file PHP để gửi thông báo
        const confirmSend = confirm("Bạn có chắc muốn gửi thông báo?");
        if (confirmSend) {
            window.location.href = 'send_expired_notification.php?user_id=' + userId;
        }
    }
</script>
</html>
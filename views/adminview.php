<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sneaker Home</title>
    <style>
  :root {
  --bg-header: #e5e5e5;
  --bg-btn: #0c6478;
  --bg-hover-btn: #159198;
  --main-font: sans-serif;
  --main-color: black;
  --second-color: #666666B3;
  --title-text-size: 32px;
  --main-text-size: 16px;
}

body {
  font-family: "Roboto", Arial, sans-serif;
  margin: 0;
  padding: 0;
  display: flex;
  height: 100vh;
  background-color: var(--bg-header);
}

/* Sidebar */
.sidebar {
  width: 240px;
  background: linear-gradient(135deg, var(--bg-header), #555);
  color: white;
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  display: flex;
  flex-direction: column;
  padding: 20px;
  box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
}

.sidebar .logo {
  font-size: 1.5rem;
  font-weight: bold;
  margin-bottom: 20px;
  display: flex;
  align-items: center;
  gap: 10px;
  color: var(--bg-hover-btn);
}

.sidebar .menu a {
  color: white;
  text-decoration: none;
  padding: 15px;
  display: flex;
  align-items: center;
  gap: 15px;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

.sidebar .menu a:hover {
  background-color: var(--second-color);
  color: var(--main-color);
}

.sidebar .menu a.active {
  background-color: var(--bg-hover-btn);
  color: var(--main-color);
}

.sidebar .menu a.logout {
  margin-top: auto;
  background-color: var(--bg-btn);
}

.sidebar .menu a.logout:hover {
  background-color: var(--bg-hover-btn);
}

/* Main Content */
.main {
  margin-left: 270px;
  padding: 20px;
  width: calc(100% - 270px);
}

.header {
  background-color: var(--bg-header);
  color: var(--main-color);
  padding: 15px;
  border-radius: 5px;
  font-size: 1.5rem;
  box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);
}

/* Section */
.section {
  margin-top: 20px;
}

.stats {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  margin-top: 20px;
}

.stat {
  background-color: #fff;
  border-radius: 10px;
  padding: 20px;
  text-align: center;
  box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.stat:hover {
  transform: translateY(-5px);
}

.stat i {
  font-size: 2rem;
  color: var(--bg-hover-btn);
  margin-bottom: 10px;
}

.stat h3 {
  font-size: 1.2rem;
  color: var(--main-color);
}

.stat p {
  font-size: 1.5rem;
  font-weight: bold;
  color: var(--second-color);
}

/* Table */
.table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.table th,
.table td {
  border: 1px solid #ddd;
  padding: 10px;
  text-align: left;
}

.table th {
  background-color: #333;
  color: #fff;
}

.table td {
  background-color: #fff;
}

.btn {
  padding: 5px 10px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
  
}

.btn.edit {
  background-color: var(--bg-hover-btn);
  color: white;
}

.btn.delete {
  background-color: #e74c3c;
  color: white;
}

/* Footer */
.footer {
  text-align: center;
  padding: 10px;
  background-color: var(--bg-header);
  color: var(--main-color);
  border-radius: 5px;
  margin-top: 20px;
}
.add_product{
  padding: 10px;
  color: var(--main-color);
  background-color: var(--bg-btn);
  font-size: 16px;
  font-weight: bold;
}
.add_product:hover{
  color: var(--bg-header);
  background-color: var(--bg-hover-btn);
  transform: translateY(-2px);
  transition: transform 0.3s ease;
}

/* Modal background */
.modal {
    display: none; /* Mặc định không hiển thị */
    position: fixed;
    z-index: 1; /* Đảm bảo modal luôn ở trên các phần tử khác */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0, 0, 0); /* Màu nền đen mờ */
    background-color: rgba(0, 0, 0, 0.4); /* Nền đen mờ với độ trong suốt */
}

/* Modal content */
.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%; /* Chiều rộng modal */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Đổ bóng nhẹ */
    border-radius: 8px; /* Bo tròn các góc */
}

/* Đóng modal */
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Form container */
form {
    display: flex;
    flex-direction: column;
    gap: 15px; /* Khoảng cách giữa các trường trong form */
}

/* Label và input */
label {
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 5px;
    font-family: "Work Sans", sans-serif;
}

input[type="text"],
input[type="number"],
input[type="file"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    width: 100%;
    box-sizing: border-box;
}

/* Button */
button {
    background-color: var(--bg-btn); /* Màu nền nút */
    color: white;
    padding: 10px;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: var(--bg-hover-btn); /* Màu nền khi hover */
}

/* Thêm khoảng cách cho tiêu đề */
h3 {
    text-align: center;
    font-size: 24px;
    font-family: "Work Sans", sans-serif;
    color: var(--main-color);
}
a {
    color: #007bff;
    text-decoration: none;
    cursor: pointer;
}

a:hover {
    text-decoration: underline;
}
#order-details-td div {
    border: 1px solid #ddd;
    background-color: #fff;
    padding: 15px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Hiệu ứng đổ bóng nhẹ */
}

#order-details-td div p {
    margin: 0;
    padding: 5px 0;
    color: #333;
    font-size: 14px;
}
    </style>
</head>
<body>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">
            <img src="../assets/img//Shoe Logo.png" alt="" style="width: 200px;" onclick="navigateTo('../views/homeviews.php')">
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
                    <!-- Data will be dynamically added here -->
                </tbody>
            </table>
        </section>

        <!-- Section: Sản phẩm -->
        <section id="products" class="section">
            <h2>Sản phẩm</h2>
            <button class="btn add_product" onclick="document.getElementById('addProductModal').style.display='block'">Thêm Sản Phẩm</button>
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
                    <!-- Data will be dynamically added here -->
                </tbody>
            </table>
        </section>
    </main>
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
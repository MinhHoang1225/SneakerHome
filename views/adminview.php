<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Admin</title>
    <?php include "./assets/css/admin.css.php"; ?>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">
            <a href="../controllers/home"><img src="../assets/img/Shoe Logo.png" alt="Logo" style="width: 200px;"></a>
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
                <i class="fa-solid fa-cart-shopping"></i> QLĐH theo trạng thái
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
                    <p id="total-customers"><?php echo $dashboardData['total_customers']; ?></p>
                </div>
                <div class="stat">
                    <i class="fa-solid fa-shoe-prints"></i>
                    <h3>Sản phẩm</h3>
                    <p id="total-products"><?php echo $dashboardData['total_products']; ?></p>
                </div>
                <div class="stat">
                    <i class="fa-solid fa-cart-arrow-down"></i>
                    <h3>Đơn hàng</h3>
                    <p id="total-orders"><?php echo $dashboardData['total_orders']; ?></p>
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
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><?php echo $customer['user_id']; ?></td>
                            <td><?php echo $customer['name']; ?></td>
                            <td><?php echo $customer['email']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <!-- Section: Sản phẩm -->
        <section id="products" class="section">
            <h2>Sản phẩm</h2>
            <button class="btn add_product" id="openModalBtn">Thêm Sản Phẩm</button>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Hình ảnh</th>
                        <th>Tên Giày</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Sửa</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo $product['product_id']; ?></td>
                            <td><img src="<?php echo $product['image_url']; ?>" alt="Ảnh sản phẩm" width="50"></td>
                            <td><?php echo $product['name']; ?></td>
                            <td><?php echo $product['price']; ?></td>
                            <td><?php echo $product['stock']; ?></td>
                            <td>
                            <button class="btn edit" id="editModalBtn">Sửa</button>                        
                            </td>
                            <td>
                                <form method="POST" action="/SneakerHome/admin/deleteProduct">
                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                    <button type="submit" class="btn delete">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <section id="orders-by-user" class="section">
            <h2>QLĐH theo khách hàng</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Tên khách hàng</th>
                        <th>Email</th>
                        <!-- <th>Xem đơn hàng</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($getOrdersByUser as $order): ?>
                        <tr>
                            <td><?php echo $order['order_id']; ?></td>
                            <td><?php echo $order['name']; ?></td>
                            <td><?php echo $order['email']; ?></td>
                            <!-- <td><button>Xem</button></td> -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div id="order-details"></div>
        </section>
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
                    <?php if (!empty($ordersByStatusInprogress)): ?>
                        <?php foreach ($ordersByStatusInprogress as $order): ?>
                        <tr>
                            <td><?= $order['order_id'] ?></td>
                            <td><?= $order['name'] ?></td>
                            <td><?= $order['order_date'] ?></td>
                            <td><?= $order['status'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4">Không có đơn hàng nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <h2>Đã giao</h2>
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
                    <?php if (!empty($ordersByStatusCompleted)): ?>
                        <?php foreach ($ordersByStatusCompleted as $order): ?>
                            <tr>
                                <td><?php echo $order['order_id']; ?></td>
                                <td><?php echo $order['name']; ?></td>
                                <td><?php echo $order['order_date']; ?></td>
                                <td><?php echo $order['status']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4">Không có đơn hàng nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <h2>Đã hủy</h2>
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
                    <?php if (!empty($ordersByStatusCancelled)): ?>
                        <?php foreach ($ordersByStatusCancelled as $order): ?>
                            <tr>
                                <td><?php echo $order['order_id']; ?></td>
                                <td><?php echo $order['name']; ?></td>
                                <td><?php echo $order['order_date']; ?></td>
                                <td><?php echo $order['status']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4">Không có đơn hàng nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
        <!-- Modal: Thêm Sản Phẩm -->
        <div id="addProductModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="document.getElementById('addProductModal').style.display='none'">&times;</span>
                <form action="/SneakerHome/Admin/addProduct" method="POST" enctype="multipart/form-data">
                    <h3>Thêm Sản Phẩm</h3>
                    <label for="name">Tên sản phẩm:</label>
                    <input type="text" id="name" name="name" required>
                    <label for="price">Giá:</label>
                    <input type="text" id="price" name="price" required>
                    <label for="stock">Số lượng:</label>
                    <input type="number" id="stock" name="stock" required>
                    <label for="image">Hình ảnh:</label>
                    <input type="file" id="image" name="image" required>
                    <button type="submit" class="btn">Thêm</button>
                </form>
            </div>
        </div>

        <div id="editModal" class="modal">
            <div class="modal-content">
            <span class="close" onclick="document.getElementById('editModal').style.display='none'">&times;</span>
            <form action = "/SneakerHome/Admin/updateProduct" method="POST" enctype="multipart/form-data">
                    <h3>Sửa Sản Phẩm</h3>
                    <input type="hidden" id="product_id" name="product_id">

                    <label for="name">Tên sản phẩm</label>
                    <input type="text" id="edit_name" name="name" required>

                    <label for="price">Giá</label>
                    <input type="number" id="edit_price" name="price" required>

                    <label for="stock">Số lượng</label>
                    <input type="number" id="edit_stock" name="stock" required>

                    <label for="image">Hình ảnh</label>
                    <input type="file" id="edit_image" name="image">

                    <button type="submit" name="edit_product">Cập nhật</button>
                </form>
            </div>
        </div>

    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../assets/js/admin.js"></script>
    <script>
        // Modal sửa sản phẩm
const editModalBtn = document.getElementById('editModalBtn');
const closeEditModal = document.getElementById('close');
const editModal = document.getElementById('editModal');

editModalBtn.addEventListener('click', () => {
    editModal.style.display = 'block';
});

closeEditModal.addEventListener('click', () => {
    editModal.style.display = 'none';
});

window.addEventListener('click', (event) => {
    if (event.target === editModal) {
        editModal.style.display = 'none';
    }
});

    </script>
</body>
</html>

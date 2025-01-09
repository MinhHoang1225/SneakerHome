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
<?php if (isset($_SESSION['success_message'])): ?>
    <script>
        alert("<?php echo htmlspecialchars($_SESSION['success_message']); ?>");
    </script>
    <?php unset($_SESSION['success_message']);  ?>
<?php endif; ?>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">
            <a href="../controllers/home"><img src="../assets/img/Shoe Logo.png" alt="Logo" style="width: 200px;"></a>
        </div>
        <nav class="menu">
            <a href="#" data-section="dashboard" class="active">
                <i class="fa-solid fa-chart-line"></i> Statistics
            </a>
            <a href="#" data-section="users-section" >
                <i class="fa-solid fa-users"></i> Customer
            </a>
            <a href="#" data-section="products-section" >
                <i class="fa-solid fa-shoe-prints"></i> Product
            </a>
            <a href="#" data-section="orders-section" >
                <i class="fa-solid fa-cart-shopping"></i> Order Management by Customer
            </a>
            <a href="#" data-section="reviews-section" >
                <i class="fa-solid fa-cart-shopping"></i> Order Management by Status
            </a>
            <form method="POST" action="/SneakerHome/User/logout">
                  <button type="submit"><i class="fa-solid fa-right-from-bracket"></i> Log Out</button>
            </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main">
        <header class="header">
            <h1>Sales Management</h1>
        </header>

        <!-- Section: Statistics -->
        <section id="dashboard" class="section">
            <h2>Statistics</h2>
            <div class="stats">
                <div class="stat">
                    <i class="fa-solid fa-users"></i>
                    <h3>Customer</h3>
                    <p id="total-customers"><?php echo $dashboardData['total_customers']; ?></p>
                </div>
                <div class="stat">
                    <i class="fa-solid fa-shoe-prints"></i>
                    <h3>Product</h3>
                    <p id="total-products"><?php echo $dashboardData['total_products']; ?></p>
                </div>
                <div class="stat">
                    <i class="fa-solid fa-cart-arrow-down"></i>
                    <h3>Order</h3>
                    <p id="total-orders"><?php echo $dashboardData['total_orders']; ?></p>
                </div>
            </div>
        </section>

        <!-- Section: Customer -->
    <section id="users-section" class="section">
    <h2>Customer</h2>
    <div class="search-bar">
        <form action="/SneakerHome/Admin/searchUser" method="POST">
            <input 
                type="text" 
                id="search_input" 
                name="keyword" 
                placeholder="Enter a name to search..." 
                required
            >
            <button type="submit">Search</button>
        </form>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody id="users-data">
            <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?php echo $customer['user_id']; ?></td>
                    <td><?php echo $customer['name']; ?></td>
                    <td><?php echo $customer['email']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination" id="users-pagination"></div>
</section>

        <!-- Section: Product -->
        <section id="products-section" class="section">
            <h2>Product</h2>
            <div class="search-bar">
                <form action="/SneakerHome/Admin/searchProduct" method="POST">
                    <input 
                        type="text" 
                        id="search_input" 
                        name="keyword" 
                        placeholder="Enter a name to search..." 
                        required
                    >
                    <button type="submit" id="searchProduct">Search</button>
                </form>
            </div>
            <button class="btn add_product" id="openModalBtn">Add Product</button>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Shoe Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody id="products-data">
                    <?php foreach ($products as $product): ?>
                        <tr class="item">
                            <td><?php echo $product['product_id']; ?></td>
                            <td><img src="<?php echo $product['image_url']; ?>" alt="Product Image" width="50"></td>
                            <td><?php echo $product['name']; ?></td>
                            <td><?php echo $product['price']; ?></td>
                            <td><?php echo $product['stock']; ?></td>
                            <td>
                                <form action = "/SneakerHome/Admin/getProduct" method="POST" >
                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                    <button type="submit"  id="editModalBtn">Edit</button>                                
                                </form>                    
                            </td>
                            <td>
                                <form method="POST" action="/SneakerHome/admin/deleteProduct">
                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                    <button type="submit" class="btn delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div class="pagination" id="products-pagination"></div>
        </section>
        <section id="orders-section" class="section">
            <h2>Order Management by Customer</h2>
            <table class="table">
                <thead>
                    <tr class="item">
                        <th>Order Code</th>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <!-- <th>Xem đơn hàng</th> -->
                    </tr>
                </thead>
                <tbody id="orders-data">
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
            
            <div class="pagination" id="orders-pagination"></div>
        </section>
        <section id="reviews-section" class="section">
            <h2>In transit</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Order Code</th>
                        <th>User Account</th>
                        <th>Order Time</th>
                        <th>Status</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="reviews-data">
                    <?php if (!empty($ordersByStatusInprogress)): ?>
                        <?php foreach ($ordersByStatusInprogress as $order): ?>
                        <tr>
                            <td><?= $order['order_id'] ?></td>
                            <td><?= $order['name'] ?></td>
                            <td><?= $order['order_date'] ?></td>
                            <td><?= $order['status'] ?></td>
                            <td> 
                                <form method="POST" action="/SneakerHome/admin/cancelOrder">
                                    <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                    <button type="submit" class="btn deleteOrder">Cancel Order</button>
                                </form>
                            </td>
                            <td> 
                                <form method="POST" action="/SneakerHome/admin/completeOrder">
                                    <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                    <button type="submit" class="btn completeOrder">Completed</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4">There are no orders.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <h2>Delivered</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Order Code</th>
                        <th>User Account</th>
                        <th>Order Time</th>
                        <th>Status</th>
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
                        <tr><td colspan="4">There are no orders.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <h2>Canceled</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Order Code</th>
                        <th>User Account</th>
                        <th>Order Time</th>
                        <th>Status</th>
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
                        <tr><td colspan="4">There are no orders.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <div class="pagination" id="reviews-pagination"></div>
        </section>
        <!-- Modal: Add Product -->
        <div id="addProductModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="document.getElementById('addProductModal').style.display='none'">&times;</span>
                <form action="/SneakerHome/Admin/addProduct" method="POST" enctype="multipart/form-data">
                    <h3>Add Product</h3>
                    <label for="name">Product Name:</label>
                    <input type="text" id="name" name="name" required>
                    <label for="price">Price:</label>
                    <input type="text" id="price" name="price" required>
                    <label for="stock">Quantity:</label>
                    <input type="number" id="stock" name="stock" required>
                    <label for="image">Image:</label>
                    <input type="file" id="image" name="image" required>
                    <button type="submit" class="btn">Add</button>
                </form>
            </div>
        </div>

        <div id="editModal" class="modal">
            <div class="modal-content">
            <span class="close" onclick="document.getElementById('editModal').style.display='none'">&times;</span>
            <form action = "/SneakerHome/admin/editProduct" method="POST" enctype="multipart/form-data">
                    <h3>Edit Sản Phẩm</h3>
                    <input type="hidden" id="product_id" name="product_id" value="<?= htmlspecialchars($getproduct ['product_name']) ?>">

                    <label for="name">Product Name</label>
                    <input type="text" id="edit_name" name="name" required>

                    <label for="price">Price</label>
                    <input type="number" id="edit_price" name="price" required>

                    <label for="stock">Quantity</label>
                    <input type="number" id="edit_stock" name="stock" required>

                    <label for="image">Image</label>
                    <input type="file" id="edit_image" name="image">

                    <button type="submit" name="edit_product">Update</button>
                </form>
            </div>
        </div>

    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../assets/js/admin.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function () {
    const menuItems = document.querySelectorAll(".menu-item");
    const sections = document.querySelectorAll(".section");

    menuItems.forEach((item) => {
        item.addEventListener("click", function (e) {
            e.preventDefault();

            // Ẩn tất cả các section
            sections.forEach((section) => {
                section.classList.remove("active");
            });

            // Delete class active của tất cả menu
            menuItems.forEach((menuItem) => {
                menuItem.classList.remove("active");
            });

            // Hiện section được chọn
            const sectionId = this.dataset.section;
            const selectedSection = document.getElementById(sectionId);
            if (selectedSection) {
                selectedSection.classList.add("active");
            }

            // Thêm class active vào menu được chọn
            this.classList.add("active");
        });
    });

    // Hiển thị section đầu tiên mặc định
    const firstMenuItem = menuItems[0];
    if (firstMenuItem) {
        firstMenuItem.click();
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const itemsPerPage = 7; // Quantity mục mỗi trang

    function setupPagination(sectionId, dataId, paginationId) {
        const section = document.querySelector(sectionId);
        const dataContainer = document.querySelector(dataId);
        const paginationContainer = document.querySelector(paginationId);

        // Lấy tất cả các hàng trong bảng
        const rows = dataContainer.querySelectorAll("tr");
        const totalItems = rows.length;

        function renderPagination(totalItems, itemsPerPage) {
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            paginationContainer.innerHTML = "";

            for (let i = 1; i <= totalPages; i++) {
                const pageLink = document.createElement("a");
                pageLink.href = "#";
                pageLink.textContent = i;
                pageLink.dataset.page = i;
                pageLink.className = "page-link";
                pageLink.addEventListener("click", function (e) {
                    e.preventDefault();
                    const page = parseInt(this.dataset.page);
                    paginate(page);
                    setActivePage(page); // Đặt trang hiện tại là active
                });

                paginationContainer.appendChild(pageLink);
            }
        }

        function paginate(page) {
            const start = (page - 1) * itemsPerPage;
            const end = start + itemsPerPage;

            // Hiển thị chỉ các hàng thuộc trang hiện tại
            rows.forEach((row, index) => {
                if (index >= start && index < end) {
                    row.style.display = ""; // Hiển thị hàng
                } else {
                    row.style.display = "none"; // Ẩn hàng
                }
            });
        }

        // Hàm để thay đổi trang hiện tại (có màu sắc)
        function setActivePage(page) {
            const pageLinks = paginationContainer.querySelectorAll(".page-link");
            pageLinks.forEach((link) => {
                if (parseInt(link.dataset.page) === page) {
                    link.classList.add("active"); // Thêm lớp active cho trang hiện tại
                } else {
                    link.classList.remove("active"); // Delete lớp active của các trang khác
                }
            });
        }

        // Khởi tạo phân trang
        if (totalItems > 0) {
            paginate(1); // Hiển thị trang đầu tiên
            renderPagination(totalItems, itemsPerPage);
            setActivePage(1); // Đặt trang 1 là trang hiện tại
        }
    }

    // Gọi hàm cho từng section
    setupPagination("#users-section", "#users-data", "#users-pagination");
    setupPagination("#products-section", "#products-data", "#products-pagination");
    setupPagination("#orders-section", "#orders-data", "#orders-pagination");
    setupPagination("#reviews-section", "#reviews-data", "#reviews-pagination");
});

    
    </script>
</body>
</html>

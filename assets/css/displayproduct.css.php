<style>
.product-card {
    border: 1px solid #eaeaea;
    border-radius: 10px;
    padding: 15px;
    text-align: center;
    position: relative;
}
.product-card img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
}
.product-card .icons {
    position: absolute;
    top: 10px;
    right: 10px;
}
.product-card .icons i {
    margin-left: 10px;
    color: #00aaff;
}
.product-card .price {
    color: #00aaff;
    font-size: 1.2em;
    font-weight: bold;
}
.product-card .old-price {
    text-decoration: line-through;
    color: #999;
    margin-left: 10px;
}
.product-card .discount {
    color: #ff0000;
    margin-left: 10px;
}
.mx-3 {
    text-decoration: none;
    color: black;
    padding: 5px 10px; /* Khoảng cách bên trong để làm nút */
    border: 2px solid transparent; /* Đường viền ban đầu trong suốt */
    border-radius: 5px; /* Góc bo tròn */
    transition: all 0.3s ease; /* Hiệu ứng mượt */
}

.mx-3:hover {
    color: white; /* Chữ màu trắng */
    background-color: #007bff; /* Nền màu xanh */
    border: 2px solid #007bff; /* Đường viền cùng màu với nền */
}

.load-more {
    text-align: center;
    margin-top: 20px;
}
.load-more a {
    color: #00aaff;
    text-decoration: none;
}
</style>
<style>
.product-card {
    border: 1px solid #eaeaea;
    border-radius: 10px;
    padding: 15px;
    text-align: center;
    position: relative;
    height: 470px;
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
}

.product-card:hover {
    transform: scale(1.05); /* Phóng to nhẹ khi hover */
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); /* Bóng đổ đẹp */
    border-color: #007bff; /* Thay đổi màu viền khi hover */
}

.product-card img {
    max-width: 100%;
    height: 300px;
    border-radius: 10px;
}
.product-card .icons {
    position: absolute;
    top: 10px;
    right: 10px;
}
.product-card .icons i {
    margin-left: 10px;
    color:red;
    font-size: 20px;
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

</style>
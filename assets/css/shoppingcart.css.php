<style>
/* Đảm bảo ảnh sản phẩm hiển thị gọn gàng */
.img_product {
    width: 80px; /* Kích thước ảnh */
    height: 80px;
    object-fit: cover; /* Cắt ảnh theo kích thước nhưng giữ tỷ lệ */
    border-radius: 8px; /* Bo tròn góc */
}

/* Điều chỉnh khoảng cách và căn chỉnh */
.container1 {
    /* max-width: 900px; */
    margin: auto; /* Canh giữa trang */
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 10px; /* Bo tròn khung */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Thêm bóng đổ */
}

h3 {
    margin-bottom: 20px;
    color: #333;
}

.table thead th {
    background-color: #343a40; /* Màu nền header */
    color: #ffffff; /* Màu chữ */
    text-align: center;
}

.table tbody td {
    vertical-align: middle; /* Căn giữa nội dung ô */
    text-align: center;
}

.btn-primary {
    background-color: #007bff;
    border: none;
}

.btn-primary:hover {
    background-color: #0056b3;
    transition: background-color 0.3s ease;
}

hr {    
    margin-top: 30px;
    margin-bottom: 30px;
}
.qty-input {
    width: 40px;
    font-weight: bold;
    font-size: 14px;
}

.input-group button {
    font-size: 14px;
    font-weight: bold;
    width: 30px;
}
.checkout-btn{
    display: flex;
    justify-content: flex-end;
}
.table td.product-total {
    width: 150px; /* Thay đổi chiều rộng phù hợp với dữ liệu */
    text-align: center;
}
  </style>
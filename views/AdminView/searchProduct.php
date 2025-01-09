<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Result</title>
    <style>
.table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-size: 16px;
    text-align: left;
}

.table thead {
    background-color: #666666B3; 
    color: white;
    text-transform: uppercase;
}

.table th, .table td {
    padding: 12px 15px;
    border: 1px solid #ddd;
}

.table tbody tr:nth-child(even) {
    background-color: #e0f7fa; 
}

.table tbody tr:hover {
    background-color: #b2ebf2; 
    cursor: pointer;
}

.table td img {
    border-radius: 5px;
    object-fit: cover;
}

#editModalBtn {
    padding: 8px 12px;
    font-size: 14px;
    color: white;
    background-color: #007bff; 
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

#editModalBtn:hover {
    background-color: #0c6478; 
}

.btn.delete {
    padding: 8px 12px;
    font-size: 14px;
    color: white;
    background-color: #e74c3c; 
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn.delete:hover {
    background-color: #c0392b; 
}
.btn-back {
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    color: white;
    background-color: #007bff; 
    border: none;
    border-radius: 5px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-back:hover {
    background-color:  #0056b3; 
    cursor: pointer;
}

    </style>
</head>
<body>
<a href="/SneakerHome/admin/adminview" class="btn-back">Back</a>
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
                <tbody id="products-data">
                    <?php foreach ($products as $product): ?>
                        <tr class="item">
                            <td><?php echo $product['product_id']; ?></td>
                            <td><img src="<?php echo $product['image_url']; ?>" alt="Ảnh sản phẩm" width="50"></td>
                            <td><?php echo $product['name']; ?></td>
                            <td><?php echo $product['price']; ?></td>
                            <td><?php echo $product['stock']; ?></td>
                            <td>
                                <form action = "/SneakerHome/Admin/getProduct" method="POST" >
                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                    <button type="submit"  id="editModalBtn">Sửa</button>                                
                                </form>                    
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
</body>
</html>
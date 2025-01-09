<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../assets/css/editProduct.css">
</head>
<body>
<div id="editModal">
            <div class="modal-content">
            <span class="close">&times;</span>
            <form action = "/SneakerHome/admin/editProduct" method="POST" enctype="multipart/form-data">
                    <h3>Edit Product</h3>
                    <input type="hidden" id="product_id" name="product_id" value="<?= htmlspecialchars($getproduct ['product_id']) ?>">

                    <label for="name">Product Name</label>
                    <input type="text" id="edit_name" name="name" value="<?= htmlspecialchars($getproduct ['name']) ?>" required>

                    <label for="price">Price</label>
                    <input type="number" id="edit_price" name="price" value="<?= htmlspecialchars($getproduct ['price']) ?>" required>

                    <label for="stock">Quantity</label>
                    <input type="number" id="edit_stock" name="stock" value="<?= htmlspecialchars($getproduct ['stock']) ?>" required>

                    <label for="image">Image</label>
                    <input type="file" id="edit_image" name="image" value="<?= htmlspecialchars($getproduct ['image_url']) ?>">

                    <button type="submit" name="edit_product">Update</button>
                </form>
            </div>
        </div>
</body>
<script>
    document.querySelector('.close').addEventListener('click', function() {
        window.location.href = '/SneakerHome/admin/adminview'; 
    });
</script>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Result</title>
    <?php include './component/linkbootstrap5.php'; ?>

    <style>
        .table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-size: 16px;
    text-align: left;
}

.table thead tr {
    background-color:#666666B3; 
    color: #333;
    text-transform: uppercase;
}

.table th, .table td {
    padding: 12px 15px;
    border: 1px solid #ddd;
}

.table tbody tr:nth-child(even) {
    background-color: #e0f7fa; 
}
.table tr th{
    background-color: black;
    color: #fff
}
.table tbody tr:hover {
    background-color: #b2ebf2; 
    cursor: pointer;
}

.table tbody tr td {
    transition: all 0.3s ease;
}

.table tbody tr td[colspan="3"] {
    color: #888;
    font-style: italic;
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
    <div class="container">
    <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($users) && is_array($users) && count($users) > 0): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" style="text-align: center;">Không tìm thấy dữ liệu</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <a href="/SneakerHome/admin/adminview" class="btn-back">Back</a>
</table>
    </div>

</body>
</html>

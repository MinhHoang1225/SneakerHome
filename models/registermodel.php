<?php

function validate_username($name)
{
    return ctype_alnum($name);
}

function validate_email($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validate_password($password) {
    // Kiểm tra mật khẩu có ít nhất 8 ký tự, một chữ hoa, một chữ thường và một số
    return strlen($password) >= 6;
}
function check_email_exists($db, $email) {
    // Kiểm tra xem email đã tồn tại trong cơ sở dữ liệu chưa
    $query = "SELECT COUNT(*) FROM user WHERE email = :email";
    $statement = $db->prepare($query);
    $statement->bindParam(":email", $email);
    $statement->execute();
    
    // Nếu có ít nhất một kết quả, trả về true (email đã tồn tại)
    return $statement->fetchColumn() > 0;
}
$db = connectdb();

function register_user($db, $name, $email, $password, $role = 'user')
{
    try {
        if (!$db) {
            throw new Exception("Database connection is null.");
        }
         // Kiểm tra nếu email đã tồn tại
         if (check_email_exists($db, $email)) {
            throw new Exception("Email is already registered.");
        }
        $query = "INSERT INTO `user` (name, email, password, role) VALUES (:name,:email , :password, :role)";
        $statement = $db->prepare($query);

        $statement->bindParam(":name", $name);
        $statement->bindParam(":email", $email);
        $statement->bindParam(":password", $password);
        $statement->bindParam(":role", $role);

        $result = $statement->execute();

        // Return true if registration is successful, false otherwise
        return $result;
    } catch (PDOException $e) {
        // Handle any database errors here
        echo "Registration failed. PDO Error: " . $e->getMessage();
        return false;
    } catch (Exception $e) {
        echo "Registration failed. Error: " . $e->getMessage();
        return false;
    }
}

?>
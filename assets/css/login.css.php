<style>
/* Centered Wrapper */
.centered-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: linear-gradient(135deg, #2c3e50, #3498db);
    padding: 20px;
}

/* Container Styling */
.container {
    width: 100%;
    max-width: 800px;
    background: #ffffff;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    position: relative;
}

/* Close Button */
.btn-close {
    width: 20px;
    height: 20px;
    background-color: #e74c3c;
    border-radius: 50%;
    position: absolute;
    top: 20px;
    left: 20px;
    display: block;
    transition: transform 0.3s ease, background-color 0.3s ease;
}

.btn-close:hover {
    background-color: #c0392b;
    transform: scale(1.2);
}

/* Login/Register Buttons */
.login-register-btn button {
    background-color: #1abc9c;
    color: white;
    border: none;
    padding: 8px 20px;
    margin: 0 5px;
    font-size: 14px;
    border-radius: 50px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
}

.login-register-btn button:hover {
    background-color: #16a085;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
}

/* Alert Styling */
.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
    border-radius: 10px;
    padding: 15px;
    margin: 20px 0;
    text-align: center;
}

/* Form Title */
.title {
    font-size: 32px;
    font-weight: bold;
    color: #2c3e50;
}

.subtitle {
    font-size: 16px;
    color: #7f8c8d;
}

/* Input Fields */
.input-info label {
    font-size: 14px;
    font-weight: bold;
    color: #34495e;
    margin-bottom: 5px;
    display: block;
}

.input-info input {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.input-info input:focus {
    border-color: #3498db;
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
    outline: none;
}

/* Logo Styling */
.logo {
    max-width: 150px;
    margin-bottom: px;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

/* Buttons */
.btn-login {
    background: #3498db;
    color: white;
    border: none;
    padding: 12px 30px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 50px;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.btn-login:hover {
    background: #2980b9;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
}

.register-link {
    font-size: 14px;
    font-weight: bold;
    color: #3498db;
    text-decoration: none;
    display: flex;
    align-items: center;
    transition: color 0.3s ease;
}

.register-link:hover {
    color: #2980b9;
}
.login-part-btn{
    gap: 30px;
}
</style>
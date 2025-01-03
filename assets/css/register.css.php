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
    max-width: 900px;
    background: #ffffff;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    position: relative;
    overflow: hidden;
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

/* Logo */
.logo {
    max-width: 150px;
    margin-bottom: 20px;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

/* Title and Subtitle */
.title {
    font-size: 32px;
    font-weight: bold;
    color: #2c3e50;
    margin-bottom: 10px;
}

.subtitle {
    font-size: 16px;
    color: #7f8c8d;
    margin-bottom: 30px;
}

/* Input Group */
.input-group {
    margin-bottom: 20px;
}

.input-group label {
    font-size: 14px;
    font-weight: bold;
    color: #34495e;
    margin-bottom: 5px;
    /* display: block; */
}

.input-group input {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.input-group input:focus {
    border-color: #3498db;
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
    outline: none;
}

/* Action Buttons */
.action-buttons {
    margin-top: 20px;
    display: flex;
    justify-content: flex-end;
    gap: 20px;
    align-items: center;
}

.back-link {
    font-size: 14px;
    font-weight: bold;
    color: #3498db;
    text-decoration: none;
    transition: color 0.3s ease;
}

.back-link:hover {
    color: #2980b9;
}

.btn-register {
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

.btn-register:hover {
    background: #2980b9;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
}

</style>
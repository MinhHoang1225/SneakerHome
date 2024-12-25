<style>

.price {
    font-size: 1.25rem;
    color: #d9534f;
    font-weight: bold;
}

.old-price {
    text-decoration: line-through;
    color: #888;
    margin-left: 10px;
}

.discount {
    font-size: 1.1rem;
    color: #28a745;
    margin-top: 10px;
}

.availability {
    margin-top: 10px;
    font-size: 1rem;
    color: #6c757d;
}

.color, .description {
    margin-top: 10px;
}

.form-control {
    font-size: 1rem;
    padding: 0.5rem;
    width: 100%;
    margin-bottom: 20px;
}

.btn-primary {
    font-size: 1rem;
    padding: 0.5rem 1.5rem;
    background-color: #007bff;
    border: none;
    border-radius: 0.25rem;
    color: #fff;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.card {
    border: 1px solid #eaeaea;
    border-radius: 10px;
    padding: 15px;
    text-align: center;
    position: relative;
    height: 470px;
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
}

.card:hover {
    transform: scale(1.05); /* Phóng to nhẹ khi hover */
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); /* Bóng đổ đẹp */
    border-color: #007bff; /* Thay đổi màu viền khi hover */
}

.card-img-top {
    height: 310px;
    /* object-fit: cover; */
}

.card-body {
    padding: 10px;
}

.card-title {
    font-size: 1.25rem;
    font-weight: bold;
    height: 50px;
}

.card-text {
    font-size: 1rem;
    margin-top: 10px;
}

.card-body a {
    font-size: 1rem;
    text-decoration: none;
    color: #007bff;
}

.card-body a:hover {
    color: #0056b3;
}

button[type="submit"], button[type="button"] {
    margin-top: 10px;
    padding: 8px 15px;
}

/* Định dạng cho phần quantity */
#quantity {
    width: 60px;
    display: inline-block;
    margin-right: 10px;
}

/* CSS cho phần giá */
.new-price {
    color: #00aaff;
    font-size: 1.2em;
    font-weight: bold;
}

.old-price {
    text-decoration: line-through;
    color: #999;
    margin-left: 10px;
}
.discount{
    color: #ff0000;
    margin-left: 10px;
}
.icons {
    position: absolute;
    top: 10px;
    right: 30px;
    z-index: 100;
}
.icons i {
    margin-left: 10px;
    color: #00aaff;
}
.content{
    display:flex;
    justify-content: center;
    padding: 20px
}
.img-fluid {
    height: 500px;
    width: 500px;
}
  </style>
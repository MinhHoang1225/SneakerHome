<style>
     body {
            background-color: #f8f9fa;

        }
        a{
            text-decoration: none;
            color: black
        }
        .container {
            margin-top: 50px;
        }
        .form-control {
            background-color: #e0e0e0;
            border: none;
            border-radius: 10px;
            height: 50px;
        }
        .form-control::placeholder {
            color: #757575;
        }
        .order-summary {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.order-summary h2 {
    font-size: 24px;
    margin-bottom: 15px;
    font-weight: bold;
    
}
.order-summary{
    max-height: 500px; /* Giới hạn chiều cao */
    overflow-y: auto; 
}
.order-item {
    background-color: #ffffff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);

}

.order-item .row {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.order-item img {
    max-width: 100%;
    border-radius: 8px;
}

.order-item .col-3 {
    display: flex;
    justify-content: center;
    align-items: center;
}

.order-item .col-3 strong {
    font-weight: 600;
    color: #333;
}

.total-price {
    background-color: #f8f9fa;
    padding: 10px;
    margin-top: 20px;
    border-radius: 8px;
    font-weight: bold;
    display: flex;
    justify-content: space-between;
}

.item-price {
    font-size: 20px;
    color: #dc3545;
}

.total-price h5 {
    margin: 0;
}

.btn-payment {
    background-color: #6c757d;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: bold;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    margin-left: auto; /* This will push the button to the right */
}

        .btn-payment:hover {
            background-color: #5a6268;
        }
        .back-to-cart {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }
        .back-to-cart i {
            margin-right: 10px;
        }
</style>
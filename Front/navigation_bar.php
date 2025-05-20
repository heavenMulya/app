<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="">
    <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="bootstrap.min.css">
<!-- Laravel Echo -->
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.0/dist/echo.iife.js"></script>
<!-- Socket.io Client -->
<script src="https://cdn.socket.io/4.0.1/socket.io.min.js"></script>

    <title></title>
</head>

<body>

    <div class="topbar">

        <div class="container">

            <div class="logo">
                <!--<img src="#" alt="">-->
                <span>Kitchen POS</span>
            </div>

            <div class="nav-page">

                <div class="">
                    <a href=""><span>Home</span></a>
                </div>

                <div class="">
                    <a href="menu.php"><span>Menu</span></a>
                </div>
            </div>

            <div class="manage">
                <div class="search">
                    <i class='bx bx-search' id="open-search"></i>
                    <div class="search-container">
                        <form action="" method="GET" id="search-form">
                            <i class='bx bx-search' id="search-button"></i>
                            <input type="text" name="search" placeholder="Search..." value="">
                        </form>
                    </div>
                </div>

                <div class="cart">
                    <i class='bx bx-cart'></i>
                    <span class="cart-quantity" id="cart-quantity">0</span>
                </div>

                <div class="company">
                    <a href=""><i class='bx bx-buildings'></i></a>
                </div>
            </div>

        </div>

    </div>

    <div class="cart-section">
        <div class="header">
            <span>Confirm Orders</span>
            <div class="close-cart">
                <i class='bx bx-x'></i>
            </div>
        </div>

        <div class="table-number">
            <span>Table No:</span>
            <input type="text" name="table_number" placeholder="0" required>
            <div class="message"></div>
            <div id="success-response" class="success-message"></div>
            <div id="error-response" class="validation-error-message"></div>
        </div>

        <div class="main-section-order">
            <span>Your Order</span>
            <div class="cart-total">
                <span id="cart-item-count">Total 0 item</span>
                <span id="cart-total-amount">0.00 TSH</span>
            </div>
        </div>

        <div class="your-order">
            <ul class="cart-list">
                <li>
                    <span class="empty">No item in cart</span>
                </li>
            </ul>
        </div>

        <div class="customer-contact">
            <span>Your Contact Number</span>
            <input type="text" name="customer_contact" placeholder="0689387277">
        </div>

        <div class="cart-button">
            <span>Please make sure your purchase before confirm the order.</span>
            <button type="button" class="confirm-order" disabled><span>Confirm Order</span></button>
        </div>
    </div>

    <script src="jquery-3.2.1.min.js"></script>
         <script type="module" src="APIEntergrationScript.js"></script>
    <script src="public.js"></script>


